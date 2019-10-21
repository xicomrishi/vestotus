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
class SessionsController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow();
        $this->set('form_templates', Configure::read('Templates'));
        $this->loadComponent('Cookie');
        $this->loadComponent('FileUpload');
        $this->loadComponent('FileUpload');
        
        
    }
    
  public function index($course_id = null)
   {
    $this->is_permission($this->Auth->user('id'));
    $this->loadModel('SessionClasses');
    $course_id = $this->mydecode($course_id);
    if($course_id)
    {
      $getClasses = $this->SessionClasses->find('all',['conditions'=>['SessionClasses.course_id'=>$course_id,'Sessions.owner'=>$this->Auth->user('id')],'contain'=>['Venues','Sessions','Courses','Sessions.Instructors']])->toArray();
      /*  $data = $this->DataTables->find('SessionClasses', 'all',['conditions'=>['SessionClasses.course_id'=>$course_id,'Sessions.owner'=>$this->Auth->user('id')],'contain'=>'Sessions']);

      $this->set([
          'data' => $data,
          '_serialize' => array_merge($this->viewVars['_serialize'], ['data'])
      ]);*/
      //pr($getClasses);exit;
      $this->set(compact('getClasses'));
      
    }
    
   }

   

  


}
