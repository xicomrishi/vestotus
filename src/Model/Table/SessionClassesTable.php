<?php
namespace App\Model\Table;

use App\Model\Entity\SessionClass;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SessionClasses Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Sessions
 * @property \Cake\ORM\Association\BelongsTo $Venues
 * @property \Cake\ORM\Association\BelongsTo $Courses
 */
class SessionClassesTable extends Table
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

        $this->table('session_classes');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Sessions', [
            'foreignKey' => 'session_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Venues', [
            'foreignKey' => 'venue_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id',
            'joinType' => 'INNER'
        ]);

        $this->hasOne('Attendences', [
            // 'className' => 'Assessments',
            // 'joinTable'=>'assessments',
            'joinType'=>'LEFT',
            'foreignKey'=>'class_id',
            'bindingKey' => 'id',
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
            ->date('start_date')
            ->requirePresence('start_date', 'create')
            ->notEmpty('start_date');

        $validator
            ->requirePresence('start_time', 'create')
            ->notEmpty('start_time');

        $validator
            ->date('end_date')
            ->requirePresence('end_date', 'create')
            ->notEmpty('end_date');

        $validator
            ->requirePresence('end_time', 'create')
            ->notEmpty('end_time');

        $validator
            ->requirePresence('venue_id', 'create')
            ->notEmpty('venue_id');

        $validator
            ->requirePresence('duration', 'create')
            ->notEmpty('duration');

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
        $rules->add($rules->existsIn(['session_id'], 'Sessions'));
        $rules->add($rules->existsIn(['venue_id'], 'Venues'));
        $rules->add($rules->existsIn(['course_id'], 'Courses'));
        return $rules;
    }
}
