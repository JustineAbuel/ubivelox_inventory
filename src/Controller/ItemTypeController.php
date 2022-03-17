<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ItemType Controller
 *
 * @property \App\Model\Table\ItemTypeTable $ItemType
 * @method \App\Model\Entity\ItemType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemTypeController extends AppController
{
    
    public function initialize(): void
    {
        parent::initialize();
  
        // $this->Authorization->skipAuthorization();

    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $itemType = $this->ItemType->newEmptyEntity();
        $this->Authorization->authorize($itemType, 'index');
        $itemType = $this->paginate($this->ItemType);
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);

        $this->set(compact('itemType'));
    }

    /**
     * View method
     *
     * @param string|null $id Item Type id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $itemType = $this->ItemType->get($id, [
            'contain' => ['Items'],
        ]);
        $this->Authorization->authorize($itemType, 'view');

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
        $this->set(compact('itemType'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $itemType = $this->ItemType->newEmptyEntity();
        $this->Authorization->authorize($itemType, 'view');
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
        if ($this->request->is('post')) {
            $itemType = $this->ItemType->patchEntity($itemType, $this->request->getData());
            if ($this->ItemType->save($itemType)) {
                $this->Flash->success(__('The item type has been saved.'));
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully added item type ='. $itemType->type_name ,
                    'request' => $this->request, 
                ]);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item type could not be saved. Please, try again.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to add an item type' ,
                'request' => $this->request, 
            ]);
        }
        $this->set(compact('itemType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Item Type id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $itemType = $this->ItemType->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($itemType, 'edit');
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>'.$this->request->getParam('action') . ' page',
            'request' => $this->request, 
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $itemType = $this->ItemType->patchEntity($itemType, $this->request->getData());
            if ($this->ItemType->save($itemType)) {
                $this->Flash->success(__('The item type has been saved.'));
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully updated item type with id = '. $itemType->id ,
                    'request' => $this->request, 
                ]);
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item type could not be saved. Please, try again.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to update item type' ,
                'request' => $this->request, 
            ]);
        }
        $this->set(compact('itemType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Item Type id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $itemType = $this->ItemType->get($id);
        $this->Authorization->authorize($itemType, 'delete');
        if ($this->ItemType->delete($itemType)) {
            $this->Flash->success(__('The item type has been deleted.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Successfully deleted item type with id = '. $id ,
                'request' => $this->request, 
            ]);
        } else {
            $this->Flash->error(__('The item type could not be deleted. Please, try again.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to delete item type' ,
                'request' => $this->request, 
            ]);
        }

        return $this->redirect(['action' => 'index']);
    }
}
