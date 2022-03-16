<?php
declare(strict_types=1);

namespace App\Controller;
use CodeItNow\BarcodeBundle\Utils\QrCode;

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
        $this->set('title','List of Transaction Items');

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

        $items = $this->TransactionItems->Items->find('list', [
            'keyField' => 'id',
            'valueField' => 'item_name'
        ]);

        $qrCode = new QrCode();

        $this->set(compact('transactionItem','items'));
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

            $transactionItem->transaction_id = $this->request->getQuery('tid'); //get transaction ID

            $checkqtystat = $this->TransactionItems->Items->find('all', [
                'conditions' => [
                    'Items.id' => $transactionItem->item_id,
                    //$transactionItem->quantity.' >' => 'Items.quantity'
                ]
            ]);
            //->count(); //count row, if true return 1, else 0
            //dd($checkqtystat);

            foreach ($checkqtystat as $res) {
                $item_quantity = $res->quantity; //item id
                if($transactionItem->quantity > $item_quantity){ //check if entered qty is greater than stocks
                            $this->Flash->error(__('Entered Quantity is greater than Item Stocks or Insufficient Item Stocks. Please, try again.'));
                            return $this->redirect(['controller' => 'transactions','action' => 'view/'.$this->request->getQuery('tid')]);//redirect to transaction main
                }
                else{
                    if ($this->TransactionItems->save($transactionItem)) {
                            $this->Flash->success(__('The transaction item has been saved.'));

                            return $this->redirect(['controller' => 'transactions','action' => 'view/'.$this->request->getQuery('tid')]);//redirect to transaction main
                    }
                    $this->Flash->error(__('The transaction item could not be saved. Please, try again.'));
                }
                
            } 
            
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
            //'contain' => [],
            'contain' => ['Transactions', 'Items'],
        ]);

        $this->Authorization->authorize($transactionItem, 'edit');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $transactionItem = $this->TransactionItems->patchEntity($transactionItem, $this->request->getData());

            $checkqtystat = $this->TransactionItems->Items->find('all', [
                'conditions' => [
                    'Items.id' => $transactionItem->item_id,
                    //$transactionItem->quantity.' >' => 'Items.quantity'
                ]
            ]);
            //->count(); //count row, if true return 1, else 0
            //dd($checkqtystat);
            foreach ($checkqtystat as $res) {
                $item_quantity = $res->quantity; //item id
                //dd($item_quantity);
                if($transactionItem->quantity > $item_quantity){ //check if entered qty is greater than stocks
                            $this->Flash->error(__('Entered Quantity is greater than Item Stocks or Insufficient Item Stocks. Please, try again.'));
                            return $this->redirect(['controller' => 'transactions','action' => 'view/'.$this->request->getQuery('tid')]);//redirect to transaction main
                }
                else{
                        if ($this->TransactionItems->save($transactionItem)) {
                            $this->Flash->success(__('The transaction item has been saved.'));

                            //return $this->redirect(['action' => 'index']);
                            return $this->redirect(['controller' => 'transactions','action' => 'view/'.$this->request->getQuery('tid')]);//redirect to transaction main
                        }
                        $this->Flash->error(__('The transaction item could not be saved. Please, try again.'));
                    }

                }
        }

        $transactions = $this->TransactionItems->Transactions->find('list', ['limit' => 200])->all();
        $items = $this->TransactionItems->Items->find('list', ['limit' => 200])->all();
        $itemOption = $this->TransactionItems->Items->find('list', [
            'keyField' => 'id',
            'valueField' => 'item_name'
        ]);
        $this->set(compact('transactionItem', 'transactions', 'items','itemOption'));
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

        //return $this->redirect(['action' => 'index']);
        return $this->redirect(['controller' => 'transactions','action' => 'view/'.$this->request->getQuery('tid')]);//redirect to transaction main
    }
}
