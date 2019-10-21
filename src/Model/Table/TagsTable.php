<?php
namespace App\Model\Table;

use App\Model\Entity\Tag;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tags Model
 *
 */
class TagsTable extends Table
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

        $this->table('tags');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('addedby')
            ->requirePresence('addedby', 'create')
            ->notEmpty('addedby');

        $validator
            ->requirePresence('title', 'create')
             ->add('title', 'unique', [
                  'rule' => 'validateUnique',   
                  'provider' => 'table',
                  'message' =>'Title already exists.'
            ])
            ->notEmpty('title');

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
