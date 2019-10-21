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
namespace App\Controller;

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
class GroupsController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow();
        $this->set('form_templates', Configure::read('Templates'));
        $this->loadComponent('Cookie');
        if($this->Auth->user('role')=='4')
        {
          $this->viewBuilder()->layout('learner');
        }
    }
    

    

   public function form($id = null)
   {
   	$this->is_permission($this->Auth->user());
    $this->loadModel('Users');
    $users = $this->Users->find('all',['conditions'=>['addedby'=>$this->Auth->user('id')],'fields'=>['id','fullname']])->toArray();
    if($id):
   	$chk = $this->Groups->is_exists($id,$this->Auth->user('id'));
    endif;
    $getParentCat = $this->Groups->find('list',['conditions'=>['addedby'=>$this->Auth->user('id')]]);
   	if($id && $chk==0)
   	{
   		$this->Flash->error('You cannot access that location'	);
   		$this->redirect($this->referer());
   	}
    if($id)
    {
      $group =  $this->Groups->get($id);
    }
    else
    {
      $group = $this->Groups->newEntity();  
    }
   	
    if($this->request->data)
    {
        $data = $this->request->data;
        
        if($data['behaviour'] == 'automatic')
        {
          $cond = [];
          for($i = 0; $i < count($data['fieldname']); $i ++)
          {
            if($data['rulename'][$i]=='ends_with')
            {
              $cond[] = $data['fieldname'][$i].' like "%'.$data['fieldval'][$i].'"';
            }
            else if($data['rulename'][$i] == 'start_with')
            {
             $cond[] = $data['fieldname'][$i].' like "'.$data['fieldval'][$i].'%"'; 
            }
            else if($data['rulename'][$i] == 'contains')
            {
             $cond[] = $data['fieldname'][$i].' like "%'.$data['fieldval'][$i].'%"'; 
            }
            else if($data['rulename'][$i] == 'equal')
            {
             $cond[$data['fieldname'][$i]] = $data['fieldval'][$i]; 
            }
            
          }

          $getu = $this->Users->find('list',['conditions'=>['addedby'=>$this->Auth->user('id'),$cond]])->toArray();
          $vals = array_keys($getu);
          $u = implode(',',$vals);
          
        }
        else
        {
          $this->request->data['users'] = implode(',',$data['users']);
        }
        $this->request->data['users'] = $u;
        $this->request->data['rules'] = json_encode($cond);
        $this->request->data['addedby'] = $this->Auth->user('id');
        $this->request->data['status'] = 1;
        $group = $this->Groups->patchEntity($group,$this->request->data);
        if($this->Groups->save($group))
        {
            $this->Flash->success('group Updated!');
            $this->redirect(['action'=>'index']);
        }
        else
        {
            $this->Flash->error('Please fix the issues mentioned below.');
        }
    }

    $this->set(compact('group','getParentCat','users'));
   }

  

   public function index()
   {
    $this->is_permission($this->Auth->user());
    $user_id = $this->Auth->user('id');
    $list = $this->Groups->find('all',['conditions'=>['Groups.addedby'=>$user_id]]);
    $list = $this->paginate($list);
    $this->set(compact('list'));

   }

   public function del($id=null)
   {
    $this->is_permission($this->Auth->user());
    if($id):
    $chk = $this->Groups->is_exists($id,$this->Auth->user('id'));
    if($chk == 1)
    {
      $del  = $this->Groups->del($id);
      if($del)
      {
        $this->Flash->success('group Deleted!');
      }
      else
      {
        $this->Flash->success('group could not be Deleted!');
      }


    }
    else
    {
        $this->Flash->error('You cannot delete this group.');
    }
    endif;

    $this->redirect($this->referer());
   }


   

}
