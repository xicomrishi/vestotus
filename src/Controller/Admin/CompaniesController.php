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
class CompaniesController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        //$this->Auth->allow(['signup','activate','login','forgotPassword','resetPassword']);
        $this->set('form_templates', Configure::read('Templates'));
        $this->loadComponent('Cookie');
        $this->loadComponent('FileUpload');
        $this->isAuthorized($this->Auth->user());
        $this->set('sidebar', 'companies');
        $this->set('submenu', 'companies');
    }
    public function form($id = null) {
        $getParentCat = $this->Companies->find('list', ['conditions' => ['parent_id' => 0]]);
        if ($id) {
            $company = $this->Companies->get($id);
        } else {
            $company = $this->Companies->newEntity();
        }
        if ($this->request->data) {
            $this->request->data['addedby'] = $this->Auth->user('id');
            $this->request->data['status'] = 1;
            if ($this->request->data['image']['name']) {
                if ($company['logo']) {
                    @unlink(WWW_ROOT . 'uploads/' . $company['logo']);
                }
                $file = $this->FileUpload->image_upload($this->request->data['image']);
                if ($file['filename']) {
                    $this->request->data['logo'] = $file['filename'];
                }
            } else {
                unset($this->request->data['logo']);
            }
            $company = $this->Companies->patchEntity($company, $this->request->data);
            // print "<pre>";print_r($file);exit;
            if ($this->Companies->save($company)) {
                $this->Flash->success('Company Updated!');
                $this->redirect(['action' => 'index']);
            } else {
                // print "<pre>";print_r($company);exit;
                $this->Flash->error('Please fix the issues mentioned below.');
            }
        }

        if ($id) $title = 'Update Company';
        else $title = 'Add Company';
        $this->set(compact('company', 'title'));
    }
    public function index() {
        $user_id = $this->Auth->user('id');

        $search = $this->request->query;
        $conditions = [];
        if (!empty(@$search['keyword'])) {
            $conditions['company_name like'] = '%'.trim($search['keyword']).'%';
        }

        $this->paginate = ['conditions' => $conditions, 'contain' => ['Users']];
        $lists = $this->paginate($this->Companies);
        //$list = $this->Companies->find('all',['contain'=>['Users']])->toArray();
        //print "<pre>";print_r($list);exit;
        $this->set(compact('lists','search'));
    }
    public function delete($id = null) {
        $id = $this->mydecode($id);
        if ($id):
            $c = $this->Companies->get($id);
            if ($c['logo']) {
                @unlink(WWW_ROOT . 'uploads/' . $c['logo']);
            }
            $del = $this->Companies->delete($c);
            if ($del) {
                $this->Flash->success('Company Deleted!');
            } else {
                $this->Flash->success('Company could not be Deleted!');
            }
        endif;
        $this->redirect($this->referer());
    }

    public function profile($company_id) {

        $company_id = $this->mydecode($company_id);

        //company info
        $company = $this->Companies->find('all', [
                'conditions' => [
                    'id' => $company_id
                ],
            ])->first();
        // print "<pre>";print_r($company);exit;
        
        $courses = $this->get_company_all_courses($company_id);

        $this->loadModel('Users');
        $this->loadModel('Enrollments');
        $managers = $this->Users->find('all', [
            'fields' => ['id','fname','lname','username','email','phone','created'],
            'conditions' => [
                'company_id' => $company_id,
                'role' => 2
            ]
        ])->enableHydration(false)->toArray();

        $instructors = $this->Users->find('all', [
            'fields' => ['id','fname','lname','username','email','phone','created'],
            'conditions' => [
                'company_id' => $company_id,
                'role' => 3
            ]
        ])->enableHydration(false)->toArray();

        $learners = $this->Users->find('all', [
            'fields' => ['id','fname','lname','username','email','phone','created'],
            'conditions' => [
                'company_id' => $company_id,
                'role' => 4
            ]
        ])->enableHydration(false)->toArray();

        $enrollments = $this->Enrollments->find('all', [
                'fields' => ['id','user_id','course_id','created','enroll_method'],
                'conditions' => ['Enrollments.deleted IS NULL' ], 
                'contain' => [
                    'Courses' => [ 
                        'fields' => ['id','title','type'] 
                    ], 
                    'Users' => [
                        'fields' => ['id','fname','lname','username'],
                        'conditions' => [
                            'company_id' => $company_id
                        ]
                    ]
                ], 
                'order' => ['Courses.id' => 'DESC'] 
            ])->enableHydration(false)->toArray();

        // print "<pre>";print_r($courses);
        // print "<pre>";print_r($managers);
        // exit;

        //get other assigned courses

        // print "<pre>";print_r($enrollments);exit;

        $this->set(compact('company','courses','managers','instructors','learners','enrollments'));
    }

    public function get_company_all_courses($company_id){ //get company courses

        $this->loadModel('Enrollments');
        $this->loadModel('UserCourses');
        $this->loadModel('Courses');
        
        // get enrolled courses
        $enrollments = $this->Enrollments->find('all', [
            'fields' => ['id','course_id','user_id'],
            'contain' => [
                'Users' => [
                    // 'fields' => ['id','fname','lname','company_id'],
                    'conditions' => [
                        'company_id' => $company_id
                    ]
                ]
            ],
            // 'group' => ['Enrollments.course_id']
        ])->enableHydration(false)->toArray();
        $enroll_course_ids = array_unique(array_column($enrollments,'course_id'));

        $user_courses_conditions = (!empty($enroll_course_ids)) ? ['UserCourses.course_id not in' => $enroll_course_ids ] : [];
        //get company's managers courses that they have not enrolled to any learner
        $user_courses = $this->UserCourses->find('all', [
            'fields' => ['UserCourses.id','course_id','user_id'],
            // 'conditions' => ['UserCourses.course_id not in' => $enroll_course_ids ],
            'conditions' => $user_courses_conditions,
            'contain' => [
                'Users' => [
                    // 'fields' => ['id','fname','lname','company_id'],
                    'conditions' => [
                        'company_id' => $company_id
                    ]
                ]
            ],
        ])
        ->enableHydration(false)->toArray();
        $user_course_ids = array_unique(array_column($user_courses,'course_id'));
        $all_course_ids = array_merge($enroll_course_ids,$user_course_ids);        

        if(!empty($all_course_ids)){
            $courses = $this->Courses->find('all', [
                'fields' => ['id','title','type','online_course_type','created'],
                'conditions' => ['id IN' => $all_course_ids]
            ])->enableHydration(false)->toArray();            
        } else{
            $courses = [];   
        }
        return $courses;
    }

}
