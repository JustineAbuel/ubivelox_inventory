<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Client;

/**
 * Company Controller
 *
 * @property \App\Model\Table\CompanyTable $Company
 * @method \App\Model\Entity\Company[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CompanyController extends AppController
{

    public function initialize() : void
    {
        parent::initialize();
 
        // $this->Authorization->skipAuthorization(); //skip authorization for user access

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        
        $company = $this->Company->newEmptyEntity();
        $this->Authorization->authorize($company, 'index' );
        $company = $this->paginate($this->Company);

        $this->set(compact('company'));
    }

    /**
     * View method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $company = $this->Company->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($company, 'view' );

        $this->set(compact('company'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $company = $this->Company->newEmptyEntity();
        $this->Authorization->authorize($company, 'add' );

        if ($this->request->is('post')) {
            $company = $this->Company->patchEntity($company, $this->request->getData());
            //$company->date_added = date('Y-m-d H:i:s');
            //$company->added_by =  $this->request->getAttribute('identity')->getIdentifier();
            /*
            if ($this->Company->save($company)) {
                $this->Flash->success(__('The company has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            */
            $http = new Client();
            $response = $http->post('http://localhost:8888/INSERT_COMPANY', [   //pointed at local
            // $response = $http->post('https://ubpdev.myubplus.com.ph/api/INSERT_COMPANY', [  
                'company_name' => $company->company_name, 
                'address' => $company->address,
                'contactno' => $company->contactno, 
                'added_by' =>  $this->request->getAttribute('identity')->getIdentifier(),
                'company_type' => $company->company_type,
            ]); 
            if ($response->getJson()['Status'] == 0) {
            // if ($this->Company->save($company)) {
                $this->Flash->success(__('The company has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            //$this->Flash->error(__('The company could not be saved. Please, try again.'));
            $this->Flash->error(__($response->getJson()['Description'])); //get API error
        }
        $this->set(compact('company'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $company = $this->Company->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($company, 'edit' );
        if ($this->request->is(['patch', 'post', 'put'])) {
            $company = $this->Company->patchEntity($company, $this->request->getData());
            //$company->date_updated = date('Y-m-d H:i:s');
            //$company->updated_by =  $this->request->getAttribute('identity')->getIdentifier();
            /*if ($this->Company->save($company)) {
                $this->Flash->success(__('The company has been saved.'));

                return $this->redirect(['action' => 'index']);
            }*/
            $http = new Client();
            $response = $http->put('http://localhost:8888/UPDATE_COMPANY/'.$id, [     
            // $response = $http->post('https://ubpdev.myubplus.com.ph/api/UPDATE_COMPANY/'.$id, [  
                'company_name' => $company->company_name ,
                'address' => $company->address ,
                'contactno' => $company->contactno,
                'updated_by' => $this->request->getAttribute('identity')->getIdentifier() ,
                'company_type' => $company->company_type,
                
            ]); 
    
            if ($response->getJson()['Status'] == 0) {
            // if ($this->Categories->save($company)) {
                $this->Flash->success(__('The category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            //$this->Flash->error(__('The company could not be saved. Please, try again.'));
            $this->Flash->error(__($response->getJson()['Description'])); //get API error
        }
        $this->set(compact('company'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $company = $this->Company->get($id);
        $this->Authorization->authorize($company, 'delete' );

        $http = new Client();
        $response = $http->delete('http://localhost:8888/DELETE_COMPANY/'.$id);  
        // $response = $http->post('https://ubpdev.myubplus.com.ph/api/DELETE_COMPANY/'.$id);  
        if ($response->getJson()['Status'] == 0) {

        // if ($this->Company->delete($category)) {
            $this->Flash->success(__('The company has been deleted.'));
        }
        else {
            //$this->Flash->error(__('The company could not be deleted. Please, try again.'));
            $this->Flash->error(__($response->getJson()['Description'])); //get API error
        }

        return $this->redirect(['action' => 'index']);
    }
}
