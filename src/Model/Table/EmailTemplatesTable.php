<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class EmailTemplatesTable extends Table
{

    public function initialize(array $config)
    {
        $this->table('email_templates');
        /*$this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'updated' => 'always'
                ]
            ]
        ]);*/

    }


    public function validationDefault(Validator $validator)
    {
        return $validator
            
            ->notEmpty('subject','Email subject is required')
            
            ->notEmpty('from_email', 'Email From address is required')
            ->add('from_email','email',['rule'=>['email','please enter valid email address']])
            ->notEmpty('from_name', 'Email From name is required')
            ->notEmpty('body', 'Email Body is required');

            
            
    }

	
    public function getTemplate($slug=null)
    {
     return $this->find('all',['conditions'=>['slug'=>$slug]])->last();
    }
  
}

?>