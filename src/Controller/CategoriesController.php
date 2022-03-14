<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Http\Exception\InternalErrorException;
use Cake\Http\Client;

/**
 * Categories Controller
 *
 * @property \App\Model\Table\CategoriesTable $Categories
 * @method \App\Model\Entity\Category[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CategoriesController extends AppController
{
    
    public function initialize(): void
    {
        parent::initialize(); 
         
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // $loggedinuser = $this->Authentication->getIdentity()->getOriginalData(); 
        // $this->Authorization->authorize($loggedinuser, 'index'); 
        
        $category = $this->Categories->newEmptyEntity();
        $this->Authorization->authorize($category, 'index');

        $this->set('title','List of Categories');
        $categories = $this->paginate($this->Categories);

        $this->set(compact('categories'));
    }

    /**
     * View method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $loggedinuser = $this->Authentication->getIdentity()->getOriginalData(); 
        $this->Authorization->authorize($loggedinuser, 'view');

        $category = $this->Categories->get($id, [
            'contain' => ['Items'],
        ]);

        $this->set(compact('category'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    { 

        $category = $this->Categories->newEmptyEntity();
        
        $this->Authorization->authorize($category, 'add' );

        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->getData()); 
 
            
            $http = new Client();
            $response = $http->post('http://localhost:8888/INSERT_CATEGORIES', [           

                'category_name' => $category->category_name ,
                'category_description' => $category->category_description ,
                'added_by' => $this->request->getAttribute('identity')->getIdentifier() ,

            // $category->date_added = date('Y-m-d H:i:s');
            // $category->added_by =  $this->request->getAttribute('identity')->getIdentifier() ;
            // $category->date_updated = date('Y-m-d H:i:s');
            // $category->updated_by =  $this->request->getAttribute('identity')->getIdentifier() ;
            
            ]); 
            if ($response->getJson()['Status'] == 0) {
            // if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            // $this->Flash->error(__('The category could not be saved. Please, try again.'));
            $this->Flash->error(__($response->getJson()['Description']));
            
        }
        $this->set(compact('category'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    { 

        $category = $this->Categories->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($category, 'edit' );
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());

            $http = new Client();
            $response = $http->put('UPDATE_CATEGORIES/'.$id, [     
 
                'id' => $id,
                'category_name' => $category->category_name ,
                'category_description' => $category->category_description ,
                'updated_by' => $this->request->getAttribute('identity')->getIdentifier() ,
                
            ]); 
    
            if ($response->getJson()['Status'] == 0) {
            // if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            // $this->Flash->error(__('The category could not be saved. Please, try again.'));
            $this->Flash->error(__($response->getJson()['Description'])); //get API error
        }
        $this->set(compact('category'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
         

        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        $this->Authorization->authorize($category, 'delete' );

        $http = new Client();
        $response = $http->delete('http://localhost:8888/DELETE_CATEGORIES/'.$id);  
        
        if ($response->getJson()['Status'] == 0) {

        // if ($this->Categories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            // $this->Flash->error(__('The category could not be deleted. Please, try again.'));
            
            $this->Flash->error(__($response->getJson()['Description'])); //get API error
        }

        return $this->redirect(['action' => 'index']);
    }
}
