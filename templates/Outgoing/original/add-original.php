<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Outgoing $outgoing
 * @var \Cake\Collection\CollectionInterface|string[] $transactions
 * @var \Cake\Collection\CollectionInterface|string[] $items
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Outgoing'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="outgoing form content">
            <?= $this->Form->create($outgoing) ?>
            <fieldset>
                <legend><?= __('Add Outgoing') ?></legend>
                <?php
                    echo $this->Form->control('transaction_id', ['options' => $transactions]);
                    echo $this->Form->control('item_id', ['options' => $items]);
                    echo $this->Form->control('status');
                    echo $this->Form->control('notes');
                    echo $this->Form->control('date_added', ['empty' => true]);
                    echo $this->Form->control('added_by');
                    echo $this->Form->control('date_updated', ['empty' => true]);
                    echo $this->Form->control('updated_by');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
