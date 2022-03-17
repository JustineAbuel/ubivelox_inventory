<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TransactionItem $transactionItem
 * @var \Cake\Collection\CollectionInterface|string[] $transactions
 * @var \Cake\Collection\CollectionInterface|string[] $items
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Transaction Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="transactionItems form content">
            <?= $this->Form->create($transactionItem) ?>
            <fieldset>
                <legend><?= __('Add Transaction Item') ?></legend>
                <?php
                    echo $this->Form->control('transaction_id', ['options' => $transactions]);
                    echo $this->Form->control('item_id', ['options' => $items]);
                    echo $this->Form->control('quantity');
                    echo $this->Form->control('internal_warranty', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
