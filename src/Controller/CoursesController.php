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
class CoursesController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['signup', 'activate', 'login', 'forgotPassword', 'resetPassword']);
        $this->set('form_templates', Configure::read('Templates'));
        $this->loadComponent('Cookie');
        $this->loadComponent('FileUpload');
        if ($this->Auth->user('role') == '4') {
            $this->viewBuilder()->layout('learner');
        }
    }
    public function onlineCourse($id = null) {
        $this->is_permission($this->Auth->user());
        $this->loadModel('Users');
        $this->loadModel('Tags');
        $session = $this->request->session();
        $session->delete('Course.id');
        $tags = $this->Tags->find('list', ['conditions' => ['addedby' => $this->Auth->user('id') ]]);
        $getcourse = $this->Courses->find('all', ['conditions' => ['is_deleted != ' => 1, 'status' => '1', 'type' => 1, 'addedby' => $this->Auth->user('id') ]])->last();
        if ($id) {
            $session->write('Course.id', $id);
        } else if ($getcourse) {
            $session->write('Course.id', $getcourse['id']);
        }
        if ($session->read('Course.id')) {
            $course = $this->Courses->find('all', ['conditions' => ['is_deleted != ' => 1, 'Courses.id' => $session->read('Course.id') ], 'contain' => ['CourseChapters', 'CourseChapters.CourseFiles', 'EnrollRules', 'CourseResources', 'CourseNotifications'], 'recursive' => - 1])->last();
            //pr($course);exit;
            
        } else {
            $course = $this->Courses->newEntity();
        }
        //pr($course);exit;
        $this->set(compact('user', 'course', 'tags'));
    }
    public function instructorCourse($id = null) {
        $this->is_permission($this->Auth->user());
        $this->loadModel('Users');
        $this->loadModel('Tags');
        $this->loadModel('Venues');
        $session = $this->request->session();
        $session->delete('Course.id');
        $user_id = $this->Auth->user('id');
        $tags = $this->Tags->find('list', ['conditions' => ['addedby' => $this->Auth->user('id') ]]);
        $getcourse = $this->Courses->find('all', ['conditions' => ['is_deleted != ' => 1, 'status' => '1', 'type' => 2, 'addedby' => $this->Auth->user('id') ]])->last();
        $instructors = $this->Users->find('list', ['conditions' => ['addedby' => $this->Auth->user('id'), 'status' => 1, 'role' => 3], 'valueField' => 'fullname']);
        $venues = $this->Venues->find('list', ['conditions' => ['addedby' => $user_id], 'valueField' => 'title']);
        if ($id) {
            $session->write('Course.id', $id);
        } else if ($getcourse) {
            $session->write('Course.id', $getcourse['id']);
        }
        if ($session->read('Course.id')) {
            $course = $this->Courses->find('all', ['conditions' => ['is_deleted != ' => 1, 'Courses.id' => $session->read('Course.id') ], 'contain' => ['CourseChapters', 'CourseChapters.CourseFiles', 'EnrollRules', 'CourseResources', 'CourseNotifications', 'Sessions', 'Sessions.SessionClasses'], 'recursive' => - 1])->last();
            //pr($course);exit;
            
        } else {
            $course = $this->Courses->newEntity();
        }
        //pr($course);exit;
        $this->set(compact('user', 'course', 'tags', 'instructors', 'venues'));
    }
    
    public function index() {
        $this->is_permission($this->Auth->user());
        $this->loadModel('Courses');
        $user_id = $this->Auth->user('id');
        $this->paginate = ['order' => ['created' => 'DESC']];
        $this->loadModel('UserCourses');

        //get all course ids assigned to this manager
        $assigned = $this->UserCourses->find('list', ['keyField' => 'id', 'valueField' => 'course_id'])->where(['user_id =' => $user_id])->toArray();
        $courses = [];
        if (!empty($assigned)) {

            //get course details
            $qry = $this->Courses->find('all', ['conditions' => ['is_deleted' => 0, 'status' => 2, 'id In' => $assigned]]);
            $courses = $this->paginate($qry);
        }
            // pr($courses);exit;

        $this->set(compact('courses'));
    }
    public function delClass() {
        $this->autoRender = false;
        $this->loadModel('SessionClasses');
        if ($this->request->isajax()) {
            $data = $this->request->data;
            $id = $data['class_id'];
            $getclass = $this->SessionClasses->get($id);
            if ($this->SessionClasses->delete($getclass)) {
                $response['status'] = 'success';
            } else {
                $response['status'] = 'error';
            }
            echo json_encode($response);
        }
    }
    public function ajaxolcourse() {
        $this->autoRender = false;
        $session = $this->request->session();
        if ($this->request->isajax()) {
            $data = $this->request->data;
            if ($data['tab_name'] == 1) {
                @$data['addedby'] = $this->Auth->user('id');
                @$data['tag_id'] = implode(',', $data['tag_id']);
                if ($session->read('Course.id')) {
                    $course = $this->Courses->get($session->read('Course.id'));
                } else if (isset($data['id'])) {
                    $course = $this->Courses->get($data['id']);
                } else {
                    $course = $this->Courses->newEntity();
                    $data['status'] = 1;
                }
                if ($data['thumbnail']['name'] !== '') {
                    if ($course['thumbnail']) {
                        $this->FileUpload->delete_file('uploads/courses/thumb/' . $course['thumbnail']);
                    }
                } else {
                    unset($data['thumbnail']);
                }
                if ($data['image']['name'] !== '') {
                    if ($course['image']) {
                        $this->FileUpload->delete_file('uploads/courses/' . $course['image']);
                    }
                } else {
                    unset($data['image']);
                }
                //$data['status'] = 2;
                $check = $this->Courses->patchEntity($course, $data);
                if ($check->errors()) {
                    $response['status'] = 'error';
                    $errors = [];
                    foreach ($check->errors() as $key => $value) {
                        foreach ($value as $val) {
                            $errors[$key] = $val;
                        }
                    }
                    $response['error'] = $errors;
                } else {
                    $check = $this->Courses->patchEntity($course, $data);
                    //pr($check);exit;
                    if ($this->Courses->save($check)) {
                        // echo $course;exit;
                        if (isset($data['thumbnail']) && $data['thumbnail']['name'] !== '') {
                            $img = $this->FileUpload->upload($data['thumbnail'], 'uploads/courses/thumb/');
                            if ($img['status'] == 'success') {
                                $check->thumbnail = $img['filename'];
                            }
                            $this->Courses->save($check);
                        }
                        if (isset($data['image']) && $data['image']['name'] !== '') {
                            $img = $this->FileUpload->upload($data['image'], 'uploads/courses/');
                            if ($img['status'] == 'success') {
                                $check->image = $img['filename'];
                            }
                            $this->Courses->save($check);
                        }
                        $response['id'] = $check->id;
                        $response['status'] = 'success';
                        $session->write('Course.id', $check->id);
                    }
                }
            } else if ($data['tab_name'] == 2) {
                //pr($data);exit;
                $id = $session->read('Course.id');
                if ($id) {
                    $course = $this->Courses->get($id);
                    $dt['must_complete'] = $data['must_complete'];
                    $course = $this->Courses->patchEntity($course, $dt);
                    if ($this->Courses->save($course)) {
                        $response['status'] = 'success';
                    }
                } else {
                    $response['status'] = 'error';
                    $response['error_code'] = 1;
                }
            } else if ($data['tab_name'] == 3) {
                //pr($data);exit;
                $this->loadModel('EnrollRules');
                $id = $session->read('Course.id');
                if ($id) {
                    $course = $this->Courses->get($id);
                    $course = $this->Courses->patchEntity($course, $data);
                    if ($this->Courses->save($course)) {
                        if (count(@$data['EnrollRules']['fields']) > 0) {
                            $ttlrecords = count($data['EnrollRules']['fields']);
                            for ($i = 0;$i < $ttlrecords;$i++) {
                                $enroll_data['fieldname'] = $data['EnrollRules']['fields'][$i];
                                $enroll_data['rule'] = $data['EnrollRules']['rules'][$i];
                                $enroll_data['ruleval'] = $data['EnrollRules']['value'][$i];
                                $enroll_data['course_id'] = $id;
                                $enroll = $this->EnrollRules->newEntity();
                                $enroll = $this->EnrollRules->patchEntity($enroll, $enroll_data);
                                $this->EnrollRules->save($enroll);
                            }
                        }
                        $response['status'] = 'success';
                    }
                } else {
                    $response['status'] = 'error';
                    $response['error_code'] = 1;
                }
            } else if ($data['tab_name'] == 4) {
                $id = $session->read('Course.id');
                if ($id) {
                    $course = $this->Courses->get($id);
                    if (@$data['receive_certificate'] == 1) {
                        if ($data['certification_url']['name'] !== '') {
                            if ($course['certification_url']) {
                                $this->FileUpload->delete_file('uploads/courses/certificates/' . $course['certification_url']);
                            }
                            $img = $this->FileUpload->upload($data['certification_url'], 'uploads/courses/certificates/');
                            if ($img['status'] == 'success') {
                                $data['certification_url'] = $img['filename'];
                            }
                        } else {
                            if (!$course['certification_url']) {
                                $response['status'] = 'error';
                                $response['error']['certification_url'] = 'Please upload Ceritification';
                                echo json_encode($response);
                                exit;
                            }
                            unset($data['certification_url']);
                        }
                    }
                    $data['competencies'] = implode(',', $data['competencies']);
                    $course = $this->Courses->patchEntity($course, $data);
                    if ($this->Courses->save($course)) {
                        $response['status'] = 'success';
                    }
                } else {
                    $response['status'] = 'error';
                    $response['error_code'] = 1;
                }
            } else if ($data['tab_name'] == 5) {
                $this->loadModel('CourseNotifications');
                $errors = [];
                if (@$data['enrollment_email'] == 1 && @$data['enrollment_email_custom'] == 1) {
                    if ($data['enrollment_subject'] == '') {
                        $errors['enrollment_subject'] = 'Please enter subject';
                    }
                    if ($data['enrollment_body'] == '') {
                        $errors['enrollment_body'] = 'Please enter Email Text';
                    }
                }
                if (@$data['completion_email'] == 1 && @$data['completion_email_custom'] == 1) {
                    if ($data['completion_subject'] == '') {
                        $errors['completion_subject'] = 'Please enter subject';
                    }
                    if ($data['completion_body'] == '') {
                        $errors['completion_body'] = 'Please enter Email Text';
                    }
                }
                if (count($errors) > 0) {
                    $response['status'] = 'error';
                    $response['error'] = $errors;
                } else {
                    $response['status'] = 'success';
                    $id = $session->read('Course.id');
                    if ($id) {
                        $getcourse = $this->Courses->get($id);
                        $getcourse = $this->Courses->patchEntity($getcourse, $data);
                        if ($this->Courses->save($getcourse)) {
                            $response['status'] = 'success';
                            if (@$data['enrollment_email_custom'] == 1) {
                                $chk = $this->CourseNotifications->find('all', ['conditions' => ['course_id' => $id, 'slug' => 'enroll']])->last();
                                if ($chk) {
                                    $notify = $this->CourseNotifications->get($chk['id']);
                                } else {
                                    $notify = $this->CourseNotifications->newEntity();
                                }
                                $dt['slug'] = 'enroll';
                                $dt['subject'] = $data['enrollment_subject'];
                                $dt['content'] = $data['enrollment_body'];
                                $dt['course_id'] = $id;
                                $dt['addedby'] = $this->Auth->user('id');
                                $notify = $this->CourseNotifications->patchEntity($notify, $dt);
                                if ($this->CourseNotifications->save($notify)) {
                                    $response['status'] = 'success';
                                } else {
                                    $response['status'] = 'error';
                                    $response['error_code'] = 2;
                                }
                            }
                            if (@$data['completion_email_custom'] == 1) {
                                $notify = $this->CourseNotifications->newEntity();
                                $dt['slug'] = 'completion';
                                $dt['subject'] = $data['completion_subject'];
                                $dt['content'] = $data['completion_body'];
                                $dt['course_id'] = $id;
                                $dt['addedby'] = $this->Auth->user('id');
                                $notify = $this->CourseNotifications->patchEntity($notify, $dt);
                                if ($this->CourseNotifications->save($notify)) {
                                    $response['status'] = 'success';
                                } else {
                                    $response['status'] = 'error';
                                    $response['error_code'] = 2;
                                }
                            }
                        } else {
                            $response['status'] = 'error';
                            $response['error_code'] = 2;
                        }
                    } else {
                        $response['status'] = 'error';
                        $response['error_code'] = 1;
                    }
                }
            } else if ($data['tab_name'] == 6) {
                $this->loadModel('CourseResources');
                $id = $session->read('Course.id');
                if ($id) {
                    $newr = $this->CourseResources->newEntity();
                    $savedata['name'] = $data['resource_name'];
                    if ($data['resource_file']['name'] !== '') {
                        $img = $this->FileUpload->upload($data['resource_file'], 'uploads/courses/resources/');
                        if ($img['status'] == 'success') {
                            $savedata['files'] = $img['filename'];
                        }
                    }
                    $savedata['addedby'] = $this->Auth->user('id');
                    $savedata['course_id'] = $id;
                    $newr = $this->CourseResources->patchEntity($newr, $savedata);
                    if ($this->CourseResources->save($newr)) {
                        $response['status'] = 'success';
                        $response['content'] = '<div class="resourcesdiv" id="resourcediv_' . $newr['id'] . '"><a href="javascript:void(0);" id="' . $newr['id'] . '" class="delete_resource delete-btn" onclick="del_resource(' . $newr['id'] . ',1)"><i class="fa fa-trash-o" aria-hidden="true"></i> </a><div class="form-group"><label for="resource-name">Name</label><p>' . $newr['name'] . '</p></div><div class="form-group"> <label>File </label> <a href="/vestotus/uploads/courses/resources/' . $newr['files'] . '" target="_blank">' . $newr['files'] . '</a></div> </div>';
                    } else {
                        $response['status'] = 'error';
                        $errors = [];
                        foreach ($newr->errors() as $key => $value) {
                            foreach ($value as $val) {
                                if ($key == 'name') {
                                    $errors['resource_name'] = $val;
                                } else if ($key == 'files') {
                                    $errors['resource_file'] = $val;
                                }
                            }
                        }
                        $response['error'] = $errors;
                    }
                } else {
                    $response['status'] = 'error';
                    $response['error_code'] = 1;
                }
            }
            //$response['status'] = 'success';
            echo json_encode($response);
        }
    }
    public function addChapter($id = null) {
        $this->autoRender = false;
        $this->loadModel('CourseFiles');
        $session = $this->request->session();
        $this->loadModel('CourseChapters');
        @$id = $this->request->data['id'];
        if ($id) {
            $chapter = $this->CourseChapters->get($id);
        } else {
            $chapter = $this->CourseChapters->newEntity();
        }
        //echo 'dsdsd';
        if ($this->request->isajax()) {
            $data = $this->request->data;
            if ($data['type'] == 'assessment') {
                $this->loadModel('Assessments');
                $course_id = $session->read('Course.id');
                $getlastnum = $this->CourseChapters->find('all', ['conditions' => ['course_id' => $course_id], 'order' => ['lesson_no' => 'DESC'], 'limit' => 1])->toArray();
                $getassess = $this->CourseChapters->find('all', ['conditions' => ['course_id' => $course_id, 'type' => 'assessment']])->last();
                if ($getassess) {
                    $chapter = $this->CourseChapters->get($getassess['id']);
                }
                if ($getlastnum) {
                    $lastnum = $getlastnum[0]['lesson_no'] + 1;
                } else {
                    $lastnum = 1;
                }
                $data['course_id'] = $course_id;
                $data['lesson_no'] = $lastnum;
                if ($data['notes'] == '') {
                    unset($data['notes']);
                }
                if ($data['description'] == '') {
                    unset($data['description']);
                }
                if ($data['title'] == '') {
                    unset($data['title']);
                }
                $data['addedby'] = $this->Auth->user('id');
                $chapter = $this->CourseChapters->patchEntity($chapter, $data);
                $errors = [];
                if ($data['question'] == '') {
                    $errors['question'] = "Please enter Question";
                }
                if ($data['answer'] == '') {
                    $errors['answer'] = "Please enter Question";
                }
                $i = 1;
                foreach ($data['options'] as $options) {
                    if ($options == ''):
                        $errors['0_' . $i] = "Please enter Question";
                    endif;
                    $i++;
                }
                if (!in_array($data['answer'], $data['options'])) {
                    $errors['answer'] = "Invalid Answer.";
                }
                if ($chapter->errors() || !empty($errors)) {
                    $response['status'] = 'error';
                    foreach ($chapter->errors() as $key => $value) {
                        foreach ($value as $val) {
                            $errors[$key] = $val;
                        }
                    }
                    $response['error'] = $errors;
                } else {
                    if ($this->CourseChapters->save($chapter)) {
                        $data['options'] = json_encode($data['options']);
                        $data['chapter_id'] = $chapter->id;
                        $data['owner'] = $this->Auth->user('id');
                        $newAssesment = $this->Assessments->newEntity();
                        $newAssesment = $this->Assessments->patchEntity($newAssesment, $data);
                        //pr($newAssesment);exit;
                        if ($this->Assessments->save($newAssesment)) {
                            $response['status'] = "success";
                            $response['data'] = $data;
                            $response['id'] = $chapter->id;
                            $response['ass_id'] = $newAssesment->id;
                            //exit;
                            
                        }
                    }
                    // $response['status'] = 'success';
                    
                }
            } else {
                $course_id = $session->read('Course.id');
                $data['course_id'] = $course_id;
                $data['addedby'] = $this->Auth->user('id');
                $chapter = $this->CourseChapters->patchEntity($chapter, $data);
                if ($chapter->errors()) {
                    $response['status'] = 'error';
                    $errors = [];
                    foreach ($chapter->errors() as $key => $value) {
                        foreach ($value as $val) {
                            $errors[$key] = $val;
                        }
                    }
                    $response['error'] = $errors;
                } else {
                    if ($this->CourseChapters->save($chapter)) {
                        $response['status'] = 'success';
                        $response['id'] = $chapter->id;
                        $response['title'] = $chapter->title;
                        //pr($data);
                        if ($data['files']) {
                            foreach ($data['files'] as $files) {
                                if ($data['type'] == 'video') {
                                    $chk = $this->FileUpload->valid_video($files);
                                    $data['type'] = 'videos';
                                } else if ($data['type'] == 'audio') {
                                    $chk = $this->FileUpload->valid_audio($files);
                                } else if ($data['type'] == 'ppt') {
                                    $chk = $this->FileUpload->valid_ppt($files);
                                }
                                if ($chk == 'success') {
                                    $upload = $this->FileUpload->upload($files, 'uploads/courses/' . $data['type'] . '/');
                                    $fdata['course_id'] = $data['course_id'];
                                    $fdata['type'] = $data['type'];
                                    $fdata['chapter_id'] = $chapter['id'];
                                    $fdata['filename'] = $upload['filename'];
                                    $filesup = $this->CourseFiles->newEntity();
                                    $filesup = $this->CourseFiles->patchEntity($filesup, $fdata);
                                    $this->CourseFiles->save($filesup);
                                }
                            }
                        }
                    }
                }
            }
        }
        echo json_encode($response);
    }
    public function delEnrollrule($id = null) {
        $this->autoRender = false;
        $this->loadModel('EnrollRules');
        if ($id) {
            $rule = $this->EnrollRules->get($id);
            if ($this->EnrollRules->delete($rule)) {
                echo 'success';
            } else {
                echo 'error';
            }
        }
    }
    public function delResource($id = null) {
        $this->autoRender = false;
        $this->loadModel('CourseResources');
        if ($id) {
            $rule = $this->CourseResources->get($id);
            if ($this->CourseResources->delete($rule)) {
                echo 'success';
            } else {
                echo 'error';
            }
        }
    }
    function activateCourse() {
        $this->autoRender = false;
        $session = $this->request->session();
        $this->loadModel('EnrollRules');
        $cid = $session->read('Course.id');
        if ($cid) {
            $course = $this->Courses->get($cid);
            $cdata['status'] = 2;
            $course = $this->Courses->patchEntity($course, $cdata);
            if ($this->Courses->save($course)) {
                $this->__enrollUsers();
                $session->delete('Course.id');
                echo 'success';
            } else {
                echo 'error';
            }
        }
    }
    function delChapter() {
        $this->autoRender = false;
        if ($this->request->isajax()) {
            $data = $this->request->data;
            $chapter_id = $data['id'];
            $this->loadModel('CourseChapters');
            $this->loadModel('CourseFiles');
            $this->loadModel('Assessments');
            $chapter = $this->CourseChapters->get($chapter_id);
            if ($chapter['type'] == 'assessment') {
                $getfiles = $this->Assessments->deletebyChapter($chapter_id);
            } else {
                $getfiles = $this->CourseFiles->deletebyChapter($chapter_id);
            }
            if ($this->CourseChapters->delete($chapter)) {
                echo "success";
            } else {
                echo "error";
            }
        }
    }
    public function getcourses() {
        $this->autoRender = false;
        $term = $this->request->query['term']['term'];
        $user_id = $this->Auth->user('id');
        $check = $this->Courses->find('all', ['conditions' => ['is_deleted != ' => 1, 'addedby' => $user_id, 'status' => '2', 'title like "%' . $term . '%"']])->toArray();
        $getarr = [];
        $i = 0;
        foreach ($check as $check) {
            $getarr[$i]['id'] = $check['id'];
            $getarr[$i]['text'] = $check['title'];
            $i++;
        }
        $getarr['results'] = $getarr;
        echo json_encode($getarr);
        exit;
    }
    public function learnerCourses() {
        $this->is_permission($this->Auth->user('id'));
        $this->loadModel('Enrollments');
        $user_id = $this->Auth->user('id');
        $getCompletedCourses = $this->Enrollments->find('all', [
                'conditions' => ['Courses.is_deleted != ' => 1, 'Enrollments.deleted IS NULL', 'Enrollments.user_id' => $user_id, 'Courses.status' => 2, 'Courses.admin_approved' => 1], 
                'contain' => [
                    'Courses', 
                    'TestResults' => [
                        'conditions' => [
                            'TestResults.user_id' => $user_id
                        ]
                    ]
                ], 
                'order' => ['Courses.id' => 'DESC']
            ])->toArray();
        $getActiveCourses = $this->Enrollments->find('all', [
                'conditions' => ['Courses.is_deleted != ' => 1, 'Enrollments.deleted IS NULL', 'Enrollments.user_id' => $user_id, 'Courses.status' => 2, 'Courses.admin_approved' => 1], 
                'contain' => ['Courses'],
                'order' => ['Courses.id' => 'DESC']
            ])->toArray();
        //pr($getActiveCourses);exit;
        $this->set(compact('getActiveCourses', 'getCompletedCourses'));
    }

    public function view($id = null) { // view course detail
        if($this->request->query('buy')) {
            $buy = 'enable';
        } else{
            $buy = '';
        }

        $id = $this->mydecode($id); 
        $this->loadModel('Enrollments');
        $this->loadModel('CourseProgress');
        $this->loadModel('TestResults');
        $user_id = $this->Auth->user('id');
        $user_enroll_check = $this->Enrollments->UserEnrolledCourse($id,$user_id);
        $chk = 1;
        if ($chk == 1) {
            $course = $this->Courses->get($id, [
                        'contain' => [
                            'CourseChapters',
                            'CourseChapters.Attendences' => [
                                'conditions' => ['student_id' => $user_id ], 'fields' => ['id'] 
                            ], 
                            'CourseResources', 'CourseReviews', 'CourseReviews.Users'
                        ]
                    ]);
            // pr($course);exit;
            $testvalid = [];
            foreach ($course['course_chapters'] as $chapters) {
                if ($chapters['type'] !== 'assessment') {
                    $get = $this->CourseProgress->find('all', ['conditions' => ['course_id' => $chapters['course_id'], 'lesson_id' => $chapters['id'], 'user_id' => $user_id, 'is_completed' => 1]])->last();
                    if ($get) {
                        $testvalid[] = 1;
                    } else {
                        $testvalid[] = 0;
                    }
                }
            }
            if (in_array(0, $testvalid)) {
                $testcheck = "invalid";
            } else {
                $testcheck = "valid";
            }
            if ($this->TestResults->getResult($id, $user_id)) {
            // if ($this->TestResults->getResult($chapters['course_id'], $user_id)) {
                $testcheck = "invalid";
            } else {
                $testcheck = "valid";
            }
            $this->set(compact('course', 'testcheck','user_enroll_check','buy'));
        } else {
            $this->redirect($this->referer());
        }
    }
    public function viewIled($id = null) {
        $id = $this->mydecode($id);
        $this->loadModel('Enrollments');
        $this->loadModel('CourseProgress');
        $this->loadModel('TestResults');
        $user_id = $this->Auth->user('id');
        $chk = $this->Enrollments->UserEnrolledCourse($id, $user_id);
        if ($chk == 1) { 
            $course = $this->Courses->get($id, ['contain' => [
                'Sessions', 
                'Sessions.SessionClasses', 
                'Sessions.SessionClasses.Venues', 
                'CourseResources', 
                'CourseReviews', 
                'Sessions.SessionClasses.Attendences' => [
                    'conditions' => ['student_id' => $user_id ], 'fields' => ['id'] 
                ],
                'CourseReviews.Users'
            ]]);
            // pr($course); die;
            $this->set(compact('course','user_id'));
        } else {
            $this->redirect($this->referer());
        }
    }
    public function commentsave() {
        $this->autoRender = false;
        $this->loadModel('CourseReviews');
        if ($this->request->isajax()) {
            $data = $this->request->data;
            $reviews = $this->CourseReviews->newEntity();
            $data['user_id'] = $this->Auth->user('id');
            $reviews = $this->CourseReviews->patchEntity($reviews, $data);
            if ($reviews->errors()) {
                $response['status'] = "error";
                $errors = [];
                foreach ($reviews->errors() as $key => $values) {
                    foreach ($values as $val) {
                        $errors[$key] = $val;
                    }
                }
                $response['error'] = $errors;
            } else {
                if ($this->CourseReviews->save($reviews)) {
                    $response['status'] = "success";
                }
            }
            echo json_encode($response);
            exit;
        }
    }
    public function manageReviews() {
        $this->is_permission($this->Auth->user());
        $this->loadModel('CourseReviews');
        $user_id = $this->Auth->user('id');
        $qry = $this->CourseReviews->find('all', ['conditions' => ['Courses.addedby' => $user_id], 'contain' => ['Courses', 'Users']]);
        //pr($qry->toArray());exit;
        $reviews = $this->paginate($qry);
        $this->set(compact('reviews'));
    }
    public function reviewup($id = null, $status = null) {
        $this->autoRender = false;
        $id = $this->mydecode($id);
        $this->loadModel('CourseReviews');
        $getReview = $this->CourseReviews->get($id);
        //pr($getReview);exit;
        if ($status == 'del') {
            if ($this->CourseReviews->delete($getReview)) {
                $this->Flash->success('Review Deleted !');
                $this->redirect($this->referer());
            }
        } else if ($status < 2) {
            $dt['status'] = $status;
            $getReview = $this->CourseReviews->patchEntity($getReview, $dt);
            if ($this->CourseReviews->save($getReview)) {
                $this->Flash->success('Review Updated !');
                $this->redirect($this->referer());
            }
        }
        $this->redirect($this->referer());
    }
    public function sessionadd() {
        $this->autoRender = false;
        $courseid = $this->request->session()->read('Course.id');
        $this->loadModel('Sessions');
        $this->loadModel('SessionClasses');
        $response = [];
        $error = [];
        if ($this->request->isajax()) {
            $data = $this->request->data;
            if (isset($data['sessionsave'])) {
                $session = $this->Sessions->newEntity();
                $record = "new";
                if ($data['session_id']) {
                    $record = "old";
                    $session = $this->Sessions->get($data['session_id']);
                }
                $data['course_id'] = $courseid;
                $data['owner'] = $this->Auth->user('id');
                $session = $this->Sessions->patchEntity($session, $data);
                if ($session->errors()) {
                    $response['status'] = 'error';
                    $error = [];
                    foreach ($session->errors() as $key => $value) {
                        foreach ($value as $key1 => $val1) {
                            $error[$key] = $val1;
                        }
                    }
                    //$response['error'] = $error;
                    
                } else {
                    if ($this->Sessions->save($session)) {
                        $response['status'] = 'success';
                        $response['session_id'] = $session->id;
                        $response['record'] = $record;
                        $response['title'] = $session->title;
                        $response['hashid'] = $this->myencode($session->id);
                    }
                    //$class = $this->SessionClasses->newEntity();
                    //$data['session_id'] = $session->id;
                    //$class = $this->SessionClasses->patchEntity($class,$data);
                    
                }
            } else if (isset($data['saveclasses'])) {
                $data = $this->request->data;
                $data['course_id'] = $courseid;
                if (!$data['session_id']) {
                    $response['status'] = 'error';
                    $error = ['session_id' => 'Please Fill Details '];
                } else {
                    $newClass = $this->SessionClasses->newEntity();
                    if ($data['start_date']) {
                        $data['start_date'] = date('Y-m-d', strtotime($data['start_date']));
                    }
                    if ($data['end_date']) {
                        $data['end_date'] = date('Y-m-d', strtotime($data['end_date']));
                    }
                    $newClass = $this->SessionClasses->patchEntity($newClass, $data);
                    if ($newClass->errors()) {
                        $response['status'] = 'error';
                        $error = [];
                        foreach ($newClass->errors() as $key => $value) {
                            foreach ($value as $key1 => $val1) {
                                $error[$key] = $val1;
                            }
                        }
                    } else {
                        if ($this->SessionClasses->save($newClass)) {
                            $response['status'] = 'success';
                            $response['data'] = $data;
                            $response['data']['class_id'] = $newClass->id;
                        }
                    }
                }
            }
        }
        $response['error'] = $error;
        echo json_encode($response);
    }
    public function editsessionpopup($id = null) {
        $this->loadModel('Sessions');
        $this->loadModel('Users');
        $this->loadModel('Venues');
        $id = $this->mydecode($id);
        $user_id = $this->Auth->user('id');
        $session = $this->Sessions->get($id, ['contain' => ['SessionClasses']]);
        $instructors = $this->Users->find('list', ['conditions' => ['addedby' => $this->Auth->user('id'), 'status' => 1, 'role' => 3], 'valueField' => 'fullname']);
        $venues = $this->Venues->find('list', ['conditions' => ['addedby' => $user_id], 'valueField' => 'title']);
        $this->set(compact('session', 'instructors', 'venues'));
    }
    public function delSession($id = null) {
        $this->autoRender = false;
        $this->loadModel('Sessions');
        $get = $this->Sessions->get($id, ['contain' => ['SessionClasses']]);
        if ($this->Sessions->delete($get)) {
            $response = 'success';
        } else {
            $response = 'error';
        }
        echo $response;
    }
    public function ecomcourses() {
        if ($this->Auth->user('role') == '4') {
            return $this->redirect(['controller' => 'learners', 'action' => 'ecomcourses']);
        }
        $this->loadModel('PurchasedCourses');
        $getpurchasedcourses = $this->PurchasedCourses->find('all', ['conditions'])->last();
        $this->paginate = ['conditions' => ['Courses.status' => 2, 'Courses.enable_ecommerce' => 1, 'Courses.admin_approved' => 1], 'contain' => ['Users'], 'limit' => 12, 'order' => ['created' => 'DESC']];
        $ecom = $this->paginate($this->Courses);
        $this->set('menu', 'ecommerce');
        $this->set(compact('ecom'));
    }
    public function single($course_type,$id = null) {   
    // public function single($id = null,$course_type='online') {
        $id = $this->mydecode($id);
        // echo $id; die;
        $this->viewBuilder()->layout('default');
        $this->loadModel('Enrollments');
        $this->loadModel('CourseProgress');
        $this->loadModel('TestResults');
        $user_id = $this->Auth->user('id');

        // if ($course['type'] == 1) {
        // if ($course_type == 'online') {
        if ($course_type == 1) { 
            $course = $this->Courses->get($id, ['contain' => ['CourseChapters', 'CourseResources', 'CourseReviews', 'CourseReviews.Users']]);
            $this->set(compact('course'));
            $this->render('single-online');
        } else {
            $course = $this->Courses->get($id, ['contain' => ['Sessions', 'Sessions.SessionClasses', 'Sessions.SessionClasses.Venues', 'CourseResources', 'CourseReviews', 'CourseReviews.Users']]);
            $this->set(compact('course'));
            $this->render('single-led');
        }
    }
    
    public function courseCheckout() {
        $this->viewBuilder()->layout('default');
        $this->loadModel('Courses');
        $this->loadModel('PurchasedCourses');
        $this->loadModel('Payments');
        $this->loadModel('Users');
        $getsession = $this->request->session()->read('cart');

        if ($data = $this->request->data) {
        // print "<pre>";print_r($getsession); //exit;
            
            if (!in_array($this->Auth->user('role'),[2,4])) {
                $this->Flash->error('You are not authorized to access this page');
                return $this->redirect($this->referer());
            } 

            $ttl_price = 0;
            foreach ($getsession as $key => $val) { 
                $c = $this->Courses->get($key);
                $this->loadModel('EcomPricings');
                $price = $this->EcomPricings->get_course_price($c['id'], $this->Auth->user('id'));

                if (!$price) {
                    $ttl_price += ($c['purchase_price'] * $val);
                } else {
                    $ttl_price+= ($price * $val);
                }
            }
            // echo $ttl_price; die;
            // print "<pre>";print_r($data);exit;

            $order_id = "STOP-" . time() . $this->Auth->user('id');

            $this->loadComponent('Authorize');
            $data['cvv']            = 123;
            $card['number']         = $data['card_number'];
            $card['exp_date']       = $data['exp_year'] . '-' . $data['exp_month'];
            $card['cvv']            = $data['cvv'];
            $payment['amount']      = $ttl_price;
            $payment['invoice_no']  = time();
            $payment['description'] = $order_id;
            $customer['first_name'] = $data['fname'];
            $customer['last_name']  = $data['lname'];
            $customer['company']    = 'Stop';
            $customer['address']    = $data['address'];
            $customer['id']         = $this->Auth->user('id');
            $customer['email']      = $data['email'];
            // $customer['email'] = $data['email'];
            // $customer['email'] = $data['email'];
            // $customer['email'] = $data['email'];
            // $customer['email'] = $data['email'];

            // $customerAddress->setCity($customer['city']);
            // $customerAddress->setState($customer['state']);
            // $customerAddress->setZip($customer['zip']);
            // $customerAddress->setCountry($customer['country']);


            $auth = $this->Authorize->charge_card($card, $payment, $customer);
            // print "<pre>";print_r($auth);exit;
            //$payment_status = "success";
            $paymentRespData = json_encode($data);
            if (!empty(@$auth['transaction_id'])) {
                
                //payment info save start
                $paymentData['user_id']       = $this->Auth->user('id');
                $paymentData['phone']         = $data['phone'];
                $paymentData['address']       = $data['address'];
                $paymentData['card_type']     = $data['orderby'];
                $paymentData['email']         = $data['email'];
                $paymentData['name']          = $data['fname'] . ' ' . $data['lname'];
                $paymentData['postal_code']   = $data['zip'];
                $paymentData['order_num']     = $order_id;
                $paymentData['trans_id']      = $auth['transaction_id'];
                $paymentData['amount']        = $payment['amount'];
                $paymentData['status']        = 1;
                $paymentData['details']       = $paymentRespData;

                $payment = $this->Payments->newEntity();
                $payment = $this->Payments->patchEntity($payment, $paymentData);
                $this->Payments->save($payment);
                //payment info saved

                $user = $this->Users->get($this->Auth->user('id'));
                if ($user['phone'] == '') {
                    $user['phone'] = $data['phone'];
                    $this->Users->save($user);
                }
                //print "<pre>";print_r($payment);exit;

                //save purchased courses 
                foreach ($getsession as $key => $val) {
                    $c = $this->Courses->get($key);
                    $pur = $this->PurchasedCourses->newEntity();
                    $this->loadModel('EcomPricings');
                    $price = $this->EcomPricings->get_course_price($c['id'], $this->Auth->user('id'));
                    if (!$price) {
                        $price = $c['purchase_price'];
                    }
                    $pur['user_id'] = $this->Auth->user('id');
                    $pur['course_id'] = $key;
                    $pur['quantity'] = $val;
                    $pur['amount'] = $price * $val;
                    $pur['price'] = $price;
                    $pur['order_num'] = $order_id;
                    $pur['purchased_by'] = ($this->Auth->user('role') == 4) ? 'L' : 'M';
                    $pur['status'] = 1;

                    $pur_corse = $this->PurchasedCourses->save($pur);

                    if ($this->Auth->user('role') != 2) { //if user is not manager type, then enroll course to him
                        $this->loadModel('Enrollments');
                        $enroll = $this->Enrollments->newEntity();
                        $enroll['user_id'] = $this->Auth->user('id');
                        $enroll['course_id'] = $key;
                        $enroll['enroll_methods'] = 1;
                        $enroll['owner'] = $this->Auth->user('id');
                        $enroll['purchased_course_id'] = $pur_corse->id;

                        $this->Enrollments->save($enroll);

                        //after enrollment set enrolled users count equal to 1
                        $pur_corse->enrolled_users = 1; 
                        $this->PurchasedCourses->save($pur_corse);

                    }
                    
                }
                $this->request->session()->delete('cart');
                $this->Flash->success('Payment Successfull.');
                if ($this->Auth->user('role') == 2) {
                    return $this->redirect(['action' => 'mycourses']);
                } else if ($this->Auth->user('role') == 4) {
                    return $this->redirect(['action' => 'catalog', 'controller' => 'learners']);
                } else{
                    return $this->redirect($this->referer());
                }
            } else {
                $this->Flash->error($auth['error_message'] . @$auth['message']);
                // $this->Flash->error($auth['error_code'] . ' : ' . $auth['error_message'] . @$auth['message']);
                return $this->redirect($this->referer());
            }
        }
        if (count($getsession) > 0) {
            $course_id = implode(',', array_keys($getsession));
            $courses = $this->Courses->find('all', ['conditions' => ['id in (' . $course_id . ')', 'status' => 2, 'admin_approved' => 1]])->toArray();
        } else {    
            $courses = [];
        }
        $this->set(compact('courses', 'getsession'));
    }

    /* before mk
    public function courseCheckout() {
        $this->viewBuilder()->layout('default');
        $this->loadModel('Courses');
        $this->loadModel('PurchasedCourses');
        $this->loadModel('Payments');
        $this->loadModel('Users');
        $getsession = $this->request->session()->read('cart');
        if ($data = $this->request->data) {
        // print "<pre>";print_r($data);exit;
            $ttl_price = 0;
            foreach ($getsession as $key => $val) {
                $c = $this->Courses->get($key);
                $this->loadModel('EcomPricings');
                $price = $this->EcomPricings->get_course_price($c['id'], $this->Auth->user('id'));
                if (!$price) {
                    $ttl_price+= $c['purchase_price'];
                } else {
                    $ttl_price+= $price;
                }
            }
            $order_id = "STOP-" . time() . $this->Auth->user('id');
            $this->loadComponent('Authorize');
            $data['cvv']            = 123;
            $card['number']         = $data['card_number'];
            $card['exp_date']       = $data['exp_year'] . '-' . $data['exp_month'];
            $card['cvv']            = $data['cvv'];
            $payment['amount']      = $ttl_price;
            $payment['invoice_no']  = time();
            $payment['description'] = $order_id;
            $customer['first_name'] = $data['fname'];
            $customer['last_name']  = $data['lname'];
            $customer['company']    = 'Stop';
            $customer['address']    = $data['address'];
            $customer['id']         = $this->Auth->user('id');
            $customer['email']      = $data['email'];
            // $customer['email'] = $data['email'];
            // $customer['email'] = $data['email'];
            // $customer['email'] = $data['email'];
            // $customer['email'] = $data['email'];

            // $customerAddress->setCity($customer['city']);
            // $customerAddress->setState($customer['state']);
            // $customerAddress->setZip($customer['zip']);
            // $customerAddress->setCountry($customer['country']);

            $auth = $this->Authorize->charge_card($card, $payment, $customer);
            // print "<pre>";print_r($auth);exit;
            //$payment_status = "success";
            $paymentdata = json_encode($data);
            if (!empty(@$auth['transaction_id'])) {
                $payments = $this->Payments->newEntity();
                $p['user_id'] = $this->Auth->user('id');
                $p['phone'] = $data['phone'];
                $p['address'] = $data['address'];
                $p['card_type'] = $data['orderby'];
                $p['email'] = $data['email'];
                $p['name'] = $data['fname'] . ' ' . $data['lname'];
                $p['postal_code'] = $data['zip'];

                $p['details'] = $paymentdata;
                $p['order_num'] = $order_id;
                $p['trans_id'] = $auth['transaction_id'];
                $p['status'] = 1;
                $payments = $this->Payments->patchEntity($payments, $p);

                $user = $this->Users->get($this->Auth->user('id'));
                if ($user['phone'] == '') {
                    $user['phone'] = $data['phone'];
                    $this->Users->save($user);
                }
                //print "<pre>";print_r($payments);exit;
                $this->Payments->save($payments);
                foreach ($getsession as $key => $val) {
                    $c = $this->Courses->get($key);
                    $pur = $this->PurchasedCourses->newEntity();
                    $this->loadModel('EcomPricings');
                    $price = $this->EcomPricings->get_course_price($c['id'], $this->Auth->user('id'));
                    if (!$price) {
                        $price = $c['purchase_price'];
                    }
                    $pur['user_id'] = $this->Auth->user('id');
                    $pur['course_id'] = $key;
                    $pur['quantity'] = $val;
                    $pur['amount'] = $price * $val;
                    $pur['price'] = $price;
                    $pur['order_num'] = $order_id;
                    $pur['purchased_by'] = ($this->Auth->user('role') == 4) ? 'L' : 'M';
                    $pur['status'] = 1;

                    $pur_corse = $this->PurchasedCourses->save($pur);

                    if ($this->Auth->user('role') != 2) { //if user is not manager type, then enroll course to him
                        $this->loadModel('Enrollments');
                        $enroll = $this->Enrollments->newEntity();
                        $enroll['user_id'] = $this->Auth->user('id');
                        $enroll['course_id'] = $key;
                        $enroll['enroll_methods'] = 1;
                        $enroll['owner'] = $this->Auth->user('id');
                        $enroll['purchased_course_id'] = $pur_corse->id;

                        $this->Enrollments->save($enroll);

                        //after enrollment set enrolled users count equal to 1
                        $pur_corse->enrolled_users = 1; 
                        $this->PurchasedCourses->save($pur_corse);

                    }
                    
                }
                $this->request->session()->delete('cart');
                $this->Flash->success('Payment Successfull.');
                if ($this->Auth->user('role') == 2) {
                    return $this->redirect(['action' => 'mycourses']);
                } else {
                    return $this->redirect(['action' => 'catalog', 'controller' => 'learners']);
                }
            } else {
                $this->Flash->error($auth['error_message'] . @$auth['message']);
                // $this->Flash->error($auth['error_code'] . ' : ' . $auth['error_message'] . @$auth['message']);
                return $this->redirect($this->referer());
            }
        }
        if (count($getsession) > 0) {
            $course_id = implode(',', array_keys($getsession));
            $courses = $this->Courses->find('all', ['conditions' => ['id in (' . $course_id . ')', 'status' => 2, 'admin_approved' => 1]])->toArray();
        } else {    
            $courses = [];
        }
        $this->set(compact('courses', 'getsession'));
    }*/

    public function addtocart($course_id = null) {
        $this->autoRender = false;
        $cart = $this->request->session()->read('cart');
        //$this->request->session()->delete('cart');exit;
        //print "<pre>";print_r($cart);
        if ($cart) {
            $session = $cart;
            $session[$course_id] = 1;
            //$s = array_unique($session);
            $session_cart = $this->request->session()->write('cart', $session);
        } else {
            $session_cart = $this->request->session()->write('cart', [$course_id => 1]);
        }
        $cart = $this->request->session()->read('cart');
        //print "<pre>";print_r($cart);exit;
        $this->redirect(['action' => 'courseCheckout']);
    }
    public function removecart($id = null) {
        $this->autoRender = false;
        $id = $this->mydecode($id);
        $courses = $this->request->session()->read('cart');
        unset($courses[$id]);
        $courses = $this->request->session()->write('cart', $courses);
        $this->Flash->success('Course Removed.');
        $this->redirect($this->referer());
    }
    public function updatecart() {
        $this->autoRender = false;
        $cart = $this->request->session()->read('cart');
        if ($this->request->isajax()) {
            $data = $this->request->data;
            $cart[$data['id']] = $data['quantity'];
            $courses = $this->request->session()->write('cart', $cart);
        }
    }
    public function mycourses() {

        $this->loadModel('Users');
        //get manager assigned learners
        $users = $this->Users->getLearnersOfManager($this->Auth->user('id'));
        $users = array_values(array_flip($users));
        $user_ids = array_merge($users,[$this->Auth->user('id')]);
        // echo '<pre>'; print_r($users); die;

        $this->loadModel('PurchasedCourses');
        $courses = $this->PurchasedCourses->find('all', [
            'conditions' => [
                'PurchasedCourses.user_id IN ' => $user_ids, 
                // 'PurchasedCourses.user_id' => $this->Auth->user('id'), //old
                'PurchasedCourses.status' => 1
            ], 
            'contain' => ['Courses']
        ]);
        // print "<pre>";print_r($courses->toArray());exit;
        $list = $this->paginate($courses);
        $this->set(compact('list'));
    }
    public function uploadLogo() {
        $this->autoRender = false;
        if ($data = $this->request->data) {
            $this->loadModel('CourseImages');
            $cimages = $this->CourseImages->find('all', ['conditions' => ['course_id' => $data['course_id'], 'user_id' => $this->Auth->user('id') ]])->last();
            if ($cimages) {
                $this->FileUpload->delete_file('uploads/courses/' . $cimages['image']);
                $new = $this->CourseImages->get($cimages['id']);
            } else {
                $new = $this->CourseImages->newEntity();
            }
            $new['course_id'] = $data['course_id'];
            $new['user_id'] = $this->Auth->user('id');
            $image = $this->FileUpload->upload($data['image'], 'uploads/courses/');
            if ($image['status'] == 'success') {
                $new['image'] = $image['filename'];
            }
            $this->CourseImages->save($new);
            $this->Flash->success('Image Uploaded.');
        }
        $this->redirect($this->referer());
    }
    public function hideprice($course_id = null, $status) {
        $this->autoRender = false;
        $course = $this->Courses->get($course_id);
        $course['hide_price'] = intval($status);
        $this->Courses->save($course);
        $this->Flash->success('Record Updated.');
        $this->redirect(['action' => 'mycourses']);
    }
}