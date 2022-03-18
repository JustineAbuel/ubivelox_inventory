<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AuditTrail $auditTrail
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Audit Trail'), ['action' => 'edit', $auditTrail->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Audit Trail'), ['action' => 'delete', $auditTrail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $auditTrail->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Audit Trails'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Audit Trail'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="auditTrails view content">
            <h3><?= h($auditTrail->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Level') ?></th>
                    <td><?= h($auditTrail->level) ?></td>
                </tr>
                <tr>
                    <th><?= __('Channel') ?></th>
                    <td><?= h($auditTrail->channel) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ip Address') ?></th>
                    <td><?= h($auditTrail->ip_address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Username') ?></th>
                    <td><?= h($auditTrail->username) ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= h($auditTrail->role) ?></td>
                </tr>
                <tr>
                    <th><?= __('Action') ?></th>
                    <td><?= h($auditTrail->action) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($auditTrail->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($auditTrail->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Timestamp') ?></th>
                    <td><?= h($auditTrail->timestamp) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Directory') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($auditTrail->directory)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($auditTrail->log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
