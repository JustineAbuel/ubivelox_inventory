<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TransactionItem $transactionItem
 * @var string[]|\Cake\Collection\CollectionInterface $transactions
 * @var string[]|\Cake\Collection\CollectionInterface $items
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $transactionItem->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $transactionItem->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Transaction Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="transactionItems form content">
            <?= $this->Form->create($transactionItem) ?>
            <fieldset>
                <legend><?= __('Edit Transaction Item') ?></legend>
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
