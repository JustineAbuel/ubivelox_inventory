<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Item Entity
 *
 * @property int $id
 * @property int $category_id
 * @property string $item_name
 * @property string|null $serial_no
 * @property string|null $item_description
 * @property \Cake\I18n\FrozenTime|null $issued_date
 * @property \Cake\I18n\FrozenDate $warranty
 * @property int $quantity
 * @property int $supplier_id
 * @property int $item_type_id
 * @property int $quality
 * @property string|null $remarks
 * @property string|null $part_no
 * @property string|null $operating_system
 * @property string|null $kernel
 * @property string|null $header_type
 * @property string|null $firmware
 * @property string|null $features
 * @property \Cake\I18n\FrozenTime|null $date_added
 * @property int|null $added_by
 * @property \Cake\I18n\FrozenTime|null $date_updated
 * @property int|null $updated_by
 * @property \Cake\I18n\FrozenTime|null $trashed
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Supplier $supplier
 * @property \App\Model\Entity\ItemType $item_type
 * @property \App\Model\Entity\Transaction[] $transactions
 */
class Item extends Entity
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
        'category_id' => true,
        'item_name' => true,
        'serial_no' => true,
        'item_description' => true,
        'issued_date' => true,
        'warranty' => true,
        'quantity' => true,
        'supplier_id' => true,
        'item_type_id' => true,
        'quality' => true,
        'remarks' => true,
        'part_no' => true,
        'operating_system' => true,
        'kernel' => true,
        'header_type' => true,
        'firmware' => true,
        'features' => true,
        'date_added' => true,
        'added_by' => true,
        'date_updated' => true,
        'updated_by' => true,
        'trashed' => true,
        'category' => true,
        'supplier' => true,
        'item_type' => true,
        'transactions' => true,
    ];
}
