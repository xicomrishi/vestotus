<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
// use Cake\Core\Exception\Exception;
use Cake\Controller\Component\CookieComponent;

class UsersTable extends Table
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
        
        $this->hasOne('Departments', [
            'className' => 'Departments',
            'foreignKey' =>  'id',
            'targetForeignKey'=>'department_id',
            'joinType'=>'Left',
            
        ]);
        $this->belongsTo('Countries', [
            'foreignKey' =>  'country_id',
            'joinType'=>'Left',
        ]);
        $this->belongsTo('States', [
            'foreignKey' =>  'state_id',
            'joinType'=>'Left',
        ]);
        $this->belongsTo('Cities', [
            'foreignKey' =>  'city_id',
            'joinType'=>'Left',
        ]);
        $this->belongsTo('UserRoles', [
            'className' =>  'Roles',
            'foreignKey' =>  'role',
            'joinType'=>'Inner',
        ]);

        /*   $this->hasOne('Countries', [
            'className' => 'Countries',
            'foreignKey' =>  'id',
            'targetForeignKey'=>'country',
            'joinType'=>'Left',
            
        ]);*/
        $this->hasOne('Companies', [
            'className' => 'Companies',
            'foreignKey' =>  'id',
            'bindingKey'=>'company_id',
            'joinType'=>'Left',
            
        ]);

         $this->hasOne('Learners', [
            'className' => 'Learners',
            'foreignKey' =>  'user_id',
            'dependent'=>true,
            'joinType'=>'Left',
            
        ]);
         
          $this->hasMany('UserDepartments', [
            'className' => 'UserDepartments',
            'foreignKey' =>  'user_id',
            'dependent'=>true,
            'joinType'=>'Left',
            
        ]);
         $this->hasMany('UserCourses', [
            'className' => 'UserCourses',
            'foreignKey' =>  'user_id',
            'dependent'=>true,
            'joinType'=>'Left',
            
        ]);



        $this->table('users');
    }

    /*public function findAuth(\Cake\ORM\Query $query, array $options)
    {
      // echo '<pre>'; print_r($options); die;
        return $query->where(
            [
                'OR' => [
                    $this->aliasField('password') => $options['password'],
                    $this->aliasField('temp_password') => $options['password'],
                    // $this->aliasField('password') => $options['temp_password'],
                ]
            ],
            [],
            true
        );
    }*/
    public function findAuth(\Cake\ORM\Query $query, array $options)
    {
        // App::import('Component','CookieComponent');
        // $Cookie = new CookieComponent();
        // echo $Cookie->read('password'); die;
        // echo $this->Cookie->read('username'); die;
        // $loginCookie['username'] = $this->Cookie->read('username');
        // $loginCookie['password'] = $this->Cookie->read('password');

        // echo '<pre>'; print_r($options); die;
        return $query->where(
            [
                // 'id' => '1'
                // 'OR' => [
                //     $this->aliasField('password') => $options['password'],
                //     $this->aliasField('temp_password') => $options['password'],
                //     // $this->aliasField('password') => $options['temp_password'],
                // ]
            ]
        );
    }

    public function validationDefault(Validator $validator)
    {
        return $validator
            ->notEmpty('fname', 'First Name is required')
            ->add('fname','custom',['rule'=>['custom','/[a-zA-Z]+/'],'message'=>'Please enter only alphabets .'])
            ->notEmpty('fullname', 'Name is required')
            ->add('fullname','custom',['rule'=>['custom','/[a-zA-Z]+/'],'message'=>'Please enter only alphabets .'])
            ->notEmpty('lname', 'Last Name is required')
            ->add('lname','custom',['rule'=>['custom','/[a-zA-Z]+/'],'message'=>'Please enter only alphabets .'])
            ->notEmpty('email', 'Email address is required.')
            ->add('email', 'validFormat', [
                  'rule' => 'email',
                  'message' => 'Enter a valid email address.'
              ])
            ->notEmpty('zip', 'Enter Postal code.')
            ->add('zip', 'minLength',['rule'=>['minLength','4'],'message'=>'Please enter valid Postal Code.'])
            ->add('zip', 'maxLength',['rule'=>['maxLength','15'],'message'=>'Please enter valid Postal Code.'])
            ->add('zip',
               [
                'alphaNumeric' => [
                    'rule' => 'alphaNumeric',
                    'last' => true,
                    'message' => 'Please use alphaNumeric characters only.'
                ],
                 ])
            ->notEmpty('country', 'Country is required')
            ->add('country', 'custom',['rule'=>['custom','/[a-zA-Z1-9]+/'],'message'=>'Please enter valid Country.'])
            ->notEmpty('city', 'City is required')
            ->add('city', 'custom',['rule'=>['custom','/[a-zA-Z1-9]+/'],'message'=>'Please enter valid City.'])
            ->notEmpty('state', 'State is required')
            ->add('state', 'custom',['rule'=>['custom','/[a-zA-Z1-9]+/'],'message'=>'Please enter valid State.'])
            ->add('username', 'unique', [
                  'rule' => 'validateUnique',   
                  'provider' => 'table',
                  'message' =>'Username already exists.'
            ])
            ->add('username',
               [
                'alphaNumeric' => [
                    'rule' => 'alphaNumeric',
                    'last' => true,
                    'message' => 'Please use alphaNumeric characters only.'
                ],
                 ])
            ->add('email', 'unique', [
                  'rule' => 'validateUnique',
                  'provider' => 'table',
                  'message' =>'Email already exists.'
            ])
            ->notEmpty('password', 'Enter a password. ')
         
            ->notEmpty('confirm_password','Confirm Password is required.')
            ->add('confirm_password', 'mismatch', [
                'rule' => ['compareWith', 'password'],
                'message' => 'Passwords donot match.',
            ])
            ->notEmpty('terms_conditions','Please accept terms and conditUserDetailsions')
          ->notEmpty('role', 'A role is required')
            ->add('role', 'inList', [
                'rule' => ['inList', ['1', '2','3','4','5']],
                'message' => 'Please enter a valid role'
            ])
            /**************************password ***************************************/
            ->add('old_password','custom',[
                'rule'=>  function($value, $context){
                    $user = $this->get($context['data']['id']);
                    if ($user) {
                        if ((new DefaultPasswordHasher)->check($value, $user->password)) {
                            return true;
                        }
                    }
                    return false;
                },
                'message'=>'The old password does not match the current password!',
            ])
            ->notEmpty('old_password')
 
            ->add('password1', [
                'length' => [
                    'rule' => ['minLength', 6],
                    'message' => 'The password have to be at least 6 characters!',
                ]
            ])
            ->add('password1', [
                'custom' => [
                    'rule' => ['custom', '/[^\w\d]*(([0-9]+.*[A-Za-z]+.*)|[A-Za-z]+.*([0-9]+.*))/'],
                    'message' => 'The password should have atleast 1 number!',
                ]
            ])
            ->add('password1',[
                'match'=>[
                    'rule'=> ['compareWith','password2'],
                    'message'=>'These passwords dont match. Try again?',
                ]
            ])
            ->notEmpty('password1')
        
            
            ->add('password2',[
                'match'=>[
                    'rule'=> ['compareWith','password1'],
                    'message'=>' ',
                ]
            ])
            ->notEmpty('password2');
    }

    public function validationregistrationSecondStep(Validator $validator)
    {
        return $validator
            
            ->notEmpty('zip', 'Enter Postal code.')
            ->add('zip', 'minLength',['rule'=>['minLength','4'],'message'=>'Please enter valid Postal Code.'])
            ->add('zip', 'maxLength',['rule'=>['maxLength','15'],'message'=>'Please enter valid Postal Code.'])
            ->add('zip',
               [
                'alphaNumeric' => [
                    'rule' => 'alphaNumeric',
                    'last' => true,
                    'message' => 'Please use alphaNumeric characters only.'
                ],
                 ])
                  ->notEmpty('address', 'Home address is required')
                
            ->notEmpty('country_id', 'Country is required')
           
            ->notEmpty('city_id', 'City is required')
          
            ->notEmpty('state_id', 'State is required');
         
          
         
    }
    public function validationRegistrationFirstStep(Validator $validator)
    {
        return $validator
            ->notEmpty('fname', 'First Name is required')
            ->add('fname','custom',['rule'=>['custom','/[a-zA-Z]+/'],'message'=>'Please enter only alphabets .'])
            ->notEmpty('lname', 'Last Name is required')
            ->add('lname','custom',['rule'=>['custom','/[a-zA-Z]+/'],'message'=>'Please enter only alphabets .'])
            ->notEmpty('email', 'Email address is required.')
            ->add('email', 'validFormat', [
                  'rule' => 'email',
                  'message' => 'Enter a valid email address.'
              ])
          
            ->add('username', 'unique', [
                  'rule' => 'validateUnique',   
                  'provider' => 'table',
                  'message' =>'Username already exists.'
            ])
            ->add('username',
               [
                'alphaNumeric' => [
                    'rule' => 'alphaNumeric',
                    'last' => true,
                    'message' => 'Please use alphaNumeric characters only.'
                ],
                 ])
            ->add('email', 'unique', [
                  'rule' => 'validateUnique',
                  'provider' => 'table',
                  'message' =>'Email already exists.'
            ])
          
         
          ->notEmpty('role', 'A role is required')
            ->add('role', 'inList', [
                'rule' => ['inList', ['1', '2','3','4','5']],
                'message' => 'Please enter a valid role'
            ])
            /**************************password ***************************************/
            ->add('old_password','custom',[
                'rule'=>  function($value, $context){
                    $user = $this->get($context['data']['id']);
                    if ($user) {
                        if ((new DefaultPasswordHasher)->check($value, $user->password)) {
                            return true;
                        }
                    }
                    return false;
                },
                'message'=>'The old password does not match the current password!',
            ])
            ->notEmpty('old_password')
 
            ->add('password1', [
                'length' => [
                    'rule' => ['minLength', 6],
                    'message' => 'The password have to be at least 6 characters!',
                ]
            ])
            ->add('password1', [
                'custom' => [
                    'rule' => ['custom', '/[^\w\d]*(([0-9]+.*[A-Za-z]+.*)|[A-Za-z]+.*([0-9]+.*))/'],
                    'message' => 'The password should have atleast 1 number!',
                ]
            ])
            ->add('password1',[
                'match'=>[
                    'rule'=> ['compareWith','password2'],
                    'message'=>'These passwords dont match. Try again?',
                ]
            ])
            ->notEmpty('password1')
        
            
            ->add('password2',[
                'match'=>[
                    'rule'=> ['compareWith','password1'],
                    'message'=>' ',
                ]
            ])
            ->notEmpty('password2');
    }
    
    
    public function beforeSave($data = array())
    {

        /*if(!$data->data['entity']['password'] && $data->data['entity']['prevent_password_update']==0)
        {
            $password = $this->generate_password();
            $data->data['entity']['username2'] = $password;
            $data->data['entity']['password'] = $password;
        } 

        $fullname = $data->data['entity']['fname'].' '.$data->data['entity']['lname'];

        try{
            $data->data['entity']['fullname'] = $fullname;
        } catch(\Exception $ex){
            //   echo $ex->message; 
        }*/        
        // $data->data['entity']['fullname'] = $data->data['entity']['fname'].' '.$data->data['entity']['lname'];

    
    }
	public function isOwnedBy($userId, $ownerId)
	{
	    return $this->exists(['Users.id' => $userId, 'Users.addedby' => $ownerId]);
	}

  public function activate($id=null)
  {
      $getUser = $this->get($id);
      $data['status'] = '1';
      $getUser = $this->patchEntity($getUser,$data);
      if($this->save($getUser))
      {
        $msg = 'done';
      }
      else
      {
        $msg='error';
      }
      return $msg;
    
  }
  public function deactivate($id=null)
  {
    $getUser = $this->get($id);
      $data['status'] = '0';
      $getUser = $this->patchEntity($getUser,$data);
      if($this->save($getUser))
      {
        $msg = 'done';
      }
      else
      {
        $msg='error';
      }
      return $msg;
    
  }
   public function delUser($id=null)
  {
    $getusers = $this->find('all',['conditions'=>['UserDetails.vendor_id'=>$id],'contain'=>['UserDetails']])->toArray();
    
    if($getusers)
    {
      foreach($getusers as $users)
      {
        $userdel = $this->get($users['id']);
        $data['status'] = '2';
        $data['email'] = time().'deleted_'.$users['email'];
        $userdel = $this->patchEntity($userdel,$data);
        $this->save($userdel);
      }

    }
   
      $msg = 'done';
    return $msg ;
  }
public function is_exists($id=null,$addedby=null)
{
  if($addedby)
  {
    return $this->find('all',['conditions'=>['Users.id'=>$id,'Users.addedby'=>$addedby]])->count();
  }
  else
  {
 return $this->find('all',['conditions'=>['Users.id'=>$id]])->count();
  }
}


public function generate_password()
{

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*";
    $password = substr( str_shuffle( $chars ), 0, '8' );
    return $password;
}


public function getByEmail($email=null)
{
 return $this->find('all',['conditions'=>['Users.email'=>$email,'Users.status !='=>'2']])->last(); 
}

public function reset_link($code=null)
{
   
   return $this->find('all',['conditions'=>['Users.reset_password'=>$code]])->last(); 

}



  function email_valid($email=null)
  {
    $validator = new Validator();
         $validator->add('email', 'validFormat', [
                  'rule' => 'email',
                  'message' => 'Please enter a valid email address.'
              ]);
    $errors = $validator->errors(['email'=>$email]);
    
if ($errors) {
return $errors['email']['validFormat'];    
}
else
{
return 'valid';
}
}
  
  


  



  public function userdelete($id=null)
  {
   
        $userdel = $this->get($id);
        $data['status'] = '2';
        $data['email'] = time().'deleted_'.$userdel['email'];
        $userdel = $this->patchEntity($userdel,$data);
        if($this->save($userdel))
        {
         $msg = 'done';
        }
        else
        {
          $msg = 'error';
        }
        return $msg ;
  }
  public function getLearnerslistbyOwner($id=null)
  {
    return $this->find('list',['conditions'=>['addedby'=>$id],'contain'=>['Learners']]);
        
  }
  
  
  public function getManagers($id=null)
  {      
    return $this->find('list',['conditions'=>['Users.role'=>2]]);
  }

  public function getLearnersOfManager($manager_user_id=null)
  {      
        return $this->find('list', [
          'keyField' => 'id',
          'valueField' => 'username',
          'conditions' => [
                'manager_id' => $manager_user_id, 
                'status' => 1,
                'role' => 4
            ], 
        ])->toArray();
  }

}

?>