<?php
namespace App\Model\Table;

use App\Model\Entity\CourseProgres;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CourseProgress Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Courses
 * @property \Cake\ORM\Association\BelongsTo $Lessions
 * @property \Cake\ORM\Association\BelongsTo $Users
 */
class CourseProgressTable extends Table
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

        $this->table('course_progress');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Lessons', [
            'ClassName'=>'CourseChapters',
            'foreignKey' => 'lession_id',
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

        $validator
            ->requirePresence('is_completed', 'create')
            ->notEmpty('is_completed');

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
        $rules->add($rules->existsIn(['course_id'], 'Courses'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }

    public function updatedata($data=[])
    {
        $get = $this->newEntity();
        $data['is_completed'] = $data['status'];
        $data['user_id'] = $data['user_id'];
        $data['lesson_id'] = $data['lesson_id'];
        $data['course_id'] = $data['course_id'];
        $get = $this->patchEntity($get,$data);
        if($this->save($get))
        {
            $response = 'success';
        }
        else
        {
            $response = 'error';
        }
        return $response;

    }

    public function getlessonStatus($lesson_id=null,$user_id=null)
    {
        $response = $this->find('all',['conditions'=>['is_completed'=>1,'user_id'=>$user_id,'lesson_id'=>$lesson_id]])->count();
        return $response;

    }
}
