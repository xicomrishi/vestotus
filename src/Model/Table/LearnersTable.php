<?php
namespace App\Model\Table;

use App\Model\Entity\Learner;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Learners Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 */
class LearnersTable extends Table
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

        $this->table('learners');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Departments', [
            'foreignKey' => 'department_id',
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
            ->requirePresence('insurance_carrier', 'create')
            ->notEmpty('insurance_carrier')
            ->add('insurance_carrier','custom',['rule'=>['custom','/^[a-zA-Z0-9- ]+$/'],'message'=>'This field can only contain letters, numbers and spaces.']);

        $validator
            ->date('renewal_date')
            ->requirePresence('renewal_date', 'create')
            ->notEmpty('renewal_date');

        $validator
            ->integer('no_of_vehicle')
            ->requirePresence('no_of_vehicle', 'create')
            ->notEmpty('no_of_vehicle')
            ->add('no_of_vehicle','custom',['rule'=>['custom','/[0-9]+/'],'message'=>'This field can only numbers .']);

        $validator
            ->requirePresence('vehicle_type', 'create')
            ->notEmpty('vehicle_type');
            

        $validator
            ->integer('no_of_passengers')
            ->requirePresence('no_of_passengers', 'create')
            ->notEmpty('no_of_passengers');

        $validator
            ->integer('no_of_drivers')
            ->requirePresence('no_of_drivers', 'create')
            ->notEmpty('no_of_drivers')
            ->add('vehicle_type','custom',['rule'=>['custom','/[0-9]+/'],'message'=>'This field can only numbers .']);

        $validator
            ->requirePresence('company_name', 'create')
            ->notEmpty('company_name')
             ->add('vehicle_type','custom',['rule'=>['custom','/^[a-zA-Z0-9- ]+$/'],'message'=>'This field can only contain letters, numbers and spaces.']);

        $validator
            ->requirePresence('company_address', 'create')
            ->notEmpty('company_address');

        $validator
            ->requirePresence('contact_person', 'create')
            ->notEmpty('contact_person')
             ->add('contact_person','custom',['rule'=>['custom','/^[a-zA-Z ]+$/'],'message'=>'This field can only contain letters and spaces.']);

        $validator
            ->requirePresence('contact_number', 'create')
            ->notEmpty('contact_number')
            ->numeric('contact_number')
            ->add('contact_number', 'minLength',['rule'=>['minLength','10']])
            ->add('contact_number', 'maxLength',['rule'=>['maxLength','10']]);

        $validator
            ->requirePresence('company_identifier', 'create')
            ->notEmpty('company_identifier');

        $validator
            ->email('sm_email')
            ->requirePresence('sm_email', 'create')
            ->notEmpty('sm_email');
        $validator
            ->requirePresence('sm_title', 'create')
            ->notEmpty('sm_title')
            ->add('sm_title','custom',['rule'=>['custom','/^[a-zA-Z0-9- ]+$/'],'message'=>'This field can only contain letters and spaces.']);

        $validator
            ->requirePresence('sm_company_name', 'create')
            ->notEmpty('sm_company_name')
            ->add('sm_company_name','custom',['rule'=>['custom','/^[a-zA-Z0-9- ]+$/'],'message'=>'This field can only contain letters and spaces.']);

        $validator
            ->requirePresence('sm_phone', 'create')
            ->notEmpty('sm_phone')
            ->add('sm_phone','custom',['rule'=>['custom','/^[0-9- ]+$/'],'message'=>'This field can only contain numbers and slashes.']);

         $validator
            ->requirePresence('sm_mobile', 'create')
            ->notEmpty('sm_mobile')
            ->add('sm_mobile','custom',['rule'=>['custom','/^[0-9 ]+$/'],'message'=>'This field can only contain numbers.']);

        $validator
            ->requirePresence('sm_driver_licence_no', 'create')
            ->notEmpty('sm_driver_licence_no')
            ->add('sm_driver_licence_no','custom',['rule'=>['custom','/^[a-zA-Z0-9 ]+$/'],'message'=>'This field can only contain letters,numbers and spaces.']);
        $validator
            ->date('sm_expiry_date')
            ->notEmpty('sm_expiry_date');
        
        $validator
            ->requirePresence('education_level', 'create')
            ->notEmpty('education_level');
            

        $validator
            ->requirePresence('relavant_certification', 'create')
            ->notEmpty('relavant_certification');
            

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }


}
