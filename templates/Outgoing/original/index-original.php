<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Outgoing[]|\Cake\Collection\CollectionInterface $outgoing
 */
?>
<div class="outgoing index content">
    <?= $this->Html->link(__('New Outgoing'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Outgoing') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('transaction_id') ?></th>
                    <th><?= $this->Paginator->sort('item_id') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('date_added') ?></th>
                    <th><?= $this->Paginator->sort('added_by') ?></th>
                    <th><?= $this->Paginator->sort('date_updated') ?></th>
                    <th><?= $this->Paginator->sort('updated_by') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($outgoing as $outgoing): ?>
                <tr>
                    <td><?= $this->Number->format($outgoing->id) ?></td>
                    <td><?= $outgoing->has('transaction') ? $this->Html->link($outgoing->transaction->id, ['controller' => 'Transactions', 'action' => 'view', $outgoing->transaction->id]) : '' ?></td>
                    <td><?= $outgoing->has('item') ? $this->Html->link($outgoing->item->id, ['controller' => 'Items', 'action' => 'view', $outgoing->item->id]) : '' ?></td>
                    <td><?= $this->Number->format($outgoing->status) ?></td>
                    <td><?= h($outgoing->date_added) ?></td>
                    <td><?= h($outgoing->added_by) ?></td>
                    <td><?= h($outgoing->date_updated) ?></td>
                    <td><?= h($outgoing->updated_by) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $outgoing->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $outgoing->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $outgoing->id], ['confirm' => __('Are you sure you want to delete # {0}?', $outgoing->id)]) ?>
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
