<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TransactionStatus $transactionStatus
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Transaction Status'), ['action' => 'edit', $transactionStatus->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Transaction Status'), ['action' => 'delete', $transactionStatus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transactionStatus->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Transaction Status'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Transaction Status'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="transactionStatus view content">
            <h3><?= h($transactionStatus->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Status Name') ?></th>
                    <td><?= h($transactionStatus->status_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($transactionStatus->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Added By') ?></th>
                    <td><?= $this->Number->format($transactionStatus->added_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated By') ?></th>
                    <td><?= $this->Number->format($transactionStatus->updated_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Added') ?></th>
                    <td><?= h($transactionStatus->date_added) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Updated') ?></th>
                    <td><?= h($transactionStatus->date_updated) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
