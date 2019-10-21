<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Venue Entity.
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $max_class_size
 * @property string $type
 * @property string $address
 * @property string $country
 * @property string $city
 * @property string $state
 * @property string $postal_code
 * @property int $addedby
 * @property \Cake\I18n\Time $modified
 */
class Venue extends Entity
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
