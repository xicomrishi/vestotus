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
class LessonsController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['signup', 'activate', 'login', 'forgotPassword', 'resetPassword']);
        $this->set('form_templates', Configure::read('Templates'));
        $this->loadComponent('Cookie');
        $this->loadComponent('FileUpload');
        $this->loadModel('CourseChapters');
        $this->loadModel('Enrollments');
        if ($this->Auth->user('role') == '4') {
            $this->viewBuilder()->layout('learner');
        }
    }
    
    public function view($id = null) {
        $id = $this->mydecode($id); 
        //echo $id; die;
        $user_id = $this->Auth->user('id');
        // $lesson = $this->CourseChapters->exists($id);
        $prevchapter = '';
        $nextchapter = '';
        $lesson = $this->CourseChapters->find('all', ['conditions' => ['CourseChapters.id' => $id, 'CourseChapters.type !=' => 'assessment'], 'contain' => ['Courses', 'CourseFiles']])->last(); 
        if (!empty($lesson)) {
            //pr($lesson); die;
            $nxtlesson = $this->CourseChapters->find('all', ['fields' => ['id'], 'conditions' => ['type !=' => 'assessment', 'id >' => $id, 'course_id' => $lesson['course_id']], 'limit' => 1])->last();
            if ($nxtlesson):
                $nextchapter = $this->myencode($nxtlesson['id']);
            endif;
            $prevlesson = $this->CourseChapters->find('all', ['fields' => ['id'], 'conditions' => ['type !=' => 'assessment', 'id <' => $id, 'course_id' => $lesson['course_id']], 'limit' => 1])->last();
            if ($prevlesson):
                $prevchapter = $this->myencode($prevlesson['id']);
            endif;

            //automatic attendance
            $this->loadModel('Attendences');
            //check if user is enrolled to the course
            $enroll_chk = $this->Enrollments->UserEnrolledCourse($lesson->course_id,$user_id);
            // echo $enroll_chk; die;
            if($enroll_chk > 0){ // if enrolled
                $attend_mark = $this->Attendences->learnerMarkAutomaticAttendanceOfCourseChapter($user_id,$lesson->course_id,$lesson->id,$user_id);
                // var_dump($attend_mark);
            }

            // pr($lesson);exit;
            // $chk = $this->Enrollments->UserEnrolledCourse($lesson['course_id'],$user_id);
            /* if($chk > 0 &&)
            {
            }
            else
            {
            $this->redirect(['action'=>'pageNotFound','controller'=>'Error']);
            }*/
            $this->set(compact('lesson', 'prevchapter', 'nextchapter'));
        } else {
            $this->redirect(['action' => 'pageNotFound', 'controller' => 'Error']);
        }
    }

    public function update() {  //check a lesson completed
        $this->loadComponent('RequestHandler');

        $this->autoRender = false;
        $this->loadModel('CourseProgress');
        if ($this->request->isajax()) {
            
            // $this->CourseProgress->find('all', )
        
            $dbup['status'] = $this->request->data['status'];
            $dbup['course_id'] = $this->request->data['course_id'];
            $dbup['lesson_id'] = $this->request->data['lesson_id'];
            $dbup['user_id'] = $this->Auth->user('id');
            if($this->CourseProgress->updatedata($dbup)){
                $resultJ = json_encode(array('status' => 'true'));
            } else{
                $resultJ = json_encode(array('status' => 'false'));
            }
            $this->response->type('json');
            $this->response->body($resultJ);
            return $this->response;
            // $this->RequestHandler->renderAs($this, 'json');
        }
    }
    public function videoedit($id = null) {
        $this->viewBuilder()->layout(false);
        $videoget = $this->CourseChapters->get($id, ['contain' => ['CourseFiles']]);
        //pr($videoget);exit;
        $this->set(compact('videoget'));
    }
    public function audioedit($id = null) {
        $this->viewBuilder()->layout(false);
        $videoget = $this->CourseChapters->get($id, ['contain' => ['CourseFiles']]);
        //pr($videoget);exit;
        $this->set(compact('videoget'));
    }
    public function pptedit($id = null) {
        $this->viewBuilder()->layout(false);
        $videoget = $this->CourseChapters->get($id, ['contain' => ['CourseFiles']]);
        //pr($videoget);exit;
        $this->set(compact('videoget'));
    }
    public function assessmentedit($id = null) {
        $this->viewBuilder()->layout(false);
        $videoget = $this->CourseChapters->get($id, ['contain' => ['Assessments']]);
        // pr($videoget);exit;
        $this->set(compact('videoget'));
    }
    public function delFile($id = null) {
        $this->autoRender = false;
        $this->loadModel('CourseFiles');
        if ($id) {
            $get = $this->CourseFiles->get($id);
            //echo json_encode($get);exit;
            if ($get['filename']) {
                if ($get['type'] == 'videos') {
                    $file = CHAPTER_VIDEO_ROOT . $get['filename'];
                } else if ($get['type'] == 'audio') {
                    $file = CHAPTER_AUDIO_ROOT . $get['filename'];
                } else if ($get['type'] == "ppt") {
                    $file = CHAPTER_PPT_ROOT . $get['filename'];
                }
                //echo $file;exit;
                if (unlink($file)) {
                    if ($this->CourseFiles->delete($get)) {
                        echo "success";
                    } else {
                        echo "error";
                    }
                }
            }
        }
    }
    public function delAssessment($id = null) {
        $this->autoRender = false;
        if ($this->request->isajax()) {
            $this->loadModel('Assessments');
            $getid = $this->Assessments->get($id);
            if ($this->Assessments->delete($getid)) {
                echo "success";
            } else {
                echo "error";
            }
        }
    }
    public function reorder() {
        $this->autoRender = false;
        $course_id = $this->request->session()->read('Course.id');
        if ($this->request->isajax()) {
            $data = $this->request->data['data'];
            $i = 1;
            foreach ($data as $data) {
                $getlesson = $this->CourseChapters->get($data);
                $dt['lesson_no'] = $i;
                $getlesson = $this->CourseChapters->patchEntity($getlesson, $dt);
                $this->CourseChapters->save($getlesson);
                $i++;
            }
        }
    }
    public function quiz($id = null) { 
        $this->is_permission($this->Auth->user('id'));
        $id = $this->mydecode($id);
        $this->loadModel('CourseChapters');
        $check = $this->testPermission($id);
        // pr($check); die;
        if ($check['status'] == 'valid') {

            //public function learnerMarkAutomaticAttendanceOfCourseSession($user_id,$course_id,$session_id,$class_id){ 


            $lesson = $this->CourseChapters->find('all', ['conditions' => ['CourseChapters.type' => 'assessment', 'CourseChapters.course_id' => $id], 'contain' => ['Courses', 'Assessments']])->last();
            if (@$check['time'] > 0) {
                $lesson['time_limit'] = $check['time'];
                $teststatus = 1;
            } else {
                $teststatus = 0;
            }
            // pr($lesson);exit;
            $totalQuestions = count($lesson['assessments']);
            
            //mark automatic attendance

            $this->loadModel('Attendences');
            //check if user is enrolled to the course
            $enroll_chk = $this->Enrollments->UserEnrolledCourse($lesson->course_id,$this->Auth->user('id'));
            // echo $enroll_chk; die;
            if($enroll_chk > 0){ // if enrolled
                $attend_mark = $this->Attendences->learnerMarkAutomaticAttendanceOfCourseChapter($this->Auth->user('id'),$lesson['course_id'],$lesson['id'],$this->Auth->user('id'));
                // var_dump($attend_mark);
            }

            $this->set(compact('lesson', 'totalQuestions', 'teststatus'));
        } else {
            if ($check['data']) {
                $this->redirect(['action' => 'quizresult', $check['data']['course_id']]);
            } else {
                $this->redirect($this->referer());
            }
        }
    }
    public function assessmentstart() {
        $this->viewBuilder()->layout(false);
        $this->loadModel('Assessments');
        $this->loadModel('Onlinetests');
        $testid = $this->request->session()->read('test_id');
        if ($this->request->isajax() && $testid) {
            $data = $this->request->data;
            $course_id = $data['course_id'];
            $lesson_id = $data['lesson_id'];
            $user_id = $this->Auth->user('id');
            $cond = '';
            $next = '';
            $prev = '';
            if (@$data['id']) {
                $cond = ['id' => $this->mydecode($data['id']) ];
            }
            $lessonnum = $this->Assessments->find('all', ['conditions' => ['course_id' => $course_id, 'chapter_id' => $lesson_id], 'order' => ['id' => 'ASC']])->toArray();
            $lessono = [];
            $i = 1;
            foreach ($lessonnum as $num) {
                $lessono[$num['id']] = $i;
                $i++;
            }
            $lesson = $this->Assessments->find('all', ['conditions' => ['course_id' => $course_id, 'chapter_id' => $lesson_id, $cond], 'order' => ['id' => 'ASC'], 'limit' => 1])->last();
            $checkans = $this->Onlinetests->checkAns($course_id, $lesson['id'], $testid);
            $next = $this->Assessments->find('all', ['conditions' => ['course_id' => $course_id, 'chapter_id' => $lesson_id, 'id > ' => $lesson['id']], 'order' => ['id' => 'ASC'], 'limit' => 1])->last();
            if ($next) {
                $next = $this->myencode($next['id']);
            }
            //pr($next);exit;
            $prev = $this->Assessments->find('all', ['conditions' => ['course_id' => $course_id, 'chapter_id' => $lesson_id, 'id < ' => $lesson['id']], 'order' => ['id' => 'DESC'], 'limit' => 1])->last();
            if ($prev) {
                $prev = $this->myencode($prev['id']);
            }
            //pr($prev);exit;
            $this->set(compact('lesson', 'next', 'prev', 'lessono', 'checkans', 'testid'));
            // exit;
            
        }
    }
    private function testPermission($id = null) {
        //$this->autoRender = false;
        $this->loadModel('Courses');
        $this->loadModel('CourseProgress');
        $this->loadModel('OnlinetestSettings');
        $user_id = $this->Auth->user('id');
        $course = $this->Courses->get($id, ['contain' => ['CourseChapters', 'CourseResources']]);
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
            $testcheck['status'] = "invalid";
        } else {
            //$testcheck = "valid";
            $gettest = $this->OnlinetestSettings->check($user_id, $id);
            // pr($gettest);exit;
            if ($gettest) {
                if ($gettest['status'] == 2) {
                    $testcheck['status'] = "alreadytaken";
                } else if ($gettest['status'] == 1 && $gettest['time_limit'] > 0) {
                    $date1 = $gettest['startime']->format('Y-m-d H:i:s');
                    $date2 = date('Y-m-d H:i:s');
                    $getstarttime = strtotime($date1);
                    $now = strtotime($date2);
                    //$now = "2017-03-02 07:06:60";
                    $min = ($now - $getstarttime);
                    $gettesttime = $gettest['time_limit'];
                    if ($min > $gettesttime) {
                        $get = $this->completeQuiz($test_id, $gettest['course_id']);
                        $testcheck['status'] = "Invalid";
                        $testcheck['data'] = $get;
                        //$this->redirect(['action'=>'quizresult',$get['course_id']]);
                        
                    } else {
                        $testcheck['status'] = 'valid';
                        $testcheck['time'] = $gettesttime - $min;
                    }
                } else {
                    $testcheck['status'] = 'valid';
                    $testcheck['time'] = 'notime';
                }
            } else {
                $testcheck['status'] = "valid";
            }
        }
        return $testcheck;
    }
    public function saveQuiz() {
        $this->autoRender = false;
        $this->loadModel('Assessments');
        $this->loadModel('Onlinetests');
        if ($this->request->isajax()) {
            $test_id = $this->request->session()->read('test_id');
            if (isset($this->request->data['answer']) && $this->request->data['answer']) {
                $course_id = $this->request->data['course_id'];
                $answer = $this->request->data['answer'];
                $lesson_id = $this->request->data['lesson_id'];
                $aid = $this->request->data['id'];
                $getasses = $this->Assessments->get($aid);
                $dt['testid'] = $test_id;
                $dt['user_id'] = $this->Auth->user('id');
                $dt['course_id'] = $course_id;
                $dt['lesson_id'] = $lesson_id;
                $dt['answerbyuser'] = $answer;
                $dt['question_id'] = $aid;
                $dt['type'] = '1';
                if ($getasses['answer'] == $answer) {
                    $dt['status'] = 1;
                } else {
                    $dt['status'] = 0;
                }
                $chk = $this->Onlinetests->find('all', ['conditions' => ['testid' => $dt['testid'], 'user_id' => $dt['user_id'], 'question_id' => $aid]])->last();
                if ($chk) {
                    $test = $this->Onlinetests->get($chk['id']);
                } else {
                    $test = $this->Onlinetests->newEntity();
                }
                $test = $this->Onlinetests->patchEntity($test, $dt);
                //pr($test);
                if ($this->Onlinetests->save($test)) {
                    $response['status'] = 1;
                } else {
                    $response['status'] = 2;
                    $response['msg'] = "Technical Problem.";
                }
            } else {
                $response['status'] = 2;
                $response['msg'] = "Please select an answer.";
            }
            echo json_encode($response);
            exit;
        }
    }
    private function completeQuiz($testid, $course_id) {
        $this->loadModel('OnlinetestSettings');
        $this->loadModel('CourseChapters');
        $this->loadModel('Assessments');
        $this->loadModel('Onlinetests');
        $this->loadModel('TestResults');
        if ($testid) {
            $course = $this->CourseChapters->find('all', ['conditions' => ['type' => 'assessment', 'course_id' => $course_id]])->last();
            $getquestions = $this->Assessments->find('all', ['conditions' => ['course_id' => $course_id]])->count();
            $percent = $course['pass_percent'];
            $gettest = $this->Onlinetests->find('all', ['conditions' => ['course_id' => $course_id, 'testid' => $testid, 'status' => 1]])->count();
            $result = $gettest * 100 / $getquestions;
            $resultsave = $this->TestResults->newEntity();
            $dt['test_id'] = $testid;
            $dt['percent'] = $result;
            $dt['required_precent'] = $percent;
            $dt['user_id'] = $this->Auth->user('id');
            $dt['course_id'] = $course_id;
            if ($result >= $percent) {
                $dt['result'] = 'pass';
            } else {
                $dt['result'] = 'fail';
            }
            $resultsave = $this->TestResults->patchEntity($resultsave, $dt);
            //pr($dt);exit;
            if ($this->TestResults->save($resultsave)) {
                $check = $this->OnlinetestSettings->check($this->Auth->user('id'), $course_id, $testid);
                if ($check) {
                    $getset = $this->OnlinetestSettings->get($check['id']);
                    $dt['endtime'] = date('Y-m-d H:i:s');
                    $dt['status'] = 2;
                    $getset = $this->OnlinetestSettings->patchEntity($getset, $dt);
                    $this->OnlinetestSettings->save($getset);
                }
                $this->loadModel('CourseProgress');
                $getp = $this->CourseProgress->newEntity();
                $dt2['user_id'] = $this->Auth->user('id');
                $dt2['lesson_id'] = $course['id'];
                $dt2['course_id'] = $course_id;
                $dt2['is_completed'] = 1;
                $getp = $this->CourseProgress->patchEntity($getp, $dt2);
                $this->CourseProgress->save($getp);
                $response['status'] = 'success';
                $response['result'] = $resultsave['result'];
                $response['course_id'] = $this->myencode($course_id);
            } else {
                $response['status'] = 'error';
            }
            return $response;
        }
    }
    public function testsubmit() {
        $this->autoRender = false;
        $this->loadModel('TestResults');
        $this->loadModel('Onlinetests');
        $this->loadModel('Courses');
        $this->loadModel('Assessments');
        $this->loadModel('CourseChapters');
        $this->loadModel('OnlinetestSettings');
        if ($this->request->isajax()) {
            @$testid = $this->request->data['testid'];
            if (!@$testid) {
                $testid = $this->request->session()->read('test_id');
            }
            $course_id = $this->request->data['course_id'];
            if ($testid) {
                $course = $this->CourseChapters->find('all', ['conditions' => ['type' => 'assessment', 'course_id' => $course_id]])->last();
                $getquestions = $this->Assessments->find('all', ['conditions' => ['course_id' => $course_id]])->count();
                $percent = $course['pass_percent'];
                $gettest = $this->Onlinetests->find('all', ['conditions' => ['course_id' => $course_id, 'testid' => $testid, 'status' => 1]])->count();
                $result = $gettest * 100 / $getquestions;
                $resultsave = $this->TestResults->newEntity();
                $dt = [];
                $dt['test_id'] = $testid;
                $dt['percent'] = $result;
                $dt['required_precent'] = (int)$percent;
                $dt['user_id'] = $this->Auth->user('id');
                $dt['course_id'] = $course_id;
                if ($result >= $percent) {
                    $dt['result'] = 'pass';
                } else {
                    $dt['result'] = 'fail';
                }

                $resultsave = $this->TestResults->patchEntity($resultsave, $dt);
                // pr($dt);
                // pr($resultsave);exit;
                if ($this->TestResults->save($resultsave)) {  
                    $this->loadModel('CourseProgress');
                    $getp = $this->CourseProgress->newEntity();
                    $dt2['user_id'] = $this->Auth->user('id');
                    $dt2['lesson_id'] = $course['id'];
                    $dt2['course_id'] = $course_id;
                    $dt2['is_completed'] = 1;
                    $getp = $this->CourseProgress->patchEntity($getp, $dt2);
                    $this->CourseProgress->save($getp);
                    $response['status'] = 'success';
                    $response['result'] = $resultsave['result'];
                    $response['course_id'] = $this->myencode($course_id);
                } else { 
                    $response['status'] = 'error';
                }
            }
            echo json_encode($response);
        }
    }
    public function quizresult($course_chapter_id = null) {
        $this->loadModel('TestResults');
        $this->loadModel('Onlinetests');
        $this->loadModel('Courses');
        $this->loadModel('Assessments');
        $this->loadModel('CourseChapters');
        if ($courseId) {
            $course_id = $this->mydecode($courseId);
            $testid = $this->request->session()->read('test_id');
            $getresult = $this->TestResults->find('all', ['conditions' => ['TestResults.user_id' => $this->Auth->user('id'), 'TestResults.course_id' => $course_id], 'contain' => ['Courses']])->last();
            $questions = $this->Assessments->find('all', ['conditions' => ['Assessments.course_id' => $course_id], 'contain' => ['Onlinetests' => ['conditions' => ['testid' => $getresult['test_id']]]]])->toArray();
            // pr($getresult);exit;
            $this->set(compact('getresult', 'questions'));
        }
    }
    public function quizview($course_chapter_id = null) { //for manager view
        $this->loadModel('TestResults');
        $this->loadModel('Onlinetests');
        $this->loadModel('Courses');
        $this->loadModel('Assessments');
        $this->loadModel('CourseChapters');

        if ($course_chapter_id) {
            $course_chapter_id = $this->mydecode($course_chapter_id);
            // $testid = $this->request->session()->read('test_id');
            // $getresult = $this->TestResults->find('all', ['conditions' => ['TestResults.user_id' => $this->Auth->user('id'), 'TestResults.course_id' => $course_id], 'contain' => ['Courses']])->last();
            /*$assessment = $this->Assessments->find('all', [
                    'conditions' => [
                        'Assessments.chapter_id' => $course_chapter_id
                    ],
                    'contain' => [
                        'CourseChapters' => [
                            'fields' => ['title','description','notes','pass_percent','test_type','time_limit']
                        ]
                    ]
                ])->toArray();*/

            $chapter = $this->CourseChapters->find('all', [
                    'fields' => ['id','title','description','notes','pass_percent','test_type','time_limit'],
                    'conditions' => [
                        'CourseChapters.id' => $course_chapter_id
                    ],
                    'contain' => [
                        'Assessments' => [
                            'fields' => ['id','chapter_id','question','options','answer']
                        ],
                        'Courses' => [
                            'fields' => ['id','title']
                        ]
                    ]
                ])->first();
            
            
            // pr($chapter);exit;
            $this->set(compact('chapter'));
        }
    }
}
