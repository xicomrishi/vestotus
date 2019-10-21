<?php
namespace App\Model\Table;

use App\Model\Entity\CourseFile;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CourseFiles Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Courses
 */
class CourseFilesTable extends Table
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

        $this->table('course_files');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('CourseChapters', [
            'foreignKey' => 'chapter_id',
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
            ->requirePresence('filename', 'create')
            ->notEmpty('filename');

        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    
    public function deletebyChapter($chapter_id=null)
    {
        $getfiles = $this->find('all',['conditions'=>['chapter_id'=>$chapter_id]])->toArray();
        foreach ($getfiles as $v) {
            $filename = $v['filename'];
            if($v['type']=='audio')
            {
             unlink(WWW_ROOT.'uploads/courses/audio/'.$filename);
            }
            if($v['type']=='video')
            {
             unlink(WWW_ROOT.'uploads/courses/videos/'.$filename);
            }
            if($v['type']=='ppt')
            {
             unlink(WWW_ROOT.'uploads/courses/ppt/'.$filename);
            }
            $get = $this->get($v['id']);
            $this->delete($get);
        }
        return true;

    }
}
