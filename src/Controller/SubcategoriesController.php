<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Subcategories Controller
 *
 * @property \App\Model\Table\SubcategoriesTable $Subcategories
 * @method \App\Model\Entity\Subcategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SubcategoriesController extends AppController
{
    
    public function initialize(): void
    {
        parent::initialize();
  
        $this->Authorization->skipAuthorization();
        
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Categories'],
        ];
        $subcategories = $this->paginate($this->Subcategories);

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);

        $title = "Sub Categories";
        $this->set(compact('title', 'subcategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Subcategory id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $subcategory = $this->Subcategories->get($id, [
            'contain' => ['Categories', 'Items'],
        ]);

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);

        $this->set(compact('subcategory'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $subcategory = $this->Subcategories->newEmptyEntity();
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);

        if ($this->request->is('post')) {
            $subcategory = $this->Subcategories->patchEntity($subcategory, $this->request->getData());
            $subcategory->added_by = $this->request->getAttribute('identity')->getIdentifier();
            
            if ($this->Subcategories->save($subcategory)) {
                $this->Flash->success(__('The subcategory has been saved.'));
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully added subcategory ='. $subcategory->subcategory_name ,
                    'request' => $this->request, 
                ]);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subcategory could not be saved. Please, try again.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to add subcategory' ,
                'request' => $this->request, 
            ]); 
        }
        $categories = $this->Subcategories->Categories->find('list', ['limit' => 200])->all();
        $this->set(compact('subcategory', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Subcategory id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $subcategory = $this->Subcategories->get($id, [
            'contain' => [],
        ]);
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $subcategory = $this->Subcategories->patchEntity($subcategory, $this->request->getData());
            $subcategory->updated_by = $this->request->getAttribute('identity')->getIdentifier();
            $this->Subcategories->touch($subcategory, 'Subcategories.updated');
            if ($this->Subcategories->save($subcategory)) {
                $this->Flash->success(__('The subcategory has been saved.'));
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully updated subcategory with id = '. $subcategory->id ,
                    'request' => $this->request, 
                ]);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subcategory could not be saved. Please, try again.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to update subcategory' ,
                'request' => $this->request, 
            ]);
        }
        $categories = $this->Subcategories->Categories->find('list', ['limit' => 200])->all();
        $this->set(compact('subcategory', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Subcategory id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $subcategory = $this->Subcategories->get($id);
        if ($this->Subcategories->delete($subcategory)) {
            $this->Flash->success(__('The subcategory has been deleted.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Successfully deleted subcategory with id = '. $id ,
                'request' => $this->request, 
            ]);
        } else {
            $this->Flash->error(__('The subcategory could not be deleted. Please, try again.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to delete subcategory' ,
                'request' => $this->request, 
            ]);
        }

        return $this->redirect(['action' => 'index']);
    }
}
