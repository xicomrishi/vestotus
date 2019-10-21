<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
// use Cake\Core\Exception\Exception;

class UserAccountAccessesTable extends Table
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
        
     
        // $this->table('users');
    }

    public function findAuth(\Cake\ORM\Query $query, array $options)
    {
        return $query->where(
            [
                'used IS ' => null
                // 'OR' => [
                //     $this->aliasField('password') => $options['password'],
                //     $this->aliasField('temp_password') => $options['password'],
                //     // $this->aliasField('password') => $options['temp_password'],
                // ]
            ]
        );
    }




}

?>