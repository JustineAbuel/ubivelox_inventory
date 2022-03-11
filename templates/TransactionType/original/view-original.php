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
            <?= $this->Html->link(__('Edit Transaction Type'), ['action' => 'edit', $transactionType->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Transaction Type'), ['action' => 'delete', $transactionType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transactionType->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Transaction Type'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Transaction Type'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="transactionType view content">
            <h3><?= h($transactionType->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Transaction Name') ?></th>
                    <td><?= h($transactionType->transaction_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($transactionType->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Transactions') ?></h4>
                <?php if (!empty($transactionType->transactions)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Item Id') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Transaction Type Id') ?></th>
                            <th><?= __('Company From') ?></th>
                            <th><?= __('Company To') ?></th>
                            <th><?= __('Subject') ?></th>
                            <th><?= __('Received By') ?></th>
                            <th><?= __('Received Date') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Date Added') ?></th>
                            <th><?= __('Added By') ?></th>
                            <th><?= __('Date Updated') ?></th>
                            <th><?= __('Updated By') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($transactionType->transactions as $transactions) : ?>
                        <tr>
                            <td><?= h($transactions->id) ?></td>
                            <td><?= h($transactions->user_id) ?></td>
                            <td><?= h($transactions->item_id) ?></td>
                            <td><?= h($transactions->quantity) ?></td>
                            <td><?= h($transactions->transaction_type_id) ?></td>
                            <td><?= h($transactions->company_from) ?></td>
                            <td><?= h($transactions->company_to) ?></td>
                            <td><?= h($transactions->subject) ?></td>
                            <td><?= h($transactions->received_by) ?></td>
                            <td><?= h($transactions->received_date) ?></td>
                            <td><?= h($transactions->status) ?></td>
                            <td><?= h($transactions->date_added) ?></td>
                            <td><?= h($transactions->added_by) ?></td>
                            <td><?= h($transactions->date_updated) ?></td>
                            <td><?= h($transactions->updated_by) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Transactions', 'action' => 'view', $transactions->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Transactions', 'action' => 'edit', $transactions->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Transactions', 'action' => 'delete', $transactions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transactions->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
