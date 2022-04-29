<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Incoming Controller
 *
 * @property \App\Model\Table\IncomingTable $Incoming
 * @method \App\Model\Entity\Incoming[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class IncomingController extends AppController
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
        // $this->paginate = [
        //     'contain' => ['Items', 'Users'],
        //     'order' => ['date_added' => 'DESC']
        // ];

        // $incoming = $this->paginate($this->Incoming); 
        $incoming = $this->Incoming->find('all', [
            'join' => [
                'alias' => 'Users',
                'table' => 'users',
                'type' => 'LEFT',
                'conditions' => [
                    'Users.id = Incoming.added_by',
                ],
            ]
        ])
            ->select(['Incoming.id', 'Incoming.quantity', 'Incoming.date_added', 'Users.firstname', 'Users.lastname', 'Items.quantity', 'Items.item_name', 'Items.id'])
            ->contain(['Items'])->order(['Incoming.id' => 'DESC'])->all();
        // dd($incoming);
        $this->set(compact('incoming'));
    }

    /**
     * View method
     *
     * @param string|null $id Incoming id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $incoming = $this->Incoming->get($id, [
            'contain' => ['Items'],
        ]);

        $this->set(compact('incoming'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $incoming = $this->Incoming->newEmptyEntity();
        if ($this->request->is('post')) {
            $incoming = $this->Incoming->patchEntity($incoming, $this->request->getData());
            if ($this->Incoming->save($incoming)) {
                $this->Flash->success(__('The incoming has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The incoming could not be saved. Please, try again.'));
        }
        $items = $this->Incoming->Items->find('list', ['limit' => 200])->all();
        $this->set(compact('incoming', 'items'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Incoming id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $incoming = $this->Incoming->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $incoming = $this->Incoming->patchEntity($incoming, $this->request->getData());
            if ($this->Incoming->save($incoming)) {
                $this->Flash->success(__('The incoming has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The incoming could not be saved. Please, try again.'));
        }
        $items = $this->Incoming->Items->find('list', ['limit' => 200])->all();
        $this->set(compact('incoming', 'items'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Incoming id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $incoming = $this->Incoming->get($id);
        if ($this->Incoming->delete($incoming)) {
            $this->Flash->success(__('The incoming has been deleted.'));
        } else {
            $this->Flash->error(__('The incoming could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
