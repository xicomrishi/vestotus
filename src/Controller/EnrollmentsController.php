<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\Controller\Component;
use Cake\Mailer\Email;
use Cake\Controller\Component\CookieComponent;
use Cake\Utility\Security;
use Cake\Utility\Crypto\Mcrypt;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class EnrollmentsController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow();
        $this->set('form_templates', Configure::read('Templates'));
        $this->loadComponent('Cookie');
        if ($this->Auth->user('role') == '4') {
            $this->viewBuilder()->layout('learner');
        }
    }

    public function index() {
        $this->is_permission($this->Auth->user());
        $user_id = $this->Auth->user('id');
        $search = $this->request->query;
        $conditions = [];
        if ($search) {

            if (@$search['start_date']){
                $start_date = date('Y-m-d', strtotime($search['start_date']));
                $conditions['Enrollments.created >='] = $start_date;
            }

            if (@$search['end_date']){
                $end_date = date('Y-m-d', strtotime($search['end_date']));
                $conditions['Enrollments.created <='] = $end_date;
            }
            
            $search_text = preg_replace("/[^a-zA-Z0-9\s]+/", "", trim($search['search_text']));
            if ($search_text) {
                $conditions['or'] = [
                    "Courses.title like '%".$search_text . "%'", 
                    "Users.fullname like '%".$search_text . "%'", 
                    // "Users.lname like '%".$search_text . "%'", 
                    "Users.username like '%".$search_text . "%'", 
                    "Users.username like '%".$search_text . "%'"
                ];
            }
        }
        $conditions['Enrollments.owner'] = $this->Auth->user('id');
        $conditions[] = 'Enrollments.deleted IS NULL ';
        //mk $conditions['Courses.addedby'] = $this->Auth->user('id');
        // pr($conditions); die;
        $list = $this->Enrollments->find('all', ['conditions' => [$conditions], 'contain' => ['Courses', 'Users']]);
        $list = $this->paginate($list);
        $this->set(compact('list','search'));
    }

    public function enrollUsers($id = null) {   
        $this->is_permission($this->Auth->user());
        $this->loadModel('Users');
        $this->loadModel('Courses');
        $learners = $this->Users->getLearnerslistbyOwner($this->Auth->user('id'));
        $courses = $this->Courses->getCourseslistbyOwner($this->Auth->user('id'));
        $enrollment = $this->Enrollments->newEntity();
        if ($this->request->data) {
            $data = $this->request->data;
            if (empty($data['users'])) {
                $enrollment->errors('users', 'Please select user');
                //$this->Flash->error('You have successfully added user');
                
            } else if (empty($data['courses'])) {
                $enrollment->errors('courses', 'Please select Course');
                //$this->Flash->success('You have successfully added user');
                
            } else {
                //$ttlu = count($data['users']);
                //$ttlc = count($data['courses']);
                foreach ($data['users'] as $users) {
                    foreach ($data['courses'] as $course) {
                        $enrollment = $this->Enrollments->newEntity();
                        $dt['enroll_method'] = 1;
                        $dt['owner'] = $this->Auth->user('id');
                        $dt['user_id'] = $users;
                        $dt['course_id'] = $course;
                        $enrollment = $this->Enrollments->patchEntity($enrollment, $dt);
                        $this->Enrollments->save($enrollment);
                        $this->__sendCourseEmail($course, $users, "enroll");
                    }
                }
                $this->Flash->success('You have successfully added user');
                $this->redirect(['action' => 'index']);
            }
        }
        $this->set(compact('enrollment', 'learners', 'courses'));
    }

    public function delete($id = null) {
        $this->is_permission($this->Auth->user());
        if ($id):
            $chk = $this->Departments->is_exists($id, $this->Auth->user('id'));
            if ($chk == 1) {
                $del = $this->Departments->delete_dpt($id);
                if ($del) {
                    $this->Flash->success('Department Deleted!');
                } else {
                    $this->Flash->success('Department could not be Deleted!');
                }
            } else {
                $this->Flash->error('You cannot delete this department.');
            }
        endif;
        $this->redirect($this->referer());
    }
    public function delenrollment($id = null) {
        $this->autoRender = false;
        $user_id = $this->Auth->user('id');
        $id = $this->mydecode($id);
        $chk = $this->Enrollments->is_owner($id, $user_id);
        if ($chk) {
            $getu = $this->Enrollments->get($id);
            if ($this->Enrollments->delete($getu)) {
                $this->Flash->success('Item Deleted !');
            } else {
                $this->Flash->error('Please try again !');
            }
        } else {
            $this->Flash->error('Page not found!');
        }
        $this->redirect($this->referer());
    }
    public function courses($id = null) {
        $id = $this->mydecode($id);
        $conditions['Courses.addedby'] = $this->Auth->user('id');
        $conditions['Courses.id'] = $id;
        $list = $this->Enrollments->find('all', ['conditions' => [$conditions], 'contain' => ['Courses', 'Users']]);
        $list = $this->paginate($list);
        $this->set(compact('list'));
    }

    public function enrollEcomUsers($id = null) {
        $this->loadModel('PurchasedCourses');
        $this->loadModel('Enrollments');
        $this->loadModel('Users');

        $id = $this->mydecode($id);

        $course = $this->PurchasedCourses->find('all', ['conditions' => ['PurchasedCourses.id' => $id], 'contain' => ['Courses']])->last();
        if(!empty($course)){

            if ($data = $this->request->data) {

                // print "<pre>";print_r($data);exit;
                // $data['users'] = explode(',', $data['users']);
                // $data['users'] = array_values(array_filter($data['users']));
                // $data['users'] = array_unique($data['users']);
                // $this->Enrollments->deleteAll(['course_id' => $course['course_id']]);

                //delete previous enrollemnts
                $this->Enrollments->deleteAll([
                    'course_id'     => $course->course_id,
                    'owner'         => $this->Auth->user('id'),
                    'enroll_method' => 1,
                    'purchased_course_id' => $course->id
                ]);
                
                // if( count($data['users']) > $course->quantity) {
                //     echo 'ee'; die;
                // }

                foreach ($data['users'] as $user_id) {
                    if ($user_id) {
                        $en = $this->Enrollments->newEntity();
                        $en['user_id']          = $user_id;
                        $en['course_id']        = $course->course_id;
                        $en['owner']            = $this->Auth->user('id');
                        $en['enroll_method']    = 1;
                        $en['purchased_course_id'] = $data['purchased_course_id'];

                        $this->Enrollments->save($en);
                    }
                }

                //update purchase count
                $pc = $this->PurchasedCourses->get($id);
                $pc['enrolled_users'] = count($data['users']);
                $this->PurchasedCourses->save($pc);

                $this->redirect(['controller' => 'courses', 'action' => 'mycourses']);
            }

            // $enrolled_users = $this->Enrollments->find('all', ['conditions' => ['course_id' => $course['course']['id'], 'owner' => $this->Auth->user('id') ], 'fields' => ['uids' => 'GROUP_CONCAT(user_id)']])->last();

            $enroll_users_opts = $this->Users->find('all', [
                                'fields' => ['id','fname','lname','username'],
                                'conditions' => ['manager_id' => $this->Auth->user('id')], 
                            ])->toList();

            $enrolled_users = $this->Enrollments->find('list', [
                                'valueField' => ['user_id'],
                                'conditions' => [
                                    // 'course_id' => $course->course_id,
                                    'owner' => $this->Auth->user('id'),
                                    'enroll_method' => 1,
                                    'purchased_course_id' => $course->id
                                ], 
                            ])->toArray();
            // $enrolled_users = array_values($enrolled_users);


            // echo '<pre>'; print_r($enrolled_users); die;
            // echo '<pre>'; print_r($enrolled_users_opts); die;

            $enrollment = $this->Enrollments->newEntity();

            $this->set(compact('course', 'enroll_users_opts','enrollment','enrolled_users'));
        } else{
            $this->redirect()->referer();
        }
    }

    public function getenrollmentusers($course_id = null) {
        $this->autoRender = false;
        $term = $this->request->query['term']['term'];
        $this->loadModel('Users');
        $user_id = $this->Auth->user('id');
        if ($course_id) {
            //$c[] = 'id not in (select user_id from enrollments where course_id = '.$course_id.')';
            
        }
        $check = $this->Users->find('all', ['conditions' => ['addedby' => $user_id, 'status' => '1', 'or' => ['fname like "%' . $term . '%"', 'fullname like "%' . $term . '%"', 'lname like "%' . $term . '%"', 'email like "%' . $term . '%"', 'username like "%' . $term . '%"'], 'role' => 4, $c]])->toArray();
        $getarr = [];
        $i = 0;
        foreach ($check as $check) {
            $getarr[$i]['id'] = $check['id'];
            $getarr[$i]['text'] = $check['fullname'] . '-' . $check['username'];
            $i++;
        }
        // $getarr['results'] = $getarr;
        echo json_encode($getarr);
        exit;
    }

    public function userSelfEnrollment($course_id = null){ //in catealog page, leaner can enroll himself
        $this->autoRender = false;
        $course_id = $this->mydecode($course_id);
        $this->loadModel('Courses');

        $condition[] = "Courses.id not in (select course_id from enrollments where user_id = " . $this->Auth->user('id') . ")";
        $course = $this->Courses->find('all',[
            'conditions' => [
                    'id' => $course_id,
                    'Courses.is_deleted != ' => 1, 
                    'Courses.admin_approved' => 1, 
                    'Courses.status' => 2,  //active 
                    'Courses.allow_reenrollment' => 1, 
                    'Courses.learner_reenroll' => 'any_time', 
                    $condition
                ], 
                // 'contain' => ['Users'], 
            ]
        )->first();
                    
        if(!empty($course)){
            //validate course id
            $enrollment = $this->Enrollments->newEntity();
            $dt['enroll_method']= 1;
            $dt['owner']        = $this->Auth->user('manager_id');      //manager id
            $dt['user_id']      = $this->Auth->user('id');
            $dt['course_id']    = $course_id;
            $dt['is_self_enrolled'] = 1;

            $enrollment = $this->Enrollments->patchEntity($enrollment, $dt);
            if($this->Enrollments->save($enrollment)){

                try{
                    $this->__sendCourseEmail($course_id, $this->Auth->user('id'), "enroll");
                } catch(\Exception $e){

                }

                $this->Flash->success('You have successfully enrolld to the course');
                $this->redirect([ 'controller' => 'courses', 'action' => 'learnerCourses']);
            } else{
                $this->Flash->error('Some error occured. Please try again !');
                $this->redirect($this->referer());
            }
        } else{
            $this->Flash->error('Some error occured. Please try again !');
            $this->redirect($this->referer());
        }
    }

}
