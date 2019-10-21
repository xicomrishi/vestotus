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
class VenuesController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['signup', 'activate', 'login', 'forgotPassword', 'resetPassword']);
        $this->set('form_templates', Configure::read('Templates'));
        $this->loadComponent('Cookie');
        if ($this->Auth->user('role') == '4') {
            $this->viewBuilder()->layout('learner');
        }
    }
    public function form($id = null) {
        $this->is_permission($this->Auth->user());
        $this->loadModel('Countries');
        $this->loadModel('States');
        $countries = $this->Countries->getList();
        $states = [];
        if ($id):
            $chk = $this->Venues->is_exists($id, $this->Auth->user('id'));
        endif;
        if ($id && $chk == 0) {
            $this->Flash->error('You cannot access that location');
            $this->redirect($this->referer());
        }
        if ($id) {
            $venue = $this->Venues->get($id);
            $states = $this->States->getbyCountry($venue['country_id']);
        } else {
            $venue = $this->Venues->newEntity();
        }
        if ($this->request->data) {
            $this->request->data['addedby'] = $this->Auth->user('id');
            $venue = $this->Venues->patchEntity($venue, $this->request->data);
            //pr($venue);exit;
            if ($this->Venues->save($venue)) {
                $this->Flash->success('venue Updated!');
                $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('Please fix the issues mentioned below.');
            }
        }
        $this->set(compact('venue', 'countries', 'states'));
    }
    public function index() {
        $this->is_permission($this->Auth->user());
        $user_id = $this->Auth->user('id');
        $this->loadModel('UserVenues');
        $assigned = $this->UserVenues->find('list', ['keyField' => 'id', 'valueField' => 'venue_id'])->where(['user_id =' => $user_id])->toArray();
        // pr($assigned); die;
        $list = [];
        if (!empty($assigned)) {
            // $list = $this->Venues->find('all', ['conditions' => ['Venues.addedby' => $user_id, 'id In' => $assigned]]);
            $list = $this->Venues->find('all', ['conditions' => ['id In' => $assigned]]);
            $list = $this->paginate($list);
        }
        $this->set(compact('list'));
    }
    public function delete($id = null) {
        $this->is_permission($this->Auth->user());
        if ($id):
            $chk = $this->Venues->is_exists($id, $this->Auth->user('id'));
            if ($chk == 1) {
                $del = $this->Venues->del($id);
                if ($del) {
                    $this->Flash->success('venue Deleted!');
                } else {
                    $this->Flash->success('venue could not be Deleted!');
                }
            } else {
                $this->Flash->error('You cannot delete this venue.');
            }
        endif;
        $this->redirect($this->referer());
    }
}