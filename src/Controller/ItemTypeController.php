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
        if ($this->request->is('post')) {
            $itemType = $this->ItemType->patchEntity($itemType, $this->request->getData());
            if ($this->ItemType->save($itemType)) {
                $this->Flash->success(__('The item type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item type could not be saved. Please, try again.'));
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
        if ($this->request->is(['patch', 'post', 'put'])) {
            $itemType = $this->ItemType->patchEntity($itemType, $this->request->getData());
            if ($this->ItemType->save($itemType)) {
                $this->Flash->success(__('The item type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item type could not be saved. Please, try again.'));
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
        } else {
            $this->Flash->error(__('The item type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
