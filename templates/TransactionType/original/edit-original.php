<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TransactionType $transactionType
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $transactionType->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $transactionType->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Transaction Type'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="transactionType form content">
            <?= $this->Form->create($transactionType) ?>
            <fieldset>
                <legend><?= __('Edit Transaction Type') ?></legend>
                <?php
                    echo $this->Form->control('transaction_name');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
