<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TransactionStatus[]|\Cake\Collection\CollectionInterface $transactionStatus
 */
?>
<div class="transactionStatus index content">
    <?= $this->Html->link(__('New Transaction Status'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Transaction Status') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('status_name') ?></th>
                    <th><?= $this->Paginator->sort('date_added') ?></th>
                    <th><?= $this->Paginator->sort('added_by') ?></th>
                    <th><?= $this->Paginator->sort('date_updated') ?></th>
                    <th><?= $this->Paginator->sort('updated_by') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactionStatus as $transactionStatus): ?>
                <tr>
                    <td><?= $this->Number->format($transactionStatus->id) ?></td>
                    <td><?= h($transactionStatus->status_name) ?></td>
                    <td><?= h($transactionStatus->date_added) ?></td>
                    <td><?= $this->Number->format($transactionStatus->added_by) ?></td>
                    <td><?= h($transactionStatus->date_updated) ?></td>
                    <td><?= $this->Number->format($transactionStatus->updated_by) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $transactionStatus->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $transactionStatus->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $transactionStatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transactionStatus->id)]) ?>
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
