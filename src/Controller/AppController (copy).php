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

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Mailer\Email;
use Cake\Network\Exception\SocketException;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    /*public $helpers = [
        'DataTables' => [
            'className' => 'DataTables.DataTables'
        ]
    ];*/

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
       
        
        if(@$this->request->params['prefix']=='admin')
        {
            $this->viewBuilder()->layout('admin');
            $this->loadComponent('Auth', [
                'loginRedirect' => [
                    'controller' => 'Users',
                    'action' => 'dashboard'
                ],
                'logoutRedirect' => BASEURL."admin/"
                    ,'authError'=>'Your session has expired due to inactivity. Please sign in again.'  
               
               
            ]);
        }
        else
        {
             $this->loadComponent('Auth', [
                'loginRedirect' => [
                    'controller' => 'users',
                    'action' => 'dashboard',
                    
                ],
                'logoutRedirect' => [
                    'controller' => 'users',
                    'action' => 'login',
                    
                ]
             ,'authError'=>'Your session has expired due to inactivity. Please sign in again.'   
            ]);
        }
        
        $this->Auth->config('authenticate', [
            'Form' => [
                'fields' => ['username' => 'username', 'password' => 'password'],
                'finder' => 'auth' //mk
            ]
        ]);
        //$this->loadComponent('DataTables.DataTables');
        
         $this->Auth->allow(['departments']);
    }

    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
        $this->loadModel('Users');
        $this->loadModel('Settings');
        $this->loadModel('Companies');
        $fb_link = $this->Settings->getField('fb_link');
        $insta_link = $this->Settings->getField('insta_link');
        $tweet_link = $this->Settings->getField('twitter_link');
        if($this->Auth->user('id') > 1)
        {
            $activeuser  = $this->Users->get($this->Auth->user('id'));
            
            //company logo and name
            $company = $this->Companies->find('all',[
                'fields' => ['id','company_name','is_whitelabel','logo'],   
                'conditions'=>['id'=>$activeuser->company_id]
            ])->first();

            if(!empty($company)){
                if($company->is_whitelabel == 1){
                    //company self logo and name
                    $activeuser->company_name = $company->company_name;
                    if(!empty($company->logo)){
                        $activeuser->logo = BASEURL.'uploads/'.$company->logo;
                    } else{ //stop logo
                        $activeuser->logo = BASEURL.'images/bottom-logo.png';
                    }
                } else{
                    //admin selected logo and name
                    $activeuser->company_name = SITE_TITLE;
                    $activeuser->logo = BASEURL.'images/bottom-logo.png';
                }
            }
        }

        $this->set(compact('activeuser','fb_link','insta_link','tweet_link'));
        //$this->__enrollUsers();
        
    }
    public function isAuthorized($user)
    {   
        if (isset($user['role']) && $user['role'] === '1') {
            return true;
        }
        else
        {
            $this->redirect(['controller'=>'users','action'=>'login','prefix'=>'admin']);
        }
        return false;
    }
    public function is_permission($user)
    {

        $permissions = array('learners/form'=>['2'],
                                'learners/index'=>array('2'),
                             'learners/dashboard' => array('4'),
                            'courses/index' => array('2'),
                             'courses/onlineCourse' => array('2'),'departments/index' => array('2'),
                             'departments/form' => array('2'),'departments/delete'=>array('2'),
                             'venues/index' => array('2'),'venues/form' => array('2'),
                             'venues/delete'=>array('2'),'learners/profile' => array('4'),
                             'tags/index'   => array('2'),'tags/form'     => array('2'),
                             'tags/delete' => array('2'),'groups/index' => array('2'),
                             'groups/form' => array('2'),'groups/del'=>array('2'),
                             'enrollkeys/index' => array('1','2'),'enrollkeys/form' => array('1','2'),
                             'enrollkeys/del'=>array('1','2'),'enrollments/enrollUsers'=>['1','2'],
                             'enrollments/index'=>['1','2'],'courses/learnerCourses'=>['1','2','4'],
                             'lessons/quiz' => ['4'],'courses/manageReviews'=>['2'],
                             'quiz/quizstart' => ['4'],'users/add'=>['2'],'users/index'=>['2'],
                             'courses/instructorCourse' =>['2'],'instructors/dashboard' =>['3'],
                             'instructors/profile' =>['3'],'attendences/mark'=>['3'],
                             'sessions/index'=>['2'],'attendences/markAttendence'=>['2'],'attendences/grades'=>['2'],'attendences/instructorAttendence' =>['3'],'resources/index'=>['2'],'resources/form'=>['2'],'users/profile' => ['2']
           
                            );
           $url = strtolower($this->request->params['controller']).'/'.$this->request->params['action'];
            $userRole = $this->Auth->user('role');
      
            if($userRole)
            {
            if (in_array($userRole,$permissions[$url])) {
                return true;
            }
            else
            {
                $this->Flash->error('You are not authorised to view this page.');
                $this->redirect($this->referer());
            }
    }
    else
    {
        $this->redirect(['controller'=>'users','action'=>'login']);
    }

        return false;
    
    }


    public function __sendEmail($data=[])
    {
        $this->loadModel('EmailTemplates');
        $template = $this->EmailTemplates->getTemplate($data['slug']);
        $getContent = str_replace(array_keys($data['replacement']), array_values($data['replacement']), $template['body']);
        $email = new Email();
        $email->from([$template['from_email'] => $template['from_name']]);
        $email->emailFormat('html');
        $email->to($data['email']);
        $email->template('mytemplate');
        $email->viewVars(array('fb_link' => 'http://www.facebook.com','tweet_link'=>'http://twitter.com','instagram_link'=>'http://instagram.com','in_link'=>'http://linkedin.com'));
       if($template['cc'])
        {
        $email->cc($template['cc']);
        }
        if($template['bcc'])
        {
        $email->bcc($template['bcc']);
        }
        $email->subject($template['subject']);
       // echo $getContent;exit;
        try
        {
         $email->send($getContent);
        }
        catch(SocketException $e)
        {
            $this->log($e);
        }
    }

    public function __sendCourseEmail($course_id = null , $user_id = null , $type = "enroll")
    {
        
        $this->loadModel('EmailTemplates');
        $this->loadModel('Courses');
        $this->loadModel('Users');
        $c = $this->Courses->get($course_id,['contain'=>['CourseNotifications'=>['conditions'=>['slug'=>$type]]]]);
        $u = $this->Users->get($user_id , ['contain'=>'Departments']);
        
        if(!$c)
        {
            $keys = "{FirstName}, {LastName}, {Email}, {Phone}, {Username}, {LMSLink}, {Department}, {CourseName}";
            $k = explode(',',$keys);
            
            $arr =  [
                        '{FirstName}'=>$u['fname'],
                        '{LastName}'=>$u['lname'],
                        '{Email}'=>$u['email'],
                        '{Phone}'=>$u['phone'],
                        '{Username}'=>$u['username'],
                        '{LMSLink}'=>BASEURL,
                        '{Department}'=>$u['department']['title'],
                        '{CourseName}'=>$c['title'],
                        '{courseName}'=>$c['title'],
                       
                    ];
            $data['replacement'] = $arr;
            $getContent = str_replace(array_keys($data['replacement']), array_values($data['replacement']), $c['course_notifications'][0]['content']);
            $subject = str_replace(array_keys($data['replacement']), array_values($data['replacement']), $c['course_notifications'][0]['subject']);
            $template['from_email'] = "support@vestotus.com";
            $template['from_name'] = "Support Team";
            $template['subject'] = $subject;

           
        }
        else
        {
             $arr =  [
                        '{fullname}'=>$u['fname'].' '.$u['lname'],
                        '{LMSLink}'=>BASEURL,
                        '{course}' => $c['title'],
                    ];
            $data['replacement'] = $arr;
            if($type == "enroll") { $slug = "course_enrollment"; } else if($type =="completed") { $slug = "course_completed"; } 
            if($slug)
            {
                $template = $this->EmailTemplates->getTemplate($slug);
                $getContent = str_replace(array_keys($data['replacement']), array_values($data['replacement']), $template['body']);
            }

        }
        //echo $getContent;exit;
        if($getContent):
        $email = new Email();
        $email->from([$template['from_email'] => $template['from_name']]);
        $email->emailFormat('html');
        $email->to($u['email']);
        $email->template('mytemplate');
        $email->viewVars(array('fb_link' => 'http://www.facebook.com','tweet_link'=>'http://twitter.com','instagram_link'=>'http://instagram.com','in_link'=>'http://linkedin.com'));
        if($template['cc'])
        {
            $email->cc($template['cc']);
        }
        if($template['bcc'])
        {
            $email->bcc($template['bcc']);
        }
        $email->subject($template['subject']);
           // echo $getContent;exit;
        return    $email->send($getContent);
        endif;
    }


    

public function myencode($value=null)
{
    return base64_encode(convert_uuencode($value));
}
public function mydecode($value=null)
{
    return convert_uudecode(base64_decode($value));
}

public function __enrollUsers()
{
    
        $this->loadModel('EnrollRules');
        $this->loadModel('Users');
        $this->loadModel('Enrollments');
        $this->loadModel('Departments');
        $getrules = $this->EnrollRules->find('all',['conditions'=>['Courses.status'=>2],'contain'=>['Courses']])->toArray();
        
        foreach($getrules as $rules)
        {
            $course_id = $rules['course_id'];
            if($rules['rule'])
            {
                $rules['fieldname'] = str_replace('lastname','lname',$rules['fieldname']);
                $rules['fieldname'] = str_replace('firstname','fname',$rules['fieldname']);
                if($rules['fieldname'] !=='department')
                {

                    if($rules['rule']=='starts')
                    {
                        $condition[0] = "Users.".$rules['fieldname']." like '".$rules['ruleval']."%'";
                    }
                    else if($rules['rule']=='equals')
                    {
                        $condition["Users.".$rules['fieldname']] =  $rules['ruleval'];
                    }
                    else if($rules['rule']=='contains')
                    {
                        $condition[0] = "Users.".$rules['fieldname']." like '%".$rules['ruleval']."%'";
                    }
                    else 
                    {
                        $condition['username'] = '00990';
                    }
                    $condition['role'] = 4;
                    $getu = $this->Users->find('all',['conditions'=>[$condition]])->toArray();
                    foreach($getu as $u)
                    {
                        $new = $this->Enrollments->newEntity();
                        $dt['course_id'] = $course_id;
                        $dt['user_id'] = $u['id'];
                        $dt['enroll_method'] = 3;
                        $dt['owner'] = 0;
                        $new = $this->Enrollments->patchEntity($new,$dt);
                        if(!$new->errors())
                        {
                          $new = $this->Enrollments->save($new);  
                        }

                    }
                }
                else if($rules['fieldname'] == 'department')
                {   
                    if($rules['rule']=='starts')
                    {
                        $condition1[0] = "title like '".$rules['ruleval']."%'";
                    }
                    else if($rules['rule']=='equals')
                    {
                        $condition1["title"] =  $rules['ruleval'];
                    }
                    else if($rules['rule']=='contains')
                    {
                        $condition1[0] = "title like '%".$rules['ruleval']."%'";
                    }
                    else 
                    {
                        $condition1['username'] = '00990';
                    }
                    $dept = $this->Departments->find('all',['conditions'=>[$condition1],'fields' => ['list'=>' GROUP_CONCAT(id) ']])->last();
                    
                    if(!is_null($dept['list']))
                    {
                    $uc['role'] = 4;
                    $uc[] = 'department_id in ('.$dept['list'].')';
                    $getu = $this->Users->find('all',['conditions'=>[$uc]])->toArray();
                    foreach($getu as $u)
                    {
                        $chk = $this->Enrollments->find('all',['conditions'=>['course_id'=>$course_id,'user_id'=>$u['id']]])->count();
                        if($chk == 0)
                        {
                            $new = $this->Enrollments->newEntity();
                            $dt['course_id'] = $course_id;
                            $dt['user_id'] = $u['id'];
                            $dt['enroll_method'] = 3;
                            $dt['owner'] = 0;
                            $new = $this->Enrollments->patchEntity($new,$dt);
                            if(!$new->errors())
                            {
                              $new = $this->Enrollments->save($new);  
                            }
                        }

                    }

                }
                }
            }
        }
    
}


function departments($userId=null){
    $this->loadModel('Departments');
    $allDepart= $this->Departments->find('all')->select(['id','title'])->enableHydration(false)->toList();
   $departments=[];
    if(!empty($allDepart)){
        foreach ($allDepart as $dep):
            $departments[$dep['id']]=$dep['title'];
        endforeach;
    }
    
    return $departments;
}



function courses($userId=null){
    $this->loadModel('Courses');
    $allDepart= $this->Courses->find('all')->select(['id','title'])->enableHydration(false)->toList();
    $departments=[];
    if(!empty($allDepart)){
        foreach ($allDepart as $dep):
            $departments[$dep['id']]=$dep['title'];
        endforeach;
    }
    
    return $departments;
}
  
    function removeDashFromArrayKey($data){ //used in export reports (admin)
        $new_arr = [];
        foreach($data as $key => $val){
            $count = 0;
            // $new_arr[str_replace('_','.',$key,'1')] = $val; 
            $new_arr[preg_replace('/[_]/','.',$key,1,$count)] = $val; 
        } 
        return $new_arr;
    }

/*    function removeDashFromArrayKey($data){ //used in export reports (admin)
        $new_arr = [];
        foreach($data as $key => $val){
            // echo $key; 
            $new_arr[str_replace('_','.',$key)] = $val; 
        } 
        // echo '<pre>'; print_r($new_arr); die; 
        return $new_arr;
    }*/

   
}
