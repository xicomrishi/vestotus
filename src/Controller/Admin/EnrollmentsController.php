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
namespace App\Controller\Admin;
use App\Controller\AppController;
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

    public function index() {   //enrollment list
        $this->is_permission($this->Auth->user());
        $user_id = $this->Auth->user('id');
        $search = $this->request->query;
        $conditions = [];

            $start_date = $end_date = '';
            if (!empty(@$search['start_date'])):
                $start_date = date('Y-m-d', strtotime($search['start_date']));
            endif;

            if (!empty(@$search['end_date'])):
                $end_date = date('Y-m-d', strtotime($search['end_date']));
            endif;

            $search_text = preg_replace("/[^a-zA-Z0-9\s]+/", "", @$search['search_text']);
            if ($start_date) {
                $conditions['Courses.created >='] = $start_date;
            }
            if ($end_date) {
                $conditions['Courses.created <='] = $end_date;
            }
            if ($search_text) {
                $conditions['or'] = ["Courses.title like '%" . $search_text . "%'", "Users.fname like '%" . $search_text . "%'", "Users.lname like '%" . $search_text . "%'", "Users.username like '%" . $search_text . "%'", "Users.username like '%" . $search_text . "%'"];
            }

        $archieved = $this->request->query('archieved');
        if($archieved == 'true'){  
            $conditions[] = ['Enrollments.deleted IS NOT NULL'];
        } else{
            $conditions[] = ['Enrollments.deleted IS NULL'];
        }
        // $conditions[] = 'Enrollments.deleted IS NULL';

        // echo '<pre>'; print_r($conditions); die;
        //$conditions['Courses.addedby'] = $this->Auth->user('id');
        $list = $this->Enrollments->find('all', ['conditions' => [$conditions], 'contain' => ['Courses', 'Users'], 'order' => ['Courses.id' => 'DESC'] ]);
        //exit;
        $list = $this->paginate($list);
        $this->set(compact('list','archieved'));
    }

    public function enrollUsers($id = null) {
        $this->is_permission($this->Auth->user());
        $this->loadModel('Users');
        $this->loadModel('Courses');
        $this->loadModel('UserCourses');
        $this->loadModel('Enrollments');

        $manager_opts = $this->Users->find('list', ['keyField' => 'id', 'valueField' => 'fname'])->where(['role =' => 2])->where(['status =' => '1'])->toArray();
        $managerId = $learner_opts = $course_opts = $EnrolledCourseArr = $enrolledlearners = '';
        // $managerId = $learners = $assignedIds = $EnrolledCourseArr = $enrolledlearners = '';
       
        if (isset($this->request->query['manager_id']) && !empty($this->request->query['manager_id'])) {

            //get all assigned users and courses of this manager 
            $managerId = $this->request->query['manager_id'];
            
            $learner_opts = $this->Users->find('list', ['keyField' => 'id', 'valueField' => 'fname'])->where(['manager_id =' => $managerId])->where(['status =' => '1'])->toArray();
            
            $user_courses = $this->UserCourses->find('all')->where(['UserCourses.user_id ' => $managerId])->contain(['Courses'])->enableHydration(false)->all();
            $course_opts = []; 
            if (!empty($user_courses)) {
                foreach ($user_courses as $dp) {
                    $course_opts[$dp['course_id']] = $dp['course']['title'];
                }
            }
            // echo '<pre>'; print_r($user_courses); die;

            // $enrolledlearners = $this->Enrollments->find('list', ['keyField' => 'id', 'valueField' => 'user_id'])->where(['owner =' => $managerId])->toArray();
            // $EnrolledCourseArr = $this->Enrollments->find('list', ['keyField' => 'id', 'valueField' => 'course_id'])->where(['owner =' => $managerId])->toArray();
            // $assignedIds = [];
        }

        // $learners = $this->Users->getLearnerslistbyOwner($this->Auth->user('id'));
        // $courses = $this->Courses->getCourseslistbyOwner($this->Auth->user('id'));
        $enrollment = $this->Enrollments->newEntity();
        if ($this->request->data) {
            // echo '<pre>'; print_r($this->request->data); die;

            //saving  enrollment
            /*if (isset($this->request->query['manager_id']) && !empty($this->request->query['manager_id'])) {
                $this->Enrollments->deleteAll(['Enrollments.owner' => $this->request->query['manager_id']]);
            }*/
            $data = $this->request->data;
            if (empty($data['users'])) {
                $enrollment->errors('users', 'Please select user');
                //$this->Flash->error('You have successfully added user');
                
            } else if (empty($data['courses'])) {
                $enrollment->errors('courses', 'Please select Course');
                //$this->Flash->success('You have successfully added user');
                
            } else {

                foreach ($data['users'] as $user_id) {
                    foreach ($data['courses'] as $course_id) {
                        
                        $enrollment = $this->Enrollments->find('all')->where([
                                'user_id' => $user_id,
                                'course_id' => $course_id,
                                'owner' => $this->request->data['owner_id']
                            ])->first();
                        
                        if(empty($enrollment)) {
                            //save enrollment, if not already enrolled 
                            $enrollment = $this->Enrollments->newEntity();
                            $dt['enroll_method'] = 1;
                            $dt['owner'] = $this->request->data['owner_id'];
                            $dt['user_id'] = $user_id;
                            $dt['course_id'] = $course_id;
                            $enrollment = $this->Enrollments->patchEntity($enrollment, $dt);
                            $this->Enrollments->save($enrollment);
                            $this->__sendCourseEmail($course_id, $user_id, "enroll");
                        }

                    }
                }
                $this->Flash->success('You have successfully added user');
                $this->redirect(['action' => 'index']);
            }
        }

        $this->set(compact('enrollment','manager_opts','learner_opts','course_opts','managerId'));
        // $this->set('assignedIds', $assignedIds);
    }

    public function delenrollment($id = null) {
        $this->autoRender = false;
        $user_id = $this->Auth->user('id');
        $id = $this->mydecode($id);

        // $chk = $this->Enrollments->is_owner($id, $user_id);
        // if ($chk) {
            $enroll = $this->Enrollments->get($id);
            if(!empty($enroll)){
                $enroll->deleted = date('Y-m-d H:i:s');
                if ($this->Enrollments->save($enroll)) {
                    $this->Flash->success('User Enrollment has been deleted successfully.');
                } else{
                    $this->Flash->error('Some error occured, please try again later.'); 
                }
            }
        // } else {
        //     $this->Flash->error('Page not found!');
        // }
        $this->redirect($this->referer());
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
        $id = $this->mydecode($id);
        $course = $this->PurchasedCourses->find('all', ['conditions' => ['PurchasedCourses.id' => $id], 'contain' => ['Courses']])->last();
        $enrolled_users = $this->Enrollments->find('all', ['conditions' => ['course_id' => $course['course']['id'], 'owner' => $this->Auth->user('id') ], 'fields' => ['uids' => 'GROUP_CONCAT(user_id)']])->last();
        $this->set(compact('course', 'enrolled_users'));
        if ($data = $this->request->data) {
            $data['users'] = explode(',', $data['users']);
            $data['users'] = array_values(array_filter($data['users']));
            $data['users'] = array_unique($data['users']);
            // print "<pre>";print_r($data);exit;
            $this->Enrollments->deleteAll(['course_id' => $course['course_id']]);
            foreach ($data['users'] as $users) {
                if ($users) {
                    $en = $this->Enrollments->newEntity();
                    $en['user_id'] = $users;
                    $en['course_id'] = $course['course_id'];
                    $en['owner'] = $this->Auth->user('id');
                    $en['enroll_method'] = 1;
                    $this->Enrollments->save($en);
                }
            }
            $pc = $this->PurchasedCourses->get($id);
            $pc['enrolled_users'] = count($data['users']);
            $this->PurchasedCourses->save($pc);
            $this->redirect(['controller' => 'courses', 'action' => 'mycourses']);
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

    /*public function viewAttendance($course_id,$learner_id) { //echo 'm'; die;
        // $this->is_permission($this->Auth->user());
        $this->loadModel('Attendences');
        $user_id = $this->Auth->user('id');
        
        $course_id = $this->mydecode($course_id);
        $learner_id = $this->mydecode($learner_id);

        $search = $this->request->query;
        $conditions = ['course_id'=>$course_id, 'student_id'=>$learner_id];
        // $conditions = [];
        if ($search) {
            $start_date = $end_date = '';
            if ($search['start_date']):
                $start_date = date('Y-m-d', strtotime($search['start_date']));
            endif;
            if ($search['end_date']):
                $end_date = date('Y-m-d', strtotime($search['end_date']));
            endif;
            $search_text = preg_replace("/[^a-zA-Z0-9\s]+/", "", $search['search_text']);
            if ($start_date) {
                $conditions['Courses.created >='] = $start_date;
            }
            if ($end_date) {
                $conditions['Courses.created <='] = $end_date;
            }
            if ($search_text) {
                $conditions['or'] = ["Courses.title like '%" . $search_text . "%'", "Users.fname like '%" . $search_text . "%'", "Users.lname like '%" . $search_text . "%'", "Users.username like '%" . $search_text . "%'", "Users.username like '%" . $search_text . "%'"];
            }
        }

        $conditions[] = 'Enrollments.deleted IS NULL';

        // echo '<pre>'; print_r($conditions); die;
        //$conditions['Courses.addedby'] = $this->Auth->user('id');
        $list = $this->Attendences->find('all', 
                ['fields' => ['id','created','status'] ],
                ['conditions' => [$conditions], 
                'contain' => [
                    'CourseChapters' =>[
                        'fields' => ['title']
                    ],
                    'Users' => [
                        'fields' => ['title']
                    ]
                ]
            ]);
        
        $list = $this->paginate($list);
        echo '<pre>'; print_r($list); die;
        $this->set(compact('list'));
    }*/

}
