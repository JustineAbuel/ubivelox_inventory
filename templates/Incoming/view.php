<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Incoming $incoming
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Incoming'), ['action' => 'edit', $incoming->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Incoming'), ['action' => 'delete', $incoming->id], ['confirm' => __('Are you sure you want to delete # {0}?', $incoming->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Incoming'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Incoming'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="incoming view content">
            <h3><?= h($incoming->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Item') ?></th>
                    <td><?= $incoming->has('item') ? $this->Html->link($incoming->item->id, ['controller' => 'Items', 'action' => 'view', $incoming->item->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($incoming->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($incoming->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Added By') ?></th>
                    <td><?= $this->Number->format($incoming->added_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated By') ?></th>
                    <td><?= $this->Number->format($incoming->updated_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Added') ?></th>
                    <td><?= h($incoming->date_added) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Updated') ?></th>
                    <td><?= h($incoming->date_updated) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
