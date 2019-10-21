<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
class UserVenuesTable extends Table
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
        
   
    }



}

?>