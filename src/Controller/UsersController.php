<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Client;
use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['login', 'add']); 
    }

    public function initialize(): void
    {
        parent::initialize();
        // $this->Authorization->skipAuthorization();
 
        // $this->Authorization->mapActions([
        //     'index' => 'list',
        //     'delete' => 'remove',
        //     'add' => 'insert',
        //     'view' => 'view',
        // ]);
    }

    public function login()
    {
        $this->Authorization->skipAuthorization();
        $this->viewBuilder()->setLayout('authlayout'); 
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) { 
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Items',
                'action' => 'index',
            ]);
    
            return $this->redirect($redirect);
        }

        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid username or password'));
        }
    }
        
    public function logout()
    { 
        $this->Authorization->skipAuthorization();
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    } 
    protected function hashPassword(string $password) : ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
    }
    public function changePassword($id = null)
    {
        $this->Authorization->skipAuthorization();
        
        $user = $id ? $this->Users->get($id) : $this->request->getAttribute('identity')->getOriginalData();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData()); 
            $requestData = $this->request->getData();
            // dd(password_hash($requestData['currentpassword'], PASSWORD_BCRYPT));
            // dd($this->hashPassword($requestData['currentpassword']));

            $http = new Client();
            $response = $http->post('http://localhost:8888/CHANGE_PASSWORD/'.$user->id, [           

            
                'id' => $user->id,
                'currentpassword' => $this->hashPassword($requestData['currentpassword']),
                'newpassword' => $requestData['newpassword'],
                'retypepassword' => $requestData['retypepassword'],

            // $category->date_added = date('Y-m-d H:i:s');
            // $category->added_by =  $this->request->getAttribute('identity')->getIdentifier() ;
            // $category->date_updated = date('Y-m-d H:i:s');
            // $category->updated_by =  $this->request->getAttribute('identity')->getIdentifier() ;
            
            ]); 
            if ($response->getJson()['Status'] == 0) {
            // if ($this->Categories->save($category)) {
                $this->Flash->success(__('Password changed successfully'));

                return $this->redirect(['action' => 'index']);
            } 
            $this->Flash->error(__($response->getJson()['Description']));
            // $this->Flash->error(__('The password could not be saved. Please, try again.'));
        } 
        $this->set(compact('user'));
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    { 
        // $this->Authorization->authorizeModel();
        // $this->Authorization->skipAuthorization();
        // $loggedInUserId = $this->request->getAttribute('identity')->id;
        // $user = $this->Users->get($loggedInUserId);
        //logged in user
        $loggedinuser = $this->Authentication->getIdentity()->getOriginalData(); 
        $this->Authorization->authorize($loggedinuser, 'index');
        
        $this->paginate = [
            'contain' => ['UserRoles'],
        ]; 
        $users = $this->paginate($this->Users);
         

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        // $loggedinuser = $this->Authentication->getIdentity()->getOriginalData(); 
        // $this->Authorization->authorize($loggedinuser, 'view');
        
        $user = $this->Users->get($id, [
            'contain' => ['UserRoles'],
        ]);
        $this->Authorization->authorize($user, 'view');

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        
        $user = $this->Users->newEmptyEntity();
        $this->Authorization->authorize($user, 'add');

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData()); 
 
            $user->date_added = date('Y-m-d H:i:s');
            $user->date_updated = date('Y-m-d H:i:s');
            $user->added_by =  $this->request->getAttribute('identity')->getIdentifier() ;
            $user->updated_by =  $this->request->getAttribute('identity')->getIdentifier() ; 
            
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $userRole = $this->Users->UserRoles->find('list', ['limit' => 200])->all();
        $this->set(compact('user', 'userRole'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
         
        $user = $this->Users->get($id, [
            'contain' => [],
        ]); 
        $this->Authorization->authorize($user, 'edit');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $userRole = $this->Users->UserRoles->find('list', ['limit' => 200])->all();
        $this->set(compact('user', 'userRole'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        
        $this->Authorization->authorize($user, 'delete'); 


        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
