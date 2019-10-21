<?php
namespace App\Model\Table;

use App\Model\Entity\Department;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Departments Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ParentCategories
 * @property \Cake\ORM\Association\HasMany $ChildCategories
 */
class DepartmentsTable extends Table
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

        $this->table('departments');
        $this->displayField('title');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ParentCategories', [
            'className' => 'Departments',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildCategories', [
            'className' => 'Departments',
            'foreignKey' => 'parent_id'
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'addedby',
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
            ->requirePresence('title', 'create')
            ->notEmpty('title')
            ->add('title', 'unique', [
                  'rule' => 'validateUnique',   
                  'provider' => 'table',
                  'message' =>'Category already exists.'
            ]);

        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
   

    public function is_exists($id=null,$user_id=null)
    {
        return $this->find('all',['conditions'=>['id'=>$id,'addedby'=>$user_id]])->count();
    }

    public function delete_dpt($id)
    {
        $del = $this->get($id);
        return $this->delete($del);
    }
}
