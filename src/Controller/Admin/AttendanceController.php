<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Core\Configure;

class AttendanceController extends AppController
{
    public $paginate = [
        'limit' => 10,
        'order' => [
            'Users.id' => 'desc'
        ]
    ];

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('login','dashboard');
        $this->set('sidebar','users');
        $this->set('form_templates', Configure::read('Templates'));
    }

    public function index()
    {
        $this->loadModel('Attendences');
        $this->loadModel('Courses');
        $this->loadModel('Users');

        $user_id = $this->Auth->user('id');
        
        $search = $this->request->query;
        // $conditions = ['course_id'=>$course_id, 'student_id'=>$learner_id];
        $conditions = [];
        if ($search) {
            if (!empty($search['filter_course_id'])) {
                $conditions['Attendences.course_id = '] = $search['filter_course_id'];
            }
            if (!empty($search['filter_learner_id'])) {
                $conditions['Attendences.student_id = '] = $search['filter_learner_id'];
            }
            if (!empty($search['filter_status'])) {
                $conditions['Attendences.status = '] = $search['filter_status'];
            }
        }

        // $conditions[] = 'Enrollments.deleted IS NULL';

        // echo '<pre>'; print_r($conditions); die;
        //$conditions['Courses.addedby'] = $this->Auth->user('id');
        $list = $this->Attendences->find('all', 
                // ['fields' => ['Attendences.id','Attendences.created','Attendences.status'] ],
                ['conditions' => [$conditions], 
                'contain' => [
                    'Courses' => [
                        'fields' => ['title','type']
                    ],
                    'Student' => [
                        'fields' => ['fname','lname','username']
                    ],
                    'CourseChapters' =>[
                        'fields' => ['title']
                    ],
                    'Sessions' => [
                        'fields' => ['title']
                    ],
                ],
                'order' => ['Attendences.id' => 'desc']
            ]);
        
        $list = $this->paginate($list);
        $courses = $this->Courses->find('list', [ 'conditions' => ['status' => '2']]);
        $learners = $this->Users->find('all', [
                        'fields'=>['id','fname','lname','username'], 
                        'conditions' => ['role'=>4, 'status'=>1], 
                        'order' => ['fname' => 'asc'] 
                    ])->toArray();

        // echo '<pre>'; print_r($list); die;
        $this->set(compact('list','courses','learners','search'));
    }

    /*public function index($role=null)
    {
        $role=$this->mydecode($role);
        $this->loadModel('Users');
        $this->loadModel('Attendences');
        $users=$this->Users->find('all')->where(['Users.role'=>$role, 'Users.status'=>1])->toArray();
        // print_r($users);
        // die;
        foreach($users as $user)
        {
            $attendance=$this->Attendences->find()->where(['Date(Attendences.created)'=>date("Y-m-d"), 'Attendences.student_id'=>$user['id']])->first();

            $manager= $this->Users->find()->where(['Users.id'=>$user['assigntomanger']])->first();

            $instructor= $this->Users->find()->where(['Users.id'=>$user['assigntoinstructor']])->first();
            
            if(!empty($attendance))
            {
                $user['attendance']='Present';
            }
            else
            {
                $user['attendance']='Absent';
            }
            $user['manager']=$manager;
            $user['instructor']=$instructor;
        }

        $this->set('users', $users);
    }*/
}