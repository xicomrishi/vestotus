<?php
namespace App\Model\Table;

use App\Model\Entity\Session;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Sessions Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Instructors
 * @property \Cake\ORM\Association\BelongsTo $Courses
 * @property \Cake\ORM\Association\HasMany $SessionClasses
 */
class SessionsTable extends Table
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

        $this->table('sessions');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        
        $this->hasOne('Instructors', [
            'className' => 'Users',
            'foreignKey' =>  'id',
            'bindingKey' =>'instructor_id',
            'dependent'=>true,
            'joinType'=>'INNER',
            
        ]);

        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('SessionClasses', [
            'foreignKey' => 'session_id',
            'dependent' => true,
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
            ->requirePresence('instructor_id', 'create')
            ->notEmpty('instructor_id');

        $validator
            
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->integer('owner')
            ->requirePresence('owner', 'create')
            ->notEmpty('owner');

        return $validator;
    }

   
}
