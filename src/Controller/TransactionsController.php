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

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);

        $this->set('title','List of Transactions');
        $this->paginate = [
            'contain' => ['Users', 'Company','TransactionType','TransactionStatus'],
            'order' => ['id' => 'desc']
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
        $transaction = $this->Transactions->get($this->request->getQuery('tid'), [
            'contain' => ['Users', 'TransactionType', 'TransactionItems','Company'],
        ]);

        $this->Authorization->authorize($transaction, 'view');

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
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

        $transactionItems = $this->Transactions->TransactionItems
        ->find()
        ->select(['id', 'transaction_id','item_id','quantity','internal_warranty','item_name' => 'i.item_name','serial_no' => 'i.serial_no' ])
        ->join([
        'table' => 'items',
        'alias' => 'i',
        'type' => 'INNER',
        'conditions' => 'i.id = item_id',
        ])
        ->where(['transaction_id' => $this->request->getQuery('tid')]);
        //->group('i.serial_no'); //item serial no
        $counttransitemrec = $transactionItems->count(); //count requested transaction items
        //->order(['id' => 'DESC']);
        //dd($transactionItems);

        $totalQuantity = $this->Transactions->TransactionItems
        ->find()
        ->select(['id', 'transaction_id','item_id','quantity','total' => ('SUM(quantity)') ])
        ->where(['transaction_id' => $this->request->getQuery('tid')])
        ->group('transaction_id');
        //dd($totalQuantity);

        //$this->set(compact('transaction'));
        $this->set(compact('transaction', 'users','transactionType','transactionStatus','company','qrCode','transactionItems','totalQuantity','counttransitemrec'));
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

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
        if ($this->request->is('post')) {
            $transaction = $this->Transactions->patchEntity($transaction, $this->request->getData());

            $transaction->transaction_code = $this->Transactions->generate_transcode(); //call function from TransactionsTable Model to generate unique code
            $transaction->user_id = $this->request->getAttribute('identity')->getIdentifier();
            $transaction->added_by = $this->request->getAttribute('identity')->getIdentifier(); 

            if ($this->Transactions->save($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully added transaction = '. $transaction->transaction ,
                    'request' => $this->request, 
                ]);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The transaction could not be saved. Please, try again.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to add an transaction' ,
                'request' => $this->request, 
            ]);
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
        $transaction = $this->Transactions->get($this->request->getQuery('tid'), [
            'contain' => [],
        ]);

        $this->Authorization->authorize($transaction, 'edit');

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $transaction = $this->Transactions->patchEntity($transaction, $this->request->getData());

            $queryupdateOutgoing = $this->Transactions->Outgoing->query();
            $queryupdateOutgoing->update()
            ->set([
                    'status' => $transaction->status])
            ->where([
                    'transaction_id' => $this->request->getQuery('tid')])
            ->execute();

            if ($this->Transactions->save($transaction)) {
                $this->Flash->success(__('The transaction has been saved.'));

                //return $this->redirect(['action' => 'index']);
                return $this->redirect(['controller' => 'transactions','action' => 'view?tid='.$this->request->getQuery('tid')]);//redirect to transaction main
                
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully updated transaction with id = '. $transaction->id ,
                    'request' => $this->request, 
                ]);
            }
            $this->Flash->error(__('The transaction could not be saved. Please, try again.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to update transaction' ,
                'request' => $this->request, 
            ]);
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
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Successfully deleted transaction with id = '. $id ,
                'request' => $this->request, 
            ]);
        } else {
            $this->Flash->error(__('The transaction could not be deleted. Please, try again.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to delete transaction' ,
                'request' => $this->request, 
            ]);
        }

        //return $this->redirect(['action' => 'index']);
        return $this->redirect(['controller' => 'transactions','action' => 'view?tid='.$this->request->getQuery('tid')]);//redirect to transaction main
    }
}
