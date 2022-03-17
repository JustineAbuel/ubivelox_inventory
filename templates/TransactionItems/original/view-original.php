<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TransactionItem $transactionItem
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Transaction Item'), ['action' => 'edit', $transactionItem->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Transaction Item'), ['action' => 'delete', $transactionItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transactionItem->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Transaction Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Transaction Item'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="transactionItems view content">
            <h3><?= h($transactionItem->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Transaction') ?></th>
                    <td><?= $transactionItem->has('transaction') ? $this->Html->link($transactionItem->transaction->id, ['controller' => 'Transactions', 'action' => 'view', $transactionItem->transaction->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Item') ?></th>
                    <td><?= $transactionItem->has('item') ? $this->Html->link($transactionItem->item->id, ['controller' => 'Items', 'action' => 'view', $transactionItem->item->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($transactionItem->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($transactionItem->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Internal Warranty') ?></th>
                    <td><?= h($transactionItem->internal_warranty) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
