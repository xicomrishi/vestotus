<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Core\Configure;

class LearnersideoptionsController extends AppController
{
    public $paginate = [
        'limit' => 10,
        'order' => [
            'Courses.id' => 'desc'
        ]
    ];

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('login','dashboard');
        $this->set('form_templates', Configure::read('Templates'));
        $this->set('sidebar','courses');
        $this->loadComponent('FileUpload');
    }

    public function index()
    {
        $this->loadModel('Users');
        $learners=$this->Users->find('all')->where(['Users.role'=>4])->order(['id'=>'desc'])->toArray();
        $this->set(compact('learners'));
    }

}
