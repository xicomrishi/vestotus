<?php
namespace App\Model\Table;

use App\Model\Entity\EnrollKey;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EnrollKeys Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Departments
 */
class EnrollKeysTable extends Table
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

        $this->table('enroll_keys');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Departments', [
            'foreignKey' => 'department_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('SubDepartments', [
            'className' => 'Departments',
            'foreignKey' => 'subdepartment_id',
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('key_name', 'create')
            ->notEmpty('key_name')
            ->add('key_name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');
            

        $validator
            ->integer('max_uses')
            ->requirePresence('max_uses', 'create')
            ->notEmpty('max_users');

        $validator
            ->integer('times_used')
            ->notEmpty('times_used');

        $validator
            ->notEmpty('courses');

        $validator
            ->date('start_date')
            ->notEmpty('start_date');

        $validator
            ->date('end_date')
            ->notEmpty('end_date');

        $validator
            ->integer('addedby')
            ->requirePresence('addedby', 'create')
            ->notEmpty('addedby');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['key_name']));
        $rules->add($rules->existsIn(['department_id'], 'Departments'));
        return $rules;
    }

    public function is_exists($id,$user_id)
    {
        return $this->find('all',['conditions'=>['id'=>$id,'addedby'=>$user_id]])->count();
    }

    public function del($id)
    {
        $key = $this->get($id);
        return $this->delete($key);
    }

    public function check_valid($key=null,$pass=null)
    {
        return  $this->find('all',['conditions'=>['key_name'=>$key,'password'=>$pass,'times_used < max_uses']])->last();
            
    }

}
