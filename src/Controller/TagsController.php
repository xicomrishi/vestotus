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
class TagsController extends AppController
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
    if($id):
   	$chk = $this->Tags->is_exists($id,$this->Auth->user('id'));
    endif;
    
   	if($id && $chk==0)
   	{
   		$this->Flash->error('You cannot access that location'	);
   		$this->redirect($this->referer());
   	}
    if($id)
    {
      $tag =  $this->Tags->get($id);
      
    }
    else
    {
    $tag = $this->Tags->newEntity();  
    }
   	
    if($this->request->data)
    {
       
        
        $this->request->data['addedby'] = $this->Auth->user('id');
        
       
        $tag = $this->Tags->patchEntity($tag,$this->request->data);
        //pr($tag);exit;
        if($this->Tags->save($tag))
        {
            $this->Flash->success('tag Updated!');
            $this->redirect(['action'=>'index']);
        }
        else
        {
            $this->Flash->error('Please fix the issues mentioned below.');
        }
    }

    $this->set(compact('tag','countries','states'));
   }

  

   public function index()
   {
    $this->is_permission($this->Auth->user());
    $user_id = $this->Auth->user('id');
    $list = $this->Tags->find('all',['conditions'=>['Tags.addedby'=>$user_id],]);
    $list = $this->paginate($list);
    $this->set(compact('list'));

   }

   public function delete($id=null)
   {
    $this->is_permission($this->Auth->user());
    if($id):
    $chk = $this->Tags->is_exists($id,$this->Auth->user('id'));
    if($chk == 1)
    {
      $del  = $this->Tags->del($id);
      if($del)
      {
        $this->Flash->success('tag Deleted!');
      }
      else
      {
        $this->Flash->success('tag could not be Deleted!');
      }


    }
    else
    {
        $this->Flash->error('You cannot delete this tag.');
    }
    endif;

    $this->redirect($this->referer());
   }


   

}
