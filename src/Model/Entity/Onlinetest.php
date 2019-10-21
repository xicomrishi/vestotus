<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Onlinetest Entity.
 *
 * @property int $id
 * @property int $question_id
 * @property \App\Model\Entity\Question $question
 * @property string $answerbyuser
 * @property string $correctanswer
 * @property string $status
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property int $course_id
 * @property \App\Model\Entity\Course $course
 * @property int $assessment_id
 * @property \App\Model\Entity\Assessment $assessment
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $created
 * @property string $type
 * @property float $percentage
 * @property string $time_of_completion
 */
class Onlinetest extends Entity
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
