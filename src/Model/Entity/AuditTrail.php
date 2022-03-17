<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AuditTrail Entity
 *
 * @property int $id
 * @property string|null $level
 * @property string|null $username
 * @property string|null $role
 * @property string|null $directory
 * @property string|null $action
 * @property string|null $status
 * @property \Cake\I18n\FrozenTime|null $timestamp
 * @property string|null $log
 */
class AuditTrail extends Entity
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
        'level' => true,
        'username' => true,
        'role' => true,
        'directory' => true,
        'action' => true,
        'status' => true,
        'timestamp' => true,
        'log' => true,
    ];
}
