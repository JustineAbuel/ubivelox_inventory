<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Incoming Entity
 *
 * @property int $id
 * @property int $item_id
 * @property int $quantity
 * @property \Cake\I18n\FrozenTime|null $date_added
 * @property int|null $added_by
 * @property \Cake\I18n\FrozenTime|null $date_updated
 * @property int|null $updated_by
 *
 * @property \App\Model\Entity\Item $item
 */
class Incoming extends Entity
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
        'item_id' => true,
        'quantity' => true,
        'date_added' => true,
        'added_by' => true,
        'date_updated' => true,
        'updated_by' => true,
        'item' => true,
    ];
}
