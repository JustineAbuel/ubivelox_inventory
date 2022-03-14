<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transaction[]|\Cake\Collection\CollectionInterface $transactions
 */
?>
<div class="transactions index content">
    <?= $this->Html->link(__('New Transaction'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Transactions') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('transaction_code') ?></th>
                    <th><?= $this->Paginator->sort('transaction_type_id') ?></th>
                    <th><?= $this->Paginator->sort('company_from') ?></th>
                    <th><?= $this->Paginator->sort('company_to') ?></th>
                    <th><?= $this->Paginator->sort('subject') ?></th>
                    <th><?= $this->Paginator->sort('received_by') ?></th>
                    <th><?= $this->Paginator->sort('received_date') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('date_added') ?></th>
                    <th><?= $this->Paginator->sort('added_by') ?></th>
                    <th><?= $this->Paginator->sort('cancelled') ?></th>
                    <th><?= $this->Paginator->sort('cancelled_by') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <td><?= $this->Number->format($transaction->id) ?></td>
                    <td><?= $transaction->has('user') ? $this->Html->link($transaction->user->id, ['controller' => 'Users', 'action' => 'view', $transaction->user->id]) : '' ?></td>
                    <td><?= h($transaction->transaction_code) ?></td>
                    <td><?= $this->Number->format($transaction->transaction_type_id) ?></td>
                    <td><?= $this->Number->format($transaction->company_from) ?></td>
                    <td><?= $this->Number->format($transaction->company_to) ?></td>
                    <td><?= h($transaction->subject) ?></td>
                    <td><?= h($transaction->received_by) ?></td>
                    <td><?= h($transaction->received_date) ?></td>
                    <td><?= $this->Number->format($transaction->status) ?></td>
                    <td><?= h($transaction->date_added) ?></td>
                    <td><?= $this->Number->format($transaction->added_by) ?></td>
                    <td><?= h($transaction->cancelled) ?></td>
                    <td><?= $this->Number->format($transaction->cancelled_by) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $transaction->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $transaction->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $transaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transaction->id)]) ?>
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
