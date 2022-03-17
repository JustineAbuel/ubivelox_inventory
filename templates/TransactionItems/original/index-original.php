<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TransactionItem[]|\Cake\Collection\CollectionInterface $transactionItems
 */
?>
<div class="transactionItems index content">
    <?= $this->Html->link(__('New Transaction Item'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Transaction Items') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('transaction_id') ?></th>
                    <th><?= $this->Paginator->sort('item_id') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('internal_warranty') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactionItems as $transactionItem): ?>
                <tr>
                    <td><?= $this->Number->format($transactionItem->id) ?></td>
                    <td><?= $transactionItem->has('transaction') ? $this->Html->link($transactionItem->transaction->id, ['controller' => 'Transactions', 'action' => 'view', $transactionItem->transaction->id]) : '' ?></td>
                    <td><?= $transactionItem->has('item') ? $this->Html->link($transactionItem->item->id, ['controller' => 'Items', 'action' => 'view', $transactionItem->item->id]) : '' ?></td>
                    <td><?= $this->Number->format($transactionItem->quantity) ?></td>
                    <td><?= h($transactionItem->internal_warranty) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $transactionItem->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $transactionItem->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $transactionItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transactionItem->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
