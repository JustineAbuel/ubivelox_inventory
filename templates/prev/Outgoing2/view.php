<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Outgoing $outgoing
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Outgoing'), ['action' => 'edit', $outgoing->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Outgoing'), ['action' => 'delete', $outgoing->id], ['confirm' => __('Are you sure you want to delete # {0}?', $outgoing->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Outgoing'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Outgoing'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="outgoing view content">
            <h3><?= h($outgoing->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Item') ?></th>
                    <td><?= $outgoing->has('item') ? $this->Html->link($outgoing->item->id, ['controller' => 'Items', 'action' => 'view', $outgoing->item->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Added By') ?></th>
                    <td><?= h($outgoing->added_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated By') ?></th>
                    <td><?= h($outgoing->updated_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($outgoing->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($outgoing->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Added') ?></th>
                    <td><?= h($outgoing->date_added) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Updated') ?></th>
                    <td><?= h($outgoing->date_updated) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($outgoing->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
