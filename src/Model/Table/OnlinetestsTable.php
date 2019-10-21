<?php
namespace App\Model\Table;

use App\Model\Entity\Onlinetest;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Onlinetests Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Questions
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Courses
 * @property \Cake\ORM\Association\BelongsTo $Assessments
 */
class OnlinetestsTable extends Table
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

        $this->table('onlinetests');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Questions', [
            'foreignKey' => 'question_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Assessments', [
            'foreignKey' => 'question_id',
            'joinType' => 'INNER'
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
            ->requirePresence('answerbyuser', 'create')
            ->notEmpty('answerbyuser');

       

        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        

        return $validator;
    }

    public function checkAns($course_id,$question_id,$test_id)
    {
        return $this->find('all',['conditions'=>['course_id'=>$course_id,'question_id'=>$question_id,'or'=>['testid'=>$test_id,'user_id'=>$test_id]]])->last();
    }

    public function getSolvedQues($course_id,$test_id)
    {
        return $this->find('all',['conditions'=>['course_id'=>$course_id,'testid'=>$test_id],'fields'=>['questions'=>'GROUP_CONCAT(question_id)']])->last();
    }

    

    
}
