<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
class LoginLogsTable extends Table
{
  public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('login_logs');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        
         $this->belongsTo('Users', [
            'className' => 'Users',
            'foreignKey' =>  'user_id'
            
        ]);
         
    }

   

}

?>