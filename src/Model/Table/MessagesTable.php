<?php
namespace App\Model\Table;

use App\Model\Entity\MetaData;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MetaData Model
 *
 */
class MessagesTable extends Table
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

        // $this->table('meta_data');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Sender', [
            'className' => 'Users',
            'foreignKey' => 'sender_id',
            'bindingKey' =>'id',
            'joinType' => 'INNER'
        ]);
    }

    public function getIncomingMessages($user_id,$limit=null){
        if(!empty($limit)){
            $limit = ['limit' => $limit];
        } else{
            $limit = [];
        }

        return $this->find('all', [
            'fields' => ['id','message','sender_id','modified'],
            'conditions' => ['receiver_id' => $user_id],
            'contain' => [
                'Sender' => [
                    'fields' => ['id','fname','lname']
                ] 
            ],
            $limit,   
            'order' => ['Messages.id' => 'desc']
        ])->toArray();

        
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    /*public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('slug', 'create')
            ->notEmpty('slug');

        

        $validator
            ->requirePresence('content', 'create')
            ->notEmpty('content');

        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        return $validator;
    }*/

    /* public function getBySlug($slug=null)
    {
        return $this->find('all',['conditions'=>['slug'=>$slug]])->last();
    }*/
}
