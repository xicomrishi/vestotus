<?php
namespace App\Model\Table;

use App\Model\Entity\Attendence;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Attendences Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Students
 * @property \Cake\ORM\Association\BelongsTo $Instructors
 * @property \Cake\ORM\Association\BelongsTo $Courses
 * @property \Cake\ORM\Association\BelongsTo $Sessions
 * @property \Cake\ORM\Association\BelongsTo $Classes
 */
class AttendencesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('attendences');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Student', [
            'className' =>'Users',
            'foreignKey' => 'student_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Instructor', [
            'className' =>'Users',
            'foreignKey' => 'instructor_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Sessions', [
            'foreignKey' => 'session_id',
            'joinType' => 'LEFT'
        ]);
        $this->belongsTo('Classes', [
            'ClassName' =>'SessionClasses',
            'foreignKey' => 'class_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('CourseChapters', [
            'foreignKey' => 'course_chapter_id',
            'joinType' => 'LEFT'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('addedby')
            ->requirePresence('addedby', 'create')
            ->notEmpty('addedby');

        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }

   

    public  function getAttendenceByClass($course_id,$class_id,$status="present")
    {
        $data = $this->find('all',['conditions'=>['status'=>$status,'course_id'=>$course_id,'class_id'=>$class_id],'fields'=>['users'=>'GROUP_CONCAT(student_id)']])->last();
        return $data;
    }

    public function learnerMarkAutomaticAttendanceOfCourseChapter($user_id,$course_id,$chapter_id,$addedby){ 
        //used in case when a learner open, lesson/session of course/led course
        $chk_count = $this->find('all',[
                    'conditions'=>[
                        'student_id'=>$user_id,
                        'course_id'=>$course_id,
                        'course_chapter_id'=>$chapter_id
                    ]
                ])->count();
        if($chk_count == 0){ 
            $attnd              = $this->newEntity();
            $attnd->student_id  = $user_id;
            $attnd->addedby     = $addedby;
            $attnd->status      = 'present';
            $attnd->course_id = $course_id;
            $attnd->course_chapter_id = $chapter_id;
            if($this->save($attnd)){
                return true;
            } else{
                return false;
            }
        } else{
            return false;
        }
    }

    public function learnerMarkAutomaticAttendanceOfCourseSession($user_id,$course_id,$session_id,$class_id){ 
        //used in case when a learner open, lesson/session of course/led course
        $chk_count = $this->find('all',[
                    'conditions'=>[
                        'student_id'=>$user_id,
                        'course_id'=>$course_id,
                        'session_id'=>$session_id,
                        'class_id'=>$class_id
                    ]
                ])->count();
        if($chk_count == 0){ 
            $attnd              = $this->newEntity();
            $attnd->student_id  = $user_id;
            $attnd->addedby     = $user_id;
            $attnd->status      = 'present';
            $attnd->course_id   = $course_id;
            $attnd->session_id  = $session_id;
            $attnd->class_id    = $class_id;
            if($this->save($attnd)){
                return true;
            } else{
                return false;
            }
        } else{
            return false;
        }
    }

    /*public function learnerMarkAutomaticAttendanceOfChapter($chapter_id){ //used in case when a learner open, lesson/session of course/led course
        $chk = $this->Attendences->find('all',[
                    'conditions'=>[
                        'Attendences.course_id'=>$course_id,
                        'Attendences.session_id'=>$session_id,
                        'Attendences.class_id'=>$class_id,
                        'Attendences.student_id'=>$data['user_id']
                    ],
                    'fields'=>['id'=>'id']
                ])->last();

    }*/

}
