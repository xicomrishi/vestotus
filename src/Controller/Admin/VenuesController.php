<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Core\Configure;

class VenuesController extends AppController
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
        $this->set('submenu','venues');
    }


     public function index($type=null)
     {
       $this->isAuthorized($this->Auth->user());
        
        if($this->request->data)
        {
            if(@$this->request->data['Search'])
            {
                $searchData = $this->request->data['Search'];
                if($searchData['search_by'] == 'name')
                {
                $searchData['fullname'] =preg_replace('!\s+!', ' ', $searchData['fullname']);
                $conditions["or"]['fname Like '] = '%'.rtrim($searchData['fullname']).'%';
                $conditions["or"]['lname Like '] = '%'.rtrim($searchData['fullname']).'%';
                 $conditions["or"]['CONCAT(fname," " ,lname) Like '] = '%'.rtrim($searchData['fullname']).'%';
                }
                  
                

            }
            
        }
        $conditions['Venues.is_deleted'] = 0;
        $list = $this->paginate($this->Venues->find('all',['conditions'=>$conditions,'contain'=>['Users','States','Countries']]));
       
        
        $this->set(compact('list'));


    }

    public function view($id)
    {
        $id = $this->mydecode($id);
        $user = $this->Courses->get($id);
        $this->set(compact('user'));
    }

    public function delete($id)
    {
        $id = $this->mydecode($id);
        $c = $this->Courses->get($id);
        $c->is_deleted = 1;
        if($this->Courses->save($c))
        {
            $this->Flash->success('Course Deleted.');    
        }
        else{
            $this->Flash->error('Please try again.');
        }
        $this->redirect($this->referer());
    }

    public function form($id = null)
   {
    $this->loadModel('Countries');
    $this->loadModel('States');
    $id = $this->mydecode($id);
    $countries = $this->Countries->getList();
    $states = [];
    if($id):
    $chk = $this->Venues->is_exists($id,$this->Auth->user('id'));
    endif;
    
    if($id && $chk==0)
    {
        $this->Flash->error('You cannot access that location'   );
        $this->redirect($this->referer());
    }
    if($id)
    {
      $venue =  $this->Venues->get($id);
      $states = $this->States->getbyCountry($venue['country_id']);
    }
    else
    {
    $venue = $this->Venues->newEntity();  
    }
    
    if($this->request->data)
    {
       
        
        $this->request->data['addedby'] = $this->Auth->user('id');
        
       
        $venue = $this->Venues->patchEntity($venue,$this->request->data);
        //pr($venue);exit;
        if($this->Venues->save($venue))
        {
            $this->Flash->success('venue Updated!');
            $this->redirect(['action'=>'index']);
        }
        else
        {
            $this->Flash->error('Please fix the issues mentioned below.');
        }
    }

    $this->set(compact('venue','countries','states'));
   }


    
  
}