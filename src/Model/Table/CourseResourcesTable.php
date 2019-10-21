<?php
namespace App\Model\Table;

use App\Model\Entity\CourseResource;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CourseResources Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Courses
 */
class CourseResourcesTable extends Table
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

        $this->table('course_resources');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id',
            'joinType' => 'LEFT'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->requirePresence('files', 'create')
            ->notEmpty('files');

        $validator
            ->integer('addedby')
            ->requirePresence('addedby', 'create')
            ->notEmpty('addedby');

        return $validator;
    }

    

    public function del($id=null)
    {
        $d = $this->get($id);
        if($d)
        {
            if(unlink(WWW_ROOT.'uploads/courses/resources/'.$d['files']))
            {
                $status = "success";
                $del = $this->delete($d);
            }
            else
            {
                $status = "fail";
            }
        }

        return $status;
    }

    
}
