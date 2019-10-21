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
class QuizController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
    }

    

function comCourses(){
    $this->loadModel('Assessments');
     $this->loadModel('Courses');
    $courseIds= $this->Assessments
                    ->find('list', [
                        'keyField' => 'id',
                        'valueField' => 'course_id'
                    ])
                    // ->group(['course_id'])
                    ->toArray();
    $courseIds = array_unique($courseIds);
    // pr($courseIds); die;
    
    if(!empty($courseIds)){
         $list = $this->paginate($this->Courses->find('all',['conditions'=>['is_deleted != '=>1,'Courses.id IN'=>$courseIds],'contain'=>['CourseChapters','CourseChapters.CourseFiles','EnrollRules','CourseResources','CourseNotifications'],'recursive'=>-1]));
    }else{
        $list=[];
    }
      

            //pr($course);exit;
        $this->set(compact('list'));
   }
   
   function assessments($id){
        $this->loadModel('Assessments');
      $list = $this->paginate($this->Assessments->find('all',['conditions'=>['Assessments.course_id'=>$id] , 'contain'=>['CourseChapters']] ));
 //   echo '<pre/>'  ; print_r($list);  echo '<pre/>' ; die;
      $this->set(compact('list'));
   }
   
   
   
    function results($id){
        $this->loadModel('TestResults');
      $list = $this->paginate($this->TestResults->find('all',['conditions'=>['TestResults.course_id'=>$id] , 'contain'=>['Users']] ));
  // echo '<pre/>'  ; print_r($list);  echo '<pre/>' ; die;
      $this->set(compact('list'));
   }
   
   

}
