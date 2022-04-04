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
    
    public function downloadcategoriesform(){
        $this->Authorization->skipAuthorization();  
        $file_path = WWW_ROOT.'forms'.DS.'UBP_MASS_CATEGORY_FORM.csv'; 
        $response = $this->response->withFile(
              $file_path,
            ['download' => true, 'name' =>'UBP_MASS_CATEGORY_FORM.csv']
        );
        return $response;
    }

    public function index()
    {
        // $loggedinuser = $this->Authentication->getIdentity()->getOriginalData(); 
        // $this->Authorization->authorize($loggedinuser, 'index'); 
        
        $category = $this->Categories->newEmptyEntity();
        $this->Authorization->authorize($category, 'index');
        
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);

        $identity = $this->request->getAttribute('identity')->getIdentifier(); 
        if(isset($_POST["submit"])){
        
            $filename=$_FILES["file"]["tmp_name"];

            if($_FILES["file"]["size"] > 0){
    
                $file = fopen($filename, "r");
                $num = 0;
                $counter = 0;
                while ($data = fgetcsv($file)){
                    if($num == 0){ //skip header names in CSV file
                        $num++;
                    } 
                    else{  
                        $category = $this->Categories->newEmptyEntity();  
                        $category = $this->Categories->patchEntity($category, $this->request->getData()); 

                        $category->category_name = $data[0];
                        $category->category_description = $data[1]; 
                        $category->date_added = date('Y-m-d H:i:s'); 
                        $category->added_by = $identity; 

                        $category = $this->Categories->save($category);
                        $this->Common->dblogger([
                            //change depending on action
                            'message' => 'Mass upload[Category] - Successfully added category with id = '. $category->category_name ,
                            'request' => $this->request, 
                        ]);

                        $counter++;
                    }
                }
                    if($counter > 0) {
                        $this->Flash->success(__('Category CSV has been uploaded. {0} category saved.', $counter));
                        return $this->redirect(['controller' => 'Categories','action' => 'index']);//redirect to company main
                    } else{
                        $this->Flash->error(__('Company Category data could not be saved. Please, try again.'));
                    }

                fclose($file);
            }
        }

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
       
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);

        $category = $this->Categories->get($id, [
            'contain' => ['Items'],
        ]);
        $this->Authorization->authorize($category, 'view');

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

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);

        if ($this->request->is('post')) {
            $category = $this->Categories->patchEntity($category, $this->request->getData()); 
 
            
            $http = new Client();
            $response = $http->post(getEnv('INVENTORY_API_URI').'/INSERT_CATEGORIES', [           

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
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully added category ='. $category->category_name ,
                    'request' => $this->request, 
                ]);

                return $this->redirect(['action' => 'index']);
            }
            // $this->Flash->error(__('The category could not be saved. Please, try again.'));
            $this->Flash->error(__($response->getJson()['Description']));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to add an category' ,
                'request' => $this->request, 
            ]);
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
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $category = $this->Categories->patchEntity($category, $this->request->getData());

            $http = new Client();
            $response = $http->put(getEnv('INVENTORY_API_URI').'/UPDATE_CATEGORIES/'.$id, [     
 
                'id' => $id,
                'category_name' => $category->category_name ,
                'category_description' => $category->category_description ,
                'updated_by' => $this->request->getAttribute('identity')->getIdentifier() ,
                
            ]); 
    
            if ($response->getJson()['Status'] == 0) {
            // if ($this->Categories->save($category)) {
                $this->Flash->success(__('The category has been saved.'));
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully updated category with id = '. $category->id ,
                    'request' => $this->request, 
                ]);

                return $this->redirect(['action' => 'index']);
            }
            // $this->Flash->error(__('The category could not be saved. Please, try again.'));
            $this->Flash->error(__($response->getJson()['Description'])); //get API error
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to update category' ,
                'request' => $this->request, 
            ]);
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

        // $http = new Client();
        // $response = $http->delete(getEnv('INVENTORY_API_URI').'/DELETE_CATEGORIES/'.$id);  
        
        // if ($response->getJson()['Status'] == 0) {

        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Successfully deleted category with id = '. $id ,
                'request' => $this->request, 
            ]);
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
            
            // $this->Flash->error(__($response->getJson()['Description'])); //get API error
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to delete category' ,
                'request' => $this->request, 
            ]);
        }

        return $this->redirect(['action' => 'index']);
    }
}
