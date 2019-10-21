<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
// use Cake\Core\Exception\Exception;

class UserDepartmentsTable extends Table
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

        $this->belongsTo('Departments',[
            'foreignKey' => 'department_id',
            'joinType' => 'inner',
        ]);        
    }
}

?>