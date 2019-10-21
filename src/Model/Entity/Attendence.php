<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Attendence Entity.
 *
 * @property int $id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $student_id
 * @property \App\Model\Entity\Student $student
 * @property int $instructor_id
 * @property \App\Model\Entity\Instructor $instructor
 * @property int $addedby
 * @property string $status
 * @property int $course_id
 * @property \App\Model\Entity\Course $course
 * @property int $session_id
 * @property \App\Model\Entity\Session $session
 * @property int $class_id
 * @property \App\Model\Entity\Class $class
 */
class Attendence extends Entity
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
