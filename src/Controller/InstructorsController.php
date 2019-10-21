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

class InstructorsController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['signup', 'activate', 'login', 'forgotPassword', 'resetPassword']);
        $this->set('form_templates', Configure::read('Templates'));
        $this->loadComponent('Cookie');
        if ($this->Auth->user('role') == '3') {
            $this->viewBuilder()->layout('instructor');
        }
        $this->loadComponent('FileUpload');

        //sidebar
/*        $this->loadModel('Sessions');
        $session_count = $this->Sessions->find('all', [
            'conditions' => [
                'Sessions.instructor_id' => $this->Auth->user('id'), 
                'Courses.status' => 2
            ], 
            'contain' => [
                'Courses', 
                'SessionClasses', 
                'SessionClasses.Venues'
            ]
        ])->count();
        */
        // $this->set(compact('session_count'));
        // echo $session_count; die;
    }

    public function dashboard() {
        $this->is_permission($this->Auth->user());
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
        $this->loadModel('Cities');
        $states = [];
        $cities = [];
        $countries = $this->Countries->getList();

        $profile = $this->Users->get($this->Auth->user('id'), ['contain' => 'Learners']);
        if (!empty($profile['country_id'])) {
            $states = $this->States->getbyCountry($profile['country_id']);
        }
        if (!empty($profile['state_id'])) {
            $cities = $this->Cities->getbyState($profile['state_id']);
        }

        // pr($profile); die;
        if ($this->request->data) {
            $data = $this->request->data;
            // pr($data); die;
            if ($data['password'] == '' && $data['confirm_password'] == '') {
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

            //my mk
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
            // pr($this->Users->save($profile)); die;
            // pr($profile);exit;
            if ($this->Users->save($profile)) {
                $this->Flash->success('Profile Saved!');
                $this->redirect(['action' => 'profile']);
            } else {
                $this->Flash->error('Please fix the errors below');
            }
        }
        $this->set(compact('profile','countries','states','cities'));
    }

    public function courses($not_used = null) {
        $this->loadModel('Sessions');
        $user_id = $this->Auth->user('id');
        $sessions = $this->Sessions->find('all', ['conditions' => ['Sessions.instructor_id' => $user_id, 'Courses.status' => 2], 'contain' => ['Courses', 'SessionClasses', 'SessionClasses.Venues']]);
        // pr($sessions->toArray());exit;
        $course = $this->paginate($sessions);
        // $total = $sessions->count();
        $this->set(compact('course'));
    }
}
