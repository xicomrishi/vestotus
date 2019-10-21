<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\I18n\Time;
// use Carbon;

use Cake\Auth\DefaultPasswordHasher;

class UsersController extends AppController {
    public $paginate = ['limit' => 10, 'order' => ['Users.id' => 'desc']];
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow('login', 'dashboard');
        $this->set('sidebar', 'users');
        $this->set('form_templates', Configure::read('Templates'));

        // $this->loadHelper('Csv');

    }

    public function import() {
        $user = $this->Users->newEntity();
        $user_arr = [];
        if ($this->request->is('post')) {
            $filename = $this->request->data['import_csv']['tmp_name'];
            $role_id = $this->request->data['role_id'];
            $handle = fopen($filename, "r");
            $header = fgetcsv($handle);
            $i = 1;
            while (($row = fgetcsv($handle)) !== FALSE) {
                $i++; /* This is line 38 */
                $data = array();
                $user = $this->Users->newEntity();
                // for each header field
                foreach ($header as $k => $head) {
                    // get the data field from Model.field
                    if (strpos($head, '.') !== false) {
                        $h = explode(".", $head);
                        $data[$h[0]][$h[1]] = (isset($row[$k])) ? $row[$k] : "";
                    }
                    // get the data field from field
                    else {
                        $data[$head] = (isset($row[$k])) ? $row[$k] : "";
                    }
                }
                $data['role_id'] = $role_id;
                $user = $this->Users->patchEntity($user, $data);
                $msg = $this->Users->save($user);
                if (!$msg) {
                }
                if (empty($user_arr)) {
                } else {
                }
            }
        }
    }
    public function index($type = null) {
        $this->isAuthorized($this->Auth->user());
        if ($this->request->data) {
            if (isset($_FILES['file']) && $_FILES['file']['size']) {
                $filename = explode('.', $_FILES['file']['name']);
                if ($filename[1] == 'csv') {
                    $handle = fopen($_FILES['file']['tmp_name'], "r");
                    $header = fgetcsv($handle);
                    $i = 0;
                    while (($row = fgetcsv($handle)) !== FALSE) {
                        $i++; /* This is line 38 */
                        $data = array();
                        // for each header field
                        $j = 0;
                        foreach ($header as $k => $head) {
                            $j++;
                            $user = $this->Users->newEntity();
                            $data[$j] = (isset($row[$k])) ? $row[$k] : "";
                            $userArr['fname'] = $data[1];
                            $userArr['lname'] = $data[2];
                            $userArr['username'] = $data[3];
                            $userArr['email'] = $data[4];
                            $userArr['password'] = $data[5];
                            $userArr['role'] = $data[6];
                        }
                        $error = [];
                        $user = $this->Users->patchEntity($user, $userArr);
                        if ($user->errors()) {
                            $error[] = $data[4];
                        } else {
                            $this->Users->save($user);
                        }
                    }
                    if (empty($error)) {
                        $this->Flash->success('Data imported Successfully.');
                        $this->redirect(['action' => 'index']);
                    } else {
                        $error = implode(',', $error);
                        $this->Flash->error($error . ' could not be imported.');
                        $this->redirect(['action' => 'index']);
                    }
                }
            } else {
                if (@$this->request->data['Search']) {
                    $searchData = $this->request->data['Search'];
                    if ($searchData['search_by'] == 'name') {
                        $searchData['fullname'] = preg_replace('!\s+!', ' ', $searchData['fullname']);
                        $conditions["or"]['fname Like '] = '%' . rtrim($searchData['fullname']) . '%';
                        $conditions["or"]['lname Like '] = '%' . rtrim($searchData['fullname']) . '%';
                        $conditions["or"]['CONCAT(fname," " ,lname) Like '] = '%' . rtrim($searchData['fullname']) . '%';
                    } elseif ($searchData['search_by'] == 'email') {
                        $conditions['email Like '] = '%' . rtrim($searchData['fullname']) . '%';
                    }
                } else {
                    if ($this->request->data['action'] && $this->request->data['delIDs']) {
                        if ($this->request->data['action'] == 'activate'):
                            foreach ($this->request->data['delIDs'] as $id):
                                $msg = $this->Users->activate($id);
                            endforeach;
                        elseif ($this->request->data['action'] == 'deactivate'):
                            foreach ($this->request->data['delIDs'] as $id):
                                $msg = $this->Users->deactivate($id);
                            endforeach;
                        elseif ($this->request->data['action'] == 'delete'):
                            foreach ($this->request->data['delIDs'] as $id):
                                $msg = $this->Users->delUser($id);
                                $this->loadModel('Dishes');
                                $this->Dishes->deleteAll(['ownedby' => $id]);
                            endforeach;
                        endif;
                        if ($msg == 'done') {
                            $this->Flash->success('Data updated Successfully.');
                            $this->redirect(['action' => 'index']);
                        }
                    } else {
                        $this->Flash->error('Please select action .');
                    }
                }
            }
        }

        $role = array('learner' => 4, 'manager' => 2, 'instructor' => 3);
        if (!$type) {
            $type = 'learner';
        }
        $conditions['role'] = $role[$type];

        $archieved = $this->request->query('archieved');
        if($archieved == 'true'){  
            $conditions[] = ['Users.status' => 2];
        } else{
            $conditions[] = ['or' => [['Users.status' => 0], ['Users.status' => 1]]];
        }
        // var_dump($archieved); die;
        $this->paginate = ['conditions' => $conditions, 
                    'sortWhiteList' => ['Company.company_name'], 
                    'contain' => ['UserDepartments', 'UserCourses', 'Companies'], 
                    'order' => ['Users.lname' => 'asc']
                ];
        $list = $this->paginate($this->Users);
        // echo '<pre/>'; print_r($list); echo '<pre/>'; die;
        $this->set(compact('list','type','archieved'));
    }

    public function export_users(){
        $this->autoRender = false;
        $conds = $this->removeDashFromArrayKey($this->request->query);
        $users = $this->Users->find('all', [
            'fields' => ['id','username','role','created','email','fname','lname','status','zip','phone','company_id','manager_id','street','country_id','state_id'],
            'contain' => [
                'Countries' => [
                    'fields' => ['name']
                ],
                'States' => [
                    'fields' => ['name']
                ],
                'Cities' => [
                    'fields' => ['name']
                ],
                'Companies' => [
                    'fields' => ['company_name']
                ],
            ], 
            'conditions' => $conds,
            'order' => ['lname' => 'asc']
        ])
        ->toArray();

        if (ob_get_length() > 0) { ob_end_clean(); }
        $fileName = 'User-List'.'.csv';  

        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename={$fileName}");
        header("Expires: 0");
        header("Pragma: public");
        // create a file pointer connected to the output stream
        $file = fopen('php://output', 'w');

        fputcsv($file, array('SR.NO.','LAST NAME','FIRST NAME','USERNAME','ROLE','EMAIL','PHONE NO','STREET','CITY','STATE','COUNTRY','COMPANY','STATUS','ADDED ON'));

        foreach($users as $key => $row){
            
            if($row['role'] == 1){
                $role = 'Admin';
            } elseif($row['role'] == 2){
                $role = 'Manager';
            }else if($row['role'] == 3){
                $role = 'Instructor';
            }else if($row['role'] == 4){
                $role = 'Learner';
            }else{
                $role = '';
            }

            $status = ($row['status'] == 1) ? 'Active':'Inactive';

            fputcsv($file, array(++$key,ucfirst($row['lname']),$row['fname'],$row['username'],$role,$row['email'],$row['phone'],$row['street'],@$row['city']['name'],@$row['state']['name'],@$row['country']['name'],ucfirst(@$row['company']['company_name']),$status,$row['created']));
        }
        fclose($file);
        // Configure::write('debug', '0');
    }
    

    public function export_login_logs(){ //export_users_login_logs
        $this->autoRender = false;
        $this->loadModel('LoginLogs');

        $logs = $this->LoginLogs->find('all', [
            'contain' => [
                'Users' => [
                    'fields' => ['fname','lname','username','role']
                ],
            ], 
            'order' => ['LoginLogs.created' => 'desc']
        ])
        ->toArray();
        // echo '<pre>'; print_r($logs); die;

        if (ob_get_length() > 0) { ob_end_clean(); }
        $fileName = 'Users-Login-Logs'.'.csv';  

        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename={$fileName}");
        header("Expires: 0");
        header("Pragma: public");
        // create a file pointer connected to the output stream
        $file = fopen('php://output', 'w');

        fputcsv($file, array('SR.NO.','LAST NAME','FIRST NAME','USERNAME','LOGIN TIME','LOGOUT TIME','IP ADDRESS','DATE'));

        foreach($logs as $key => $row){

            fputcsv($file, array(++$key,ucfirst($row['user']['lname']),$row['user']['fname'],$row['user']['username'],$row['login_time'],$row['logout_time'],$row['ip'],$row['created']));
        }
        fclose($file);
        // Configure::write('debug', '0');
    }

    /*public function export_users(){
        //$user_type,$status
        $list = $this->Users->find('all',[
                    // 'conditions' => $conditions, 
                    'sortWhiteList' => ['Company.company_name'], 
                    'contain' => ['UserDepartments', 'UserCourses', 'Companies'], 
                    'order' => ['Users.lname' => 'asc']
                ])->toArray();

        $this->autoRender = false;

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=file.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('S.No.', 'Last Name', 'First Name', 'Email', 'Username','Role', 'Company','Created');

        $callback = function() use ($list, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            // foreach($reviews as $review) {
            //     fputcsv($file, array($review->reviewID, $review->provider, $review->title, $review->review, $review->location, $review->review_created, $review->anon, $review->escalate, $review->rating, $review->name));
            // }
            fclose($file);
        };
        // return 'true';
        // return Response::stream($callback, 200, $headers);
    }*/

    public function view($id) {
        $user = $this->Users->get($id);
        $this->set(compact('user'));
    }
    public function update($id = null) {
        $this->set('submenu', 'index');
        $user = $this->Users->newEntity();
        $record = 'add';
        if ($id) {
            $record = 'edit';
            $user = $this->Users->get($id);
        }
        if ($this->request->data) {
            $inp_pas = $this->request->data['password'];
            if ($this->request->data['password'] == '') {
                if (!$id) {
                    $this->request->password = md5(uniqid(rand(0, 1000000), true));
                }
                unset($this->request->data['password']);
            }
            $this->request->data['addedby'] = $this->Auth->user('id');
            $this->request->data['fullname'] = $this->request->data['fname'] . ' ' . $this->request->data['lname'];
            // echo '<pre>'; print_r($this->request->data); die;
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                if ($record == 'add') {
                    $emaildata['slug'] = 'account_created';
                    $emaildata['email'] = $user['email'];
                    $activate_link = BASEURL . 'users/login';
                    $emaildata['replacement'] = array('{fullname}' => $user['fullname'], '{username}' => $user['username'], '{password}' => $inp_pas, '{link}' => $activate_link);
                    $this->__sendEmail($emaildata);
                }
                $this->Flash->success(__('The user has been saved.'));
                // $role = array('learner'=>4,'manager'=>2,'instructor'=>3);
                $role = array(4 => 'learner', 2 => 'manager', 3 => 'instructor');
                return $this->redirect(['action' => 'index', $role[$user['role']]]);
            }
            $this->Flash->error(__('Unable to add the user.'));
        }
        $this->set('user', $user);
    }
    public function login() {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $error = '';
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($user->errors() && !@$user->errors() ['username']['unique']) {
                // $this->Flash->error(__("Please fix the errors highlighted in the fields below."));
                
            }
            if ($this->request->data['username'] == '' && $this->request->data['password'] == '') {
                $error = 'Please enter username and password. ';
            }
            if ($this->request->data['username'] !== '' && $this->request->data['password'] == '') {
                $error.= 'Please enter password.';
            }
            if ($this->request->data['username'] == '' && $this->request->data['password'] !== '') {
                $error.= 'Please enter username.';
            }
            if ($user->errors() && !@$user->errors() ['username']['unique']) {
                //$this->Flash->error(__($error));
                
            } else {
                $users = $this->Auth->identify();
                if ($users) {
                    if ($users['role'] == '1') {
                        $this->Auth->setUser($users);
                        return $this->redirect($this->Auth->redirectUrl());
                    } else {
                        $user->errors('email', ['unique' => '']);
                        $this->Flash->error(__('Email address or password is incorrect.Try again.'));
                    }
                }
                $user->errors('email', ['unique' => '']);
                $this->Flash->error(__('Email address or password is incorrect.Try again.'));
            }
        }
        // pr($user);exit;
        $this->set('user', $user);
    }
    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
    public function dashboard() {
        //echo 'hi';exit;
        $this->isAuthorized($this->Auth->user());
        $role = $this->Auth->user('role');
        $this->loadModel('Courses');
        $this->loadModel('Users');
        $this->loadModel('Messages');

        $recentCourses = $this->Courses->find('all', [
                'fields' => ['id','title','type','online_course_type','created'],
                'limit' => '5', 
                'order' => ['Courses.id' => 'DESC']
            ])->toArray();

        $query = $this->Users->find('all', ['conditions' => ['Users.role >' => 1]]);
        $userCount = $query->count();
        $query = $this->Users->find('all', ['conditions' => ['Users.role' => 2]]);
        $managerCount = $query->count();
        $query = $this->Users->find('all', ['conditions' => ['Users.role' => 3]]);
        $instructorCount = $query->count();
        $query = $this->Users->find('all', ['conditions' => ['Users.role' => 4]]);
        $learnerCount = $query->count();
        $query = $this->Courses->find('all', ['conditions' => ['is_deleted' => 0]]);
        $courseCount = $query->count();

        $recent_messages = $this->Messages->find('all', [
                'conditions' => ['receiver_id' => $this->Auth->user('id')],
                'contain' => [
                    'Sender' => [
                        'fields' => ['id','fname','lname']
                    ] 
                ],
                'limit' => '5',
                'order' => ['Messages.id' => 'desc']
            ])->toArray();

        // $now = Time::parse('2014-10-31');
         // $now = Carbon::parse('2014-10-31');

        // $now = new Time('2014-10-31');
        // echo $now; die;
        // echo '<pre>'; print_r($recent_messages); die;
        $this->set('sidebar', 'dashboard');

        $this->set(compact('recentCourses', 'userCount', 'managerCount', 'instructorCount', 'learnerCount', 'courseCount','recent_messages'));
    }
    public function delete($id = null) {
        $this->autoRender = false;
        $user = $this->Users->is_exists($id);
        if ($user) {
            $this->Users->newEntity();
            $delUser = $this->Users->get($id);
            $delUser['status'] = '2';    //deleted
            //pr($delUser);exit;
            if ($this->Users->save($delUser)) {
                $this->Flash->success(__('You have successfully deleted User'));
            }
        } else {
            $this->Flash->error(__('User does not exist , try again'));
        }
        $this->redirect($this->referer());
    }
    public function profile() {
        $this->isAuthorized($this->Auth->user());
        $profile = $this->Users->get($this->Auth->user('id'));
        if ($this->request->data) {
            if (!$this->request->data['password']) {
                unset($this->request->data['password']);
                unset($this->request->data['confirm_password']);
            }
            $profile = $this->Users->patchEntity($profile, $this->request->data);
            if ($this->Users->save($profile)) {
                $this->Flash->success('Profile Updated!');
                $this->redirect(['action' => 'profile']);
            }
        }
        $this->set(compact('profile'));
    }
    public function getManagers() {
        $this->autoRender = false;
        $list = $this->Users->find('all', ['conditions' => ['role' => 2, 'status' => 1], 'fields' => ['id', 'text' => "CONCAT(fname,' ',lname)"]])->toArray();
        echo json_encode($list);
    }
    function update_learner($id, $step = 1) {
        $this->set('submenu', 'index');
        $user = $this->Users->newEntity();
        $record = 'add';
        if ($id) {
            $record = 'edit';
            $user = $this->Users->get($id);
        }
        if ($this->request->data) {
            if ($this->request->data['step']) {
                $step = $this->request->data['step'];
            }
            if ($this->request->data['password'] == '') {
                if (!$id) {
                    $this->request->password = md5(uniqid(rand(0, 1000000), true));
                }
                unset($this->request->data['password']);
            }
            $this->request->data['addedby'] = $this->Auth->user('id');
            //  $user = $this->Users->patchEntity($user, $this->request->data);
            //Custom Validations
            if ($step == 1) {
                $userError = $this->Users->patchEntity($user, $this->request->data, ['validate' => 'registrationFirstStep']);
            } else if ($step == 2) {
                $userError = $this->Users->patchEntity($user, $this->request->data, ['validate' => 'registrationSecondStep']);
            }
            $error = $userError->errors();
            if ($this->Users->save($user)) {
                $this->Flash->success(__('detail has been saved'));
                if ($step < 4) return $this->redirect(['action' => 'update_learner', $id, $step + 1]);
                else return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update details. please fill all required fields'));
        }
        $this->set('user', $user);
        $this->set('step', $step);
    }

    function assign_department($id = null) {
        $this->loadModel('Departments');
        $this->loadModel('UserDepartments');
        $userdepartments = $this->UserDepartments->newEntity();
        $departments = $this->Departments->find('list', ['conditions' => ['Departments.status' => 1]]);
        $this->set('departments', $departments);
        if ($this->request->data) {
            $data = $this->request->data;
            //print_r($this->request->data); die;
            if (!empty($data['department_id'])) {
                $this->UserDepartments->deleteAll(['UserDepartments.user_id' => $this->request->data['user_id']]);
                for ($i = 0;$i < count($this->request->data['department_id']);$i++) {
                    $userdepartments = $this->UserDepartments->newEntity();
                    $userdepartments->department_id = $this->request->data['department_id'][$i];
                    $userdepartments->user_id = $this->request->data['user_id'];
                    $this->UserDepartments->save($userdepartments);
                }
                $this->Flash->success(__('Record saved to database.'));
                // return $this->redirect(['action' => 'index']);
            }
        }
        $allDept = $this->UserDepartments->find('all')->where(['UserDepartments.user_id ' => $id])->enableHydration(false)->toList();
        $assignedIds = [];
        if (!empty($allDept)) {
            foreach ($allDept as $dp) {
                $assignedIds[] = $dp['department_id'];
            }
        }
        $this->set('userdepartments', $userdepartments);
        $this->set('assignedIds', $assignedIds);
    }

    function logs($user_id) {
        $this->loadModel('LoginLogs');
        $list = $this->paginate($this->LoginLogs->find('all', ['conditions' => ['LoginLogs.user_id' => $user_id], 'Order' => ['LoginLogs.created DESC']]));
        $getuser = $this->Users->get($user_id);
        $this->set(compact('list', 'getuser'));
    }

    function assign_users($manager_id = null) {
        //  Configure::write('debug',2);
        $admin_id = $this->Auth->user('id');

        //get all users added by manager or admin
        $allUsers=$this->Users->find('all')->select(['id','fname','lname','addedby','manager_id'])
                            ->where(['Users.role'=>4, 'status'=>1])
                            ->order('fname','asc')
                            ->where(['or' => [['Users.addedby' =>$admin_id ],['Users.addedby' => $manager_id]]] )
                            ->enableHydration(false)->toList();
        // echo '<pre>'; print_r($allUsers); //die;
        // $allUsers = $this->Users->find('all')->select(['id', 'fname', 'lname'])->where(['Users.addedby' => 0, 'Users.role' => 4])->orWhere(['Users.addedby' => $manager_id, 'Users.role' => 4])->enableHydration(false)->toList(); // commented by mk
        $user_opts = [];
        $sel_users = [];
        if (!empty($allUsers)) {
            foreach ($allUsers as $user){
                $user_opts[$user['id']] = ucfirst($user['fname']) . ' ' . $user['lname'];
               
                if($user['manager_id'] == $manager_id){
                    $sel_users[] = $user['id'];
                }
            }
        }
        
        // $sel_users = $this->Users->find('list')->select(['id'])->where(['Users.addedby' => $manager_id])->enableHydration(false)->toList();
        // echo '<pre>'; print_r($sel_users); die;

        if ($this->request->data) {

            //update assigned users
            //removing all users to this manager
            $this->Users->updateAll(['manager_id' => null], ['addedby' => $admin_id]);

            //now assigning users 
            if (!empty($this->request->data['assigned_ids'])) {

                $this->Users->updateAll(
                            ['manager_id' => $this->request->data['user_id']], 
                            [
                                'addedby' => $admin_id,
                                'id IN ' => $this->request->data['assigned_ids']
                            ]
                        );
                // echo '<pre>'; print_r($this->request->data['assigned_ids']); die;

                /*foreach($this->request->data['assigned_ids'] as $user_id)
                // for ($i = 0;$i < count($this->request->data['assigned_ids']);$i++) {

                    $user = $this->Users->find($user_id);
                    $user->manager_id = $this->request->data['assigned_ids'][$i];
                    $user->addedby = $this->request->data['user_id'];
                    $user->prevent_password_update = 1;
                    $this->Users->save($user);
                }*/
                $this->Flash->success(__('Record saved to database.'));
            }

            // echo '<pre>'; print_r($this->request->data); die;
            /*$this->Users->updateAll(['addedby' => '1'], ['addedby' => $this->request->data['user_id']]);
            if (!empty($this->request->data['assigned_ids'])) {
                for ($i = 0;$i < count($this->request->data['assigned_ids']);$i++) {
                    $saveArr = $this->Users->newEntity();
                    $saveArr->id = $this->request->data['assigned_ids'][$i];
                    $saveArr->addedby = $this->request->data['user_id'];
                    $saveArr->prevent_password_update = 1;
                    $this->Users->save($saveArr);
                }
                $this->Flash->success(__('Record saved to database.'));
            }*/
        }
        
        $userData = $this->Users->newEntity();
        $record = 'add';
        if ($manager_id) {
            $record = 'edit';
            $userData = $this->Users->get($manager_id);
        }
        $this->set(compact('user_opts', 'userData', 'sel_users'));
    }

    function assign_course($id = null) {
        $this->loadModel('UserCourses');
        $this->loadModel('Courses');
        $userCourses = $this->UserCourses->newEntity();
        $courses = $this->Courses->find('all', ['conditions' => ['Courses.status' => 2,'is_deleted' => 0 ], 'fields' => ['id','title','type'], 'order'=>['type' => 'asc','title' => 'asc' ] ] )->enableHydration(false)->toList();
        // $courses = $this->Courses->find('list', ['conditions' => ['Courses.status' => 2, 'Courses.type' => 1]]);
        // pr($courses); die;
        if ($this->request->data) {
            $data = $this->request->data;
            //print_r($this->request->data); die;
            if (!empty($data['course_id'])) {
                $this->UserCourses->deleteAll(['UserCourses.user_id' => $this->request->data['user_id']]);
                for ($i = 0;$i < count($this->request->data['course_id']);$i++) {
                    $userCourses = $this->UserCourses->newEntity();
                    $userCourses->course_id = $this->request->data['course_id'][$i];
                    $userCourses->user_id = $this->request->data['user_id'];
                    $this->UserCourses->save($userCourses);
                }
                $this->Flash->success(__('Record saved to database.'));
            }
        }

        $allDept = $this->UserCourses->find('all')->where(['UserCourses.user_id ' => $id])->enableHydration(false)->toList();
        $opts = [];
        foreach($courses as $value){
            $type = ($value['type'] == 1) ? 'Online course' : 'Led course';
            $opts[$value['id']] = $value['title'].' ('.$type.')';
        }
        $courses = $opts;

        $assignedIds = [];
        if (!empty($allDept)) {
            foreach ($allDept as $dp) {
                $assignedIds[] = $dp['course_id'];
            }
        }
        $this->set(compact('userCourses','assignedIds','courses'));
    }

    function assign_courseins($id = null) {
        $this->loadModel('UserCourses');
        $this->loadModel('Courses');
        $userdepartments = $this->UserCourses->newEntity();
        $departments = $this->Courses->find('list', ['conditions' => ['Courses.status' => 2, 'Courses.type' => 2]]);
        $this->set('departments', $departments);
        if ($this->request->data) {
            $data = $this->request->data;
            //print_r($this->request->data); die;
            if (!empty($data['course_id'])) {
                $this->UserCourses->deleteAll(['UserCourses.user_id' => $this->request->data['user_id']]);
                for ($i = 0;$i < count($this->request->data['course_id']);$i++) {
                    $userCourses = $this->UserCourses->newEntity();
                    $userCourses->course_id = $this->request->data['course_id'][$i];
                    $userCourses->user_id = $this->request->data['user_id'];
                    $this->UserCourses->save($userCourses);
                }
                $this->Flash->success(__('Record saved to database.'));
            }
        }
        $allDept = $this->UserCourses->find('all')->where(['UserCourses.user_id ' => $id])->enableHydration(false)->toList();
        $assignedIds = [];
        if (!empty($allDept)) {
            foreach ($allDept as $dp) {
                $assignedIds[] = $dp['course_id'];
            }
        }
        $this->set('userdepartments', $userdepartments);
        $this->set('assignedIds', $assignedIds);
    }
    function assign_venue($id = null) {
        $this->loadModel('UserVenues');
        $this->loadModel('Venues');
        $userdepartments = $this->UserVenues->newEntity();
        $departments = $this->Venues->find('list', ['conditions' => ['Venues.is_deleted' => 0]]);
        $this->set('departments', $departments);
        if ($this->request->data) {
            $data = $this->request->data;
            if (!empty($data['venue_id'])) {
                $this->UserVenues->deleteAll(['UserVenues.user_id' => $this->request->data['user_id']]);
                for ($i = 0;$i < count($this->request->data['venue_id']);$i++) {
                    $userdepartments = $this->UserVenues->newEntity();
                    $userdepartments->venue_id = $this->request->data['venue_id'][$i];
                    $userdepartments->user_id = $this->request->data['user_id'];
                    $this->UserVenues->save($userdepartments);
                }
                $this->Flash->success(__('Record saved to database.'));
            }
        }
        $allDept = $this->UserVenues->find('all')->where(['UserVenues.user_id ' => $id])->enableHydration(false)->toList();
        $assignedIds = [];
        if (!empty($allDept)) {
            foreach ($allDept as $dp) {
                $assignedIds[] = $dp['venue_id'];
            }
        }
        $this->set('userdepartments', $userdepartments);
        $this->set('assignedIds', $assignedIds);
    }

    function generate_learner_credentials(){
        
        $user_id =  $this->request->data('user_id');
        // echo '2'; die;
        $this->autoRender = false;
        $otp    = $this->generateRandomString();
        $user   = $this->Users->findById($this->request->data('user_id'))->first();
        if(!empty($user)){

            $this->loadModel('UserAccountAccesses');

            $user_acc_ass = $this->UserAccountAccesses->find('all', [
                'conditions' => [
                    'admin_id' => $this->Auth->user('id'),
                    'user_id' => $this->request->data('user_id'),
                    'used' => null
                ]
            ])->first();
            if(empty($user_acc_ass)){            
                $user_acc_ass           = $this->UserAccountAccesses->newEntity();
                $user_acc_ass->admin_id = $this->Auth->user('id');
                $user_acc_ass->user_id  = $this->request->data('user_id');
            }
            $user_acc_ass->username = $user->username;
            $user_acc_ass->password = (new DefaultPasswordHasher)->hash($otp);
            // echo '<pre>'; print_r($this->request->data('user_id')); die;

            // $user['temp_password'] = Auth::passowrd($otp);
            // $user['temp_password'] = (new DefaultPasswordHasher)->hash($otp);

            if($this->UserAccountAccesses->save($user_acc_ass)) {
                $resp = [
                    'status'   => true,
                    'otp'      => $otp,
                    'username' => $user_acc_ass->username,
                ];
            } else{
                $resp = [
                    'status' => false,
                ];
            }
        }else{
            $resp = [
                'status' => false,
            ];            
        }
        $this->response->type('json');
        $this->response->body(json_encode($resp));
        return $this->response;
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
