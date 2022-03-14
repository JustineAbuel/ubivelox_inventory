<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transaction $transaction
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Transaction'), ['action' => 'edit', $transaction->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Transaction'), ['action' => 'delete', $transaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transaction->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Transactions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Transaction'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="transactions view content">
            <h3><?= h($transaction->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $transaction->has('user') ? $this->Html->link($transaction->user->id, ['controller' => 'Users', 'action' => 'view', $transaction->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Transaction Code') ?></th>
                    <td><?= h($transaction->transaction_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subject') ?></th>
                    <td><?= h($transaction->subject) ?></td>
                </tr>
                <tr>
                    <th><?= __('Received By') ?></th>
                    <td><?= h($transaction->received_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($transaction->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Transaction Type Id') ?></th>
                    <td><?= $this->Number->format($transaction->transaction_type_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company From') ?></th>
                    <td><?= $this->Number->format($transaction->company_from) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company To') ?></th>
                    <td><?= $this->Number->format($transaction->company_to) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($transaction->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Added By') ?></th>
                    <td><?= $this->Number->format($transaction->added_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cancelled By') ?></th>
                    <td><?= $this->Number->format($transaction->cancelled_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Received Date') ?></th>
                    <td><?= h($transaction->received_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Added') ?></th>
                    <td><?= h($transaction->date_added) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cancelled') ?></th>
                    <td><?= h($transaction->cancelled) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Transaction Items') ?></h4>
                <?php if (!empty($transaction->transaction_items)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Transaction Id') ?></th>
                            <th><?= __('Item Id') ?></th>
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Internal Warranty') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($transaction->transaction_items as $transactionItems) : ?>
                        <tr>
                            <td><?= h($transactionItems->id) ?></td>
                            <td><?= h($transactionItems->transaction_id) ?></td>
                            <td><?= h($transactionItems->item_id) ?></td>
                            <td><?= h($transactionItems->quantity) ?></td>
                            <td><?= h($transactionItems->internal_warranty) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'TransactionItems', 'action' => 'view', $transactionItems->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'TransactionItems', 'action' => 'edit', $transactionItems->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'TransactionItems', 'action' => 'delete', $transactionItems->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transactionItems->id)]) ?>
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
