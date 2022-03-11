<?php
declare(strict_types=1);

namespace App\Controller;
use CodeItNow\BarcodeBundle\Utils\QrCode;
use Cake\Http\Client;

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
        $this->loadModel('ItemType');  
        $this->loadModel('Company');  

        // $this->Authorization->skipAuthorization();
        
    }

    
    public function dashboard(){
        // $loggedinuser = $this->Authentication->getIdentity()->getOriginalData(); 
        // $this->Authorization->authorize($loggedinuser, 'index');
        $this->Authorization->skipAuthorization();

		$this->viewBuilder()->setLayout('dashboard');
        $items = $this->Items->find()->count();
        $users = $this->Users->find()->count();
        $categories = $this->Categories->find()->count();

        
        $stocklevel = $this->Items->find()
                    ->where([
                        'quantity <=' => 100
                    ])
                    ->count(); 

        
        $this->set(compact('items', 'users', 'categories', 'stocklevel'));
 
    }


    public function index()
    {
 
        // $this->Authorization->skipAuthorization();
        // $loggedinuser = $this->Authentication->getIdentity()->getOriginalData(); 
        $loggedinuser = $this->Authentication->getIdentity()->getOriginalData(); 
        $item = $this->Items->newEmptyEntity(); 
        $this->Authorization->authorize($item, 'index');
        
        $this->paginate = [
            'contain' => ['Categories'],
            'conditions' => [
                'trashed IS ' => NULL 
            ]
        ]; 
        // $items = $this->paginate($this->Items); 
        // $this->Authorization->applyScope($query);
        $items = $this->paginate($this->Items);  
        // dd($items);
         
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
        // $loggedinuser = $this->Authentication->getIdentity()->getOriginalData(); 
        // $this->Authorization->authorize($loggedinuser, 'view');

        $item = $this->Items->get($id, [
            // 'contain' => ['Categories', 'Suppliers', 'ItemTypes', 'Transactions'],
            'contain' => ['Categories' ],
        ]);

        $this->Authorization->authorize($item, 'view');

        $this->set(compact('item'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        
        // $loggedinuser = $this->Authentication->getIdentity()->getOriginalData(); 
        // $this->Authorization->authorize($loggedinuser, 'add');

        $item = $this->Items->newEmptyEntity(); 
        $this->Authorization->authorize($item, 'add');
        // $this->Authorization->authorize($item);

        if ($this->request->is('post')) {
            $item = $this->Items->patchEntity($item, $this->request->getData());
            $http = new Client();
            $response = $http->post('http://localhost:8888/INSERT_ITEMS', [             //pointed at local
            // $response = $http->post('https://ubpdev.myubplus.com.ph/api/REGISTER_ITEM', [   

                'category_id' => $item->category_id, 
                'item_name' => $item->item_name, 
                'serial_no' => $item->serial_no, 
                'item_description' => $item->item_description, 
                'issued_date' => $item->issued_date, 
                'warranty' => $item->warranty, 
                'quantity' => $item->quantity, 
                'supplier_id' => 1, 
                'item_type_id' => 1, 
                'quality' => $item->quality, 
                'remarks' => $item->remarks, 
                'part_no' => $item->part_no, 
                'operating_system' => $item->operating_system, 
                'kernel' => $item->kernel, 
                'header_type' => $item->header_type, 
                'firmware' => $item->firmware, 
                'features' => $item->features, 
                'added_by' =>  $this->request->getAttribute('identity')->getIdentifier()


            ]); 
            if ($response->getJson()['Status'] == 0) {
            // if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            // $this->Flash->error(__('The item could not be saved. Please, try again.'));
            $this->Flash->error(__($response->getJson()['Description'])); //get API error
        }
        $categories = $this->Items->Categories->find('list')->all(); 
        $company = $this->Items->Company->find('list', ['limit' => 200])->all();
        $itemTypes = $this->Items->ItemType->find('list', ['limit' => 200])->all(); 
        $this->set(compact('item', 'categories', 'company', 'itemTypes'));
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
        
        // $loggedinuser = $this->Authentication->getIdentity()->getOriginalData(); 
        // $this->Authorization->authorize($loggedinuser, 'edit');
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $item = $this->Items->patchEntity($item, $this->request->getData()); 
                
            $http = new Client();
            $response = $http->put('http://localhost:8888/UPDATE_ITEMS/'.$id, [             //pointed at local
            // $response = $http->post('https://ubpdev.myubplus.com.ph/api/REGISTER_ITEM', [   

                'id' => $id,
                'category_id' => $item->category_id, 
                'item_name' => $item->item_name, 
                'serial_no' => $item->serial_no, 
                'item_description' => $item->item_description, 
                'issued_date' => $item->issued_date, 
                'warranty' => $item->warranty, 
                'quantity' => $item->quantity, 
                'supplier_id' => 1, 
                'item_type_id' => 1, 
                'quality' => $item->quality, 
                'remarks' => $item->remarks, 
                'part_no' => $item->part_no, 
                'operating_system' => $item->operating_system, 
                'kernel' => $item->kernel, 
                'header_type' => $item->header_type, 
                'firmware' => $item->firmware, 
                'features' => $item->features, 
                'updated_by' =>  $this->request->getAttribute('identity')->getIdentifier()

            ]); 

            if ($response->getJson()['Status'] == 0) {

                // if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            // $this->Flash->error(__('The item could not be saved. Please, try again.'));
            $this->Flash->error(__($response->getJson()['Description'])); //get API error
             
        }
        
        
        $categories = $this->Items->Categories->find('list')->all(); 
        $company = $this->Items->Company->find('list', ['limit' => 200])->all();
        $itemTypes = $this->Items->ItemType->find('list', ['limit' => 200])->all(); 
        $this->set(compact('item', 'categories', 'company', 'itemTypes'));
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


        $this->request->allowMethod(['post', 'delete']);
        $item = $this->Items->get($id);
        $this->Authorization->authorize($item, 'add');
        
        $http = new Client();
        $response = $http->delete('http://localhost:8888/DELETE_ITEMS/'.$id);  
        
        if ($response->getJson()['Status'] == 0) {


        // if ($this->Items->delete($item)) {
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            // $this->Flash->error(__('The item could not be deleted. Please, try again.'));
            $this->Flash->error(__($response->getJson()['Description'])); //get API error
        }

        return $this->redirect(['action' => 'index']);
    }


}
