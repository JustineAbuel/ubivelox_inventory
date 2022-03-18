<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transaction $transaction
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $items
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $transaction->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $transaction->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Transactions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="transactions form content">
            <?= $this->Form->create($transaction) ?>
            <fieldset>
                <legend><?= __('Edit Transaction') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('item_id', ['options' => $items]);
                    echo $this->Form->control('transaction_type_id');
                    echo $this->Form->control('company_from');
                    echo $this->Form->control('company_to');
                    echo $this->Form->control('subject');
                    echo $this->Form->control('received_by');
                    echo $this->Form->control('received_date', ['empty' => true]);
                    echo $this->Form->control('status');
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