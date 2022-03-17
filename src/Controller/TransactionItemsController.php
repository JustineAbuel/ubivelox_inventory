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
    public $connection;

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


        $this->set(compact('transactionItem','items','transitem'));
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

                $item_quantity = $res->quantity; //item id/qty

                $total_deducted = $item_quantity - $transactionItem->quantity; //deduction from trans qty to item qty

                if($transactionItem->quantity > $item_quantity){ //check if entered qty is greater than stocks

                            $this->Flash->error(__('Entered Quantity is greater than Item Stocks or Insufficient Item Stocks. Please, try again.'));
                            return $this->redirect(['controller' => 'transactions','action' => 'view?tid='.$this->request->getQuery('tid')]);//redirect to transaction main
                }
                else{
                    if ($this->TransactionItems->save($transactionItem)) {

                        $queryupdate = $this->TransactionItems->Items->query();
                        $queryupdate->update()
                            ->set([
                                'quantity' => $total_deducted])
                            ->where([
                                'id' => $transactionItem->item_id])
                            ->execute();

                            $this->Flash->success(__('The transaction item has been saved.'));

                            return $this->redirect(['controller' => 'transactions','action' => 'view?tid='.$this->request->getQuery('tid')]);//redirect to transaction main
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
                            return $this->redirect(['controller' => 'transactions','action' => 'view?tid='.$this->request->getQuery('tid')]);//redirect to transaction main
                }
                else{
                        if ($this->TransactionItems->save($transactionItem)) {
                            $this->Flash->success(__('The transaction item has been saved.'));

                            //return $this->redirect(['action' => 'index']);
                            return $this->redirect(['controller' => 'transactions','action' => 'view?tid='.$this->request->getQuery('tid')]);//redirect to transaction main
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

        $checkqtystat = $this->TransactionItems->Items->find('all', [
                'conditions' => [
                'Items.id' => $transactionItem->item_id,
                ]
        ]);

        foreach ($checkqtystat as $res) {

                $item_quantity = $res->quantity; //item id/qty

                $total_revert = $item_quantity + $transactionItem->quantity; //revert back from trans qty to item qty

                if ($this->TransactionItems->delete($transactionItem)) {
                    $queryupdate = $this->TransactionItems->Items->query();
                    $queryupdate->update()
                        ->set([
                            'quantity' => $total_revert])
                        ->where([
                            'id' => $transactionItem->item_id])
                        ->execute();

                    $this->Flash->success(__('The transaction item has been deleted.'));
                } else {
                    $this->Flash->error(__('The transaction item could not be deleted. Please, try again.'));
                }
        }

        //return $this->redirect(['action' => 'index']);
        return $this->redirect(['controller' => 'transactions','action' => 'view?tid='.$this->request->getQuery('tid')]);//redirect to transaction main
    }

    public function canceltransaction($id=null){

        $this->Authorization->skipAuthorization(); //skip authorization for user access

        $transactionItems = $this->TransactionItems
        ->find()
        ->select(['id', 'transaction_id','item_id','quantity','internal_warranty','item_name' => 'i.item_name'])
        ->join([
        'table' => 'items',
        'alias' => 'i',
        'type' => 'INNER',
        'conditions' => 'i.id = item_id',
        ])
        ->where(['transaction_id' => $this->request->getQuery('tid')]);

        $setCancelled = $this->TransactionItems->Transactions->query();
        $setCancelled->update()
            ->set([
            'status' => 3, //cancelled status
            'cancelled' => date('Y-m-d H:i:s'),
            'cancelled_by' => $this->request->getAttribute('identity')->getIdentifier()
            ])
            ->where([
            'id' => $this->request->getQuery('tid')
            ])
            ->execute();

        foreach ($transactionItems as $transactionItem){

                $checkqtystat = $this->TransactionItems->Items->find('all', [
                'conditions' => [
                'Items.id' => $transactionItem->item_id,
                //$transactionItem->quantity.' >' => 'Items.quantity'
                    ]
                ]);
                foreach ($checkqtystat as $res) {

                $item_quantity = $res->quantity; //item id/qty

                $total_revert = $item_quantity + $transactionItem->quantity; //revert back from trans qty to item qty

                    $queryupdate = $this->TransactionItems->Items->query();
                    $queryupdate->update()
                        ->set([
                            'quantity' => $total_revert])
                        ->where([
                            'id' => $transactionItem->item_id])
                        ->execute();
            }
        }
        $this->Flash->success(__('The transaction has been cancelled.'));

        $this->set(compact('transactionItems'));

        return $this->redirect(['controller' => 'transactions','action' => 'view?tid='.$this->request->getQuery('tid')]);//redirect to transaction main

    }

    public function printtrans(){
        $this->Authorization->skipAuthorization(); //skip authorization for user access

        $trans = $this->connection->execute("SELECT * FROM transactions WHERE id=".$this->request->getQuery('tid'));
        //->fetchALL("assoc");
        $row_trans = $trans->fetch('assoc');
        $trans_code = $row_trans['transaction_code'];
        $trans_typeid = $row_trans['transaction_type_id'];
        $trans_company_to = $row_trans['company_to'];
        $trans_date_added = $row_trans['date_added'];
        $trans_subject = $row_trans['subject'];
        $trans_received_by = $row_trans['received_by'];
        $trans_sreceived_date = $row_trans['received_date'];

        $transtype = $this->connection->execute("SELECT * FROM transaction_type WHERE id=".$trans_typeid);
        //->fetchALL("assoc");
        $row_trans_type = $transtype->fetch('assoc');
        $trans_type_name = $row_trans_type['transaction_name'];

        $compny = $this->connection->execute("SELECT * FROM company WHERE id=".$trans_company_to);
        //->fetchALL("assoc");
        $row_compny = $compny->fetch('assoc');
        $trans_company_name = $row_compny['company_name'];

        $usr = $this->connection->execute("SELECT * FROM users WHERE id=".$trans_received_by);
        //->fetchALL("assoc");
        $row_usr = $usr->fetch('assoc');
        $trans_fullname = $row_usr['firstname']." ".$row_usr['lastname'];

        $transitems = $this->connection->execute("SELECT * FROM transaction_items WHERE transaction_id=".$this->request->getQuery('tid'))->fetchALL("assoc"); 
        //$this->Flash->set('Here is your data', [ 'element' => 'success']);

        $this->set(compact('trans','transitems','transtype','trans_code','trans_type_name','trans_company_name','trans_typeid','trans_date_added','trans_subject','trans_received_by','trans_sreceived_date','trans_fullname'));
        
    }


}
