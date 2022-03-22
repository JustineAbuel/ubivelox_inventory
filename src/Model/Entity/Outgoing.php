<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Outgoing Entity
 *
 * @property int $id
 * @property int $transaction_id
 * @property int $item_id
 * @property int $status
 * @property string|null $notes
 * @property \Cake\I18n\FrozenTime|null $date_added
 * @property string|null $added_by
 * @property \Cake\I18n\FrozenTime|null $date_updated
 * @property string|null $updated_by
 *
 * @property \App\Model\Entity\Transaction $transaction
 * @property \App\Model\Entity\Item $item
 */
class Outgoing extends Entity
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
        'transaction_id' => true,
        'item_id' => true,
        'status' => true,
        'notes' => true,
        'date_added' => true,
        'added_by' => true,
        'date_updated' => true,
        'updated_by' => true,
        'transaction' => true,
        'item' => true,
    ];
}
