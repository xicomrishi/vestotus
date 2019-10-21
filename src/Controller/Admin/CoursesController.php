<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Core\Configure;
class CoursesController extends AppController {
    public $paginate = ['limit' => 10, 'order' => ['Courses.id' => 'desc']];
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow('login', 'dashboard');
        $this->set('form_templates', Configure::read('Templates'));
        $this->set('sidebar', 'courses');
        $this->loadComponent('FileUpload');
    }
    function chapters() {
        $this->loadModel('CourseChapters');
        $list = $this->paginate($this->CourseChapters->find('all', ['contain' => ['Courses']]));
        //  echo '<pre/>';    print_r($list); echo '</pre>'; die;
        $this->set(compact('list'));
    }
    function view_chapter($id = null) {
        $this->loadModel('CourseChapters');
        $list = $this->CourseChapters->find('all', ['conditions' => ['CourseChapters.id' => $id], 'contain' => ['Courses']])->first();
        //  echo '<pre/>';    print_r($list); echo '</pre>'; die;
        $this->set(compact('list'));
    }
    public function index($type = null) { 
        $this->isAuthorized($this->Auth->user());
        $this->set('submenu', 'index');
        if ($this->request->data) {
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
        $conditions[] = "Courses.status > 1";
        $conditions["Courses.enable_ecommerce"] = 0;

        if(@$this->request->query['deleted'] == 'true'){
            $conditions['Courses.is_deleted'] = 1;
            $deleted = 'true';
        } else{
            $conditions['Courses.is_deleted'] = 0;
            $deleted = 'false';
        }
        // echo $deleted; die;
        $list = $this->paginate($this->Courses->find('all', ['conditions' => $conditions, 'contain' => ['Users'] ]));
         // echo '<pre/>';    print_r($list); echo '</pre>'; die;

        $this->set(compact('list','deleted'));
    }

    public function export_courses(){ 
        $this->autoRender = false;
        $conds = $this->removeDashFromArrayKey($this->request->query);
        array_push($conds,[ 'Courses.is_deleted' => 0]);
        $courses = $this->Courses->find('all', [
            'fields' => ['id','title','description','notes','type','online_course_type','created','addedby','status','tag_id','automatic_enrollment','public_purchase','purchase_price','approval','admin_approved','receive_certificate','allow_reenrollment','allow_failure' ],
            'contain' => [
                'Users' => [
                    'fields' => ['fname','lname','username','role']
                ],
            ], 
            'conditions' => $conds,
            'order' => ['Courses.created' => 'desc']
        ])
        ->toArray();

        $this->loadModel('Tags');
        $tags = $this->Tags->find('list')->toArray();

        // echo '<pre>'; print_r($courses); die;
        // echo '<pre>'; print_r($tags); //die;

        if (ob_get_length() > 0) { ob_end_clean(); }

        if(@$conds['Courses.type'] == 1) {
            if(@$conds['Courses.online_course_type'] == 1) {
                $fileName = 'Online-Courses-List'.'.csv';  
            } else{
                $fileName = 'Competence-Courses-List'.'.csv';  
            }
        } elseif(@$conds['Courses.type'] == 2) {
            $fileName = 'Instructor-Led-Courses-List'.'.csv';  
        } else{
            $fileName = 'Courses-List'.'.csv';  
        }

        // $fileName = 'Courses-List'.'.csv';  

        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename={$fileName}");
        header("Expires: 0");
        header("Pragma: public");
        // create a file pointer connected to the output stream
        $file = fopen('php://output', 'w');

        $fields = array('SR.NO.','TITLE','DESCRIPTION','NOTES','STATUS','TAGS','AUTOMATIC ENROLLEMENT','PUBLIC PURCHASE','PURCHASE PRICE','APPROVAL','ADMIN APPROVAL','RECEIVE CERTIFICATE','REENROLLMENT','FAILURE ALLOWED','ADDED BY','ADDED ON');
        
        //show course type when showing all courses
        if(empty($conds)){
            array_push($fields,'COURSE TYPE');
        }

        fputcsv($file, $fields);

        foreach($courses as $key => $row){

            $tag_str = '';
            if(!empty($row['tag_id'])){
                $tag_arr = explode(',',$row['tag_id']);
                $filtered_tag_arr = array_intersect_key($tags,array_flip($tag_arr));
                $tag_str = implode(', ',$filtered_tag_arr);
            }

            if($row['status'] == 0){
                $status = 'Inactive';
            } else if($row['status'] == 1){
                $status = 'Draft';
            } else{
                $status = 'Active';
            }

            if($row['public_purchase'] == 1){
                $purchase_price = 'CAD '.$row['purchase_price'];
            } else{
                $purchase_price = 'N\A';
            }

            if($row['admin_approved'] == 1) { $admin_approved = 'Approved';} 
            else if($row['admin_approved'] == 2) { $admin_approved = 'Un-Approved';} 
            else { $admin_approved = 'Pending';}
            
            $course_type = '';
            if(empty($conds)){
                if($row['type'] == 1) {
                    if($row['online_course_type'] == 1) {
                        $course_type = 'Online course';  
                    } else{
                        $course_type = 'Competence courses';  
                    }
                } elseif($row['type'] == 2) {
                    $course_type = 'Instructor Led Course';  
                } 
            }

            fputcsv($file, array(++$key,ucfirst($row['title']),ucfirst($row['description']),ucfirst($row['notes']),
                $status,
                $tag_str, 
                ($row['automatic_enrollment'] == 1) ? 'Alowed':'Not allowed',
                ($row['public_purchase'] == 1) ? 'Alowed':'Not allowed',
                $purchase_price,
                $row['approval'],
                $admin_approved,
                ($row['receive_certificate'] == 1) ? 'Yes':'No',
                ($row['allow_reenrollment'] == 1) ? 'Allowed':'Not allowed',
                ($row['allow_failure'] == 1) ? 'Allowed':'Not allowed',
                ucfirst($row['user']['fname']).' '.$row['user']['lname'],
                $row['created'],
                $course_type
            ));
        }
        fclose($file);
        // Configure::write('debug', '0');
    }

    public function delete($id) {
        $id = $this->mydecode($id);
        $c = $this->Courses->get($id);
        $c->is_deleted = 1;
        if ($this->Courses->save($c)) {
            $this->Flash->success('Course Deleted.');
        } else {
            $this->Flash->error('Please try again.');
        }
        $this->redirect($this->referer());
    }
    public function update($id = null) { 
        $this->loadModel('Users');
        $this->loadModel('Tags');
        $session = $this->request->session();
        $session->delete('Course.id');

        $course_id = $id;
        $tags = $this->Tags->find('list', ['conditions' => []]);
        $getcourse = $this->Courses->find('all', ['conditions' => ['status' => '1', 'type' => 1, 'addedby' => $this->Auth->user('id') ]])->last();
        if (@$id) {
            $formtype = "edit";
            $id = $this->mydecode($id);
            $session->write('Course.id', $id);
        }
        /* else if($getcourse)
        {
        $formtype = "draft";
        $session->write('Course.id',$getcourse['id']);
        }*/
        else {
            $formtype = "new";
        }
        if ($session->read('Course.id')) {
            $course = $this->Courses->find('all', ['conditions' => ['Courses.id' => $session->read('Course.id') ], 'contain' => ['CourseChapters', 'CourseChapters.CourseFiles', 'EnrollRules', 'CourseResources', 'CourseNotifications'], 'recursive' => - 1])->last();
            //pr($course);exit;
            
        } else {
            $course = $this->Courses->newEntity();
        }
        //pr($course);exit;
        $this->set(compact('user', 'course','course_id', 'tags', 'formtype'));
    }
    public function ajaxolcourse() {
        $this->autoRender = false;
        $session = $this->request->session();
        if ($this->request->isajax()) {
            $data = $this->request->data;
            // pr($data); die;

            if ($data['tab_name'] == 1) {
                @$data['addedby'] = $this->Auth->user('id');
                @$data['tag_id'] = implode(',', $data['tag_id']);
                if ($session->read('Course.id')) {
                    $course = $this->Courses->get($session->read('Course.id'));
                } else if (isset($data['id'])) {
                    $course = $this->Courses->get($data['id']);
                } else {
                    $course = $this->Courses->newEntity();
                    $data['status'] = 2;
                }
                if ($data['thumbnail']['name'] !== '') {
                    if ($course['thumbnail']) {
                        $this->FileUpload->delete_file('uploads/courses/thumb/' . $course['thumbnail']);
                    }
                } else {
                    unset($data['thumbnail']);
                }
                if ($data['image']['name'] !== '') {
                    if ($course['image']) {
                        $this->FileUpload->delete_file('uploads/courses/' . $course['image']);
                    }
                } else {
                    unset($data['image']);
                }
                //$data['status'] = 2;
                
                $check = $this->Courses->patchEntity($course, $data);
                if ($check->errors()) {
                    $response['status'] = 'error';
                    $errors = [];
                    foreach ($check->errors() as $key => $value) {
                        foreach ($value as $val) {
                            $errors[$key] = $val;
                        }
                    }
                    $response['error'] = $errors;
                } else {
                	if(isset($data['online_course_type'])){
	                    $course->online_course_type = $data['online_course_type'];
                	}
                    $check = $this->Courses->patchEntity($course, $data);
                    // pr($data);
                    // pr($check);exit;
                    if ($this->Courses->save($check)) {
                        // echo $course;exit;
                        if (isset($data['thumbnail']) && $data['thumbnail']['name'] !== '') {
                            $img = $this->FileUpload->upload($data['thumbnail'], 'uploads/courses/thumb/');
                            if ($img['status'] == 'success') {
                                $check->thumbnail = $img['filename'];
                            }
                            $this->Courses->save($check);
                        }
                        if (isset($data['image']) && $data['image']['name'] !== '') {
                            $img = $this->FileUpload->upload($data['image'], 'uploads/courses/');
                            if ($img['status'] == 'success') {
                                $check->image = $img['filename'];
                            }
                            $this->Courses->save($check);
                        }
                        $response['id'] = $check->id;
                        $response['course_id'] = $this->myencode($check->id);
                        $response['status'] = 'success';
                        $session->write('Course.id', $check->id);
                    }
                }
            } else if ($data['tab_name'] == 2) {
                //pr($data);exit;
                $id = $session->read('Course.id');
                if ($id) {
                    $course = $this->Courses->get($id);
                    $dt['must_complete'] = $data['must_complete'];
                    $course = $this->Courses->patchEntity($course, $dt);
                    if ($this->Courses->save($course)) {
                        $response['status'] = 'success';
                    }
                } else {
                    $response['status'] = 'error';
                    $response['error_code'] = 1;
                }
            } else if ($data['tab_name'] == 3) {
                //pr($data);exit;
                $this->loadModel('EnrollRules');
                $id = $session->read('Course.id');
                if ($id) {
                    
                    $data['purchase_price'] = (float)$data['purchase_price'];

                    $course = $this->Courses->get($id);
                    $course = $this->Courses->patchEntity($course, $data);
                    if ($this->Courses->save($course)) {
                        if (count(@$data['EnrollRules']['fields']) > 0) {
                            $ttlrecords = count($data['EnrollRules']['fields']);
                            for ($i = 0;$i < $ttlrecords;$i++) {
                                $enroll_data['fieldname'] = $data['EnrollRules']['fields'][$i];
                                $enroll_data['rule'] = $data['EnrollRules']['rules'][$i];
                                $enroll_data['ruleval'] = $data['EnrollRules']['value'][$i];
                                $enroll_data['course_id'] = $id;
                                $enroll = $this->EnrollRules->newEntity();
                                $enroll = $this->EnrollRules->patchEntity($enroll, $enroll_data);
                                $this->EnrollRules->save($enroll);
                            }
                        }
                        $response['status'] = 'success';
                    }
                } else {
                    $response['status'] = 'error';
                    $response['error_code'] = 1;
                }
            } else if ($data['tab_name'] == 4) {
                $id = $session->read('Course.id');
                if ($id) {
                    $course = $this->Courses->get($id);
                    if (@$data['receive_certificate'] == 1) {
                        if ($data['certification_url']['name'] !== '') {
                            if ($course['certification_url']) {
                                $this->FileUpload->delete_file('uploads/courses/certificates/' . $course['certification_url']);
                            }
                            $img = $this->FileUpload->upload($data['certification_url'], 'uploads/courses/certificates/');
                            if ($img['status'] == 'success') {
                                $data['certification_url'] = $img['filename'];
                            }
                        } else {
                            if (!$course['certification_url']) {
                                $response['status'] = 'error';
                                $response['error']['certification_url'] = 'Please upload Ceritification';
                                echo json_encode($response);
                                exit;
                            }
                            unset($data['certification_url']);
                        }
                    }
                    // $data['competencies'] = implode(',', $data['competencies']);
                    $data['competencies'] = (isset($data['competencies'])) ? implode(',', $data['competencies']) : '';
                    $course = $this->Courses->patchEntity($course, $data);
                    if ($this->Courses->save($course)) {
                        $response['status'] = 'success';
                    }
                } else {
                    $response['status'] = 'error';
                    $response['error_code'] = 1;
                }
            } else if ($data['tab_name'] == 5) {
                $this->loadModel('CourseNotifications');
                $errors = [];
                if (@$data['enrollment_email'] == 1 && @$data['enrollment_email_custom'] == 1) {
                    if ($data['enrollment_subject'] == '') {
                        $errors['enrollment_subject'] = 'Please enter subject';
                    }
                    if ($data['enrollment_body'] == '') {
                        $errors['enrollment_body'] = 'Please enter Email Text';
                    }
                }
                if (@$data['completion_email'] == 1 && @$data['completion_email_custom'] == 1) {
                    if ($data['completion_subject'] == '') {
                        $errors['completion_subject'] = 'Please enter subject';
                    }
                    if ($data['completion_body'] == '') {
                        $errors['completion_body'] = 'Please enter Email Text';
                    }
                }
                if (count($errors) > 0) {
                    $response['status'] = 'error';
                    $response['error'] = $errors;
                } else {
                    $response['status'] = 'success';
                    $id = $session->read('Course.id');
                    if ($id) {
                        $getcourse = $this->Courses->get($id);
                        $getcourse = $this->Courses->patchEntity($getcourse, $data);
                        if ($this->Courses->save($getcourse)) {
                            $response['status'] = 'success';
                            if (@$data['enrollment_email_custom'] == 1) {
                                $notify = $this->CourseNotifications->newEntity();
                                $dt['slug'] = 'enroll';
                                $dt['subject'] = $data['enrollment_subject'];
                                $dt['content'] = $data['enrollment_body'];
                                $dt['course_id'] = $id;
                                $dt['addedby'] = $this->Auth->user('id');
                                $notify = $this->CourseNotifications->patchEntity($notify, $dt);
                                if ($this->CourseNotifications->save($notify)) {
                                    $response['status'] = 'success';
                                } else {
                                    $response['status'] = 'error';
                                    $response['error_code'] = 2;
                                }
                            }
                            if (@$data['completion_email_custom'] == 1) {
                                $notify = $this->CourseNotifications->newEntity();
                                $dt['slug'] = 'completion';
                                $dt['subject'] = $data['completion_subject'];
                                $dt['content'] = $data['completion_body'];
                                $dt['course_id'] = $id;
                                $dt['addedby'] = $this->Auth->user('id');
                                $notify = $this->CourseNotifications->patchEntity($notify, $dt);
                                if ($this->CourseNotifications->save($notify)) {
                                    $response['status'] = 'success';
                                } else {
                                    $response['status'] = 'error';
                                    $response['error_code'] = 2;
                                }
                            }
                        } else {
                            $response['status'] = 'error';
                            $response['error_code'] = 2;
                        }
                    } else {
                        $response['status'] = 'error';
                        $response['error_code'] = 1;
                    }
                }
            } else if ($data['tab_name'] == 6) {
                // echo '<PRE>'; print_r($data); die;

                $this->loadModel('CourseResources');
                $id = $session->read('Course.id');
                if ($id) {
                    $newr = $this->CourseResources->newEntity();
                    $savedata['name'] = $data['resource_name'];
                    if ($data['resource_file']['name'] !== '') {
                        $img = $this->FileUpload->upload($data['resource_file'], 'uploads/courses/resources/');
                        if ($img['status'] == 'success') {
                            $savedata['files'] = $img['filename'];
                        }
                    }
                    $savedata['addedby'] = $this->Auth->user('id');
                    $savedata['course_id'] = $id;
                    $newr = $this->CourseResources->patchEntity($newr, $savedata);
                    if ($this->CourseResources->save($newr)) {
                        // echo '<PRE>'; print_r($newr); die;

                        $response['status'] = 'success';
                        $response['content'] = '<div class="resourcesdiv" id="resourcediv_' . $newr['id'] . '"><a href="javascript:void(0);" id="' . $newr['id'] . '" class="delete_resource delete-btn" onclick="del_resource(' . $newr['id'] . ',1)"><i class="fa fa-trash-o" aria-hidden="true"></i> </a><div class="form-group"><label for="resource-name">Name</label><p>' . $newr['name'] . '</p></div><div class="form-group"> <label>File </label> <a href="/vestotus/uploads/courses/resources/' . $newr['files'] . '" target="_blank">' . $newr['files'] . '</a></div> </div>';
                    } else {
                        $response['status'] = 'error';
                        $errors = [];
                        foreach ($newr->errors() as $key => $value) {
                            foreach ($value as $val) {
                                if ($key == 'name') {
                                    $errors['resource_name'] = $val;
                                } else if ($key == 'files') {
                                    $errors['resource_file'] = $val;
                                }
                            }
                        }
                        $response['error'] = $errors;
                    }
                } else {
                    $response['status'] = 'error';
                    $response['error_code'] = 1;
                }
            }
            //$response['status'] = 'success';
            echo json_encode($response);
        }
    }
    public function addChapter($id = null) {
        $this->autoRender = false;
        $this->loadModel('CourseFiles');
        $session = $this->request->session();
        $this->loadModel('CourseChapters');
        @$id = $this->request->data['id'];
        if ($id) {
            $chapter = $this->CourseChapters->get($id);
        } else {
            $chapter = $this->CourseChapters->newEntity();
            // $chapter = $this->CourseChapters->find('all')->first();

        }
        // pr($chapter); die;

        //echo 'dsdsd';
        if ($this->request->isajax()) {
            $data = $this->request->data;
            if(!empty($data['course_id'])){
                $data['course_id'] = $this->mydecode($data['course_id']);
                if ($data['type'] == 'assessment') {
            
                    $this->loadModel('Assessments');
                    // $course_id = $session->read('Course.id');
                    $course_id = $data['course_id'];
                    $getlastnum = $this->CourseChapters->find('all', ['conditions' => ['course_id' => $course_id], 'order' => ['lesson_no' => 'DESC'], 'limit' => 1])->toArray();
                    $getassess = $this->CourseChapters->find('all', ['conditions' => ['course_id' => $course_id, 'type' => 'assessment']])->last();
                    if ($getassess) {
                        $chapter = $this->CourseChapters->get($getassess['id']);
                    }
                    if ($getlastnum) {
                        $lastnum = $getlastnum[0]['lesson_no'] + 1;
                    } else {
                        $lastnum = 1;
                    }
                    $data['course_id'] = $course_id;
                    $data['lesson_no'] = $lastnum;
                    if ($data['notes'] == '') {
                        unset($data['notes']);
                    }
                    if ($data['description'] == '') {
                        unset($data['description']);
                    }
                    if ($data['title'] == '') {
                        unset($data['title']);
                    }
                    $data['addedby'] = $this->Auth->user('id');
                    $chapter = $this->CourseChapters->patchEntity($chapter, $data);
                    $errors = [];
                    if ($data['question'] == '') {
                        $errors['question'] = "Please enter Question";
                    }
                    if ($data['answer'] == '') {
                        $errors['answer'] = "Please enter Question";
                    }
                    $i = 1;
                    foreach ($data['options'] as $options) {
                        if ($options == ''):
                            $errors['0_' . $i] = "Please enter Question";
                        endif;
                        $i++;
                    }
                    if (!in_array($data['answer'], $data['options'])) {
                        $errors['answer'] = "Invalid Answer.";
                    }
                    if ($chapter->errors() || !empty($errors)) {
                        $response['status'] = 'error';
                        foreach ($chapter->errors() as $key => $value) {
                            foreach ($value as $val) {
                                $errors[$key] = $val;
                            }
                        }
                        $response['error'] = $errors;
                    } else {
                        if ($this->CourseChapters->save($chapter)) {
                            $data['options'] = json_encode($data['options']);
                            $data['chapter_id'] = $chapter->id;
                            $data['owner'] = $this->Auth->user('id');
                            $newAssesment = $this->Assessments->newEntity();
                            $newAssesment = $this->Assessments->patchEntity($newAssesment, $data);
                            //pr($newAssesment);exit;
                            if ($this->Assessments->save($newAssesment)) {
                                $response['status'] = "success";
                                $response['data'] = $data;
                                $response['id'] = $chapter->id;
                                $response['ass_id'] = $newAssesment->id;
                                //exit;
                            }
                        }
                        // $response['status'] = 'success';
                    }
           
                } else {
                    // $course_id = $session->read('Course.id');
                    $data['addedby'] = $this->Auth->user('id');
                    // pr($data); //die;
                    $chapter = $this->CourseChapters->patchEntity($chapter, $data);
                    $chapter->lesson_no = $data['lesson_no'];
                    // pr($chapter); die;
                    if ($chapter->errors()) {
                        $response['status'] = 'error';
                        $errors = [];
                        foreach ($chapter->errors() as $key => $value) {
                            foreach ($value as $val) {
                                $errors[$key] = $val;
                            }
                        }
                        $response['error'] = $errors;
                    } else {
                        if ($this->CourseChapters->save($chapter)) {
                            // $this->CourseChapters->lesson_no = '121';
                            // $this->CourseChapters->save();
                            
                            $response['status'] = 'success';
                            $response['id'] = $chapter->id;
                            $response['title'] = $chapter->title;
                            //pr($data);
                            if ($data['files']) {
                                foreach ($data['files'] as $files) {
                                    if ($data['type'] == 'video') {
                                        $chk = $this->FileUpload->valid_video($files);
                                        $data['type'] = 'videos';
                                    } else if ($data['type'] == 'audio') {
                                        $chk = $this->FileUpload->valid_audio($files);
                                    } else if ($data['type'] == 'ppt') {
                                        $chk = $this->FileUpload->valid_ppt($files);
                                    }
                                    if ($chk == 'success') {
                                        $upload = $this->FileUpload->upload($files, 'uploads/courses/' . $data['type'] . '/');
                                        $fdata['course_id'] = $data['course_id'];
                                        $fdata['type'] = $data['type'];
                                        $fdata['chapter_id'] = $chapter['id'];
                                        $fdata['filename'] = $upload['filename'];
                                        $filesup = $this->CourseFiles->newEntity();
                                        $filesup = $this->CourseFiles->patchEntity($filesup, $fdata);
                                        $this->CourseFiles->save($filesup);
                                    }
                                }
                            }
                        }
                    }
                }
            } else{
                $response['status'] = 'course_error';
            }
        }
        echo json_encode($response);
    }
    public function del_enrollrule($id = null) {
        $this->autoRender = false;
        $this->loadModel('EnrollRules');
        if ($id) {
            $rule = $this->EnrollRules->get($id);
            if ($this->EnrollRules->delete($rule)) {
                echo 'success';
            } else {
                echo 'error';
            }
        }
    }
    public function del_resource($id = null) {
        $this->autoRender = false;
        $this->loadModel('CourseResources');
        if ($id) {
            $rule = $this->CourseResources->get($id);
            if ($this->CourseResources->delete($rule)) {
                echo 'success';
            } else {
                echo 'error';
            }
        }
    }
    function activateCourse() {
        $this->autoRender = false;
        $session = $this->request->session();
        $this->loadModel('EnrollRules');
        $cid = $session->read('Course.id');
        if ($cid) {
            $course = $this->Courses->get($cid);
            $cdata['status'] = 2;
            $course = $this->Courses->patchEntity($course, $cdata);
            if ($this->Courses->save($course)) {
                $this->__enrollUsers();
                $session->delete('Course.id');
                echo 'success';
            } else {
                echo 'error';
            }
        }
    }
    function delChapter() {
        $this->autoRender = false;
        if ($this->request->isajax()) {
            $data = $this->request->data;
            $chapter_id = $data['id'];
            $this->loadModel('CourseChapters');
            $this->loadModel('CourseFiles');
            $this->loadModel('Assessments');
            $chapter = $this->CourseChapters->get($chapter_id);
            if ($chapter['type'] == 'assessment') {
                $getfiles = $this->Assessments->deletebyChapter($chapter_id);
            } else {
                $getfiles = $this->CourseFiles->deletebyChapter($chapter_id);
            }
            if ($this->CourseChapters->delete($chapter)) {
                echo "success";
            } else {
                echo "error";
            }
        }
    }
    public function getcourses() {
        $this->autoRender = false;
        $term = $this->request->query['term']['term'];
        $user_id = $this->Auth->user('id');
        $check = $this->Courses->find('all', ['conditions' => ['addedby' => $user_id, 'status' => '2', 'title like "%' . $term . '%"']])->toArray();
        $getarr = [];
        $i = 0;
        foreach ($check as $check) {
            $getarr[$i]['id'] = $check['id'];
            $getarr[$i]['text'] = $check['title'];
            $i++;
        }
        $getarr['results'] = $getarr;
        echo json_encode($getarr);
        exit;
    }
    public function learnerCourses() {
        $this->loadModel('Enrollments');
        $user_id = $this->Auth->user('id');
        $getCompletedCourses = $this->Enrollments->find('all', ['conditions' => ['Enrollments.user_id' => $user_id, 'Courses.status' => 2, 'Courses.admin_approved' => 1], 'contain' => ['Courses', 'TestResults' => ['conditions' => ['TestResults.user_id' => $user_id]]]])->toArray();
        $getActiveCourses = $this->Enrollments->find('all', ['conditions' => ['Enrollments.user_id' => $user_id, 'Courses.status' => 2], 'contain' => ['Courses']])->toArray();
        //pr($getActiveCourses);exit;
        $this->set(compact('getActiveCourses', 'getCompletedCourses'));
    }
    public function view($id = null) {
        $id = $this->mydecode($id);
        $this->loadModel('Enrollments');
        $this->loadModel('CourseProgress');
        $this->loadModel('TestResults');
        $user_id = $this->Auth->user('id');
        $chk = $this->Enrollments->UserEnrolledCourse($id, $user_id);
        if ($chk == 1) {
            $course = $this->Courses->get($id, ['contain' => ['CourseChapters', 'CourseResources', 'CourseReviews', 'CourseReviews.Users']]);
            //pr($course);exit;
            $testvalid = [];
            foreach ($course['course_chapters'] as $chapters) {
                if ($chapters['type'] !== 'assessment') {
                    $get = $this->CourseProgress->find('all', ['conditions' => ['course_id' => $chapters['course_id'], 'lesson_id' => $chapters['id'], 'user_id' => $user_id, 'is_completed' => 1]])->last();
                    if ($get) {
                        $testvalid[] = 1;
                    } else {
                        $testvalid[] = 0;
                    }
                }
            }
            if (in_array(0, $testvalid)) {
                $testcheck = "invalid";
            } else {
                $testcheck = "valid";
            }
            if ($this->TestResults->getResult($chapters['course_id'], $user_id)) {
                $testcheck = "invalid";
            } else {
                $testcheck = "valid";
            }
            $this->set(compact('course', 'testcheck'));
        } else {
            $this->redirect($this->referer());
        }
    }
    public function viewIled($id = null) {
        $id = $this->mydecode($id);
        $this->loadModel('Enrollments');
        $this->loadModel('CourseProgress');
        $this->loadModel('TestResults');
        $user_id = $this->Auth->user('id');
        $chk = $this->Enrollments->UserEnrolledCourse($id, $user_id);
        if ($chk == 1) {
            $course = $this->Courses->get($id, ['contain' => ['Sessions', 'Sessions.SessionClasses', 'Sessions.SessionClasses.Venues', 'CourseResources', 'CourseReviews', 'CourseReviews.Users']]);
            $this->set(compact('course'));
        } else {
            $this->redirect($this->referer());
        }
    }
    public function instructor_course($id = null) {
        $this->loadModel('Users');
        $this->loadModel('Tags');
        $this->loadModel('Venues');
        $session = $this->request->session();
        $session->delete('Course.id');
        $user_id = $this->Auth->user('id');
        $tags = $this->Tags->find('list', ['conditions' => []]);
        $getcourse = $this->Courses->find('all', ['conditions' => ['status' => '1', 'type' => 2, 'addedby' => $this->Auth->user('id') ]])->last();
        $instructors = $this->Users->find('list', ['conditions' => ['addedby' => $this->Auth->user('id'), 'status' => 1, 'role' => 3], 'valueField' => 'fullname']);
        $venues = $this->Venues->find('list', ['conditions' => ['addedby' => $user_id], 'valueField' => 'title']);
        if ($id) {
            $formtype = "edit";
            $id = $this->mydecode($id);
            $session->write('Course.id', $id);
        }
        /* else if($getcourse)
        {
        $formtype = "draft";
        $session->write('Course.id',$getcourse['id']);
        }*/
        else {
            $formtype = "new";
        }
        if ($session->read('Course.id')) {
            $course = $this->Courses->find('all', ['conditions' => ['Courses.id' => $session->read('Course.id') ], 'contain' => ['CourseChapters', 'CourseChapters.CourseFiles', 'EnrollRules', 'CourseResources', 'CourseNotifications', 'Sessions', 'Sessions.SessionClasses'], 'recursive' => - 1])->last();
            //pr($course);exit;
            
        } else {
            $course = $this->Courses->newEntity();
        }
        // pr($course);exit;
        $this->set(compact('user', 'course', 'tags', 'instructors', 'venues', 'formtype'));
    }
    public function sessionadd() {
        $this->autoRender = false;
        $courseid = $this->request->session()->read('Course.id');
        $this->loadModel('Sessions');
        $this->loadModel('SessionClasses');
        $response = [];
        $error = [];
        if ($this->request->isajax()) {
            $data = $this->request->data;
            if ($data['title'] == '') {
                $response['status'] = 'error';
                $response['error']['title'] = 'Title Required.';
            }
            if (!$data['description']) {
                $response['status'] = 'error';
                $response['error']['description'] = 'Description Required.';
            }
            if (!$data['instructor_id']) {
                $response['status'] = 'error';
                $response['error']['instructor_id'] = 'Instructor Required.';
            }
            if (!$data['max_class_size']) {
                $response['status'] = 'error';
                $response['error']['max_class_size'] = 'Max Class size Required.';
            }
            if (!$data['start_date']) {
                $response['status'] = 'error';
                $response['error']['start_date'] = 'Start Date Required.';
            }
            if (!$data['start_time']) {
                $response['status'] = 'error';
                $response['error']['start_time'] = 'Start Time Required.';
            }
            if (!$data['end_date']) {
                $response['status'] = 'error';
                $response['error']['end_date'] = 'End Date Required.';
            }
            if (!$data['end_time']) {
                $response['status'] = 'error';
                $response['error']['end_time'] = 'End Time Required.';
            }
            if (!$data['venue_id']) {
                $response['status'] = 'error';
                $response['error']['venue_id'] = 'Venue Required.';
            }
            if (isset($response['error'])) {
                echo json_encode($response);
                exit;
            }
            if (isset($data['sessionsave'])) {
                $session = $this->Sessions->newEntity();
                $record = "new";
                if ($data['session_id']) {
                    $record = "old";
                    $session = $this->Sessions->get($data['session_id']);
                }
                $data['course_id'] = $courseid;
                $data['owner'] = $this->Auth->user('id');
                $session = $this->Sessions->patchEntity($session, $data);
                if ($session->errors()) {
                    $response['status'] = 'error';
                    $error = [];
                    foreach ($session->errors() as $key => $value) {
                        foreach ($value as $key1 => $val1) {
                            $error[$key] = $val1;
                        }
                    }
                    //$response['error'] = $error;
                    
                } else {
                    if ($this->Sessions->save($session)) {
                        $chk = $this->SessionClasses->find('all', ['conditions' => ['session_id' => $session->id]])->last();
                        if ($chk) {
                            $newClass = $this->SessionClasses->get($chk->id);
                        } else {
                            $newClass = $this->SessionClasses->newEntity();
                        }
                        if ($data['start_date']) {
                            $data['start_date'] = date('Y-m-d', strtotime($data['start_date']));
                        }
                        if ($data['end_date']) {
                            $data['end_date'] = date('Y-m-d', strtotime($data['end_date']));
                        }
                        //Configure::write('debug',true);
                        $d1 = new \DateTime($data['start_date'] . ' ' . $data['start_time']);
                        $d2 = new \DateTime($data['end_date'] . ' ' . $data['end_time']);
                        $interval = $d1->diff($d2);
                        $data['duration'] = ($interval->days * 24) + $interval->h;
                        $data['session_id'] = $session->id;
                        $newClass = $this->SessionClasses->patchEntity($newClass, $data);
                        $this->SessionClasses->save($newClass);
                        //print "<pre>";print_r($newClass);exit;

                        //save instructor start - mk - not done. because instructor should assign on sesson basis
                        /*$this->loadModel('UserCourses');
                        $userCourses            = $this->UserCourses->newEntity();
                        $userCourses->course_id = $courseid;
                        $userCourses->user_id   = $instructor_id;
                        $this->UserCourses->save($userCourses);*/
                        //save instructor end - mk

                        
                        $response['status'] = 'success';
                        $response['session_id'] = $session->id;
                        $response['record'] = $record;
                        $response['title'] = $session->title;
                        $response['hashid'] = $this->myencode($session->id);
                    }
                    //$class = $this->SessionClasses->newEntity();
                    //$data['session_id'] = $session->id;
                    //$class = $this->SessionClasses->patchEntity($class,$data);
                    
                }
            } else if (isset($data['saveclasses'])) {
                $data = $this->request->data;
                $data['course_id'] = $courseid;
                if (!$data['session_id']) {
                    $response['status'] = 'error';
                    $error = ['session_id' => 'Please Fill Details '];
                } else {
                    $newClass = $this->SessionClasses->newEntity();
                    if ($data['start_date']) {
                        $data['start_date'] = date('Y-m-d', strtotime($data['start_date']));
                    }
                    if ($data['end_date']) {
                        $data['end_date'] = date('Y-m-d', strtotime($data['end_date']));
                    }
                    $newClass = $this->SessionClasses->patchEntity($newClass, $data);
                    if ($newClass->errors()) {
                        $response['status'] = 'error';
                        $error = [];
                        foreach ($newClass->errors() as $key => $value) {
                            foreach ($value as $key1 => $val1) {
                                $error[$key] = $val1;
                            }
                        }
                    } else {
                        if ($this->SessionClasses->save($newClass)) {
                            $response['status'] = 'success';
                            $response['data'] = $data;
                            $response['data']['class_id'] = $newClass->id;
                        }
                    }
                }
            }
        }
        $response['error'] = $error;
        echo json_encode($response);
    }
    public function editsessionpopup($id = null) {
        $this->loadModel('Sessions');
        $this->loadModel('Users');
        $this->loadModel('Venues');
        $id = $this->mydecode($id);
        $user_id = $this->Auth->user('id');
        $session = $this->Sessions->get($id, ['contain' => ['SessionClasses']]);
        $instructors = $this->Users->find('list', ['conditions' => ['status' => 1, 'role' => 3], 'valueField' => 'fullname']);
        $venues = $this->Venues->find('list', ['conditions' => ['addedby' => $user_id], 'valueField' => 'title']);
        $this->set(compact('session', 'instructors', 'venues'));
    }
    public function delSession($id = null) {
        $this->autoRender = false;
        $this->loadModel('Sessions');
        $get = $this->Sessions->get($id, ['contain' => ['SessionClasses']]);
        if ($this->Sessions->delete($get)) {
            $response = 'success';
        } else {
            $response = 'error';
        }
        echo $response;
    }
    public function manageReviews() {
        $this->loadModel('CourseReviews');
        $user_id = $this->Auth->user('id');
        $qry = $this->CourseReviews->find('all', ['conditions' => [], 'contain' => ['Courses', 'Users']]);
        $reviews = $this->paginate($qry);
        $this->set(compact('reviews'));
        $this->set('submenu', 'reviews');
    }
    public function reviewup($id = null, $status = null) {
        $this->autoRender = false;
        $id = $this->mydecode($id);
        $this->loadModel('CourseReviews');
        $getReview = $this->CourseReviews->get($id);
        //pr($getReview);exit;
        if ($status == 'del') {
            if ($this->CourseReviews->delete($getReview)) {
                $this->Flash->success('Review Deleted !');
                $this->redirect($this->referer());
            }
        } else if ($status < 2) {
            $dt['status'] = $status;
            $getReview = $this->CourseReviews->patchEntity($getReview, $dt);
            if ($this->CourseReviews->save($getReview)) {
                $this->Flash->success('Review Updated !');
                $this->redirect($this->referer());
            }
        }
        $this->redirect($this->referer());
    }
    public function adminApproved($id = null, $status = null) {
        $this->autoRender = false;
        try {
            $c = $this->Courses->get($id);
            if ($c) {
                $c->admin_approved = $status;
                $this->Courses->save($c);
                $this->Flash->success('Date Updated !');
                $this->redirect($this->referer());
            }
        }
        catch(Exception $e) {
            $this->Flash->error('Page not found!');
            $this->redirect($this->referer());
        }
    }
    public function ecommerce() {
        $this->isAuthorized($this->Auth->user());
        $this->set('submenu', 'ecommerce_list');
        $this->set('sidebar', 'ecommerce');
        if ($this->request->data) {
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
        $conditions[] = "Courses.status > 1";
        $conditions["Courses.enable_ecommerce"] = 1;
        if(@$this->request->query['deleted'] == 'true'){
            $conditions['Courses.is_deleted'] = 1;
            $deleted = 'true';
        } else{
            $conditions['Courses.is_deleted'] = 0;
            $deleted = 'false';
        }
        // $conditions['Courses.is_deleted'] = 0;
        $list = $this->paginate($this->Courses->find('all', ['conditions' => $conditions, 'contain' => ['Users']]));
        $this->set(compact('list','deleted'));
    }
    public function getenrolledusers($id = null) {
        
        $this->autoRender = false;
        $this->loadModel('Enrollments');
        $getusers = $this->Enrollments->find('all', [
            'conditions' => [
                'Enrollments.purchased_course_id' => $id
                // 'Enrollments.course_id' => $id
            ], 
            'contain' => ['Users', 'Courses'], 
            'fields' => ['fname' => 'UPPER(Users.fname)', 'lname' => 'UPPER(Users.lname)', 
                'date' => 'date_format(Enrollments.created,"%M %d, %Y")', 'title' => 'Courses.title']
            ])->toArray();
        // echo '<pre>'; print_r($getusers); die;
        echo json_encode($getusers);
    }
    public function coursePrice($course_id = null) {
        $course_id = $this->mydecode($course_id);
        $course = $this->Courses->get($course_id);
        $this->loadModel('EcomPricings');
        if ($data = $this->request->data) {
            foreach ($data['user_id'] as $uid) {
                $new = $this->EcomPricings->newEntity();
                $check = $this->EcomPricings->find('all', ['conditions' => ['user_id' => $uid, 'course_id' => $course_id]])->last();
                if ($check) {
                    $new = $this->EcomPricings->get($check['id']);
                }
                $new['user_id'] = $uid;
                $new['course_id'] = $course_id;
                $new['price'] = $data['price'];
                $this->EcomPricings->save($new);
            }
            $this->Flash->success('Price Saved Successfully');
        }
        $pricing = $this->EcomPricings->find('all', ['conditions' => ['EcomPricings.course_id' => $course_id], 'contain' => ['Users']])->toArray();
        $this->set(compact('course', 'pricing'));
    }
    public function deletep($id = null) {
        $this->loadModel('EcomPricings');
        $this->autoRender = false;
        if ($id) {
            $new = $this->EcomPricings->get($id);
            if ($this->EcomPricings->delete($new)) {
                $this->Flash->success('Record Deleted Successfully');
            } else {
                $this->Flash->error("Record couldn't deleted .");
            }
        }
        $this->redirect($this->referere());
    }
}
