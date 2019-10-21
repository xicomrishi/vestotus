<?php
namespace App\Model\Table;

use App\Model\Entity\Assessment;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Assessments Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Chapters
 * @property \Cake\ORM\Association\BelongsTo $Courses
 */
class AssessmentsTable extends Table
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

        $this->table('assessments');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('CourseChapters', [
            'foreignKey' => 'chapter_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id',
            'joinType' => 'INNER'
        ]);

        $this->hasOne('Onlinetests', [
            'foreignKey' => 'question_id',
            'bindingKey' => 'id',
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
            ->requirePresence('question', 'create')
            ->notEmpty('question');

        $validator
            ->requirePresence('options', 'create')
            ->notEmpty('options');

        $validator
            ->requirePresence('answer', 'create')
            ->notEmpty('answer');

        $validator
            ->integer('owner')
            ->requirePresence('owner', 'create')
            ->notEmpty('owner');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */

    public function deletebyChapter($chapter_id=null)
    {
        $getdata = $this->find('all',['conditions'=>['chapter_id'=>$chapter_id]])->toArray();
        foreach($getdata as $data)
        {
            $dt = $this->get($data['id']);
            $this->delete($dt);
        }
     //   echo 'success';
    }
    
}
