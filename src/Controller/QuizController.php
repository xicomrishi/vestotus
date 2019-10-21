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
class QuizController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow();
        $this->set('form_templates', Configure::read('Templates'));
        $this->loadComponent('Cookie');
        $this->loadComponent('FileUpload');
        $this->loadModel('OnlinetestSettings');
        if ($this->Auth->user('role') == '4') {
            $this->viewBuilder()->layout('learner');
        }
    }
    public function testStart() {
        $this->autoRender = false;
        $this->loadModel('CourseChapters');
        if ($this->request->isajax()) { 
            $data = $this->request->data;
            $user_id = $this->Auth->user('id');
            $course_id = $data['course_id'];
            $test_id = $this->request->session()->id() . $course_id;
            // pr($course_id); die;
            $assessment = $this->CourseChapters->getAssessment($course_id);
            // pr($assessment); die; 
            $check = $this->OnlinetestSettings->check($user_id, $course_id, $test_id);
            // pr($check); die; 
            // echo 'q'; die;
            if (!$check) { 
                $new = $this->OnlinetestSettings->newEntity();
                $data['test_id'] = $test_id;
                $data['user_id'] = $user_id;
                $data['course_id'] = $course_id;
                $data['startime'] = date('Y-m-d H:i:s');

                $data['status'] = 1;
                $data['time_limit'] = $assessment['time_limit'];
                $data['endtime'] = date('Y-m-d H:i:s',strtotime('+'.$data['time_limit'].' seconds',strtotime($data['startime'])));

                $new = $this->OnlinetestSettings->patchEntity($new, $data);
                // pr($new); die;
                if ($this->OnlinetestSettings->save($new)) {
                    $this->request->session()->write('test_id', $test_id);
                    echo "success";
                } else {
                    echo "error";
                }
            } else {
                echo "success";
            }
        } 
    }
    public function quizstart($id = null) {
        $this->is_permission($this->Auth->user('id'));
        $id = $this->mydecode($id);
        $this->loadModel('CourseChapters');
        $check = $this->testPermission($id);
        //pr($check);
        //exit;
        if ($check['status'] == 'valid') {
            $lesson = $this->CourseChapters->find('all', ['conditions' => ['CourseChapters.type' => 'assessment', 'CourseChapters.course_id' => $id], 'contain' => ['Courses', 'Assessments']])->last();
            $totalQuestions = count($lesson['assessments']);
            $this->set(compact('lesson', 'totalQuestions', 'teststatus', 'quesno'));
        } else {
            if ($check['data']) {
                $this->redirect(['action' => 'quizresult', $check['data']['course_id']]);
            } else {
                $this->redirect(['controller' => 'lessons', 'action' => 'quizresult', $this->myencode($id) ]);
            }
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
            $user_id = $this->Auth->user('id');
            $gettest = $this->OnlinetestSettings->check($user_id, $id);
            if (!$gettest) {
                $testid = $this->request->session()->id() . $id;
                $this->request->session()->write('test_id', $testid);
                $newEntity = $this->OnlinetestSettings->newEntity();
                $dt['user_id'] = $user_id;
                $dt['course_id'] = $id;
                $dt['test_id'] = $testid;
                $dt['status'] = 1;
                $dt['time_limit'] = 0;
                $dt['startime'] = date('Y-m-d h:i:s');
                $newEntity = $this->OnlinetestSettings->patchEntity($newEntity, $dt);
                if ($this->OnlinetestSettings->save($newEntity)) {
                    $testcheck['status'] = "valid";
                }
            } else {
                if ($gettest['status'] == 1) {
                    $testid = $gettest['test_id'];
                    $this->request->session()->write('test_id', $testid);
                    $testcheck['status'] = "valid";
                } else {
                    $testcheck['status'] = "invalid";
                }
            }
        }
        return $testcheck;
    }
    public function question() {
        $this->viewBuilder()->layout(false);
        $this->loadModel('Assessments');
        $this->loadModel('Onlinetests');
        if ($this->request->isajax()) {
            $data = $this->request->data;
            //pr($data);
            $course_id = $data['course_id'];
            $lesson_id = $data['lesson_id'];
            $user_id = $this->Auth->user('id');
            $cond = '';
            $next = '';
            $prev = '';
            $test_id = $this->request->session()->read('test_id');
            $check = $this->Onlinetests->getSolvedQues($course_id, $test_id);
            $quesids = $check['questions'];
            if ($quesids) {
                $cond[] = 'id not in (' . $quesids . ')';
            }
            $lessonnum = $this->Assessments->find('all', ['conditions' => ['course_id' => $course_id, 'chapter_id' => $lesson_id, ], 'order' => ['id' => 'ASC']])->toArray();
            $lessono = [];
            $i = 1;
            foreach ($lessonnum as $num) {
                $lessono[$num['id']] = $i;
                $i++;
            }
            $lesson = $this->Assessments->find('all', ['conditions' => ['course_id' => $course_id, 'chapter_id' => $lesson_id, $cond], 'order' => ['id' => 'ASC'], 'limit' => 1])->last();
            $testid = $this->request->session()->id();
            $checkans = $this->Onlinetests->checkAns($course_id, $lesson['id'], $this->Auth->user('id'));
            $next = $this->Assessments->find('all', ['conditions' => ['course_id' => $course_id, 'chapter_id' => $lesson_id, 'id > ' => $lesson['id']], 'order' => ['id' => 'ASC'], 'limit' => 1])->last();
            if ($next) {
                $next = $this->myencode($next['id']);
            }
            //pr($next);exit;
            $prev = $this->Assessments->find('all', ['conditions' => ['course_id' => $course_id, 'chapter_id' => $lesson_id, 'id < ' => $lesson['id']], 'order' => ['id' => 'DESC'], 'limit' => 1])->last();
            //pr($prev);exit;
            if ($prev) {
                $prev = $this->myencode($prev['id']);
            }
            $this->set(compact('lesson', 'next', 'prev', 'lessono', 'checkans', 'testid'));
            // exit;
            
        }
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
}
