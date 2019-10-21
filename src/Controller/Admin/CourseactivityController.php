<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Core\Configure;

class CourseactivityController extends AppController
{
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('login','dashboard');
    }

    public function index()
    {
    	$this->viewBuilder()->setLayout('ajax');
    	$this->loadModel('Enrollments');
        $this->loadModel('CourseProgress');
        $this->loadModel('CourseChapters');
    	$enrollments=$this->Enrollments->find('all')->where(['course_id'=>$this->request->data['courseid']])->order(['Enrollments.id'=>'Desc'])->contain(['Users', 'Manager'])->toArray();
    	//print_r($enrollments);
        
        foreach($enrollments as $enrollment)
        {
            $lessons=$this->CourseProgress->find('all')->where(['CourseProgress.course_id'=>$enrollment['course_id'], 'CourseProgress.user_id'=>$enrollment['user_id']])->toArray();
            $enrollment['lessons']=$lessons;
        }
        // print_r($enrollments);
        // die;
    	$this->set('enrollments', $enrollments);
    }


    public function courseenrolls()
    {
        $this->viewBuilder()->setLayout('ajax');
        $this->loadModel('Enrollments');
        $this->loadModel('CourseProgress');
        $this->loadModel('CourseChapters');
        if($this->request->is(['post', 'put']))
        {
            $courseid=$this->request->data['courseid'];
            $enrollments=$this->Enrollments->find('all')->where(['course_id'=>$courseid])->order(['Enrollments.id'=>'Desc'])->contain(['Users', 'Manager', 'Courses'])->toArray();
            $this->set('enrollments', $enrollments);
        }
    }

    public function enrolluserlist()
    {
        $this->viewBuilder()->setLayout('ajax');
        $this->loadModel('Enrollments');
        $this->loadModel('CourseProgress');
        $this->loadModel('CourseChapters');
        if($this->request->is(['post', 'put']))
        {
            $courseid=$this->request->data['courseid'];
            $enrollments=$this->Enrollments->find('all')->where(['course_id'=>$courseid])->order(['Enrollments.id'=>'Desc'])->contain(['Users', 'Manager', 'Courses'])->toArray();
            $this->set('enrollments', $enrollments);
        }
    }

    public function deletecourse()
    {
        $this->viewBuilder()->setLayout('ajax');
        $this->loadModel('Courses');
        $this->loadModel('Enrollments');
        $this->loadModel('CourseProgress');
        $this->loadModel('CourseChapters');
        if($this->request->is(['post', 'put']) && !empty($this->request->data['courseid']))
        {
            $course=$this->Courses->find('all')->where(['Courses.id'=>$this->request->data['courseid']])->first();
            //$this->set('course', $course);

            $courseid=$this->request->data['courseid'];
            
            $learners=$this->Enrollments->find('all')->select(['Enrollments.id', 'Enrollments.user_id', 'Users.fname', 'Users.lname'])->where(['Enrollments.course_id'=>$courseid])->contain(['Users'])->toArray();
            $this->set(compact('course', 'learners'));
        }  

        if($this->request->is(['post', 'put']) && !empty($this->request->data['course_id']))
        {
            $courseid=$this->request->data['course_id'];
            $learnerdata=explode(",", $this->request->data['learner']);
            $learner=$learnerdata[1];
            $enrollid=$learnerdata[0];
            $enrollment=$this->Enrollments->get($enrollid);
            if($this->Enrollments->delete($enrollment))
            {
                echo "User has been removed";
            }
            die;
        }    
    }
}