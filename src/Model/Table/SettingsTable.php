<?php
namespace App\Model\Table;

use App\Model\Entity\Setting;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Settings Model
 *
 */
class SettingsTable extends Table
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

        $this->table('settings');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->requirePresence('contact_email', 'create')
            ->email('contact_email')
            ->notEmpty('contact_email');

        $validator
            ->requirePresence('fb_link', 'create')
            ->add('fb_link', 'custom', ['rule' => ['custom','/^(http|https):\\/\\/[facebook.com]+([\\-\\.]{1}[a-z0-9]+)*\\.[a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i'],'message'=>'Please enter valid Facebook Link .'])
            ->notEmpty('fb_link');

        $validator
            ->requirePresence('twitter_link', 'create')
            ->add('twitter_link', 'custom', ['rule' => ['custom','/^(http|https):\\/\\/[twitter.com]+([\\-\\.]{1}[a-z0-9]+)*\\.[a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i'],'message'=>'Please enter valid Twitter Link .'])
            ->notEmpty('twitter_link');

        $validator
            ->requirePresence('gplus_link', 'create')
             ->add('gplus_link', 'custom', ['rule' => ['custom','/^(http|https):\\/\\/[plus.google.com]+([\\-\\.]{1}[a-z0-9]+)*\\.[a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i'],'message'=>'Please enter valid Google Plus Link .']);
            

         $validator
            ->requirePresence('insta_link', 'create')
             ->add('insta_link', 'custom', ['rule' => ['custom','/^(http|https):\\/\\/[instagram.com]+([\\-\\.]{1}[a-z0-9]+)*\\.[a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i'],'message'=>'Please enter valid Instagram Link .'])
            ->notEmpty('insta_link');

        $validator
            ->requirePresence('youtube_link', 'create')
            ->add('youtube_link', 'custom', ['rule' => ['custom','/^(http|https):\\/\\/[youtube.com]+([\\-\\.]{1}[a-z0-9]+)*\\.[a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i'],'message'=>'Please enter valid Youtube Link .']);
            

        return $validator;
    }

    public function getField($slug=null)
    {
        $data = $this->get('1',['fields'=>$slug]);
        return $data[$slug];
    }
}
