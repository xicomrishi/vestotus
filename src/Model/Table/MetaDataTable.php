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
class MetaDataTable extends Table
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

        $this->table('meta_data');
        $this->displayField('title');
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
            ->requirePresence('slug', 'create')
            ->notEmpty('slug');

        

        $validator
            ->requirePresence('content', 'create')
            ->notEmpty('content');

        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        return $validator;
    }

     public function getBySlug($slug=null)
    {
        return $this->find('all',['conditions'=>['slug'=>$slug]])->last();
    }
}
