<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Course Entity.
 *
 * @property int $id
 * @property string $title
 * @property string $tags
 * @property string $description
 * @property string $image
 * @property string $thumbnail
 * @property string $notes
 * @property string $type
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $addedby
 * @property \App\Model\Entity\CourseChapter[] $course_chapters
 * @property \App\Model\Entity\EnrollRule[] $enroll_rules
 */
class Course extends Entity
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
