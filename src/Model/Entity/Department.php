<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity.
 *
 * @property int $id
 * @property string $title
 * @property int $parent_id
 * @property \App\Model\Entity\ParentCategory $parent_category
 * @property string $status
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\ChildCategory[] $child_categories
 */
class Department extends Entity
{

}
