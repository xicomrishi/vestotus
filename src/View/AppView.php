<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\View;

use Cake\View\View;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
 


/**
 * Application View
 *
 * Your application’s default view class
 *
 * @link http://book.cakephp.org/3.0/en/views.html#the-app-view
 */
class AppView extends View
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize()
    {
    }

    public function __get_role($role = 0)
    {   
        switch ($role) {
            case 1:
                $type = "Admin";
                break;

            case 2:
                $type = "Manager";
                break;

            case 3:
                $type = "Instructor";
                break;

            case 4:
                $type = "Learner / Driver";
                break;
            
            default:
                $type = "Not Registered";
                break;

        
        }

        return $type;

    }

     public function get_course_price($course_id , $user_id)
    {
      $tbl = TableRegistry::get('EcomPricings');
      $check = $tbl->find('all',['conditions'=>['course_id'=>$course_id,'user_id'=>$user_id]])->last();
      return $check['price'];
    }

    public function is_white_labeled($user_id = null)
    {
        $tbl = TableRegistry::get('Users');
        $chk = $tbl->find('all',['conditions'=>['id'=>$user_id]])->last();
        return $chk['white_label'];
    }
    public function get_course_image($course_id = null , $user_id  = null)
    {
        $tbl = TableRegistry::get('CourseImages');
        $chk = $tbl->find('all',['conditions'=>['course_id'=>$course_id,'user_id'=>$user_id]])->last();
        
        return $chk['image'];
    }

    public function __getUserImage($user_id)
    {
        $tbl = TableRegistry::get('Users');
        $getuser = $tbl->find('all',['conditions'=>['id'=>$user_id],'fields'=>['avatar']])->last();
        if($getuser['avatar'])
        {
            return BASEURL.'uploads/user_data/'.$getuser['avatar'];
        }
        else{
            return USER_AVATAR;
        }
    }

    public function __getCompanyList($list = null)
    {
        $tbl = TableRegistry::get('Companies');
        if($list)
        {
            $list = $tbl->find('list',['conditions'=>['status'=>1],'keyField'=>'id','valueField'=>'company_name'])->toArray();
        }
        else{
        $list = $tbl->find('all',['conditions'=>['status'=>1]])->toArray();
        }
        return $list;
    }

    /*public function getUserCompanyInfo($company_id)
    {
        $tbl = TableRegistry::get('Companies');
        $company = $tbl->find('all',[
                'fields' => ['id','company_name','is_whitelabel','logo'],   
                'conditions'=>['id'=>$company_id]])->first();
        if(!empty($company)){
            if($company->is_whitelabel == ''){

            }
        }
        return $company;
    }*/
    
    /*public function getSessionCountForInstructorLeftSideBar(){
        // $this->loadModel('Sessions');
        $tbl = TableRegistry::get('Sessions');
        $session_count = $tbl->find('all', [
            'conditions' => [
                'Sessions.instructor_id' => $this->Auth->user('id'), 
                'Courses.status' => 2
            ], 
            'contain' => [
                'Courses', 
                'SessionClasses', 
                'SessionClasses.Venues'
            ]
        ])->count();
        return $session_count;
    }*/
        
}
