<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Client;
use Cake\I18n\FrozenTime;
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
        
        

        $setid = $this->Authentication->getIdentity()->getIdentifier(); 
        if($id){
            $loggedinuser = $this->Authentication->getIdentity()->getOriginalData(); 
            $this->Authorization->authorize($loggedinuser, 'changePassword');
            $setid = $id;
        }


        $user =  $this->Users->get($setid); 

       
        if ($this->request->is(['patch', 'post', 'put'])) {
            $requestData = $this->request->getData();   
            if(password_verify($requestData['currentpassword'], $user->password)){ 
                if($requestData['newpassword'] === $requestData['retypepassword']){
                    
                    $user = $this->Users->patchEntity($user, ['password' => $this->request->getData('newpassword')]);  
                    if ($this->Users->save($user)) {
                        $this->Flash->success(__('Password changed successfully'));
        
                        return $this->redirect(['action' => 'index']);
                    }  
                    $this->Flash->error(__('The password could not be saved. Please, try again.'));
                }else{
                    $this->Flash->error(__('New and retype password does not match. Please, try again'));
                }

            }else{ 
                $this->Flash->error(__('Incorrect password'));
            } 
        } 
        $this->set(compact('user'));
    }
    public function profile()
    {
         
        $this->Authorization->skipAuthorization();
        
        // $user = $this->Users->get($id, [
        //     'contain' => [],
        // ]); 
        $user = $this->Users->get($this->Authentication->getIdentity()->getIdentifier() );
        $this->Authorization->authorize($user, 'edit');
 
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());  
            // debug($image);
            // dd($imageName); 
            $image = $this->request->getData('image_file');
            $fileName = $image->getClientFilename(); 
            // dd($image);
            $user->image = $fileName;
            if ($this->Users->save($user)) {

                if (!$user->getErrors()) {
                    // never trust anything in `$image` if you haven't properly validated it!!!
                    
    
                    if(!is_dir(WWW_ROOT.'img/uploads/profilepicture'.DS.$user->id))
                    mkdir(WWW_ROOT.'img/uploads/profilepicture'.DS.$user->id);
    
                    if($fileName){
                        $image->moveTo(WWW_ROOT . 'img/uploads/profilepicture'. DS .$user->id.'/'. DS . $fileName);
                    
                    }
                }

                $this->Flash->success(__('The user has been saved.'));
                $this->Authentication->setIdentity($user);
                // dd($request->getAttribute('identity'));
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully updated user profile with id = '. $user->id ,
                    'request' => $this->request, 
                ]);

                return $this->redirect(['action' => 'profile']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to update profile' ,
                'request' => $this->request, 
            ]);
        }
        $userRole = $this->Users->UserRoles->find('list', ['limit' => 200])->all();
        $this->set(compact('user', 'userRole'));
    }
    public function resetPassword()
    {
           
        $user = $this->Users->get($this->Authentication->getIdentity()->getIdentifier() );
        $this->Authorization->authorize($user, 'edit');
 
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData() );
            $user->password = 'qwerty123';
            
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user\'s password has been reset to default password.'));
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully updated user profile picture with id = '. $user->id ,
                    'request' => $this->request, 
                ]);
                $this->Authentication->setIdentity($user);
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Could not reset password. Please, try again.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to update profile' ,
                'request' => $this->request, 
            ]);
        }
        // $userRole = $this->Users->UserRoles->find('list', ['limit' => 200])->all();
        // $this->set(compact('user', 'userRole'));
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {  
        //logged in user
        $loggedinuser = $this->Authentication->getIdentity()->getOriginalData(); 
        $this->Authorization->authorize($loggedinuser, 'index');
        
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
        $this->paginate = [
            'contain' => ['UserRoles'],
            'order' => ['id' => 'DESC'],
            
            'conditions' => [
                'trashed IS ' => NULL 
            ], 
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

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
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

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData()); 
 
            $user->date_added = date('Y-m-d H:i:s');
            // $user->date_updated = date('Y-m-d H:i:s');
            $user->added_by =  $this->request->getAttribute('identity')->getIdentifier() ;
            $user->password = 'qwerty123'; 
 
            // $http = new Client();
            // $response = $http->post(getEnv('INVENTORY_API_URI').'/INSERT_USERS', [           

            
            //     'username' => $user->username, 
            //     'email' => $user->email, 
            //     'firstname' => $user->firstname,
            //     'middlename' => $user->middlename,
            //     'lastname' => $user->lastname,
            //     'contactno' => $user->contactno,
            //     'added_by' => $this->request->getAttribute('identity')->getIdentifier(),
            //     'role_id' => $user->role_id,
            //     'password_expiration' => date('Y-m-d'),
            //     'password' => $this->request->getData('password') 
            // ]); 
            // // dd($response->getJson());
            // if ($response->getJson()['Status'] == 0) {
                 
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully added user = '. $user->username ,
                    'request' => $this->request, 
                ]);

                return $this->redirect(['action' => 'index']);
            }
            dd($user);

            $this->Flash->error(__('The user could not be saved. Please, try again.'));
            // $this->Flash->error(__($response->getJson()['Description']));
            
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to add an user' ,
                'request' => $this->request, 
            ]);
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

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully updated user with id = '. $user->id ,
                    'request' => $this->request, 
                ]);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to update user' ,
                'request' => $this->request, 
            ]);
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
        $this->request->allowMethod(['put', 'post', 'delete']);
        $user = $this->Users->get($id); 
        $this->Authorization->authorize($user, 'delete');    
 
        $user->trashed = date('Y-m-d H:i:s'); 
 
        if ($a = $this->Users->save($user)) { 
        //     dd($a);
            $this->Flash->success(__('The user has been deleted.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Successfully deleted user with id = '. $id ,
                'request' => $this->request, 
            ]);
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to delete user' ,
                'request' => $this->request, 
            ]);
        }

        return $this->redirect(['action' => 'index']);
    }
}
