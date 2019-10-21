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
class EnrollKeysController extends AppController
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
    $this->loadModel('Departments');
    $this->loadModel('Courses');
    $departments = $this->Departments->find('list',['conditions'=>['parent_id'=>0,'addedby'=>$this->Auth->user('id')]]);
    $course = $this->Courses->find('all',['conditions'=>['status'=>2,'addedby'=>$this->Auth->user('id')]]);
    $defaultCourses = [];
    if($id):
   	$chk = $this->EnrollKeys->is_exists($id,$this->Auth->user('id'));
    endif;
    $getParentCat = $this->EnrollKeys->find('list',['conditions'=>['addedby'=>$this->Auth->user('id')]]);
   	if($id && $chk==0)
   	{
   		$this->Flash->error('You cannot access that location'	);
   		$this->redirect($this->referer());
   	}
    if($id)
    {
      $enrollkey =  $this->EnrollKeys->get($id);
      $getcourses = $this->Courses->find('all',['conditions'=>['id in '=>[$enrollkey['courses']]]])->toArray();
      foreach($getcourses as $courses)
      {
        $defaultCourses[$courses['id']] = $courses['title'];
        
      }
      $enrollkey['courses'] = $defaultCourses;
      $ckeys = array_keys($defaultCourses);
      $ckeys = implode(',',$ckeys);
    }
    else
    {
      $enrollkey = $this->EnrollKeys->newEntity();  
    }
   	
    if($this->request->data)
    {
      $data = $this->request->data;
      $data['addedby'] = $this->Auth->user('id');
      $data['start_date'] = date('Y-m-d',strtotime($data['start_date']));
      $data['end_date'] = date('Y-m-d',strtotime($data['end_date']));
      $data['courses'] = implode(',',$data['courses']);
      $enrollkey = $this->EnrollKeys->patchEntity($enrollkey,$data);
      //pr($data);exit;
      if($this->EnrollKeys->save($enrollkey))
      {
        $this->Flash->success('Key added');
        $this->redirect(['action'=>'index']);
      }
      else
      {
        $this->Flash->error('Please fix the errors below.');
      }
    }

    $this->set(compact('defaultCourses','enrollkey','getParentCat','users','departments','course','ckeys'));
   }

  

   public function index()
   {
    $this->is_permission($this->Auth->user());
    $user_id = $this->Auth->user('id');
    
    $this->loadModel('UserCourses');
    $assigned = $this->UserCourses
    ->find('list', [
        'keyField' => 'id',
        'valueField' => 'course_id'
    ])
    ->where(['user_id =' => $user_id])
    ->toArray();
    
   
    // $assigned=implode(',',$assigned);
    $list = $this->EnrollKeys->find('all',['conditions'=>['EnrollKeys.courses LIKE'=>'%'.implode(',',$assigned).'%'],'contain'=>['Departments','SubDepartments']]);
    
    if(empty($list)){
        $list = $this->EnrollKeys->find('all',['conditions'=>['EnrollKeys.courses LIKE'=>'%'.$assigned],'contain'=>['Departments','SubDepartments']]);
    }
     if(empty($list)){
        $list = $this->EnrollKeys->find('all',['conditions'=>['EnrollKeys.courses LIKE'=>$assigned.'%'],'contain'=>['Departments','SubDepartments']]);
    }
    
    //pr($list->toArray());exit;
    $list = $this->paginate($list);
    $this->set(compact('list'));

   }

   public function del($id=null)
   {
    $this->is_permission($this->Auth->user());
    if($id):
    $chk = $this->EnrollKeys->is_exists($id,$this->Auth->user('id'));
    if($chk == 1)
    {
      $del  = $this->EnrollKeys->del($id);
      if($del)
      {
        $this->Flash->success('Key Deleted!');
      }
      else
      {
        $this->Flash->success('Key could not be Deleted!');
      }


    }
    else
    {
        $this->Flash->error('You cannot delete this Key.');
    }
    endif;

    $this->redirect($this->referer());
   }


   public function shareKey()
   {
    $this->autoRender = false;
    if($this->request->isajax())
    {
      $data = $this->request->data;
      $emails = $data['emails'];
      $emails_arr = explode(',',$emails);
      $sendEmail = 1;
      $keyid = $data['id'];
      $getkey = $this->EnrollKeys->get($keyid);

      foreach( $emails_arr as $email )
      {
        $email = trim($email);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $sendEmail = 0;
        }
      }
      if($sendEmail==1)
      { 
       foreach( $emails_arr as $email )
        {
          $link = BASEURL.'users/enrollkey?key='.$getkey['key_name'].'&password='.$getkey['password'].'&sharer'.  base64_encode($this->Auth->user());
          $emaildata['slug'] = 'enrollkeyshare';
          $emaildata['email'] = $email;
          $emaildata['replacement'] = ['{link}'=>$link];
          $this->__sendEmail($emaildata);

        }
        $keydata['share'] = $getkey['share'].','.$emails;
        $getkey = $this->EnrollKeys->patchEntity($getkey,$keydata);
        if($this->EnrollKeys->save($getkey))
        {
          $response['status'] = 'success';
        }
        
      }
      else
      {
        $response['status'] = 'error';
        $response['errors'] = 'Invalid Emails.';
      }

      echo json_encode($response);

    }
   }


   

}

