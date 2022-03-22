<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Outgoing Controller
 *
 * @property \App\Model\Table\OutgoingTable $Outgoing
 * @method \App\Model\Entity\Outgoing[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OutgoingController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization(); //skip authorization for user access

        $this->paginate = [
            'contain' => ['TransactionItems'],
        ];
        $outgoing = $this->paginate($this->Outgoing);

        $this->set(compact('outgoing'));
    }

    /**
     * View method
     *
     * @param string|null $id Outgoing id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->Authorization->skipAuthorization(); //skip authorization for user access
        
        $outgoing = $this->Outgoing->get($id, [
            'contain' => ['TransactionItems'],
        ]);

        $this->set(compact('outgoing'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->Authorization->skipAuthorization(); //skip authorization for user access
        
        $outgoing = $this->Outgoing->newEmptyEntity();
        if ($this->request->is('post')) {
            $outgoing = $this->Outgoing->patchEntity($outgoing, $this->request->getData());
            if ($this->Outgoing->save($outgoing)) {
                $this->Flash->success(__('The outgoing has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The outgoing could not be saved. Please, try again.'));
        }
        $transactionItems = $this->Outgoing->TransactionItems->find('list', ['limit' => 200])->all();
        $this->set(compact('outgoing', 'transactionItems'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Outgoing id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->Authorization->skipAuthorization(); //skip authorization for user access
        
        $outgoing = $this->Outgoing->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $outgoing = $this->Outgoing->patchEntity($outgoing, $this->request->getData());
            if ($this->Outgoing->save($outgoing)) {
                $this->Flash->success(__('The outgoing has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The outgoing could not be saved. Please, try again.'));
        }
        $transactionItems = $this->Outgoing->TransactionItems->find('list', ['limit' => 200])->all();
        $this->set(compact('outgoing', 'transactionItems'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Outgoing id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->Authorization->skipAuthorization(); //skip authorization for user access
        
        $this->request->allowMethod(['post', 'delete']);
        $outgoing = $this->Outgoing->get($id);
        if ($this->Outgoing->delete($outgoing)) {
            $this->Flash->success(__('The outgoing has been deleted.'));
        } else {
            $this->Flash->error(__('The outgoing could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
