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
class DepartmentsController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['signup','activate','login','forgotPassword','resetPassword']);
        $this->set('form_templates', Configure::read('Templates'));
        $this->loadComponent('Cookie');
        $this->isAuthorized($this->Auth->user());
        $this->set('sidebar','departments');
        $this->set('submenu','departments');
    }
    

    

   public function form($id = null)
   {
   	
    $getParentCat = $this->Departments->find('list',['conditions'=>['parent_id'=>0]]);
    if($id)
    {
      $department =  $this->Departments->get($id);
    }
    else
    {
      $department = $this->Departments->newEntity();  
    }
   	
    if($this->request->data)
    {
        $this->request->data['addedby'] = $this->Auth->user('id');
        $department = $this->Departments->patchEntity($department,$this->request->data);
        if($this->Departments->save($department))
        {
            $this->Flash->success('Department Updated!');
            $this->redirect(['action'=>'index']);
        }
        else
        {
            $this->Flash->error('Please fix the issues mentioned below.');
        }
    }
   if($id) $title='Update Department'; else $title='Add Department';
    $this->set(compact('department','getParentCat','title'));
   }

  

   public function index()
   {
    
    $user_id = $this->Auth->user('id');
    $list = $this->Departments->find('all',['contain'=>['ParentCategories','Users']]);
    $list = $this->paginate($list);
    $this->set(compact('list'));

   }

   public function delete($id=null)
   {
    $id = $this->mydecode($id);
    if($id):
      $del  = $this->Departments->delete_dpt($id);
      if($del)
      {
        $this->Flash->success('Department Deleted!');
      }
      else
      {
        $this->Flash->success('Department could not be Deleted!');
      }

  endif;

    $this->redirect($this->referer());
   }

   public function getSubdpt($id=null)
   {
    $this->autoRender = false;
    if($this->request->isajax())
    {
    $getsub= $this->Departments->find('all',['conditions'=>['parent_id'=>$id,'status'=>1]])->toArray();
    $list = [];
    foreach($getsub as $sub)
    {
      $list[$sub['id']] = $sub['title'];
    }
    echo json_encode($list);exit;
    }

   }


   

}
