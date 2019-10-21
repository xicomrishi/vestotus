<?php
namespace App\Model\Table;

use App\Model\Entity\Group;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Groups Model
 *
 */
class GroupsTable extends Table
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

        $this->table('groups');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->requirePresence('behaviour', 'create')
            ->notEmpty('behaviour');

        $validator
            ->integer('addedby')
            ->requirePresence('addedby', 'create')
            ->notEmpty('addedby');

        $validator
            ->requirePresence('users', 'create')
            ->notEmpty('users');

        return $validator;
    }


     public function is_exists($id=null,$user_id=null)
    {
        return $this->find('all',['conditions'=>['id'=>$id,'addedby'=>$user_id]])->count();
    }

     public function del($id)
    {
        $del = $this->get($id);
        return $this->delete($del);
    }
}
