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
use Cake\I18n\Time;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class UsersController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['signup', 'activate', 'login', 'forgotPassword', 'resetPassword', 'searchbykey', 'enrollkey']);
        $this->set('form_templates', Configure::read('Templates'));
        $this->loadComponent('Cookie');
        $this->loadComponent('FileUpload');
    }

    public function signup() {
        $user = $this->Users->newEntity();
        if ($this->request->data) {
            $this->request->data['fullname'] = $this->request->data['fname'] . '&nbsp;' . $this->request->data['lname'];
            $this->request->data['role'] = '4';
            $this->request->data['status'] = '0';
            $user = $this->Users->patchEntity($user, $this->request->data);
            $errors = $user->errors();
            if ($this->Users->save($user)) {
                $emaildata['slug'] = 'activate_account';
                $emaildata['email'] = $user['email'];
                $activate_link = BASEURL . 'users/activate?q=' . base64_encode($user['email']);
                $emaildata['replacement'] = array('{fullname}' => $user['fullname'], '{link}' => $activate_link);
                $this->__sendEmail($emaildata);
                $this->Flash->success('You have successfully registered .');
                $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error('Please fix the issues mentioned below.');
            }
        }
        $this->set(compact('user'));
    }
    
    public function activate() {
        $this->autoRender = false;
        $query = $this->request->query;
        $email = base64_decode($query['q']);
        $check = $this->Users->find('all', ['conditions' => ['email' => $email]])->last();
        if ($check) {
            $get = $this->Users->get($check['id']);
            $dt['status'] = 1;
            $get = $this->Users->patchEntity($get, $dt);
            if ($this->Users->save($get)) {
                $this->Flash->success('Account Activated!');
                $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error('Page not Found !');
            }
        }
    }
    public function login() {
        $user = $this->Users->newEntity();
        $loginCookie['username'] = $this->Cookie->read('username');
        $loginCookie['password'] = $this->Cookie->read('password');
        if ($this->request->is('post')) {
            
            $username = $this->request->data['username'];
            $password = $this->request->data['password'];
            $error = '';

            /*------ code for login with email or username start ----*/ 
            // if (Validation::email($this->request->data['username'])) {
                $this->Auth->config(
                    'authenticate', [
                        'Form' => [
                            'fields' => ['username' => 'username', 'password' => 'password'],
                            // 'fields' => ['password' => 'temp_password'],
                            // 'finder' => 'auth' //mk

                        ]
                    ]
                );
                $this->Auth->constructAuthenticate();
                // $this->request->data['password'] = $this->request->data['password']; 
                // unset($this->request->data['temp_password']);
            // }
            /*------ code for login with email or username end ----*/ 



            $users = $this->Auth->identify();
            if ($users) {
                if ($users['role'] > 1 && $users['status'] == '1') {
                    if (@$this->request->data['rememberme'] == '1') {
                        $this->Cookie->write('username', $this->request->data['username']);
                        $this->Cookie->write('password', $this->request->data['password']);
                    }
                    $this->Auth->setUser($users);
                    $getuser = $this->Users->get($users['id']);
                    $this->loadModel('LoginLogs');
                    $logs = $this->LoginLogs->newEntity();
                    //generate session token
                    $timestamp = date('Y-m-d H:i:s');
                    $hash = sha1($timestamp);
                    $this->request->session()->write('session_id', $hash);
                    $logs['login_time'] = date('Y-m-d H:i:s');
                    $logs['session_id'] = $hash;
                    $logs['user_id'] = $users['id'];
                    $logs['ip'] = $this->request->clientIp();
                    $this->LoginLogs->save($logs);
                    $data['last_login'] = date('y-m-d H:i:s');
                    $data = $this->Users->patchEntity($getuser, $data);
                    $this->Users->save($data);
                    return $this->redirect(['action' => 'dashboard']);
                    exit;
                } else {
                    $user->errors('username', ['unique' => '']);
                    $user->errors('password', ['custom' => 'Username or password is incorrect.Try again.']);
                }
                $user->errors('username', ['unique' => '']);
                $user->errors('password', ['custom' => 'Username or password is incorrect.Try again.']);
            } else {
                $user->errors('username', ['unique' => '']);
                $user->errors('password', ['custom' => 'Username or password is incorrect.Try again.']);
            }
        }
        $this->set(compact('user', 'loginCookie'));
    }
    public function dashboard() {
        $role = $this->Auth->user('role');
        if ($role == 4) {
            $this->redirect(['controller' => 'learners', 'action' => 'dashboard']);
        }
        if ($role == 3) {
            $this->redirect(['controller' => 'instructors', 'action' => 'profile']);
        }

        $this->loadModel('Courses');
        $this->loadModel('Messages');
        $this->loadModel('UserCourses');

        $assigned = $this->UserCourses->find('list', ['keyField' => 'id', 'valueField' => 'course_id'])->where(['user_id =' => $this->Auth->user('id')])->toArray();
        $courses = [];
        if (!empty($assigned)) {
            //get course details
            $recentCourses = $this->Courses->find('all', ['conditions' => ['is_deleted' => 0, 'status' => 2, 'id In' => $assigned], 'limit' => 5, 'order' => ['Courses.id' => 'DESC'] ])->toArray();
        }

        // echo $this->Auth->user('id'); die;
        /*$recentCourses = $this->Courses->find('all', [
                        'fields' => ['id','title','type'],
                        'conditions' => [
                            'Courses.is_deleted' => 0, 
                            'Courses.status' => 2, 
                            'UserCourses.user_id' => $this->Auth->user('id')
                            // 'id In' => $assigned
                        ],
                        'contain' => [
                            // 'UserCourses'
                            'UserCourses' => [
                                'fields' => ['user_id','course_id','id']
                                'conditions' => [
                                    'user_id' => $this->Auth->user('id')
                                ]
                            ]
                        ]
                    ])
                    ->enableHydration(false)
                    ->toArray();*/

        // pr($recentCourses); die;
        $u = $this->Users->find('all', ['conditions' => ['Users.id' => $this->Auth->user('id') ]])->last();
        //$recentCourses = $this->Courses->find('all', ['conditions' => ['Courses.addedby' => $u['id'], 'status' => '2', 'admin_approved' => 1], 'limit' => '5', 'order' => ['Courses.id' => 'DESC']])->toArray();

        $messages = $this->Messages->getIncomingMessages($this->Auth->user('id'),5);
        // pr($messages); die;
        $this->set(compact('u', 'recentCourses','messages'));

        //edit profile
        if ($this->request->data) {
            $data = $this->request->data;
            $profile = $this->Users->get($u['id']);
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
            $profile = $this->Users->patchEntity($profile, $data);
            if ($this->Users->save($profile)) {
                $this->Flash->success('Profile Saved!');
                $this->redirect(['action' => 'dashboard']);
            } else {
                $this->Flash->error('Please fix the errors below');
            }
        }
    }
    public function logout() {
        $this->loadModel('LoginLogs');
        $user_id = $this->Auth->user('id');
        $session_id = $this->request->session()->read('session_id');
        $logData = $this->LoginLogs->find('all', ['conditions' => ['LoginLogs.user_id' => $user_id, 'LoginLogs.session_id' => $session_id]])->first();
        $logs = $this->LoginLogs->newEntity();
        $timestamp = date('Y-m-d H:i:s');
        $hash = sha1($timestamp);
        $logs['logout_time'] = date('Y-m-d H:i:s');
        $logs['id'] = $logData->id;
        $this->LoginLogs->save($logs);
        return $this->redirect($this->Auth->logout());
    }
    public function forgotPassword() {
        $user = $this->Users->newEntity();
        if ($this->request->data) {
            $email = $this->request->data['email'];
            if ($email == '') {
                $user->errors('email', ['custom' => 'Enter an email address']);
                //    $this->Flash->error(__('Please enter email Address.'));
                
            } else {
                $is_valid = $this->Users->email_valid($email);
                if ($is_valid == 'valid') {
                    $chk = $this->Users->getByEmail($this->request->data['email']);
                    if ($chk) {
                        $user = $this->Users->get($chk['id']);
                        $data['reset_password'] = base64_encode($email) . '_' . strtotime(date("Y-m-d", strtotime("+1 week")));
                        $data = $this->Users->patchEntity($user, $data);
                        if ($this->Users->save($data)) {
                            $dt['slug'] = 'reset_password';
                            $dt['email'] = $data['email'];
                            $reset_url = BASEURL . "users/reset_password/" . $data['reset_password'];
                            $dt['replacement'] = array('{name}' => $data['fullname'], "{link}" => $reset_url);
                            $this->__sendEmail($dt);
                            $this->Flash->success(__('Email has been successfully sent to your email address. Please follow the instructions to reset your password.'));
                            $this->redirect(['action' => 'login']);
                        }
                        //pr($data);
                        
                    } else {
                        $user->errors('email', ['custom' => 'Email address is incorrect. Try again.']);
                    }
                } else {
                    $user->errors('email', ['custom' => 'Enter a valid email address']);
                    //$this->Flash->error(__($is_valid));
                    
                }
            }
        }
        $this->set('user', $user);
    }
    public function resetPassword($hashcode = null) {
        $user = $this->Users->newEntity();
        if ($hashcode) {
            $chk = $this->Users->reset_link($hashcode);
            if ($chk) {
                $chkTime = $chk['reset_password'];
                $chk_email = explode('_', $chkTime);
                $timevalid = date('Y-m-d', $chk_email[1]);
                $todayTime = date('Y-m-d');
                if ($timevalid > $todayTime) {
                    $user = $this->Users->get($chk['id']);
                    if ($this->request->data) {
                        $this->request->data['password'] = $this->request->data['password1'];
                        $this->request->data['reset_password'] = '';
                        $user = $this->Users->patchEntity($user, $this->request->data);
                        //pr($user);exit;
                        if ($this->Users->save($user)) {
                            /*$email = new Email();
                            $this->loadModel('emailTemplates');
                            $getTemplate = $this->emailTemplates->getTemplate('reset_password');
                            $reset_url = BASEURL."users/reset_password/".$data['reset_password'];
                            $getContent = $getTemplate['body'];
                            $getContent = str_replace('{name}', $data['fullname'], $getContent);
                            $getContent = str_replace('{reset_url}', $reset_url, $getContent);
                            //$link = "<a href=".BASEURL."users/login>Login </a>";
                            // $getContent = str_replace('{login_link}',$link, $getContent);
                            $email->from([$getTemplate['from_email'] => $getTemplate['from_name']])
                                ->emailFormat('html')
                                ->to($this->request->data['email'])
                                ->subject($getTemplate['subject'])
                                ->send($getContent);*/
                            $this->Flash->success(__('Password has been updated successfully'));
                            $this->redirect(['action' => 'login']);
                            //pr($data);
                            
                        } else {
                            $this->Flash->error(__('Please fix the errors highlighted in the fields below.'));
                        }
                    }
                } else {
                    $this->Flash->error(__('Link has been expired'));
                }
            } else {
                $this->Flash->error(__('Invalid Link'));
            }
        } else {
            $this->redirect(['action' => 'forgot_password']);
        }
        $this->set('user', $user);
    }
    public function searchbykey($key = null) {
        $this->autoRender = false;
        $users = $this->Users->find('all', ['conditions' => ['addedby' => $this->Auth->user('id'), 'or' => ['email like "%' . $key . '%"', 'fname like "%' . $key . '%"', 'lname like "%' . $key . '%"', 'fullname like "%' . $key . '%"']]])->toArray();
        $list = [];
        $i = 0;
        foreach ($users as $user) {
            $list[$i]['id'] = $user['id'];
            $list[$i]['term'] = $user['fullname'];
            $i++;
        }
        echo json_encode($list);
        exit;
    }
    public function getlearners() {
        $this->autoRender = false;
        $term = $this->request->query['term']['term'];
        $user_id = $this->Auth->user('id');
        $check = $this->Users->find('all', ['conditions' => ['addedby' => $user_id, 'status' => '1', 'or' => ['fname like "%' . $term . '%"', 'fullname like "%' . $term . '%"', 'lname like "%' . $term . '%"', 'email like "%' . $term . '%"', 'username like "%' . $term . '%"'], 'role' => 4]])->toArray();
        $getarr = [];
        $i = 0;
        foreach ($check as $check) {
            $getarr[$i]['id'] = $check['id'];
            $getarr[$i]['text'] = $check['fullname'] . '-' . $check['username'];
            $i++;
        }
        $getarr['results'] = $getarr;
        echo json_encode($getarr);
        exit;
    }
    public function enrollkey() {
        $this->loadModel('EnrollKeys');
        $this->loadModel('Enrollments');
        $key = $this->request->query['key'];
        $password = $this->request->query['password'];
        if ($key && $password) {
            $getkey = $this->EnrollKeys->check_valid($key, $password);
            if ($getkey) {
                $user = $this->Users->newEntity();
                if ($this->request->data) {
                    $data = $this->request->data;
                    $user['role'] = 4;
                    $user['status'] = 1;
                    $user = $this->Users->patchEntity($user, $data);
                    if ($user->errors()) {
                        $this->Flash->error('Please fix the errors given below.');
                    } else {
                        if ($this->Users->save($user)) {
                            $getenroll = $this->EnrollKeys->get($getkey['id']);
                            $getenroll['times_used'] = $getenroll['times_used'] + 1;
                            $this->EnrollKeys->save($getenroll);
                            $courses = explode(',', $getenroll['courses']);
                            foreach ($courses as $course) {
                                $newEnrollment = $this->Enrollments->newEntity();
                                $enroll['user_id'] = $user->id;
                                $enroll['course_id'] = $course;
                                $enroll['owner'] = base64_decode($this->request->query['sharer']);
                                $enroll['enroll_method'] = 2;
                                $newEnrollment = $this->Enrollments->patchEntity($newEnrollment, $enroll);
                                $this->Enrollments->save($newEnrollment);
                            }
                            $emaildata['slug'] = 'account_created';
                            $emaildata['email'] = $user['email'];
                            $activate_link = BASEURL . 'users/login';
                            $emaildata['replacement'] = array('{fullname}' => $user['fullname'], '{username}' => $user['username'], '{password}' => $data['password'], '{link}' => $activate_link);
                            $this->__sendEmail($emaildata);
                            $this->Flash->success('Account Created!');
                            $this->redirect(['action' => 'login']);
                        }
                    }
                }
                $this->set(compact('user', 'getkey'));
            } else {
                $this->Flash->error('Invalid Key !');
            }
        } else {
            $this->redirect(['action' => 'home', 'controller' => 'pages']);
        }
    }
    public function add($id = null) {
        $this->is_permission($this->Auth->user('id'));
        $this->loadModel('Departments');
        $deplist = $this->Departments->find('list', ['conditions' => ['Departments.parent_id' => 0, 'Departments.addedby' => $this->Auth->user('id') ], 'contain' => ['ChildCategories']]);
        $newuser = $this->Users->newEntity();
        if ($id) {
            $id = $this->mydecode($id);
            $newuser = $this->Users->get($id);
        }
        if ($this->request->data) {
            $data = $this->request->data;
            if ($id && $data['password'] == '' && $data['confirm_password'] == '') {
                unset($data['password']);
                unset($data['confirm_password']);
            }
            $data['addedby'] = $this->Auth->user('id');
            $data['role'] = $data['role'];
            if (@$data['password']):
                $data['username2'] = $data['password'];
            endif;
            if ($data['role'] == '') {
                $data['role'] = '3';
            }
            $newuser = $this->Users->patchEntity($newuser, $data);
            if ($this->Users->save($newuser)) {
                $this->Flash->success('User Added !');
                $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('Error!');
            }
        }
        $this->set(compact('newuser', 'deplist'));
    }
    public function index() {   //manager's learners list
        $this->is_permission($this->Auth->user('id'));
        $list = $this->paginate($this->Users->find('all', ['conditions' => ['manager_id' => $this->Auth->user('id') ]]));
        $this->set(compact('list'));
    }
    public function delUser($id = null) {
        $id = $this->Mydecode($id);
        $getuser = $this->Users->get($id, ['contain' => ['Learners']]);
        if ($getuser['avatar']) {
            $this->FileUpload->delete_file('uploads/user_data/' . $getuser['avatar']);
        }
        if ($getuser['profile_cover']) {
            $this->FileUpload->delete_file('uploads/user_data/' . $getuser['profile_cover']);
        }
        if ($this->Users->delete($getuser)) {
            $this->Flash->success('User Deleted!');
        } else {
            $this->Flash->error('Please try again!');
        }
        $this->redirect($this->referer());
    }
    public function contactusform() {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $data = $this->request->data;
            $this->loadModel('Contacts');
            $c = $this->Contacts->newEntity();
            $c = $this->Contacts->patchEntity($c, $data);
            if ($this->Contacts->save($c)) {
                $response['status'] = "success";
            } else {
                $response['status'] = "error";
                $arr = [];
                //echo json_encode($c->errors());exit;
                foreach ($c->errors() as $key => $val) {
                    foreach ($val as $inv) {
                        $arr[] = $inv;
                    }
                }
                $response['message'] = implode(',', $arr);
            }
        }
        echo json_encode($response);
        exit;
    }
    public function contacttoadmin() {
        $this->loadModel('Contacts');
        if ($data = $this->request->data) {
            $c = $this->Contacts->newEntity();
            $data['user_id'] = $this->Auth->user('id');
            $data['name'] = $data['fname'] . ' ' . $data['lname'];
            $data['comment'] = $data['message'];
            $c = $this->Contacts->patchEntity($c, $data);
            if ($this->Contacts->Save($c)) {
                $this->Flash->success('Thank you for contacting us . Oue Support team will contact you soon .');
                $this->redirect();
            }
        }
    }
    function logs($user_id) {
        $this->loadModel('LoginLogs');
        $user_id = $this->mydecode($user_id);
        $list = $this->paginate($this->LoginLogs->find('all', ['conditions' => ['LoginLogs.user_id' => $user_id], 'Order' => ['LoginLogs.created DESC']]));
        $getuser = $this->Users->get($user_id);
        $this->set(compact('list', 'getuser'));
    }
}
