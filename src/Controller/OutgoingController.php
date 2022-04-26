<?php
declare(strict_types=1);

namespace App\Controller;
use CodeItNow\BarcodeBundle\Utils\QrCode;

/**
 * Outgoing Controller
 *
 * @property \App\Model\Table\OutgoingTable $Outgoing
 * @method \App\Model\Entity\Outgoing[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OutgoingController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization(); //skip authorization for user access

        $this->set('title','List of Outgoing Items');
        /*
        $this->paginate = [
            'contain' => ['Transactions', 'Items'],
        ];
        $outgoing = $this->paginate($this->Outgoing);
        */
         $this->paginate = [
            'contain' => ['Transactions','TransactionItems' ,'Items']
        ];

        $outgoing = $this->Outgoing->find()
        ->select(['id','transaction_id','item_id','status','notes','date_added',
            'item_name' => 'i.item_name',
            'serial_no' => 'i.serial_no',
            'image' => 'i.image',
            'itemid' => 'i.id',
            'transaction_code' => 't.transaction_code' ])
        ->join([
        'table' => 'transactions',
        'alias' => 't',
        'type' => 'INNER',
        'conditions' => 't.id = transaction_id',
        ])
        ->join([
        'table' => 'items',
        'alias' => 'i',
        'type' => 'INNER',
        'conditions' => 'i.id = item_id',
        ])
        ->where([
        'OR' => [
                ['Outgoing.status' => 4],  //4=display all for repair,
                ['Outgoing.status' => 5],  //5=repaired,
                ['Outgoing.status' => 6],  //6=for disposal, and
                ['Outgoing.status' => 2]], //2=delivered items only
        ])
        ->order(['Outgoing.id' => 'desc']);

        $qrCode = new QrCode();

        $this->set(compact('outgoing'));
    }

    /**
     * View method
     *
     * @param string|null $id Outgoing id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->Authorization->skipAuthorization(); //skip authorization for user access

        $outgoing = $this->Outgoing->get($id, [
            'contain' => ['Transactions', 'Items'],
        ]);

        $items = $this->Outgoing->TransactionItems->Items->find('list',[
            'keyField' => 'id',
            'valueField' => 'item_name'
        ]);

        $itemStatus = $this->Outgoing->TransactionStatus->find('list', [
            'keyField' => 'id',
            'valueField' => 'status_name'
        ]); 

        $this->set(compact('outgoing', 'items','itemStatus'));

        //$this->set(compact('outgoing'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->Authorization->skipAuthorization(); //skip authorization for user access

        $outgoing = $this->Outgoing->newEmptyEntity();
        if ($this->request->is('post')) {
            $outgoing = $this->Outgoing->patchEntity($outgoing, $this->request->getData());

            $transItemRec = $this->Outgoing->TransactionItems
            ->find()
            ->where([
            'AND' => [['transaction_id' => $outgoing->transaction_id],['item_id' => $outgoing->item_id]], 
            ]);

            foreach ($transItemRec as $key => $value) {
                //dd($value->quantity); //quantity from transaction items
                $outgoing->quantity = $value->quantity; //insert transaction item quantity
            }

            $outgoing->added_by = $this->request->getAttribute('identity')->getIdentifier(); //session user id

            $outgoingRec = $this->Outgoing->find('list')
            ->where([
            'AND' => [['transaction_id' => $outgoing->transaction_id],['item_id' => $outgoing->item_id]], 
            ])
            ->count(); //count row, if true return 1, else 0

            //dd($outgoingRec);

            if($outgoingRec > 0){ //check if selected transaction item already exist!
                $this->Flash->error(__('Selected Transaction Item already exist, Please try again!'));
                return $this->redirect(['action' => 'add']); //redirect to add again
            }
            else{

                if ($this->Outgoing->save($outgoing)) {

                    $this->Flash->success(__('The outgoing has been saved.'));

                    $this->Common->dblogger([
                        //change depending on action
                        'message' => 'Accessed Outgoing Transactions>'.$this->request->getParam('controller').'>'.$this->request->getParam('action').">Transaction>".$outgoing->transaction_id.">Item>".$outgoing->item_id,
                        'request' => $this->request, 
                    ]);

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The outgoing could not be saved. Please, try again.'));
                $this->Common->dblogger([
                //change depending on action
                'message' => 'The outgoing could not be saved. Please, try again.' ,
                'request' => $this->request, 
                'status' => 'error',
                ]);
            }
        }
        //$transactions = $this->Outgoing->Transactions->find('list', ['limit' => 200])->all();
        //$items = $this->Outgoing->Items->find('list', ['limit' => 200])->all();

        $transactions = $this->Outgoing->Transactions->find('list',[
            'keyField' => 'id',
            'valueField' => 'transaction_code'
        ])
        ->where(['status' => 2]) //display all 2=DELIVERED items only
        ->innerJoinWith('TransactionItems')->all();
        $items = $this->Outgoing->TransactionItems->Items->find('list',[
            'keyField' => 'id',
            'valueField' => 'item_name'
        ])
        ->all(); 

        $this->set(compact('outgoing', 'transactions', 'items'));
    }

    public function getItems(){ 
        $this->Authorization->skipAuthorization();
          
        if($this->request->is('ajax')){
            $this->layout = 'ajax'; 
            $items = $this->Outgoing->TransactionItems->find('all')
            ->select(['item_id','transaction_id','item_name' => 'Items.item_name'])
            ->innerJoinWith('Items')
            ->where(['transaction_id' => $this->request->getData('transaction_id')])
            ->all(); 
            $option = '';
            foreach($items as $item){
                $option .= '<option value='.$item->item_id.'>'.$item->item_name.'</option>';
            }
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'items' => $option
                    // 'items' => $items
                ])); 
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Outgoing id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->Authorization->skipAuthorization(); //skip authorization for user access

        $outgoing = $this->Outgoing->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $outgoing = $this->Outgoing->patchEntity($outgoing, $this->request->getData());

            $outgoing->updated_by = $this->request->getAttribute('identity')->getIdentifier(); //session user id
            $outgoing->date_updated = date('Y-m-d H:i:s');

            if ($this->Outgoing->save($outgoing)) {
                $this->Flash->success(__('The outgoing has been saved.'));
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully updated outgoing = '. $outgoing->id ,
                    'request' => $this->request, 
                ]);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The outgoing could not be saved. Please, try again.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'The outgoing could not be saved. Please, try again.' ,
                'request' => $this->request, 
                'status' => 'error',
            ]);
        }
        //$transactions = $this->Outgoing->Transactions->find('list', ['limit' => 200])->all();
        //$items = $this->Outgoing->Items->find('list', ['limit' => 200])->all();

        $transactions = $this->Outgoing->Transactions->find('list',[
            'keyField' => 'id',
            'valueField' => 'transaction_code'
        ])
        ->where(['status' => 2]) //display all 2=DELIVERED items only
        ->innerJoinWith('TransactionItems')->all();
        $items = $this->Outgoing->TransactionItems->Items->find('list',[
            'keyField' => 'id',
            'valueField' => 'item_name'
        ])
        ->all(); 

        $this->set(compact('outgoing', 'transactions', 'items'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Outgoing id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->Authorization->skipAuthorization(); //skip authorization for user access
        
        $this->request->allowMethod(['post', 'delete']);
        $outgoing = $this->Outgoing->get($id);
        if ($this->Outgoing->delete($outgoing)) {
            $this->Flash->success(__('The outgoing has been deleted.'));
        } else {
            $this->Flash->error(__('The outgoing could not be deleted. Please, try again.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'The outgoing could not be deleted. Please, try again.' ,
                'request' => $this->request, 
                'status' => 'error',
            ]);
        }

        return $this->redirect(['action' => 'index']);
    }
}
