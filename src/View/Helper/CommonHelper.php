<?php
namespace App\View\Helper;
use Cake\View\Helper;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
class CommonHelper extends Helper {
    public function myencode($value = null) {
        return base64_encode(convert_uuencode($value));
    }
    public function mydecode($value = null) {
        return convert_uudecode(base64_decode($value));
    }
    /*public function getactivecoursescount($id=null) //mk commented
    {
    $tbl_enrollment = TableRegistry::get('Enrollments');
    $getcourses = $tbl_enrollment->find('all',['conditions'=>['Enrollments.user_id'=>$id,'Courses.status'=>2],'contain'=>['Courses']])->count();
    return $getcourses;
    }*/
    public function getactivecoursescount($user_id) //mk commented
    {
        $tbl = TableRegistry::get('Sessions');
        $session_count = $tbl->find('all', [
            'conditions' => [
                'Sessions.instructor_id' => $user_id, 
                'Courses.status' => 2             //active
            ], 
            'contain' => [
                'Courses', 
                'SessionClasses', 
                'SessionClasses.Venues'
            ]
        ])->count();
        return $session_count;

        // $tbl_enrollment = TableRegistry::get('Enrollments');
        // $getcourses = $tbl_enrollment->find('all', ['conditions' => ['Enrollments.user_id' => $id, 'Courses.status' => 2], 'contain' => ['Courses']])->count();
        // return $getcourses;
    }
    public function getCountry($country_id = null) {
        $tbl_country = TableRegistry::get('Countries');
        $country = $tbl_country->getList();
        if ($country_id) {
            $country = $tbl_country->get($country_id);
            return ucfirst($country['name']);
        } else {
            return $country;
        }
    }
    public function getStates($country_id = null, $state_id = null) {
        $tbl_country = TableRegistry::get('States');
        $list = $tbl_country->getbyCountry($country_id);
        if ($state_id) {
            $country = $tbl_country->get($state_id);
            return ucfirst($country['name']);
        } else {
            return $list;
        }
    }
    public function getCities($state_id = null, $city_id = null) {
        $tbl_country = TableRegistry::get('Cities');
        $list = $tbl_country->getbyState($state_id);
        if ($city_id) {
            $country = $tbl_country->get($city_id);
            return ucfirst($country['name']);
        } else {
            return $list;
        }
    }
    public function getLessonStatus($lesson_id = null, $user_id) {
        $tbl_cp = TableRegistry::get('CourseProgress');
        //$user_id = $activeuser['id'];
        $data = $tbl_cp->getlessonStatus($lesson_id, $user_id);
        if ($data > 0) {
            $response = 'completed';
        } else {
            $response = 'notcompleted';
        }
        return $response;
    }
    public function getResult($course_id = null, $user_id = null) {
        $tbl_cp = TableRegistry::get('TestResults');
        return $result = $tbl_cp->getResult($course_id, $user_id);
    }
    public function getCourseProgress($courseId = null, $userId = null) {
        //echo $courseId.'/'.$userId;
        $tbl_setting = TableRegistry::get('OnlinetestSettings');
        $tbl_progress = TableRegistry::get('CourseProgress');
        $tbl_lesson = TableRegistry::get('CourseChapters');
        $progress = 0;
        $checktest = $tbl_setting->find('all', ['conditions' => ['user_id' => $userId, 'course_id' => $courseId, 'status' => 2]])->count();
        if ($checktest) {
            $progress = '100';
        } else {
            $checkpro = $tbl_progress->find('all', ['conditions' => ['user_id' => $userId, 'course_id' => $courseId, 'is_completed' => 1], 'fields' => ['lessons' => 'DISTINCT lesson_id']])->toArray();
            $CC = count($checkpro);
            $CL = $tbl_lesson->find('all', ['conditions' => ['course_id' => $courseId]])->count();
            @$progress = $CC * 100 / $CL;
        }
        return round($progress);
    }
    public function getAttendenceByUser($class_id, $user_id) {
        $tbl = TableRegistry::get('Attendences');
        $check = $tbl->find('all', ['conditions' => ['class_id' => $class_id, 'student_id' => $user_id]])->last();
        if ($check && $check['status'] == 'present') {
            $response = 1;
        } else {
            $response = 0;
        }
        return $response;
    }
    public function getGradeByUser($session_id, $user_id) {
        $tbl = TableRegistry::get('Grades');
        $check = $tbl->find('all', ['conditions' => ['session_id' => $session_id, 'student_id' => $user_id], 'fields' => ['grade' => 'grade']])->last();
        return $check['grade'];
    }
    public function get_enrolled_users($course_id) {
        $tbl = TableRegistry::get('Enrollments');
        $check = $tbl->find('all', ['conditions' => ['course_id' => $course_id]])->count();
        return $check;
    }
    public function mycourses($user_id = null, $full = 0) {
        $tbl = TableRegistry::get('Courses');
        if ($full == 0) {
            $check = $tbl->find('list', ['conditions' => ['addedby' => $user_id]])->toArray();
        } else {
            $check = $tbl->find('all', ['conditions' => ['addedby' => $user_id]])->toArray();
        }
        return $check;
    }
    public function get_user_type($type_id = null) {
        switch ($type_id) {
            case '2':
                $type = "Manager";
            break;
            case '3':
                $type = "Instructor";
            break;
            case '4':
                $type = "Learner";
            break;
            case '5':
                $type = "Others";
            break;
            default:
                $type = '';
            break;
        }
        return $type;
    }
}
?>