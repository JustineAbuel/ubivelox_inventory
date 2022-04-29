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
        $this->loadModel('Categories');
        // $this->Authorization->skipAuthorization();

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */


    public function downloadsubcategoriesform()
    {
        $this->Authorization->skipAuthorization();
        $file_path = WWW_ROOT . 'forms' . DS . 'UBP_MASS_SUBCATEGORY_FORM.csv';
        $response = $this->response->withFile(
            $file_path,
            ['download' => true, 'name' => 'UBP_MASS_SUBCATEGORY_FORM.csv']
        );
        return $response;
    }

    public function index()
    {
        $subcategory = $this->Subcategories->newEmptyEntity();
        $this->Authorization->authorize($subcategory, 'index');

        $this->paginate = [
            'contain' => ['Categories'],
        ];
        $subcategories = $this->paginate($this->Subcategories);

        $categories = $this->Categories->find()->all();

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>' . $this->request->getParam('action') . ' page',
            'request' => $this->request,
        ]);
        $identity = $this->request->getAttribute('identity')->getIdentifier();
        if (isset($_POST["submit"])) {

            $filename = $_FILES["file"]["tmp_name"];

            if ($_FILES["file"]["size"] > 0) {
                $requiredHeaders = ['*Subcategory name', 'Subcategory Description'];
                $file = fopen($filename, "r");
                $firstLine = fgets($file);
                $num = 0;
                $counter = 0;
                $errorCounter = 0;

                $foundHeaders = str_getcsv(trim($firstLine), ',', '"');
                if ($foundHeaders !== $requiredHeaders) {
                    $this->Flash->error(__('Uploaded CSV is not the correct template. Please, try again'));
                    return $this->redirect(['controller' => 'Subcategories', 'action' => 'index']);
                    die();
                }

                while ($data = fgetcsv($file)) {
                    // if ($num == 0) { //skip header names in CSV file
                    //     $num++;
                    // } else {
                    if ($data[0] == "") {

                        $this->Common->dblogger([
                            //change depending on action
                            'message' => 'Mass upload[Subcategory] - Could not save row record',
                            'request' => $this->request,
                            'status' => 'error'
                        ]);

                        $errorCounter++;
                    } else {
                        $subcategory = $this->Subcategories->newEmptyEntity();
                        $subcategory = $this->Subcategories->patchEntity($subcategory, $this->request->getData());

                        $subcategory->category_id = $subcategory->category_id;
                        $subcategory->subcategory_name =  $data[0];
                        $subcategory->subcategory_description = $data[1];
                        $subcategory->date_added = date('Y-m-d H:i:s');
                        $subcategory->added_by = $identity;

                        $subcategory = $this->Subcategories->save($subcategory);

                        $this->Common->dblogger([
                            //change depending on action
                            'message' => 'Mass upload[Subcategory] - Successfully added subcategory with id = ' . $subcategory->subcategory_name,
                            'request' => $this->request,
                        ]);

                        $counter++;
                    }
                    // }
                }
                if ($counter > 0) {
                    $this->Flash->success(__('Subcategory CSV has been uploaded. {0} subcategory saved.', $counter));
                    if ($errorCounter > 0) {
                        $this->Flash->error(__('Subcategory CSV has been uploaded. {0} subcategory could not be saved.', $errorCounter));
                    }
                    return $this->redirect(['controller' => 'Subcategories', 'action' => 'index']); //redirect to company main
                } elseif ($errorCounter > 0) {
                    $this->Flash->error(__('Subcategory CSV has been uploaded. {0} subcategory could not be saved.', $errorCounter));
                } else {
                    $this->Flash->error(__('Subcategory CSV data could not be saved. Please, try again.'));
                }
                fclose($file);
            }
        }
        $title = "Sub Categories";
        $this->set(compact('title', 'subcategories', 'categories'));
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
        $this->Authorization->authorize($subcategory, 'view');

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>' . $this->request->getParam('action') . ' page',
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
        $this->Authorization->authorize($subcategory, 'add');
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>' . $this->request->getParam('action') . ' page',
            'request' => $this->request,
        ]);

        if ($this->request->is('post')) {
            $subcategory = $this->Subcategories->patchEntity($subcategory, $this->request->getData());
            $subcategory->added_by = $this->request->getAttribute('identity')->getIdentifier();

            if ($this->Subcategories->save($subcategory)) {
                $this->Flash->success(__('The subcategory has been saved.'));
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully added subcategory =' . $subcategory->subcategory_name,
                    'request' => $this->request,
                ]);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subcategory could not be saved. Please, try again.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to add subcategory',
                'request' => $this->request,
                'status' => 'error',
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
        $this->Authorization->authorize($subcategory, 'edit');
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>' . $this->request->getParam('action') . ' page',
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
                    'message' => 'Successfully updated subcategory with id = ' . $subcategory->id,
                    'request' => $this->request,
                ]);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subcategory could not be saved. Please, try again.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to update subcategory',
                'request' => $this->request,
                'status' => 'error',
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
        $this->Authorization->authorize($subcategory, 'delete');
        if ($this->Subcategories->delete($subcategory)) {
            $this->Flash->success(__('The subcategory has been deleted.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Successfully deleted subcategory with id = ' . $id,
                'request' => $this->request,
            ]);
        } else {
            $this->Flash->error(__('The subcategory could not be deleted. Please, try again.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to delete subcategory',
                'request' => $this->request,
                'status' => 'error',
            ]);
        }

        return $this->redirect(['action' => 'index']);
    }
}
