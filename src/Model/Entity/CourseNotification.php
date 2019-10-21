<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CourseNotification Entity.
 *
 * @property int $id
 * @property string $subject
 * @property string $content
 * @property int $addedby
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $course_id
 * @property \App\Model\Entity\Course $course
 * @property string $slug
 */
class CourseNotification extends Entity
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
