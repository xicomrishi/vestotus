<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Core\Configure;

class CoursereportsController extends AppController
{
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('login','dashboard');
        //$this->set('form_templates', Configure::read('Templates'));
        //$this->set('sidebar','courses');
        $this->loadComponent('FileUpload');
    }

    public function index()
    {
    	$this->loadModel('Courses');

    	$courses=$this->Courses->find('all')->order(['Courses.id'=>'Desc'])->toArray();
    	$this->set(compact('courses'));
    }

    public function coursenavigation()
    {
        if($this->request->is(['post', 'put']))
        {
            // print_r($this->request->data);
            // die;
            $this->viewBuilder()->setLayout('ajax');
            $this->loadModel('Courses');
            $data=$this->request->data;
            $course=$this->Courses->find('all')->where(['Courses.id'=>$data['courseid']])->first();
            $this->set('course', $course);
        }
    }
}