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
class CronController extends AppController
{
  public function beforeFilter(Event $event)
  {
        parent::beforeFilter($event);
        $this->Auth->allow();
        $this->loadComponent('Cookie');
        $this->loadComponent('FileUpload');
  }
  
  // Cron for automatic enroll users to course as per course rules set 
  public function EnrollUsers($id = null)
  {
    $this->autoRender = false;
    $this->__enrollUsers();
  }

  // Auotmatic Expire Courses as per their dates
  public function CouseExpire()
  {

  }
}
