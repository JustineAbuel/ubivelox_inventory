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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $auditTrail->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $auditTrail->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Audit Trails'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="auditTrails form content">
            <?= $this->Form->create($auditTrail) ?>
            <fieldset>
                <legend><?= __('Edit Audit Trail') ?></legend>
                <?php
                    echo $this->Form->control('level');
                    echo $this->Form->control('channel');
                    echo $this->Form->control('ip_address');
                    echo $this->Form->control('username');
                    echo $this->Form->control('role');
                    echo $this->Form->control('directory');
                    echo $this->Form->control('action');
                    echo $this->Form->control('status');
                    echo $this->Form->control('timestamp', ['empty' => true]);
                    echo $this->Form->control('log');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
