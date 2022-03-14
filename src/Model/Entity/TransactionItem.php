<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TransactionItem Entity
 *
 * @property int $id
 * @property int $transaction_id
 * @property int $item_id
 * @property int $quantity
 * @property \Cake\I18n\FrozenDate|null $internal_warranty
 *
 * @property \App\Model\Entity\Transaction $transaction
 * @property \App\Model\Entity\Item $item
 */
class TransactionItem extends Entity
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
        'quantity' => true,
        'internal_warranty' => true,
        'transaction' => true,
        'item' => true,
    ];
}
