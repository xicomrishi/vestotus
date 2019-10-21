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
class AttendencesController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['signup', 'activate', 'login', 'forgotPassword', 'resetPassword']);
        $this->set('form_templates', Configure::read('Templates'));
        $this->loadComponent('Cookie');
        if ($this->Auth->user('role') == '3') {
            $this->viewBuilder()->layout('instructor');
        } else if ($this->Auth->user('role') == '2') {
            $this->viewBuilder()->layout('default');
        }
        $this->loadComponent('FileUpload');
    }
    public function mark($course_id, $session_id, $class_id) {
        // echo '2'; die;
        $this->is_permission($this->Auth->user());
        $this->loadModel('Enrollments');
        $this->loadModel('Sessions');
        $course_id = $this->mydecode($course_id);
        $session_id = $this->mydecode($session_id);
        $class_id = $this->mydecode($class_id);
        $session = $this->Sessions->get($session_id);
        $getusers = $this->Enrollments->find('all', ['conditions' => ['Enrollments.course_id' => $course_id], 'contain' => ['Users']])->toArray();
        $presentlist = $this->Attendences->getAttendenceByClass($course_id, $class_id, 'present');
        // pr($getusers);exit;
        $data = $this->request->data;
        if ($data) {
            //pr($data);exit;
            foreach ($data['attendence'] as $data) {
                $new = $this->Attendences->newEntity();
                $chk = $this->Attendences->find('all', ['conditions' => ['Attendences.course_id' => $course_id, 'Attendences.session_id' => $session_id, 'Attendences.class_id' => $class_id, 'Attendences.student_id' => $data['user_id']], 'fields' => ['id' => 'id']])->last();
                if ($chk) {
                    $new = $this->Attendences->get($chk['id']);
                }
                $attdata['course_id'] = $course_id;
                $attdata['session_id'] = $session_id;
                $attdata['class_id'] = $class_id;
                $attdata['instructor_id'] = $session['instructor_id'];
                $attdata['addedby'] = $this->Auth->user('id');
                $attdata['status'] = $data['status'];
                $attdata['student_id'] = $data['user_id'];
                $new = $this->Attendences->patchEntity($new, $attdata);
                $this->Attendences->save($new);
            }
            $this->Flash->success('Attendence updated!');
            $this->redirect('');
        }
        $this->set(compact('getusers', 'presentlist'));
        //pr($getusers);exit;
        
    }
    public function markAttendence($course_id, $session_id) //for instructor
    {   
        $this->is_permission($this->Auth->user());
        $this->loadModel('Enrollments');
        $this->loadModel('Sessions');
        $course_id = $this->mydecode($course_id);
        $session_id = $this->mydecode($session_id);
        $session = $this->Sessions->find('all', ['conditions' => ['Sessions.id' => $session_id], 'contain' => ['SessionClasses']])->last();
        //pr($session);exit;
        $getusers = $this->Enrollments->find('all', ['conditions' => ['Enrollments.course_id' => $course_id], 'contain' => ['Users']])->toArray();
        //pr($presentlist);exit;
        $data = $this->request->data;
        if ($data) {
            //pr($data); exit;
            foreach ($data['attendence'] as $data) {
                if (isset($data['status'])) {
                    $status = $data['status'];
                } else {
                    $status = "absent";
                }
                $new = $this->Attendences->newEntity();
                $chk = $this->Attendences->find('all', ['conditions' => ['Attendences.course_id' => $course_id, 'Attendences.session_id' => $session_id, 'Attendences.class_id' => $data['class_id'], 'Attendences.student_id' => $data['user_id']], 'fields' => ['id' => 'id']])->last();
                if ($chk) {
                    $new = $this->Attendences->get($chk['id']);
                }
                $attdata['course_id'] = $course_id;
                $attdata['session_id'] = $session_id;
                $attdata['class_id'] = $data['class_id'];
                $attdata['instructor_id'] = $session['instructor_id'];
                $attdata['addedby'] = $this->Auth->user('id');
                $attdata['status'] = $status;
                $attdata['student_id'] = $data['user_id'];
                $new = $this->Attendences->patchEntity($new, $attdata);
                try {
                    $this->Attendences->save($new);
                }
                catch(Exception $e) {
                    echo $e;
                }
            }
            $this->Flash->success('Attendence updated!');
            $this->redirect('');
        }
        $this->set(compact('getusers', 'presentlist', 'session'));
        //pr($getusers);exit;
    }

    public function learnerMarkAutomaticAttendanceOfCourseSession($user_id,$course_id,$session_id,$class_id) //for learner
    {
        $user_id = $this->mydecode($user_id);
        $course_id = $this->mydecode($course_id);
        $session_id = $this->mydecode($session_id);
        $class_id = $this->mydecode($class_id);

        $this->loadModel('Attendences');
        $this->loadModel('Enrollments');

        $enroll_chk = $this->Enrollments->UserEnrolledCourse($course_id,$user_id);
        if($enroll_chk > 0){ // if enrolled
            $attend_mark = $this->Attendences->learnerMarkAutomaticAttendanceOfCourseSession($user_id,$course_id,$session_id,$class_id);
            if($attend_mark){
                $this->Flash->success('Attendence marked successfully!');
            } else{
                $this->Flash->error('Some error occured, please try again later');
            }
        // var_dump($attend_mark);
        }
        return $this->redirect($this->referer());
    }    

    public function grades($course_id, $session_id) {
        $this->is_permission($this->Auth->user());
        $this->loadModel('Enrollments');
        $this->loadModel('Sessions');
        $this->loadModel('Grades');
        $course_id = $this->mydecode($course_id);
        $session_id = $this->mydecode($session_id);
        $session = $this->Sessions->find('all', ['conditions' => ['Sessions.id' => $session_id], 'contain' => ['SessionClasses']])->last();
        //pr($session);exit;
        $getusers = $this->Enrollments->find('all', ['conditions' => ['Enrollments.course_id' => $course_id], 'contain' => ['Users']])->toArray();
        //pr($presentlist);exit;
        $data = $this->request->data;
        if ($data) {
            //pr($data); exit;
            foreach ($data['attendence'] as $data) {
                if (isset($data['status'])) {
                    $status = $data['status'];
                } else {
                    $status = "absent";
                }
                $new = $this->Grades->newEntity();
                $chk = $this->Grades->find('all', ['conditions' => ['instructor_id' => $session['instructor_id'], 'Grades.course_id' => $course_id, 'Grades.session_id' => $session_id, 'Grades.student_id' => $data['user_id']], 'fields' => ['id' => 'id']])->last();
                if ($chk) {
                    $new = $this->Grades->get($chk['id']);
                }
                $attdata['course_id'] = $course_id;
                $attdata['session_id'] = $session_id;
                $attdata['instructor_id'] = $session['instructor_id'];
                $attdata['addedby'] = $this->Auth->user('id');
                $attdata['grade'] = $data['grade'];
                $attdata['student_id'] = $data['user_id'];
                $new = $this->Grades->patchEntity($new, $attdata);
                try {
                    $this->Grades->save($new);
                }
                catch(Exception $e) {
                    echo $e;
                }
            }
            $this->Flash->success('Grades updated!');
            $this->redirect('');
        }
        $this->set(compact('getusers', 'session'));
        //pr($getusers);exit;
        
    }
    public function instructorAttendence() {
        $this->is_permission($this->Auth->user());
        $this->loadModel('Enrollments');
        $this->loadModel('Sessions');
    }
}
