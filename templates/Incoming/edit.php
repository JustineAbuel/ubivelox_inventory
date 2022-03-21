<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Incoming $incoming
 * @var string[]|\Cake\Collection\CollectionInterface $items
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $incoming->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $incoming->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Incoming'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="incoming form content">
            <?= $this->Form->create($incoming) ?>
            <fieldset>
                <legend><?= __('Edit Incoming') ?></legend>
                <?php
                    echo $this->Form->control('item_id', ['options' => $items]);
                    echo $this->Form->control('quantity');
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
