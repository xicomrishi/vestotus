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

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ResourcesController extends AppController
{


     public $paginate = [
        'limit' => 8,
        'order' => [
            'id' => 'desc'
        ]
    ];
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow();
        $this->set('form_templates', Configure::read('Templates'));
        $this->loadComponent('Cookie');
        $this->loadComponent('FileUpload');
        $this->isAuthorized($this->Auth->user());
        $this->set('sidebar','courses');
        $this->set('submenu','resources');
        $this->loadModel('CourseResources');
    }
    

    

   public function form($id = null)
   {
    $id = $this->mydecode($id);
    $this->loadModel('Courses');
    $courses = $this->Courses->find('list',['conditions'=>['status'=>'2']])->toArray();
    

   	if($id)
    {
      $resource =  $this->CourseResources->get($id);
      
    }
    else
    {
    $resource = $this->CourseResources->newEntity();  
    }
   	
    if($this->request->data)
    {
       
          $img = $this->FileUpload->upload($data['files'],'uploads/courses/resources/');
          if($img['status']=='success')
          {
            $this->request->data['files'] = $img['filename'];
          }
        
          $this->request->data['addedby'] = $this->Auth->user('id');
        
       
        $resource = $this->CourseResources->patchEntity($resource,$this->request->data);
        //pr($tag);exit;
        if($this->CourseResources->save($resource))
        {
            $this->Flash->success('Data Updated!');
            $this->redirect(['action'=>'index']);
        }
        else
        {
            $this->Flash->error('Please fix the issues mentioned below.');
        }
    }

    $this->set(compact('resource','courses'));
   }

  

   public function index()
   {
    $user_id = $this->Auth->user('id');
    $list = $this->CourseResources->find('all',['contain'=>['Users','Courses']]);
    $list = $this->paginate($list);
    $this->set(compact('list'));

   }

   public function delete($id=null)
   {
      $id = $this->mydecode($id);  
      if($id):
        $del  = $this->CourseResources->del($id);
        if($del == 'success')
        {
          $this->Flash->success('Data Deleted!');
        }
        else
        {
          $this->Flash->success('Data could not be Deleted!');
        }
      endif;

      $this->redirect($this->referer());
   }


   

}
