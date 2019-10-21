<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Core\Configure;

class PurchaseController extends AppController
{
    

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->set('form_templates', Configure::read('Templates'));
        $this->set('sidebar','ecommerce');
        $this->loadModel('Courses');
        $this->loadModel('Enrollments');
        $this->loadModel('PurchasedCourses');
        
    }

    public function index()
    {
      $this->paginate = ['contain'=>['Courses','Users'],'limit'=>10,'order' => [
            'Users.id' => 'desc'
        ],'sortWhitelist'=>['Courses.title','Users.fname','PurchasedCourses.created']];
      $list = $this->paginate($this->PurchasedCourses);
      $this->set(compact('list'));
    }

    public function enrollments($id = null)
    {
      if($id)
      {
        $id = $this->mydecode($id);
        $this->paginate = ['conditions'=>['Enrollments.course_id'=>$id],'contain'=>['Courses'=>['fields'=>['thumbnail','title','purchase_price','id']],'Users'=>['fields'=>['fname','lname','id','role']],'Manager'=>['fields'=>['fname','lname','id']]],'limit'=>10,'order' => [
              'Users.id' => 'desc'
          ],'sortWhitelist'=>['Courses.title','Users.fname','Enrollments.created']];
        $list = $this->paginate($this->Enrollments);
        $submenu = "purchased_history";
        $this->set(compact('list','submenu'));

      }
    }


    
    
  
}