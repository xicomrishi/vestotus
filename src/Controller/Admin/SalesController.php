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
class SalesController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow();
        $this->set('form_templates', Configure::read('Templates'));
        $this->loadComponent('Cookie');
        $this->isAuthorized($this->Auth->user());
        $this->set('sidebar', 'others');
        $this->set('submenu', 'sales');

        $this->loadModel('Payments');
    }

    public function index() {
        $user_id = $this->Auth->user('id');

        $sort_columns   = $this->Payments->schema()->columns();
        $sort_columns[] = 'Users.fname';
        
        $conditions = [];

        $date_range = @$this->request->query['date_range']; 
        if(!empty($date_range)){
            
            $date_arr   = explode('-',$date_range);
            $start_date = date_create_from_format("d/m/Y",trim($date_arr[0]));            
            $end_date   = date_create_from_format('d/m/Y',trim($date_arr[1]));            

            $start_date = date_format($start_date,'Y-m-d');
            $end_date   = date_format($end_date,'Y-m-d');
        } else{
            //by default show last 7 days sales
            $current_date = date('Y-m-d');
            $end_date = $current_date; 
            $start_date = date('Y-m-d', strtotime('-7 days'));
        }

        $conditions = array(
            'Payments.created >=' =>  $start_date,
            'Payments.created <=' => $end_date,
        );
        // echo '<pre>'; print_r($conditions); 

        $list = $this->Payments->find('all', [
            'fields' => ['id','order_num','amount','modified','user_id','created'],
            'contain' => [
                'Users' => [
                    'fields' => ['id','fname','lname','role'],
                ],
                'Users.UserRoles' => [
                    'fields' => ['id','name'],
                ],
                'Users.Companies' => [
                    'fields' => ['id','company_name'],
                ],

                // 'OrderItems.Courses',

            ],
            'conditions' => [
                $conditions,
                'Payments.status' => 1,
            ],
            'sortWhitelist' => $sort_columns,
            'order' => ['Payments.id' => 'desc']
        ]);
        $list = $this->paginate($list);

        $list_arr = json_decode(json_encode($list), true);
        $total_sale = array_sum(array_column($list_arr,'amount'));

        // echo '<pre>'; print_r($list); die;
        $this->set(compact('list','start_date','end_date','total_sale'));
    }

    public function view($id = null) {
        $id = $this->mydecode($id);

        $sale = $this->Payments->find('all', [
            // 'fields' => ['Payments.id','Payments.order_num','Payments.amount','Payments.modified','Payments.user_id','Users.id','Users.fname','Users.lname','Users.role', 'UserRoles.id', 'UserRoles.name'  ],
            // 'fields' => ['Payments.id','Payments.order_num','Payments.amount','Payments.modified','Payments.user_id','Users.id','Users.fname','Users.lname','Users.role', 'UserRoles.id', 'UserRoles.name'  ],
            'conditions' => [
                'Payments.id' => $id,
            ],
            'contain' => [
                'Users' => [
                    'fields' => ['id','fname','lname','role'],
                ],
                'Users.UserRoles' => [
                    'fields' => ['id','name'],
                ],                
                'Users.Companies' => [
                    'fields' => ['id','company_name'],
                ],
                'OrderItems' => [
                    'fields' => ['id','course_id','amount','quantity','price','order_num'],
                ],
                'OrderItems.Courses' => [
                    'fields' => ['id','title'],
                ]
            ],
        ])->first();
        // echo '<pre>'; print_r($sale); die;
        $this->set(compact('sale'));
    }

    /*public function form($id = null) {
        $id = $this->mydecode($id);
        if ($id) {
            $tag = $this->Payments->get($id);
        } else {
            $tag = $this->Payments->newEntity();
        }
        if ($this->request->data) {
            $this->request->data['addedby'] = $this->Auth->user('id');
            $tag = $this->Payments->patchEntity($tag, $this->request->data);
            //pr($tag);exit;
            if ($this->Payments->save($tag)) {
                $this->Flash->success('tag Updated!');
                $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('Please fix the issues mentioned below.');
            }
        }
        $this->set(compact('tag', 'countries', 'states'));
    }
    public function delete($id = null) {
        $id = $this->mydecode($id);
        if ($id):
            $del = $this->Payments->del($id);
            if ($del) {
                $this->Flash->success('tag Deleted!');
            } else {
                $this->Flash->success('tag could not be Deleted!');
            }
        endif;
        $this->redirect($this->referer());
    }*/
}
