<?php
namespace App\Model\Table;

use App\Model\Entity\OnlinetestSetting;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OnlinetestSettings Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Tests
 * @property \Cake\ORM\Association\BelongsTo $Users
 */
class OnlinetestSettingsTable extends Table
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

        $this->table('onlinetest_settings');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Tests', [
            'foreignKey' => 'test_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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

    

       
        return $validator;
    }

    public function check($user_id,$course_id,$test_id=null)
    {
        $cond = [];
        if($test_id){
            $cond['test_id'] = $test_id; 
        }
        return $this->find('all',['conditions'=>['user_id'=>$user_id,'course_id'=>$course_id,$cond]])->last();
    }
}
