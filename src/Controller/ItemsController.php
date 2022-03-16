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
  
        $loggedinuser = $this->Authentication->getIdentity()->getOriginalData(); 
        $item = $this->Items->newEmptyEntity(); 
        $this->Authorization->authorize($item, 'index');
        
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
        
        if ($this->request->is('post')) {
            $item = $this->Items->patchEntity($item, $this->request->getData()); 
            $item->added_by = $this->request->getAttribute('identity')->getIdentifier(); 
            // dd($item);
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.')); 
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
            $this->log('You are here', 'debug'); 
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
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $item = $this->Items->patchEntity($item, $this->request->getData()); 
                
            $item->updated_by = $this->request->getAttribute('identity')->getIdentifier();
            $this->Items->touch($item, 'Items.updated');
            // $item->date_added = date('Y-m-d H:i:s');
                // dd($item);
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.')); 
             
        }
        
        
        $quality =  ['BRAND NEW', 'SECOND HAND'];
        $categories = $this->Items->Categories->find('list', ['contains' => ['Subcategories']])->all(); 
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
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.')); 
        }

        return $this->redirect(['action' => 'index']);
    }


}
