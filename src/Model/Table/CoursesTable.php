<?php
namespace App\Model\Table;

use App\Model\Entity\Course;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Courses Model
 *
 * @property \Cake\ORM\Association\HasMany $CourseChapters
 * @property \Cake\ORM\Association\HasMany $EnrollRules
 */
class CoursesTable extends Table
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

        $this->table('courses');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('CourseChapters', [
            'foreignKey' => 'course_id',
            'sort'=>'lesson_no ASC',
        ]);
        $this->hasMany('EnrollRules', [
            'foreignKey' => 'course_id'
        ]);
        $this->hasMany('CourseResources', [
            'foreignKey' => 'course_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'addedby'
        ]);
        $this->hasMany('CourseNotifications', [
            'foreignKey' => 'course_id'
        ]);
        $this->hasMany('Enrollments', [
            'foreignKey' => 'course_id'
        ]);
        $this->hasMany('CourseReviews', [
            'foreignKey' => 'course_id',
            'conditions'=>['CourseReviews.status'=>1]
        ]);
        $this->hasMany('Sessions', [
            'foreignKey' => 'course_id',
            
        ]);
        
        //catalog course: show courses which have been assinged to manager but mananger has bot assigned them to learner.
        $this->hasOne('CourseManagers', [
            'className' => 'UserCourses',
            'foreignKey' => 'course_id',
            'joinType' => 'left',
        ]);
        
        /*$this->hasMany('UserCourses', [
            'foreignKey' => 'course_id',
            'joinType' => 'INNER'
        ]);*/
        
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
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->requirePresence('tag_id', 'create')
            ->notEmpty('tag_id');

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->requirePresence('image', 'create')
            ->add('image', 'file', [
                'rule' => ['mimeType', ['image/jpeg', 'image/png','image/jpg','image/gif']],
                'message'=>'Invalid Image'
            ])
            ->add( 'image' ,'custom', [
                'rule' => ['fileSize', '<=', '1MB'],
                'message' => 'Image must be less than 1MB'
            ])
            ->add('image', 'file', [
                'rule' => ['uploadedFile', ['optional' => true]],
            ])
            ->allowEmpty('image');

        $validator
            ->requirePresence('thumbnail', 'create')
            ->add('thumbnail', 'file', [
                'rule' => ['mimeType', ['image/jpeg', 'image/png','image/jpg','image/gif']],
                'message'=>'Invalid Image'
            ])
            ->allowEmpty('thumbnail');

        $validator
            ->requirePresence('notes', 'create')
            ->add('notes','lengthBetween',['rule'=>['lengthBetween',10,2000],'message'=>'This field should have 10 - 2000 characters.'])
            ->notEmpty('notes');

        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->integer('addedby')
            ->requirePresence('addedby', 'create')
            ->notEmpty('addedby');

        return $validator;
    }

    public function getCourseslistbyOwner($id=null)
    {
        return $this->find('list',['conditions'=>['addedby'=>$id]]);
    }

    



}
