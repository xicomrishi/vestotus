<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * EnrollKey Entity.
 *
 * @property int $id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property string $title
 * @property string $key_name
 * @property int $department_id
 * @property \App\Model\Entity\Department $department
 * @property int $max_users
 * @property int $times_used
 * @property int $no_of_courses
 * @property int $addedby
 */
class EnrollKey extends Entity
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
