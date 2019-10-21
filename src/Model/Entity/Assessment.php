<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Assessment Entity.
 *
 * @property int $id
 * @property string $question
 * @property string $options
 * @property string $answer
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $chapter_id
 * @property \App\Model\Entity\Chapter $chapter
 * @property int $owner
 * @property int $course_id
 * @property \App\Model\Entity\Course $course
 */
class Assessment extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
