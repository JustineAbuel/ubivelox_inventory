<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserRole Entity
 *
 * @property int $id
 * @property string $role_name
 * @property \Cake\I18n\FrozenTime|null $date_added
 * @property int|null $added_by
 * @property \Cake\I18n\FrozenTime|null $date_updated
 * @property int|null $updated_by
 */
class UserRole extends Entity
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
        'role_name' => true,
        'date_added' => true,
        'added_by' => true,
        'date_updated' => true,
        'updated_by' => true,
    ];
}
