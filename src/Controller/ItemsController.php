<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\I18n\Time;
use Cake\Http\Client; 
use Cake\I18n\FrozenTime;
use Cake\Collection\Collection;
use CodeItNow\BarcodeBundle\Utils\QrCode;
/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */ 
    public function initialize(): void
    {
        parent::initialize();
 
        $this->loadModel('Users');
        $this->loadModel('Categories');  
        $this->loadModel('Subcategories');  
        $this->loadModel('ItemType');  
        $this->loadModel('Company'); 
        $this->loadModel('Incoming'); 
        $this->loadModel('Outgoing');  

        // $this->Authorization->skipAuthorization();
        
    }

    
    public function dashboard(){ 
        $this->Authorization->skipAuthorization();
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
		$this->viewBuilder()->setLayout('dashboard');
        $items = $this->Items->find()->count();
        $users = $this->Users->find()->count();
        $categories = $this->Categories->find()->count();

        
        $stocklevel = $this->Items->find()
                    ->where([
                        'quantity <=' => 100
                    ])
                    ->count(); 


        $month = date('Y-m'); 
        $condition = [ 
                'date_added >' => date('Y-m-01 00:00:00'), 
                'date_added <=' => date('Y-m-t 23:59:59') 
        ];
        $query = $this->Items->Incoming->find()->where($condition);
        $incoming = $query->select([
            'month' => $query->func()->month([
                'Incoming.date_added' => 'identifier'
            ]),
            'day' => $query->func()->day([
                'Incoming.date_added' => 'identifier'
            ]),
            'totalQuantity' => $query->func()->sum('Incoming.quantity')
        ])->group(['day'])->all();
        // dd($incoming);
 

        $addedThisMonth = $this->Items->find('all')->where(['date_added >' => date('Y-m-01 00:00:00'), 'date_added <' => date('Y-m-t 23:59:59') ])->count();
        // dd($items);
        $returnedItems = $this->Outgoing->find()->where(['OR' => [ 'status IS' => 5, 'status' => 4]])->count();
        $returnedWithoutDamage = $this->Outgoing->find()->where([ 'status IS' => 5])->count();
        $damagedItem = $this->Outgoing->find()->where([ 'status IS' => 4])->count();

        // dd($damagedItem);

        $query = $this->Items->Outgoing->query();
        $outgoing = $query->select([
            'month' => $query->func()->month([
                'Outgoing.date_added' => 'identifier'
            ]),
            'day' => $query->func()->day([
                'Outgoing.date_added' => 'identifier'
            ]),
            'totalQuantity' => $query->func()->sum('Outgoing.quantity')
        ])
            // ->join([
            //     'table' => 'transaction_items',
            //     'alias' => 'TransactionItems',
            //     'type' => 'INNER',
            //     'conditions' => 'TransactionItems.transaction_id = Outgoing.transaction_id',
            //     ])
        ->group(['day'])->all();
        // dd($outgoing);
 
        // $outgoing = $this->Items->Outgoing; 
        // $query = $outgoing->find()
        //     ->select([
        //         'id',
        //         'transaction_id',
        //         'item_id',
        //         'month' => $query->func()->month([
        //             'Outgoing.date_added' => 'identifier'
        //         ]),
        //         'day' => $query->func()->day([
        //             'Outgoing.date_added' => 'identifier'
        //         ]),
        //         'totalQuantity' => $query->func()->sum('TransactionItems.quantity'),
        //     ])
        //     // // ->select($outgoing->TransactionItems)
        //     // ->select($outgoing->Transactions)
        //     ->contain(['TransactionItems'])
        //     // ->where(['Outgoing.transaction_id = TransactionItems.transaction_id'])
            
        //     ->group([ 'day'])->all();
        //     dd($query); 
         
        $this->set(compact('items', 'users', 'categories', 'stocklevel', 'incoming', 'outgoing', 'addedThisMonth', 'returnedItems', 'returnedWithoutDamage','damagedItem'));
 
    }


    public function index()
    {   
        $item = $this->Items->newEmptyEntity(); 
        $this->Authorization->authorize($item, 'index');
        
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
         
        $this->paginate = [
            'contain' => ['Categories', 'Company', 'ItemType', 'Subcategories'],
            'conditions' => [
                'trashed IS ' => NULL 
            ], 
            'order' => ['id' => 'DESC']
        ];   
        $items = $this->paginate($this->Items);   
        $qrCode = new QrCode();

		$this->set('title','List of Items');
		$this->set(compact('items', 'qrCode'));
    }

    /**
     * View method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    { 
        

        $item = $this->Items->get($id, [
            // 'contain' => ['Categories', 'Suppliers', 'ItemTypes', 'Transactions'],
            'contain' => ['Categories', 'Company', 'ItemType' ],
        ]);

        $this->Authorization->authorize($item, 'view');

        $this->Common->dblogger([ 
            'message' => 'Viewed Item with id = '. $this->request->getParam('pass')[0],
            'request' => $this->request, 
        ]);
        
        $this->set(compact('item'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    { 
        $item = $this->Items->newEmptyEntity(); 
        $this->Authorization->authorize($item, 'add');

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
        
        if ($this->request->is('post')) {
            $item = $this->Items->patchEntity($item, $this->request->getData()); 
            $identity = $this->request->getAttribute('identity')->getIdentifier(); 
            $item->added_by = $identity;
            // dd($item);
            if ($item = $this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                $incomingTable = $this->Items->Incoming;
                $incoming = $incomingTable->newEmptyEntity();  

                $incoming->item_id = $item->id;
                $incoming->quantity = $this->request->getData('quantity');
                $incoming->added_by = $identity;
                $incoming->date_added = date('Y-m-d H:i:s');
                $incomingTable->save($incoming);

                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully added item with id = '. $item->item_name ,
                    'request' => $this->request, 
                ]);
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.')); 
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to add an item' ,
                'request' => $this->request, 
            ]);
        } 
        $quality =  ['BRAND NEW', 'SECOND HAND']; 
        // $categories = $this->Categories->find('list', ['contain' => ['Subcategories']])->all();  
        $categories = $this->Categories->find('list')->innerJoinWith('Subcategories')->all();
        $subcategories = $this->Items->Subcategories->find('list')->all(); 
        $company = $this->Items->Company->find('list', ['limit' => 200])->all();
        $itemTypes = $this->Items->ItemType->find('list', ['limit' => 200])->all();  

        $this->set(compact('item', 'categories','subcategories', 'company', 'itemTypes', 'quality'));
 
    }

    public function addStocksQuantity(){
        $this->Authorization->skipAuthorization();
          
        if($this->request->is('ajax')){
            $this->layout = 'ajax'; 
            // $item = $this->Items->find('all')->where(['id' => $this->request->getData('item_id')])->first();
            $item = $this->Items->get($this->request->getData('item_id'));
            $quantity = $this->request->getData('quantity');
            $identity = $this->request->getAttribute('identity')->getIdentifier(); 
            $item = $this->Items->patchEntity($item, 
                [ 'quantity' => $item->quantity += $quantity ]); 

            if ($this->Items->save($item)) {
                $this->Flash->success(__('Stocks added for '.$item->item_name)); 
                
                $incomingTable = $this->Items->Incoming;
                $incoming = $incomingTable->newEmptyEntity();  

                $incoming->item_id = $item->id;
                $incoming->quantity = $quantity;
                $incoming->added_by = $identity;
                $incoming->date_added = date('Y-m-d H:i:s');
                $incomingTable->save($incoming);

                $msg = 1;
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully added stocks for item with id = '. $item->id ,
                    'request' => $this->request, 
                ]);
            }else{
                $msg = 2;
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Could not add stocks for item with id = '. $item->id ,
                    'request' => $this->request, 
                ]);
                $this->Flash->error(__('Could not add stocks')); 
            }

            $response = $this->response->withType('application/json')
                ->withStringBody(json_encode(['data' => $item, 'msg' => $msg]));
            return $response; 
        }
         
    }

    public function getsubcategories(){ 
        $this->Authorization->skipAuthorization();
          
        if($this->request->is('ajax')){
            $this->layout = 'ajax'; 
            $subcategories = $this->Items->Subcategories->find('all')->where(['category_id' => $this->request->getData('category_id')])->all(); 
            $option = '';
            foreach($subcategories as $subcategory){
                $option .= '<option value='.$subcategory->id.'>'.$subcategory->subcategory_name.'</option>';
            }
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'subcategories' => $option
                    // 'subcategories' => $subcategories
                ])); 
        }
    }
    /**
     * Edit method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $item = $this->Items->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($item, 'edit'); 
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $item = $this->Items->patchEntity($item, $this->request->getData()); 
                
            $item->updated_by = $this->request->getAttribute('identity')->getIdentifier();
            $this->Items->touch($item, 'Items.updated');
            // $item->date_added = date('Y-m-d H:i:s');
                // dd($item);
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully updated an item with id = '. $item->id ,
                    'request' => $this->request, 
                ]);
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.')); 
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to update item' ,
                'request' => $this->request, 
            ]);
             
        }
        
        
        $quality =  ['BRAND NEW', 'SECOND HAND']; 
        $categories = $this->Categories->find('list')->innerJoinWith('Subcategories')->all();
        $subcategories = $this->Items->Subcategories->find('list')->all(); 
        $company = $this->Items->Company->find('list', ['limit' => 200])->all();
        $itemTypes = $this->Items->ItemType->find('list', ['limit' => 200])->all(); 
        $this->set(compact('item', 'categories', 'company', 'itemTypes', 'subcategories', 'quality'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {  
        
        $this->request->allowMethod(['put', 'post', 'delete']);
        $item = $this->Items->get($id);
        $this->Authorization->authorize($item, 'delete');
         
        $item->trashed = date('Y-m-d H:i:s'); 

        if ($this->Items->save($item)) {
            $this->Flash->success(__('The item has been deleted.'));
            
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Successfully deleted item with id = '. $id ,
                'request' => $this->request, 
            ]);
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.')); 
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to delete item' ,
                'request' => $this->request, 
            ]);
        }

        return $this->redirect(['action' => 'index']);
    }


}
