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
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class LearnersController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['signup', 'activate', 'login', 'forgotPassword', 'resetPassword']);
        $this->set('form_templates', Configure::read('Templates'));
        $this->loadComponent('Cookie');
        if ($this->Auth->user('role') == '4') {
            $this->viewBuilder()->layout('learner');
        }
        $this->loadComponent('FileUpload');
    }
    public function dashboard() {
        $this->is_permission($this->Auth->user());
        $this->loadModel('Users');
        $profile = $this->Users->get($this->Auth->user('id'), ['contain' => 'Learners']);
        $this->set(compact('profile'));
    }
    public function form($id = null) {
        $this->is_permission($this->Auth->user());
        $this->loadModel('Users');
        $this->loadModel('Departments');
        $deplist = $this->Departments->find('list', ['conditions' => ['Departments.parent_id' => 0, 'Departments.addedby' => $this->Auth->user('id') ], 'contain' => ['ChildCategories']]);
        $chk = $this->Users->is_exists($id, $this->Auth->user('id'));
        if ($id && $chk == 0) {
            $this->Flash->error('You cannot access that location');
            $this->redirect($this->referer());
        }
        if ($id) {
            $user = $this->Users->get($id, ['contain' => 'Learners']);
            $type = 'old';
        } else {
            $type = 'new';
            $user = $this->Users->newEntity(['contain' => 'Learners']);
        }
        if ($this->request->data) {
            if ($this->request->data['password'] == '') {
                unset($this->request->data['password']);
                unset($this->request->data['confirm_password']);
            }
            $this->request->data['fullname'] = $this->request->data['fname'] . '&nbsp;' . $this->request->data['lname'];
            $this->request->data['role'] = '4';
            $this->request->data['status'] = '1';
            $this->request->data['learner']['renewal_date'] = '0';
            $this->request->data['status'] = '0';
            $this->request->data['addedby'] = $this->Auth->user('id');
            $this->request->data['learner']['sm_expiry_date'] = date('Y-m-d', strtotime($this->request->data['learner']['sm_expiry_date']));
            $this->request->data['learner']['renewal_date'] = date('Y-m-d', strtotime($this->request->data['learner']['renewal_date']));
            $user = $this->Users->patchEntity($user, $this->request->data);
            // pr($user);exit;
            if ($this->Users->save($user)) {
                if ($type == 'new') {
                    $emaildata['slug'] = 'account_created';
                    $emaildata['email'] = $user['email'];
                    $activate_link = BASEURL . 'users/activate?q=' . base64_encode($user['email']);
                    $link = BASEURL . 'users/login';
                    $emaildata['replacement'] = array('{fullname}' => $user['fullname'], '{link}' => $link, '{username}' => $user['username'], '{password}' => $user['username2']);
                    $this->__sendEmail($emaildata);
                }
                $this->Flash->success('User updated.');
                $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('Please fix the issues mentioned below.');
            }
        }
        $this->set(compact('user', 'deplist'));
    }
    public function index() {
        $this->is_permission($this->Auth->user());
        $this->loadModel('Users');
        $user_id = $this->Auth->user('id');
        $list = $this->paginate($this->Users->find('all', ['conditions' => ['Users.role' => '4', 'Users.addedby' => $user_id], 'contain' => ['Learners']]));
        $this->set(compact('list'));
    }

    public function profile() {
        $this->is_permission($this->Auth->user());
        $this->loadModel('Users');
        $this->loadModel('Countries');
        $this->loadModel('States');
        $states = [];
        $country = $this->Countries->getList();
        $profile = $this->Users->get($this->Auth->user('id'), ['contain' => 'Learners']);
        if ($profile['country']) {
            $states = $this->States->getbyCountry($profile['country']);
        }
        if ($this->request->data) {
            $data = $this->request->data;
            // pr($data); die;
            if (@$data['password'] == '' && @$data['confirm_password'] == '') {
                unset($data['password']);
                unset($data['confirm_password']);
            }
            if ($data['avatar']['name'] !== '') {
                $img = $this->FileUpload->image_upload($data['avatar'], '', 'uploads/user_data/');
                if ($img['status'] == 'success') {
                    $data['avatar'] = $img['filename'];
                    if ($profile['avatar']) {
                        $this->FileUpload->delete_file('uploads/user_data/' . $profile['avatar']);
                    }
                }
            } else {
                $data['avatar'] = $profile['avatar'];
            }
            if (!empty(@$data['profile_cover']['name'])) {
                
                $img1 = $this->FileUpload->image_upload($data['profile_cover'], '', 'uploads/user_data/');
                if ($img1['status'] == 'success') {
                    $data['profile_cover'] = $img1['filename'];
                    if ($profile['profile_cover']) {
                        $this->FileUpload->delete_file('uploads/user_data/' . $profile['profile_cover']);
                    }
                }
            } else {
                $data['profile_cover'] = $profile['profile_cover'];
            }
            $profile = $this->Users->patchEntity($profile, $data);
            if ($this->Users->save($profile)) {
                $this->Flash->success('Profile Saved!');
                $this->redirect(['action' => 'profile']);
            } else {
                $this->Flash->error('Please fix the errors below');
            }
        }
        $this->set(compact('profile', 'states', 'country'));
    }
    public function catalog() {

        //show all the other courses avaialble for enrollment
        $this->loadModel('Courses');
        $menu = "catalog";
        $condition = [];
        if ($keyword = @$this->request->query['keyword']) {
            $keyword = stripslashes($keyword);
            $condition['or'] = ['Courses.title like "%' . $keyword . '%"', 'Courses.description like "%' . $keyword . '%"'];
        }
        if ($course_type = @$this->request->query['course_type']) {
            $condition['Courses.type'] = $course_type;
        }

        $manager_id = $this->Auth->user('manager_id');

        $condition[] = "Courses.id not in (select course_id from enrollments where user_id = " . $this->Auth->user('id') . ")";
        $this->paginate = [
            'fields' => ['Courses.id','Courses.title','Courses.description','Courses.type','Courses.thumbnail','Courses.online_course_type','Courses.created','Courses.status','Courses.purchase_price','Courses.public_purchase','CourseManagers.user_id','Users.fname','Users.lname','Users.id'  ],
            'conditions' => [
                'Courses.is_deleted != ' => 1, 
                'Courses.admin_approved' => 1, 
                'Courses.status' => 2,  //active 
                'Courses.allow_reenrollment' => 1, 
                'Courses.learner_reenroll' => 'any_time', 
                'CourseManagers.user_id' => $manager_id, //this is to reject(remove) the courses from query result which are not assigned to my manager 
                $condition
            ], 
            'limit' => 6, 
            'contain' => [
                'Users',
                'CourseManagers' => [
                    //check courses's manangers and check if these course is assigned to my manager or not. 
                    'queryBuilder' => function($q) use ($manager_id) {
                        return $q->where([
                            'user_id' => $manager_id 
                        ]);
                    }
                ],
                'Enrollments' => function($q) use($manager_id) {
                    $q->select([
                        'Enrollments.course_id',
                        'total' => $q->func()->count('Enrollments.course_id')
                    ])
                    ->where(['owner' => $manager_id ])
                    ->group(['Enrollments.course_id']);
                    return $q;
                }
            ], 
            'order' => ['Courses.id' => 'DESC']
        ];
            
        $list = $this->paginate($this->Courses);
        // echo '<PRE>'; print_r($list); die;

        $this->set(compact('menu', 'list', 'course_type', 'keyword'));
    }
    public function transcript() {
        $menu = "transcript";
        $this->loadModel('Enrollments');
        $user_id = $this->Auth->user('id');
        $getCompletedCourses = $this->Enrollments->find('all', ['conditions' => ['Courses.is_deleted != ' => 1, 'Enrollments.user_id' => $user_id, 'Courses.status' => 2, 'Courses.admin_approved' => 1], 'contain' => ['Courses', 'TestResults' => ['conditions' => ['TestResults.user_id' => $user_id]]]]);
        //print "<pre>";print_r($getCompletedCourses->toArray());exit;
        $completedc = $this->paginate($getCompletedCourses);
        $this->set(compact('menu', 'completedc'));
    }
    public function globalresources() {
        $menu = "globalresources";
        $this->loadModel('CourseResources');
        $condition = [];
        if ($keyword = @$this->request->query['keyword']) {
            $keyword = stripslashes($keyword);
            $condition['or'] = ['CourseResources.name like "%' . $keyword . '%"', 'Users.fullname like "%' . $keyword . '%"'];
        }
        $cr = $this->CourseResources->find('all', ['conditions' => ['is_global' => 1, $condition], 'contain' => ['Users']]);
        $list = $this->paginate($cr);
        $this->set(compact('menu', 'list', 'keyword'));
    }
    public function calendar() {
        $menu = "calendar";
        $this->set(compact('menu'));
    }
    public function ecomcourses() {
        $this->loadModel('PurchasedCourses');
        $this->loadModel('Courses');
        $this->loadModel('Enrollments');
        $user_id = $this->Auth->user('id');
        $cids = $this->Enrollments->get_enrolled_courses($user_id);
        if ($cids) {
            $conditions[] = 'Courses.id not in (' . $cids . ')';
        }
        $this->paginate = ['conditions' => [$conditions, 'Courses.status' => 2, 'Courses.enable_ecommerce' => 1, 'Courses.admin_approved' => 1], 'contain' => ['Users'], 'limit' => 12, 'order' => ['created' => 'DESC']];
        $ecom = $this->paginate($this->Courses);
        $this->set('menu', 'ecommerce');
        $this->set(compact('ecom'));
    }
    public function contactmanager() {
        $this->loadModel('Users');
        if ($data = $this->request->data) {
            $manager = $this->Users->find('all', ['conditions' => ['id' => $this->Auth->user('manager_id') ]])->last();
            // $manager = $this->Users->find('all',['conditions'=>['id'=>$this->Auth->user('addedby')]])->last();
            $manager_name = $manager['fname'] . ' ' . $manager['lname'];
            $manager_email = $manager['email'];
            $sender_name = $data['fname'] . ' ' . $data['lname'];
            $sender_email = $data['email'];
            $sender_phone = $data['phone'];
            $sender_msg = $data['message'];
            $emaildata['slug'] = 'learner_request_to_manager';
            $emaildata['email'] = $manager_email;
            $link = BASEURL . 'users/login';
            $emaildata['replacement'] = array('{fullname}' => $manager_name, '{link}' => $link, '{sender_name}' => $sender_name, '{sender_email}' => $sender_email, 'sender_phone' => $sender_phone, 'message' => $sender_msg);
            $this->__sendEmail($emaildata);
            $this->Flash->success('Request Sent to your Manager .');
            $this->redirect(['action' => 'contactmanager']);
            $this->Flash->success('Request Sent to your Manager .');
            $this->redirect(['action' => 'contactmanager']);
        }
    }


}
