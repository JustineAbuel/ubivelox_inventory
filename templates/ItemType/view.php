<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ItemType $itemType
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Item Type'), ['action' => 'edit', $itemType->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Item Type'), ['action' => 'delete', $itemType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $itemType->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Item Type'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Item Type'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="itemType view content">
            <h3><?= h($itemType->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Type Name') ?></th>
                    <td><?= h($itemType->type_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($itemType->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Items') ?></h4>
                <?php if (!empty($itemType->items)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Category Id') ?></th>
                            <th><?= __('Item Name') ?></th>
                            <th><?= __('Serial No') ?></th>
                            <th><?= __('Item Description') ?></th>
                            <th><?= __('Issued Date') ?></th>
                            <th><?= __('Warranty') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Supplier Id') ?></th>
                            <th><?= __('Item Type Id') ?></th>
                            <th><?= __('Quality') ?></th>
                            <th><?= __('Remarks') ?></th>
                            <th><?= __('Part No') ?></th>
                            <th><?= __('Operating System') ?></th>
                            <th><?= __('Kernel') ?></th>
                            <th><?= __('Header Type') ?></th>
                            <th><?= __('Firmware') ?></th>
                            <th><?= __('Features') ?></th>
                            <th><?= __('Date Added') ?></th>
                            <th><?= __('Added By') ?></th>
                            <th><?= __('Date Updated') ?></th>
                            <th><?= __('Updated By') ?></th>
                            <th><?= __('Trashed') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($itemType->items as $items) : ?>
                        <tr>
                            <td><?= h($items->id) ?></td>
                            <td><?= h($items->category_id) ?></td>
                            <td><?= h($items->item_name) ?></td>
                            <td><?= h($items->serial_no) ?></td>
                            <td><?= h($items->item_description) ?></td>
                            <td><?= h($items->issued_date) ?></td>
                            <td><?= h($items->warranty) ?></td>
                            <td><?= h($items->quantity) ?></td>
                            <td><?= h($items->supplier_id) ?></td>
                            <td><?= h($items->item_type_id) ?></td>
                            <td><?= h($items->quality) ?></td>
                            <td><?= h($items->remarks) ?></td>
                            <td><?= h($items->part_no) ?></td>
                            <td><?= h($items->operating_system) ?></td>
                            <td><?= h($items->kernel) ?></td>
                            <td><?= h($items->header_type) ?></td>
                            <td><?= h($items->firmware) ?></td>
                            <td><?= h($items->features) ?></td>
                            <td><?= h($items->date_added) ?></td>
                            <td><?= h($items->added_by) ?></td>
                            <td><?= h($items->date_updated) ?></td>
                            <td><?= h($items->updated_by) ?></td>
                            <td><?= h($items->trashed) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Items', 'action' => 'view', $items->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Items', 'action' => 'edit', $items->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Items', 'action' => 'delete', $items->id], ['confirm' => __('Are you sure you want to delete # {0}?', $items->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
