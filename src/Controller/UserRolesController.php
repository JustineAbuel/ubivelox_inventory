<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Client;

/**
 * UserRoles Controller
 *
 * @property \App\Model\Table\UserRolesTable $UserRoles
 * @method \App\Model\Entity\UserRole[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserRolesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    
 

    public function initialize(): void
    {
        parent::initialize();
 
        $this->loadModel('Menus'); 
        $this->loadModel('UserAccess'); 
        // $this->Authorization->skipAuthorization();

    }

    public function access()
    { 
        $userRoles =  $this->paginate($this->UserRoles);
        $menus =  $this->paginate($this->Menus); 
        $userAccess = $this->UserAccess->newEmptyEntity();

        if ($this->request->is('post')) {
            $userRole = $this->UserAccess->patchEntity($userAccess, $this->request->getData());
            if ($this->UserRoles->save($userRole)) {
                $this->Flash->success(__('The user access has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user access could not be saved. Please, try again.'));
        }
        $this->set(compact('userRoles', 'menus', 'userAccess'));
    }

     
    
    public function index()
    {
        
        $userRoles = $this->UserRoles->newEmptyEntity(); 
        $this->Authorization->authorize($userRoles, 'index');

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);

        $userRoles = $this->paginate($this->UserRoles);

        $this->set(compact('userRoles'));
    }

    /**
     * View method
     *
     * @param string|null $id User Role id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userRole = $this->UserRoles->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($userRole, 'view');

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
        $this->set(compact('userRole'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userRole = $this->UserRoles->newEmptyEntity();
        $this->Authorization->authorize($userRole, 'add');
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
        if ($this->request->is('post')) {
            $userRole = $this->UserRoles->patchEntity($userRole, $this->request->getData());
            $http = new Client();
            $response = $http->post(getEnv('INVENTORY_API_URI').'/INSERT_USER_ROLES', [           

                'role_name' => $userRole->role_name,
                'added_by' =>  $this->request->getAttribute('identity')->getIdentifier(),
 
            ]); 
            if ($response->getJson()['Status'] == 0) {
                $this->Flash->success(__('The user role has been saved.'));
                
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully added user role = '. $userRole->role_name ,
                    'request' => $this->request, 
                ]);

                return $this->redirect(['action' => 'index']);
            }
            // $this->Flash->error(__('The user role could not be saved. Please, try again.'));
            
            $this->Flash->error(__($response->getJson()['Description'])); //get API error
            
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to add an user role' ,
                'request' => $this->request, 
            ]);
        }
        $this->set(compact('userRole'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User Role id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userRole = $this->UserRoles->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($userRole, 'edit');
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userRole = $this->UserRoles->patchEntity($userRole, $this->request->getData());
            $http = new Client();
            $response = $http->put(getEnv('INVENTORY_API_URI').'/UPDATE_USER_ROLES/'.$id, [           

                'role_name' => $userRole->role_name,
                'updated_by' =>  $this->request->getAttribute('identity')->getIdentifier(),
 
            ]); 
            if ($response->getJson()['Status'] == 0) {
                $this->Flash->success(__('The user role has been saved.'));

                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully updated user role with id = '. $userRole->id ,
                    'request' => $this->request, 
                ]);

                return $this->redirect(['action' => 'index']);
            }
            // $this->Flash->error(__('The user role could not be saved. Please, try again.'));
            $this->Flash->error(__($response->getJson()['Description'])); //get API error
            
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to update user role' ,
                'request' => $this->request, 
            ]);
        }
        $this->set(compact('userRole'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User Role id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userRole = $this->UserRoles->get($id);
        $this->Authorization->authorize($userRole, 'delete');
        $http = new Client();
        $response = $http->delete(getEnv('INVENTORY_API_URI').'/DELETE_USER_ROLES/'.$id); 
        if ($response->getJson()['Status'] == 0) {
            $this->Flash->success(__('The user role has been deleted.'));
            
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Successfully deleted user role with id = '. $id ,
                'request' => $this->request, 
            ]);
        } else {
            $this->Flash->error(__('The user role could not be deleted. Please, try again.'));
            
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to delete user role' ,
                'request' => $this->request, 
            ]);
        }

        return $this->redirect(['action' => 'index']);
    }
}
