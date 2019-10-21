<?php
namespace App\Model\Table;

use App\Model\Entity\CourseChapter;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CourseChapters Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Courses
 */
class CourseChaptersTable extends Table
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

        $this->table('course_chapters');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->BelongsTo('Courses', [
            'foreignKey' => 'course_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('CourseFiles', [
            'className' => 'CourseFiles',
            'joinTable'=>'course_files',
            'joinType'=>'LEFT',
            'foreignKey'=>'chapter_id',
            'bindingKey' => 'id',
            
            
            
        ]);
        $this->hasMany('Assessments', [
            'className' => 'Assessments',
            'joinTable'=>'assessments',
            'joinType'=>'LEFT',
            'foreignKey'=>'chapter_id',
            'bindingKey' => 'id',
        ]);

        $this->hasOne('Attendences', [
            // 'className' => 'Assessments',
            // 'joinTable'=>'assessments',
            'joinType'=>'LEFT',
            'foreignKey'=>'course_chapter_id',
            'bindingKey' => 'id',
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
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->requirePresence('notes', 'create')
            ->notEmpty('notes');

        
        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->integer('video_width')
            ->notEmpty('video_width');

        

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */

    public function getAssessment($course_id)
    {
        return $this->find('all',['conditions'=>['course_id'=>$course_id]])->last();
    }
    
}
