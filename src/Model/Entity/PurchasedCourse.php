<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PurchasedCourse Entity.
 *
 * @property int $id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property int $course_id
 * @property \App\Model\Entity\Course $course
 * @property float $amount
 * @property int $quantity
 * @property int $status
 * @property int $enrolled_users
 */
class PurchasedCourse extends Entity
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
