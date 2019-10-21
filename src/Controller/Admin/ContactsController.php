<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Core\Configure;


/**
 * Admin/badges Controller
 *
 * @property \App\Model\Table\Admin/badgesTable $Admin/badges
 */
class ContactsController extends AppController
{

    public $paginate = [
            'limit' =>5,
            'order' => [
                'Contacts.id' => 'desc'
            ]
        ];
        public function initialize()
        {
            parent::initialize();
            $this->loadComponent('Paginator');
            $this->loadComponent('FileUpload');
        }
        public function beforeFilter(Event $event)
        {
            parent::beforeFilter($event);
            $this->Auth->allow();
            $this->set('form_templates', Configure::read('Templates'));
        }
    public function index()
    {
        $this->isAuthorized($this->Auth->user());
        $pages = $this->Contacts->find('all',['contain'=>['Users'=>['fields'=>['role']]],'order'=>['Contacts.id'=>'desc']])->toArray();
        //print "<pre>";print_r($pages);exit;
        $this->set(compact('pages'));
        $this->set('_serialize', ['pages']);
    }

    

    public function delete($id = null)
    {
        $this->isAuthorized($this->Auth->user());
        $pages = $this->Contacts->get($id);
        if($this->Contacts->delete($pages))
        {
            $this->Flash->success('Request Deleted !');
            $this->redirect($this->referer());
        }
    }



    

   

    


   
    


}
