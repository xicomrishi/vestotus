<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SessionClass Entity.
 *
 * @property int $id
 * @property int $session_id
 * @property \App\Model\Entity\Session $session
 * @property \Cake\I18n\Time $start_date
 * @property string $start_time
 * @property \Cake\I18n\Time $end_date
 * @property string $end_time
 * @property int $venue_id
 * @property \App\Model\Entity\Venue $venue
 * @property int $duration
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $course_id
 * @property \App\Model\Entity\Course $course
 */
class SessionClass extends Entity
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
