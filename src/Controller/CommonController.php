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
class CommonController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow();
        $this->set('form_templates', Configure::read('Templates'));
        $this->loadComponent('Cookie');
        $this->loadComponent('FileUpload');
    }
    public function fileupload($id = null) {
        $this->autoRender = false;
        $session = $this->request->session();
        if ($this->request->isajax()) {
            $data = $this->request->data;
            $file = $this->FileUpload->upload($data['file']);
            if ($file['status'] == 'success') {
                $user_id = $this->Auth->user('id');
                $fl = substr($data['file'], strpos($data['file'], ".") + 1);
                $file = $session->write('file.' . $user_id . '.' . rand() . '_' . $fl, $file['filename']);
                $file = $session->read('file.' . $user_id);
                pr($file);
                exit;
                echo 'success';
                exit;
            } else {
                echo 'error';
                exit;
            }
            exit;
        }
    }
    public function filedelete($filename = null) {
        $this->autoRender = false;
        $session = $this->request->session();
        $user_id = $this->Auth->user('id');
        $file = $session->read('file.' . $user_id);
        pr($file);
        exit;
        $file = $this->FileUpload->upload($data['file']);
        if ($file['status'] == 'success') {
            $user_id = $this->Auth->user('id');
            $session->write('Chapters[' . $user_id . '][]', $file['filename']);
            echo 'success';
            exit;
        } else {
            echo 'error';
            exit;
        }
        exit;
    }
    public function getStates($country_id = null) {
        $this->autoRender = false;
        $this->loadModel('States');
        if ($country_id) {
            $s = $this->States->getbyCountry($country_id);
            echo json_encode($s);
        }
    }
    public function getCities($state_id = null) {
        $this->autoRender = false;
        $this->loadModel('Cities');
        if ($state_id) {
            $s = $this->Cities->getbyState($state_id);
            echo json_encode($s);
        }
    }

 }
