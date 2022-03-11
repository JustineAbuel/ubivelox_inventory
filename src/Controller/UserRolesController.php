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
        if ($this->request->is('post')) {
            $userRole = $this->UserRoles->patchEntity($userRole, $this->request->getData());
            $http = new Client();
            $response = $http->post('http://localhost:8888/INSERT_USER_ROLES', [           

                'role_name' => $userRole->role_name,
                'added_by' =>  $this->request->getAttribute('identity')->getIdentifier(),

            // $category->date_added = date('Y-m-d H:i:s');
            // $category->added_by =  $this->request->getAttribute('identity')->getIdentifier() ;
            // $category->date_updated = date('Y-m-d H:i:s');
            // $category->updated_by =  $this->request->getAttribute('identity')->getIdentifier() ;
            
            ]); 
            if ($response->getJson()['Status'] == 0) {
                $this->Flash->success(__('The user role has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            // $this->Flash->error(__('The user role could not be saved. Please, try again.'));
            
            $this->Flash->error(__($response->getJson()['Description'])); //get API error
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
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userRole = $this->UserRoles->patchEntity($userRole, $this->request->getData());
            $http = new Client();
            $response = $http->put('http://localhost:8888/UPDATE_USER_ROLES/'.$id, [           

                'role_name' => $userRole->role_name,
                'updated_by' =>  $this->request->getAttribute('identity')->getIdentifier(),

            // $category->date_added = date('Y-m-d H:i:s');
            // $category->added_by =  $this->request->getAttribute('identity')->getIdentifier() ;
            // $category->date_updated = date('Y-m-d H:i:s');
            // $category->updated_by =  $this->request->getAttribute('identity')->getIdentifier() ;
            
            ]); 
            if ($response->getJson()['Status'] == 0) {
                $this->Flash->success(__('The user role has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            // $this->Flash->error(__('The user role could not be saved. Please, try again.'));
            $this->Flash->error(__($response->getJson()['Description'])); //get API error
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
        $response = $http->delete('http://localhost:8888/DELETE_USER_ROLES/'.$id); 
        if ($response->getJson()['Status'] == 0) {
            $this->Flash->success(__('The user role has been deleted.'));
        } else {
            $this->Flash->error(__('The user role could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
