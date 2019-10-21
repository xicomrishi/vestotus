<?php
namespace App\Model\Table;

use App\Model\Entity\Enrollment;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Enrollments Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Courses
 * @property \Cake\ORM\Association\BelongsTo $Users
 */
class EnrollmentsTable extends Table
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

        $this->table('enrollments');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Manager', [
            'className' => 'Users',
            'foreignKey' => 'owner',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('TestResults', [
            'foreignKey' => 'course_id',
            'bindingKey' => 'course_id',
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
            ->integer('owner')
            ->requirePresence('owner', 'create')
            ->notEmpty('owner');

        $validator
            ->requirePresence('user_id', 'create')
            ->notEmpty('user_id')
            ->add('user_id',[
                'unique' => [
                    'rule' => ['validateUnique', ['scope' => 'course_id']],
                    'provider' => 'table'
                ] ]);

            

        $validator
            ->requirePresence('enroll_method', 'create')
            ->notEmpty('enroll_method');

        return $validator;
    }


    public function is_owner($id=null,$owner=null)
    {
        return $this->find('all',['conditions'=>['owner'=>$owner,'id'=>$id]])->count();
    }

    public function UserEnrolledCourse($id,$user_id)
    {
        return $this->find('all',['conditions'=>['user_id'=>$user_id,'course_id'=>$id, 'deleted IS NULL']])->count();
    }

    public function get_enrolled_courses($user_id = null)
    {
        $c = $this->find('all',['conditions'=>['user_id'=>$user_id, 'deleted IS NULL'],'fields'=>['cids'=>'GROUP_CONCAT(course_id)']])->last();
        return $c['cids'];
    }


    
    
}
