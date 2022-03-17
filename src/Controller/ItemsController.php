<?php
declare(strict_types=1);

namespace App\Controller;
use CodeItNow\BarcodeBundle\Utils\QrCode;
use Cake\Http\Client; 
use Cake\I18n\Time;
use Cake\I18n\FrozenTime;
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

        
        $this->set(compact('items', 'users', 'categories', 'stocklevel'));
 
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
            ]
        ];  
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
            $item->added_by = $this->request->getAttribute('identity')->getIdentifier(); 
            // dd($item);
            if ($item = $this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

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
