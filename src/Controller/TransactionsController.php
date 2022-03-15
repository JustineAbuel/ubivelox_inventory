<?php
declare(strict_types=1);

namespace App\Controller;
use CodeItNow\BarcodeBundle\Utils\QrCode;

/**
 * Transactions Controller
 *
 * @property \App\Model\Table\TransactionsTable $Transactions
 * @method \App\Model\Entity\Transaction[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TransactionsController extends AppController
{
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
            'contain' => ['Users', 'Company','TransactionType','TransactionStatus'],
        ];
        $transactions = $this->paginate($this->Transactions);

        $qrCode = new QrCode();

        $this->set(compact('transactions','qrCode'));
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
            'contain' => ['Users', 'TransactionType', 'TransactionItems','Company'],
        ]);

        $this->Authorization->authorize($transaction, 'view');

        //$users = $this->Transactions->Users->find('list', ['limit' => 200])->all();
        $users = $this->Transactions->Users->find('list', [
            'keyField' => 'id',
            'valueField' => 'firstname'
        ]);
        //$TransactionType = $this->Transactions->TransactionType->find('list', ['limit' => 200])->all();
        $transactionType = $this->Transactions->TransactionType->find('list', [
            'keyField' => 'id',
            'valueField' => 'transaction_name'
        ]);
        $transactionStatus = $this->Transactions->TransactionStatus->find('list', [
            'keyField' => 'id',
            'valueField' => 'status_name'
        ]);
        $company = $this->Transactions->Company->find('list', [
            'keyField' => 'id',
            'valueField' => 'company_name'
        ]);

        $qrCode = new QrCode();

        //$this->set(compact('transaction'));
        $this->set(compact('transaction', 'users','transactionType','transactionStatus','company','qrCode'));
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

            $transaction->transaction_code = $this->Transactions->generate_transcode(); //call function from TransactionsTable Model to generate unique code
            $transaction->user_id = $this->request->getAttribute('identity')->getIdentifier();
            $transaction->added_by = $this->request->getAttribute('identity')->getIdentifier(); 

            if ($this->Transactions->save($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transaction could not be saved. Please, try again.'));
        }
        //$users = $this->Transactions->Users->find('list', ['limit' => 200])->all();
        $users = $this->Transactions->Users->find('list', [
            'keyField' => 'id',
            'valueField' => 'firstname'
        ]);
        //$TransactionType = $this->Transactions->TransactionType->find('list', ['limit' => 200])->all();
        $transactionType = $this->Transactions->TransactionType->find('list', [
            'keyField' => 'id',
            'valueField' => 'transaction_name'
        ]);
        $transactionStatus = $this->Transactions->TransactionStatus->find('list', [
            'keyField' => 'id',
            'valueField' => 'status_name'
        ]);
        $company = $this->Transactions->Company->find('list', [
            'keyField' => 'id',
            'valueField' => 'company_name'
        ]);
        //$this->set(compact('transaction', 'users', 'TransactionType'));
        $this->set(compact('transaction', 'users','transactionType','transactionStatus','company'));
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

            if ($this->Transactions->save($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transaction could not be saved. Please, try again.'));
        }
        //$users = $this->Transactions->Users->find('list', ['limit' => 200])->all();
        $users = $this->Transactions->Users->find('list', [
            'keyField' => 'id',
            'valueField' => 'firstname'
        ]);
        //$TransactionType = $this->Transactions->TransactionType->find('list', ['limit' => 200])->all();
        $transactionType = $this->Transactions->TransactionType->find('list', [
            'keyField' => 'id',
            'valueField' => 'transaction_name'
        ]);
        $transactionStatus = $this->Transactions->TransactionStatus->find('list', [
            'keyField' => 'id',
            'valueField' => 'status_name'
        ]);
        $company = $this->Transactions->Company->find('list', [
            'keyField' => 'id',
            'valueField' => 'company_name'
        ]);
        //$this->set(compact('transaction', 'users', 'TransactionType'));
        $this->set(compact('transaction', 'users','transactionType','transactionStatus','company'));
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
        
        if ($this->Transactions->delete($transaction)) {
            $this->Flash->success(__('The transaction has been deleted.'));
        } else {
            $this->Flash->error(__('The transaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
