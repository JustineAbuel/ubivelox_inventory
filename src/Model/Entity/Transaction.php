<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Transaction Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $transaction_code
 * @property int $transaction_type_id
 * @property int $company_from
 * @property int $company_to
 * @property string|null $subject
 * @property string|null $received_by
 * @property \Cake\I18n\FrozenTime|null $received_date
 * @property int|null $status
 * @property \Cake\I18n\FrozenTime|null $date_added
 * @property int|null $added_by
 * @property \Cake\I18n\FrozenTime|null $cancelled
 * @property int|null $cancelled_by
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\TransactionType $transaction_type
 * @property \App\Model\Entity\TransactionItem[] $transaction_items
 */
class Transaction extends Entity
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
        'user_id' => true,
        'transaction_code' => true,
        'transaction_type_id' => true,
        'company_from' => true,
        'company_to' => true,
        'subject' => true,
        'received_by' => true,
        'received_date' => true,
        'status' => true,
        'date_added' => true,
        'added_by' => true,
        'cancelled' => true,
        'cancelled_by' => true,
        'user' => true,
        'transaction_type' => true,
        'transaction_items' => true,
        'company' => true,
    ];
}
