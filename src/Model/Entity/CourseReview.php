<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CourseReview Entity.
 *
 * @property int $id
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property int $course_id
 * @property \App\Model\Entity\Course $course
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property string $message
 * @property string $name
 * @property string $email
 * @property string $status
 * @property string $website
 */
class CourseReview extends Entity
{

}
