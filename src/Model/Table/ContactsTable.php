<?php
namespace App\Model\Table;

use App\Model\Entity\Contact;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Contacts Model
 *
 */
class ContactsTable extends Table
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

        $this->table('contacts');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->BelongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'LEFT'
        ]);
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
            ->add('name','custom',['rule'=>['custom','/^[a-zA-Z1-9 ]+$/'],'message'=>'Please enter valid name.'])
            ->notEmpty('name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
           
            ->requirePresence('phone', 'create')
            ->add('phone','custom',['rule'=>['custom','/^[\s()+-]*([0-9][\s()+-]*){6,20}$/'],'message'=>'Please enter a valid Phone number .'])
            ->notEmpty('phone');

         
      
        $validator
            ->requirePresence('comment', 'create')
            ->notEmpty('comment');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    
}
