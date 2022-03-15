<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * TransactionItems Controller
 *
 * @property \App\Model\Table\TransactionItemsTable $TransactionItems
 * @method \App\Model\Entity\TransactionItem[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TransactionItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $transactionItem = $this->TransactionItems->newEmptyEntity();

        $this->Authorization->authorize($transactionItem, 'index');

        $this->paginate = [
            'contain' => ['Transactions', 'Items'],
        ];
        $transactionItems = $this->paginate($this->TransactionItems);

        $this->set(compact('transactionItems'));
    }

    /**
     * View method
     *
     * @param string|null $id Transaction Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        $transactionItem = $this->TransactionItems->get($id, [
            'contain' => ['Transactions', 'Items'],
        ]);

        $this->Authorization->authorize($transactionItem, 'view');

        $this->set(compact('transactionItem'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($id=null)
    {
        $transactionItem = $this->TransactionItems->newEmptyEntity();

        $this->Authorization->authorize($transactionItem, 'add');

        if ($this->request->is('post')) {
            $transactionItem = $this->TransactionItems->patchEntity($transactionItem, $this->request->getData());

            $transactionItem->transaction_id = $id; //get transaction ID

            if ($this->TransactionItems->save($transactionItem)) {
                $this->Flash->success(__('The transaction item has been saved.'));

                return $this->redirect(['controller' => 'transactions','action' => 'view/'.$id]);//redirect to transaction main
            }
            $this->Flash->error(__('The transaction item could not be saved. Please, try again.'));
        }

        $transactions = $this->TransactionItems->Transactions->find('list', ['limit' => 200])->all();
        //$items = $this->TransactionItems->Items->find('list', ['limit' => 200])->all();
        $items = $this->TransactionItems->Items->find('list', [
            'keyField' => 'id',
            'valueField' => 'item_name'
        ]);
        $this->set(compact('transactionItem', 'transactions', 'items'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Transaction Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $transactionItem = $this->TransactionItems->get($id, [
            'contain' => [],
        ]);

        $this->Authorization->authorize($transactionItem, 'edit');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $transactionItem = $this->TransactionItems->patchEntity($transactionItem, $this->request->getData());
            if ($this->TransactionItems->save($transactionItem)) {
                $this->Flash->success(__('The transaction item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transaction item could not be saved. Please, try again.'));
        }
        $transactions = $this->TransactionItems->Transactions->find('list', ['limit' => 200])->all();
        $items = $this->TransactionItems->Items->find('list', ['limit' => 200])->all();
        $this->set(compact('transactionItem', 'transactions', 'items'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Transaction Item id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $transactionItem = $this->TransactionItems->get($id);

        $this->Authorization->authorize($transactionItem, 'delete');

        if ($this->TransactionItems->delete($transactionItem)) {
            $this->Flash->success(__('The transaction item has been deleted.'));
        } else {
            $this->Flash->error(__('The transaction item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
