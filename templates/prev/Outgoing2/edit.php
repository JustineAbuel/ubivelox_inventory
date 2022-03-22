<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Outgoing $outgoing
 * @var string[]|\Cake\Collection\CollectionInterface $items
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $outgoing->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $outgoing->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Outgoing'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="outgoing form content">
            <?= $this->Form->create($outgoing) ?>
            <fieldset>
                <legend><?= __('Edit Outgoing') ?></legend>
                <?php
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
