<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
class UserCoursesTable extends Table
{

    public function initialize(array $config)
    {
       
        
      $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always'
                ]
            ]
        ]);
         $this->belongsTo('Courses', [
            'className' => 'Courses',
            'foreignKey' =>  'course_id',
            'dependent'=>true,
            'joinType'=>'Left',
            
        ]);

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);

        
   
    }



}

?>