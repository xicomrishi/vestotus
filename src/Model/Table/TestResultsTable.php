<?php
namespace App\Model\Table;

use App\Model\Entity\TestResult;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TestResults Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Tests
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Courses
 */
class TestResultsTable extends Table
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

        $this->table('test_results');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Onlinetests', [
            'foreignKey' => 'testid',
            'bindingKey'=>'test_id',
            'joinType' => 'Left'
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
            ->decimal('percent')
            ->requirePresence('percent', 'create')
            ->notEmpty('percent');

        $validator
            ->integer('required_precent')
            ->requirePresence('required_precent', 'create')
            ->notEmpty('required_precent');

        $validator
            ->add('user_id', 'unique', [
                  'rule' => ['validateUnique',['scope'=>'course_id']],
                  'provider' => 'table',
                  'message' =>'User has already taken this test.'
            ]);
        return $validator;
    }



    public function getResult($course_id=null,$user_id = null)
    {
        return $this->find('all',['conditions'=>['user_id'=>$user_id,'course_id'=>$course_id]])->last();
    }

    
}
