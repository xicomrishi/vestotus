<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TestResult Entity.
 *
 * @property int $id
 * @property string $test_id
 * @property \App\Model\Entity\Test $test
 * @property float $percent
 * @property int $required_precent
 * @property int $created
 * @property int $modified
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property int $course_id
 * @property \App\Model\Entity\Course $course
 */
class TestResult extends Entity
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
