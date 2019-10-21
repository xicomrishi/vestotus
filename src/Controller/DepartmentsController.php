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
class DepartmentsController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['signup', 'activate', 'login', 'forgotPassword', 'resetPassword']);
        $this->set('form_templates', Configure::read('Templates'));
        $this->loadComponent('Cookie');
        if ($this->Auth->user('role') == '4') {
            $this->viewBuilder()->layout('learner');
        }
    }

    public function index() {
        $this->is_permission($this->Auth->user());
        $user_id = $this->Auth->user('id');
        $this->loadModel('UserDepartments');
        $list = $this->UserDepartments->find('all', [
                  'fields' => ['UserDepartments.id','UserDepartments.modified','Departments.title'],
                  'conditions' => ['UserDepartments.user_id' => $user_id], 
                  'contain' => ['Departments','Departments.ParentCategories' => ['fields' => ['title']] ] 
                ]);
        // $list = $this->Departments->find('all', ['conditions' => ['Departments.addedby' => $user_id], 'contain' => 'ParentCategories']);

        $list = $this->paginate($list);
        // echo '<pre>'; print_r($list); die;
        $this->set(compact('list'));
    }

    public function form($id = null) {
        $this->is_permission($this->Auth->user());
        if ($id):
            $chk = $this->Departments->is_exists($id, $this->Auth->user('id'));
        endif;
        $getParentCat = $this->Departments->find('list', ['conditions' => ['parent_id' => 0, 'addedby' => $this->Auth->user('id') ]]);
        if ($id && $chk == 0) {
            $this->Flash->error('You cannot access that location');
            $this->redirect($this->referer());
        }
        if ($id) {
            $department = $this->Departments->get($id);
        } else {
            $department = $this->Departments->newEntity();
        }
        if ($this->request->data) {
            $this->request->data['addedby'] = $this->Auth->user('id');
            $this->request->data['status'] = 1;
            $department = $this->Departments->patchEntity($department, $this->request->data);
            if ($this->Departments->save($department)) {
                $this->Flash->success('Department Updated!');
                $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('Please fix the issues mentioned below.');
            }
        }
        $this->set(compact('department', 'getParentCat'));
    }

    public function delete($id = null) {
        $this->is_permission($this->Auth->user());
        if ($id):
            $chk = $this->Departments->is_exists($id, $this->Auth->user('id'));
            if ($chk == 1) {
                $del = $this->Departments->delete_dpt($id);
                if ($del) {
                    $this->Flash->success('Department Deleted!');
                } else {
                    $this->Flash->success('Department could not be Deleted!');
                }
            } else {
                $this->Flash->error('You cannot delete this department.');
            }
        endif;
        $this->redirect($this->referer());
    }
    public function getSubdpt($id = null) {
        $this->autoRender = false;
        if ($this->request->isajax()) {
            $getsub = $this->Departments->find('all', ['conditions' => ['parent_id' => $id, 'status' => 1]])->toArray();
            $list = [];
            foreach ($getsub as $sub) {
                $list[$sub['id']] = $sub['title'];
            }
            echo json_encode($list);
            exit;
        }
    }
}
