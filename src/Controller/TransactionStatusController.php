<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Client;

/**
 * TransactionStatus Controller
 *
 * @property \App\Model\Table\TransactionStatusTable $TransactionStatus
 * @method \App\Model\Entity\TransactionStatus[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TransactionStatusController extends AppController
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
        $transactionStatus = $this->TransactionStatus->newEmptyEntity();
        $this->Authorization->authorize($transactionStatus, 'index');
        $transactionStatus = $this->paginate($this->TransactionStatus);
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);

        $this->set(compact('transactionStatus'));
    }

    /**
     * View method
     *
     * @param string|null $id Transaction Status id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $transactionStatus = $this->TransactionStatus->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($transactionStatus, 'view');
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);

        $this->set(compact('transactionStatus'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $transactionStatus = $this->TransactionStatus->newEmptyEntity();
        $this->Authorization->authorize($transactionStatus, 'add');
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
        if ($this->request->is('post')) {
            $transactionStatus = $this->TransactionStatus->patchEntity($transactionStatus, $this->request->getData());
            /*
            if ($this->TransactionStatus->save($transactionStatus)) {
                $this->Flash->success(__('The transaction status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            */
            $http = new Client();
            $response = $http->post(getEnv('INVENTORY_API_URI').'/INSERT_TRANSACTION_STATUS', [   //pointed at local
            // $response = $http->post('https://ubpdev.myubplus.com.ph/api/INSERT_TRANSACTION_STATUS', [  
                'status_name' => $transactionStatus->status_name, 
                'added_by' => $this->request->getAttribute('identity')->getIdentifier()  
            ]); 
            if ($response->getJson()['Status'] == 0) {
            // if ($this->TransactionType->save($transactionStatus)) {
                $this->Flash->success(__('The transaction status has been saved.'));
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully added transaction status ='. $transactionStatus->status_name ,
                    'request' => $this->request, 
                ]);

                return $this->redirect(['action' => 'index']);
            }
            //$this->Flash->error(__('The transaction status could not be saved. Please, try again.'));
            $this->Flash->error(__($response->getJson()['Description'])); //get API error
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to add transaction status' ,
                'request' => $this->request, 
            ]); 
        }
        $this->set(compact('transactionStatus'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Transaction Status id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $transactionStatus = $this->TransactionStatus->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($transactionStatus, 'edit');
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $transactionStatus = $this->TransactionStatus->patchEntity($transactionStatus, $this->request->getData());
            /*
            if ($this->TransactionStatus->save($transactionStatus)) {
                $this->Flash->success(__('The transaction status has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            */
            $http = new Client();
            $response = $http->put(getEnv('INVENTORY_API_URI').'/UPDATE_TRANSACTION_STATUS/'.$id, [     
            // $response = $http->post('https://ubpdev.myubplus.com.ph/api/UPDATE_TRANSACTION_STATUS/'.$id, [  
                'status_name' => $transactionStatus->status_name,   
                'updated_by' => $this->request->getAttribute('identity')->getIdentifier()            
            ]); 
    
            if ($response->getJson()['Status'] == 0) {
            // if ($this->TransactionType->save($transactionStatus)) {
                $this->Flash->success(__('The transaction type has been saved.'));
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully updated transaction status with id = '. $transactionStatus->id ,
                    'request' => $this->request, 
                ]);

                return $this->redirect(['action' => 'index']);
            }
            //$this->Flash->error(__('The transaction status could not be saved. Please, try again.'));
            $this->Flash->error(__($response->getJson()['Description'])); //get API error
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to update transaction status' ,
                'request' => $this->request, 
            ]);
        }
        $this->set(compact('transactionStatus'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Transaction Status id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $transactionStatus = $this->TransactionStatus->get($id);
        $this->Authorization->authorize($transactionStatus, 'delete');
        /*
        if ($this->TransactionStatus->delete($transactionStatus)) {
            $this->Flash->success(__('The transaction status has been deleted.'));
        } else {
            $this->Flash->error(__('The transaction status could not be deleted. Please, try again.'));
        }
        */
        $http = new Client();
        $response = $http->delete(getEnv('INVENTORY_API_URI').'/DELETE_TRANSACTION_STATUS/'.$id);  
        // $response = $http->post('https://ubpdev.myubplus.com.ph/api/DELETE_TRANSACTION_STATUS/'.$id);  
        if ($response->getJson()['Status'] == 0) {
 
            $this->Flash->success(__('The transaction status has been deleted.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Successfully deleted transaction status with id = '. $id ,
                'request' => $this->request, 
            ]);
        }
        else {
            //$this->Flash->error(__('The transaction status could not be deleted. Please, try again.'));
            $this->Flash->error(__($response->getJson()['Description'])); //get API error
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to delete transaction status' ,
                'request' => $this->request, 
            ]);
        }

        return $this->redirect(['action' => 'index']);
    }
}
