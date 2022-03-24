<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Client;

/**
 * TransactionTypes Controller
 *
 * @property \App\Model\Table\TransactionTypesTable $TransactionTypes
 * @method \App\Model\Entity\TransactionType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TransactionTypeController extends AppController
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
        $transactionType = $this->TransactionType->newEmptyEntity();
        $this->Authorization->authorize($transactionType, 'index');
        $transactionType = $this->paginate($this->TransactionType);

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
        $this->set(compact('transactionType'));
    }

    /**
     * View method
     *
     * @param string|null $id Transaction Type id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $transactionType = $this->TransactionType->get($id, [
            'contain' => ['Transactions'],
        ]);
        $this->Authorization->authorize($transactionType, 'view');

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
        $this->set(compact('transactionType'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $transactionType = $this->TransactionType->newEmptyEntity();
        $this->Authorization->authorize($transactionType, 'add');
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
        if ($this->request->is('post')) {
            $transactionType = $this->TransactionType->patchEntity($transactionType, $this->request->getData());
            /*
            if ($this->TransactionType->save($transactionType)) {
                $this->Flash->success(__('The transaction type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            */
            $http = new Client();
            $response = $http->post(getEnv('INVENTORY_API_URI').'/INSERT_TRANSACTION_TYPE', [   //pointed at local
            // $response = $http->post('https://ubpdev.myubplus.com.ph/api/INSERT_TRANSACTION_TYPE', [  
                'transaction_name' => $transactionType->transaction_name, 
            ]); 
            if ($response->getJson()['Status'] == 0) {
            // if ($this->TransactionType->save($transactionType)) {
                $this->Flash->success(__('The transaction type has been saved.'));

                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully added transaction type ='. $transactionType->transaction_name ,
                    'request' => $this->request, 
                ]);
                return $this->redirect(['action' => 'index']);
            }
            //$this->Flash->error(__('The transaction type could not be saved. Please, try again.'));
            $this->Flash->error(__($response->getJson()['Description'])); //get API error
            
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to add transaction type' ,
                'request' => $this->request, 
            ]); 
        }
        $this->set(compact('transactionType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Transaction Type id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $transactionType = $this->TransactionType->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($transactionType, 'edit');
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $transactionType = $this->TransactionType->patchEntity($transactionType, $this->request->getData());
            /*
            if ($this->TransactionType->save($transactionType)) {
                $this->Flash->success(__('The transaction type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            */
            $http = new Client();
            $response = $http->put(getEnv('INVENTORY_API_URI').'/UPDATE_TRANSACTION_TYPE/'.$id, [     
            // $response = $http->post('https://ubpdev.myubplus.com.ph/api/UPDATE_TRANSACTION_TYPE/'.$id, [  
                'transaction_name' => $transactionType->transaction_name ,               
            ]); 
    
            if ($response->getJson()['Status'] == 0) {
            // if ($this->TransactionType->save($transactionType)) {
                $this->Flash->success(__('The transaction type has been saved.'));
                
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully updated transaction type with id = '. $transactionType->id ,
                    'request' => $this->request, 
                ]);

                return $this->redirect(['action' => 'index']);
            }
            //$this->Flash->error(__('The transaction type could not be saved. Please, try again.'));
            $this->Flash->error(__($response->getJson()['Description'])); //get API error
            
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to update transaction type' ,
                'request' => $this->request, 
            ]);
        }
        $this->set(compact('transactionType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Transaction Type id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $transactionType = $this->TransactionType->get($id);
        $this->Authorization->authorize($transactionType, 'delete');
        /*
        if ($this->TransactionType->delete($transactionType)) {
            $this->Flash->success(__('The transaction type has been deleted.'));
        } else {
            $this->Flash->error(__('The transaction type could not be deleted. Please, try again.'));
        }
        */
        $http = new Client();
        $response = $http->delete(getEnv('INVENTORY_API_URI').'/DELETE_TRANSACTION_TYPE/'.$id);  
        // $response = $http->post('https://ubpdev.myubplus.com.ph/api/DELETE_TRANSACTION_TYPE/'.$id);  
        if ($response->getJson()['Status'] == 0) {
 
            $this->Flash->success(__('The transaction type has been deleted.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Successfully deleted transaction type with id = '. $id ,
                'request' => $this->request, 
            ]);
        }
        else {
            //$this->Flash->error(__('The transaction type could not be deleted. Please, try again.'));
            $this->Flash->error(__($response->getJson()['Description'])); //get API error
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to delete transaction type' ,
                'request' => $this->request, 
            ]);
        }

        return $this->redirect(['action' => 'index']);
    }
}
