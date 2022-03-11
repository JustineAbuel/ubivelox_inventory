<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ItemType[]|\Cake\Collection\CollectionInterface $itemType
 */
?>
<div class="itemType index content">
    <?= $this->Html->link(__('New Item Type'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Item Type') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('type_name') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($itemType as $itemType): ?>
                <tr>
                    <td><?= $this->Number->format($itemType->id) ?></td>
                    <td><?= h($itemType->type_name) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $itemType->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $itemType->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $itemType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $itemType->id)]) ?>
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
