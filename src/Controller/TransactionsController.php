<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Client;
use Cake\I18n\Time;
use Cake\I18n\FrozenTime;

/**
 * Transactions Controller
 *
 * @property \App\Model\Table\TransactionsTable $Transactions
 * @method \App\Model\Entity\Transaction[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TransactionsController extends AppController
{
    public function initialize() : void
    {
        parent::initialize();
 
        // $this->Authorization->skipAuthorization(); //skip authorization for user access

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $transaction = $this->Transactions->newEmptyEntity();
        $this->Authorization->authorize($transaction, 'index');
        $this->set('title','List of Transactions');
        $this->paginate = [
            'contain' => ['Users', 'Items', 'Company','TransactionType','TransactionStatus'],
        ];

        $transactions = $this->paginate($this->Transactions);

        $this->set(compact('transactions'));
    }

    /**
     * View method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $transaction = $this->Transactions->get($id, [
            'contain' => ['Users', 'Items'],
        ]);
        $this->Authorization->authorize($transaction, 'view');

        $this->set(compact('transaction'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $transaction = $this->Transactions->newEmptyEntity();
        $this->Authorization->authorize($transaction, 'add');
        if ($this->request->is('post')) {
            $transaction = $this->Transactions->patchEntity($transaction, $this->request->getData());
            /*if ($this->Transactions->save($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            */
            //dd($transaction); //debug function/debug($var); exit;
            $http = new Client();
            $response = $http->post('http://localhost:8888/INSERT_TRANSACTIONS', [   //pointed at local
            // $response = $http->post('https://ubpdev.myubplus.com.ph/api/INSERT_TRANSACTIONS', [  
                'user_id' => $this->request->getAttribute('identity')->getIdentifier(),
                'item_id' => $transaction->item_id,
                'quantity' => $transaction->quantity,
                'transaction_type_id' => $transaction->transaction_type_id, 
                'company_from' => $transaction->company_from, 
                'company_to' => $transaction->company_to, 
                'subject' => $transaction->subject, 
                'status' => $transaction->status, 
                'added_by' => $this->request->getAttribute('identity')->getIdentifier()
            ]); 
            if ($response->getJson()['Status'] == 0) {
            // if ($this->Company->save($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            //$this->Flash->error(__('The transaction could not be saved. Please, try again.'));
            $this->Flash->error(__($response->getJson()['Description'])); //get API error
        }
        //$users = $this->Transactions->Users->find('list', ['limit' => 200])->all();
        $users = $this->Transactions->Users->find('list', [
            'keyField' => 'id',
            'valueField' => 'firstname'
        ]);
        //$items = $this->Transactions->Items->find('list', ['limit' => 200])->all();
        $items = $this->Transactions->Items->find('list', [
            'keyField' => 'id',
            'valueField' => 'item_name'
        ]);
        //$transactionType = $this->Transactions->TransactionType->find('list', ['limit' => 200])->all();
        $transactionType = $this->Transactions->TransactionType->find('list', [
            'keyField' => 'id',
            'valueField' => 'transaction_name'
        ]);
        //$transactionStatus = $this->Transactions->TransactionStatus->find('list', ['limit' => 200])->all();
        $transactionStatus = $this->Transactions->TransactionStatus->find('list', [
            'keyField' => 'id',
            'valueField' => 'status_name'
        ]);

        //$company = $this->Transactions->Company->find('list', ['limit' => 200])->all();
        $company = $this->Transactions->Company->find('list', [
            'keyField' => 'id',
            'valueField' => 'company_name'
        ]);
        $this->set(compact('transaction', 'users', 'items','transactionType','transactionStatus','company'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $transaction = $this->Transactions->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($transaction, 'edit');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $transaction = $this->Transactions->patchEntity($transaction, $this->request->getData());
            /*
            if ($this->Transactions->save($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            */
            //dd($transaction); //debug function/debug($var); exit;
            $http = new Client();
            $received_datetime = $time = new FrozenTime($transaction->received_date);
            $response = $http->put('http://localhost:8888/UPDATE_TRANSACTIONS/'.$id, [   //pointed at local
            // $response = $http->post('https://ubpdev.myubplus.com.ph/api/UPDATE_TRANSACTIONS', [  
                'user_id' => $this->request->getAttribute('identity')->getIdentifier(),
                'item_id' => $transaction->item_id,
                'quantity' => $transaction->quantity,
                'transaction_type_id' => $transaction->transaction_type_id, 
                'company_from' => $transaction->company_from, 
                'company_to' => $transaction->company_to, 
                'subject' => $transaction->subject, 
                'status' => $transaction->status, 
                'received_by' => $transaction->received_by,
                'received_date' => $received_datetime->format('Y-m-d H:i:s'),
                'updated_by' => $this->request->getAttribute('identity')->getIdentifier()
            ]); 
            if ($response->getJson()['Status'] == 0) {
            // if ($this->Company->save($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            //$this->Flash->error(__('The transaction could not be saved. Please, try again.'));
             $this->Flash->error(__($response->getJson()['Description'])); //get API error
        }
        //$users = $this->Transactions->Users->find('list', ['limit' => 200])->all();
        $users = $this->Transactions->Users->find('list', [
            'keyField' => 'id',
            'valueField' => 'firstname'
        ]);
        //$items = $this->Transactions->Items->find('list', ['limit' => 200])->all();
        $items = $this->Transactions->Items->find('list', [
            'keyField' => 'id',
            'valueField' => 'item_name'
        ]);
        //$transactionType = $this->Transactions->TransactionType->find('list', ['limit' => 200])->all();
        $transactionType = $this->Transactions->TransactionType->find('list', [
            'keyField' => 'id',
            'valueField' => 'transaction_name'
        ]);
        //$transactionStatus = $this->Transactions->TransactionStatus->find('list', ['limit' => 200])->all();
        $transactionStatus = $this->Transactions->TransactionStatus->find('list', [
            'keyField' => 'id',
            'valueField' => 'status_name'
        ]);

        //$company = $this->Transactions->Company->find('list', ['limit' => 200])->all();
        $company = $this->Transactions->Company->find('list', [
            'keyField' => 'id',
            'valueField' => 'company_name'
        ]);
        $this->set(compact('transaction', 'users', 'items','transactionType','transactionStatus','company'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Transaction id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $transaction = $this->Transactions->get($id);
        $this->Authorization->authorize($transaction, 'delete');

        /*
        if ($this->Transactions->delete($transaction)) {
            $this->Flash->success(__('The transaction has been deleted.'));
        } else {
            $this->Flash->error(__('The transaction could not be deleted. Please, try again.'));
        }
        */
        $http = new Client();
        $response = $http->delete('http://localhost:8888/DELETE_TRANSACTIONS/'.$id);  
        // $response = $http->post('https://ubpdev.myubplus.com.ph/api/UPDATE_TRANSACTIONS/'.$id);
        
        if ($response->getJson()['Status'] == 0) {

        //if ($this->Categories->delete($category)) {
            $this->Flash->success(__('The transaction has been deleted.'));
        } else {
            //$this->Flash->error(__('The transaction could not be deleted. Please, try again.'));
            $this->Flash->error(__($response->getJson()['Description'])); //get API error
        }

    
    }
}
