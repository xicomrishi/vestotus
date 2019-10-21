<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payment Entity.
 *
 * @property int $id
 * @property int $created
 * @property int $modified
 * @property string $status
 * @property string $order_num
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property string $details
 */
class Payment extends Entity
{

}
