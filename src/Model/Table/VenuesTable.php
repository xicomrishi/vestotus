<?php
namespace App\Model\Table;

use App\Model\Entity\Venue;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Venues Model
 *
 */
class VenuesTable extends Table
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

        $this->table('venues');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Countries', [
            'foreignKey' => 'country_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('States', [
            'foreignKey' => 'state_id',
            'joinType' => 'INNER'
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
            ->notEmpty('title');

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->integer('max_class_size')
            ->requirePresence('max_class_size', 'create')
            ->notEmpty('max_class_size');

        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->requirePresence('address', 'create')
            ->notEmpty('address');

        $validator
            ->requirePresence('country_id', 'create')
            ->notEmpty('country_id');

        $validator
            ->requirePresence('city', 'create')
            ->notEmpty('city');

        $validator
            ->requirePresence('state_id', 'create')
            ->notEmpty('state_id');

        $validator
            ->requirePresence('postal_code', 'create')
            ->notEmpty('postal_code');

     

        return $validator;
    }

    public function is_exists($id=null,$user_id=null)
    {
        $owner = [];
        // if($uset_id > 1)
        // {
        //     $owner['addedby'] = $user_id;
        // }
        return $this->find('all',['conditions'=>['id'=>$id,$owner]])->count();
    }

    public function del($id)
    {
        $del = $this->get($id);
        return $this->delete($del);
    }
}
