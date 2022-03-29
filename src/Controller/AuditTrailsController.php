<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AuditTrails Controller
 *
 * @property \App\Model\Table\AuditTrailsTable $AuditTrails
 * @method \App\Model\Entity\AuditTrail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AuditTrailsController extends AppController
{
    
    public function initialize(): void
    {
        parent::initialize();
   
        
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        
        $auditTrail = $this->AuditTrails->newEmptyEntity();
        $this->Authorization->authorize($auditTrail, 'index');
  
         

        $auditTrails = $this->AuditTrails->find('all', ['limit' => 20])
            ->select(['user_roles.role_name'])
            ->select($this->AuditTrails)
            ->innerJoin(['user_roles'])
            ->where(['AuditTrails.role = user_roles.id'])->order(['AuditTrails.id' => 'DESC'])->all(); 

        $this->set(compact('auditTrails'));
    }

    /**
     * View method
     *
     * @param string|null $id Audit Trail id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $auditTrail = $this->AuditTrails->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($auditTrail, $this->request->getParam('action'));
        $this->Common->dblogger([ 
            'message' => 'Viewed Item with id = '. $this->request->getParam('pass')[0],
            'request' => $this->request, 
        ]);
        
        $this->set(compact('auditTrail'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $auditTrail = $this->AuditTrails->newEmptyEntity();
        $this->Authorization->authorize($auditTrail, $this->request->getParam('action'));
        if ($this->request->is('post')) {
            $auditTrail = $this->AuditTrails->patchEntity($auditTrail, $this->request->getData());
            if ($this->AuditTrails->save($auditTrail)) {
                $this->Flash->success(__('The audit trail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The audit trail could not be saved. Please, try again.'));
        }
        $this->set(compact('auditTrail'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Audit Trail id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $auditTrail = $this->AuditTrails->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($auditTrail, $this->request->getParam('action'));
        if ($this->request->is(['patch', 'post', 'put'])) {
            $auditTrail = $this->AuditTrails->patchEntity($auditTrail, $this->request->getData());
            if ($this->AuditTrails->save($auditTrail)) {
                $this->Flash->success(__('The audit trail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The audit trail could not be saved. Please, try again.'));
        }
        $this->set(compact('auditTrail'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Audit Trail id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $auditTrail = $this->AuditTrails->get($id);
        $this->Authorization->authorize($auditTrail, $this->request->getParam('action'));
        if ($this->AuditTrails->delete($auditTrail)) {
            $this->Flash->success(__('The audit trail has been deleted.'));
        } else {
            $this->Flash->error(__('The audit trail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
