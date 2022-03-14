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

        $this->set(compact('transactionItem'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $transactionItem = $this->TransactionItems->newEmptyEntity();
        if ($this->request->is('post')) {
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
        if ($this->TransactionItems->delete($transactionItem)) {
            $this->Flash->success(__('The transaction item has been deleted.'));
        } else {
            $this->Flash->error(__('The transaction item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
