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
class MessageController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
      
        
    }

    function index(){
        if($this->Auth->User('role')==2)
        {
            $this->viewBuilder()->layout('default');
        }
        if($this->Auth->user('role')=='4')
        {
          $this->viewBuilder()->layout('learner');
        }
        if($this->Auth->user('role')=='3')
        {
          $this->viewBuilder()->layout('instructor');
        }
        $user=$this->Auth->User();
        $userid = $this->Auth->User('id');
        $userrole = $this->Auth->User('role');
        $this->loadModel('Messages');
        $messages=$this->Messages->find('all')->where(['OR' => 
                    [
                        ['Messages.receiver_id' => 33, 'Messages.sender_id' => $userid],
                        ['Messages.sender_id' => 33, 'Messages.receiver_id' => $userid]
                    ]
                ])->order(['Messages.id'=>'Asc'])->toArray();
        $this->set(compact('userid', 'messages', 'userrole'));

         // $this->viewBuilder()->layout('admin');
         // $this->loadModel('Users');
         // $managers=$this->Users->find()->select(['Users.id','Users.fname','Users.lname'])->where(['Users.role'=>2])->all();
         // $instructors=$this->Users->find()->select(['Users.id','Users.fname','Users.lname'])->where(['Users.role'=>3])->all();
         // $learners=$this->Users->find()->select(['Users.id','Users.fname','Users.lname'])->where(['Users.role'=>4])->all();
           
         // $this->set(compact('managers','instructors','learners'));
    }

    function add()
    {
        if($this->request->is(['post']))
        {
            $this->autoRender = false;
            $this->loadModel('Messages');
            $this->viewBuilder()->setLayout('ajax');
            if(!empty($this->request->data)) {
                       
                $this->request->data['sender_id']=$this->Auth->user('id');
                $msg=$this->Messages->newEntity();
                $msg=$this->Messages->patchEntity($msg,$this->request->data);
                if($message = $this->Messages->save($msg)) {
                    $message["created_formatted"] = date('H:i', strtotime($message["created"]));
                    print json_encode($message);
                }
            }
        }
    }


    function refresh()
    {
        $this->viewBuilder()->layout('ajax');
        if($this->request->is(['post', 'put']))
        {
            if(!empty($this->request->data['userid']))
            {
                $this->loadModel('Users');
                $user=$this->Users->find()->where(['Users.id'=>$this->request->data['userid']])->first();
                if($user)
                {
                    $this->loadModel('Messages');
                    $userid=$this->Auth->user('id');
                    $messages=$this->Messages->find('all')->where(['OR' => 
                        [
                            ['Messages.receiver_id' => $this->request->data['userid'], 'Messages.sender_id' => $userid],
                            ['Messages.sender_id' => $this->request->data['userid'], 'Messages.receiver_id' => $userid]
                        ]
                    ])->order(['Messages.id'=>'Asc'])->toArray();
                    $this->set(compact('messages', 'userid'));
                }
                else
                {
                    $this->set("error", "You are not authorised to access this location.");
                }
            }
            else
            {
                $this->set("error", "Please provide userid and userrole.");
            }
        }
        else
        {
            $this->set("error", "Request method is not valid.");
        }
    }  
}
