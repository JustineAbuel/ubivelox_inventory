<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Client;

/**
 * Company Controller
 *
 * @property \App\Model\Table\CompanyTable $Company
 * @method \App\Model\Entity\Company[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CompanyController extends AppController
{
    public $connection;

    public function initialize(): void
    {
        parent::initialize();

        // $this->Authorization->skipAuthorization(); //skip authorization for user access

    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function downloadcompanyform()
    {
        $this->Authorization->skipAuthorization();
        $file_path = WWW_ROOT . 'forms' . DS . 'UBP_MASS_COMPANY_FORM.csv';
        $response = $this->response->withFile(
            $file_path,
            ['download' => true, 'name' => 'UBP_MASS_COMPANY_FORM.csv']
        );
        return $response;
    }
    public function index()
    {

        $company = $this->Company->newEmptyEntity();
        $this->Authorization->authorize($company, 'index');
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>' . $this->request->getParam('action') . ' page',
            'request' => $this->request,
        ]);

        $company = $this->Company->find()->all();

        //$csv_file_name = WWW_ROOT.'forms'.DS.'UBP_MASS_COMPANY_FORM.csv'; //company csv template path
        //$filename = basename($csv_file_name); //get file name of csv
        //dd($filename);

        if (isset($_POST["submit"])) {

            //dd($_FILES['file']['name']);

            //if(trim($_FILES['file']['name']) != trim($filename) ){ //check input filename from webroot company csv if valid
            //    $this->Flash->error(__('Incorrect Company CSV Template! Please, try again.'));
            //    $this->Common->dblogger([
            //                    //change depending on action
            //                    'message' => 'Incorrect Company CSV Template! Please, try again.',
            //                    'request' => $this->request, 
            //                    'status' => 'error',
            //    ]);
            //    return $this->redirect(['controller' => 'Company', 'action' => 'index']);
            //}
            //else{

            $filename = $_FILES["file"]["tmp_name"];

            if ($_FILES["file"]["size"] > 0) {

                $requiredHeaders = ['*Company', '*Address', '*Mobile No', 'Tel No.*', 'Email*', '*Company Type - 1=Client,2=Supplier'];

                $file = fopen($filename, "r");
                $firstLine = fgets($file);
                $num = 0;
                $foundHeaders = str_getcsv(trim($firstLine), ',', '"');
                if ($foundHeaders !== $requiredHeaders) {
                    $this->Flash->error(__('Uploaded CSV is not the correct Company CSV template. Please, try again.'));
                    $this->Common->dblogger([
                        //change depending on action
                        'message' => 'Uploaded CSV is not the correct Company CSV template. Please, try again.',
                        'request' => $this->request,
                        'status' => 'error',
                    ]);
                    return $this->redirect(['controller' => 'Company', 'action' => 'index']);
                    die();
                }
                while ($data = fgetcsv($file)) {
                    //if($num == 0){ //skip header names in CSV file
                    //    $num++;
                    //} 
                    //else{
                    $company_name = $data[0];
                    $address = $data[1];
                    $contactno = $data[2];
                    $tel_no = $data[3];
                    $email = $data[4];
                    $company_type = $data[5];
                    $date_added = date('Y-m-d H:i:s');
                    $added_by = $this->request->getAttribute('identity')->getIdentifier();
                    /*
                    $data = array(
                        'company_name' => $company_name,
                        'address' => $address,
                        'contactno' => $contactno,
                        'company_type' => $company_type,
                        'date_added' => date('Y-m-d H:i:s'),
                        'added_by' => $this->request->getAttribute('identity')->getIdentifier()
                    );

                    $Company = $this->Company->newEntity($data);
                    $this->Company->save($Company);
                    */
                    $insertquery = $this->connection->execute("
                        INSERT INTO company(
                       company_name,address,contactno,tel_no,email,date_added,added_by,company_type) 
                        SELECT * FROM 
                        (SELECT '$company_name') AS tmp1,
                        (SELECT '$address') AS tmp2,
                        (SELECT '$contactno') AS tmp3,
                        (SELECT '$tel_no') AS tmp4,
                        (SELECT '$email') AS tmp5,
                        (SELECT '$date_added') AS tmp6,
                        (SELECT '$added_by') AS tmp7,
                        (SELECT '$company_type') AS tmp8 
                        WHERE NOT EXISTS 
                        (SELECT 
                        company_name,address,contactno,date_added,added_by,company_type
                        FROM 
                        company 
                        WHERE 
                        company_name = '$company_name' 
                        )
                        ");
                    $this->Common->dblogger([
                        //change depending on action
                        'message' => 'Mass upload[Company] - Successfully added company name = ' . $company_name,
                        'request' => $this->request,
                    ]);
                    //}
                }
                if ($insertquery) {
                    $this->Flash->success(__('Company CSV data has been saved.'));
                    $this->Common->dblogger([
                        //change depending on action
                        'message' => 'Company CSV data has been saved/uploaded.',
                        'request' => $this->request,
                    ]);
                    return $this->redirect(['controller' => 'Company', 'action' => 'index']); //redirect to company main
                } else {
                    $this->Flash->error(__('Company CSV data could not be saved/uploaded. Please, try again.'));
                    $this->Common->dblogger([
                        //change depending on action
                        'message' => 'Company CSV data could not be saved/uploaded. Please, try again.',
                        'request' => $this->request,
                        'status' => 'error',
                    ]);
                }

                fclose($file);
            }
            //} //end else

        }

        $this->set(compact('company'));
    }

    /**
     * View method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $company = $this->Company->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($company, 'view');

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>' . $this->request->getParam('action') . ' page',
            'request' => $this->request,
        ]);

        $this->set(compact('company'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $company = $this->Company->newEmptyEntity();
        $this->Authorization->authorize($company, 'add');

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>' . $this->request->getParam('action') . ' page',
            'request' => $this->request,
        ]);
        if ($this->request->is('post')) {
            $company = $this->Company->patchEntity($company, $this->request->getData());
            $company->date_added = date('Y-m-d H:i:s');
            $company->added_by =  $this->request->getAttribute('identity')->getIdentifier();
            /*
            if ($this->Company->save($company)) {
                $this->Flash->success(__('The company has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            */
            //$http = new Client();
            //$response = $http->post(getEnv('INVENTORY_API_URI').'/INSERT_COMPANY', [   //pointed at local
            // $response = $http->post('https://ubpdev.myubplus.com.ph/api/INSERT_COMPANY', [  
            //    'company_name' => $company->company_name, 
            //    'address' => $company->address,
            //    'contactno' => $company->contactno,
            //    'added_by' =>  $this->request->getAttribute('identity')->getIdentifier(),
            //    'company_type' => $company->company_type,
            //]); 
            //if ($response->getJson()['Status'] == 0) {

            $check_exist = $this->Company
                ->find('all')
                ->where(['company_name' => $company->company_name])
                ->count();

            if ($check_exist > 0) {
                $this->Flash->error(__('The company name ' . $company->company_name . ' already exist! Please, try again.'));
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'The company name ' . $company->company_name . ' already exist! Please, try again.',
                    'request' => $this->request,
                    'status' => 'error',
                ]);
            } else {

                if ($this->Company->save($company)) {
                    $this->Flash->success(__('The company has been saved.'));
                    $this->Common->dblogger([
                        //change depending on action
                        'message' => 'Successfully added company = ' . $company->company_name,
                        'request' => $this->request,
                    ]);

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The company could not be saved. Please, try again.'));
                //$this->Flash->error(__($response->getJson()['Description'])); //get API error
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'The company could not be saved. Please, try again.',
                    'request' => $this->request,
                    'status' => 'error',
                ]);
            }
        }
        $this->set(compact('company'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $company = $this->Company->get($id, [
            'contain' => [],
        ]);

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>' . $this->request->getParam('action') . ' page',
            'request' => $this->request,
        ]);

        $this->Authorization->authorize($company, 'edit');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $company = $this->Company->patchEntity($company, $this->request->getData());
            $company->date_updated = date('Y-m-d H:i:s');
            $company->updated_by =  $this->request->getAttribute('identity')->getIdentifier();

            //$http = new Client();
            //$response = $http->put(getEnv('INVENTORY_API_URI').'/UPDATE_COMPANY/'.$id, [     
            // $response = $http->post('https://ubpdev.myubplus.com.ph/api/UPDATE_COMPANY/'.$id, [  
            //    'company_name' => $company->company_name ,
            //    'address' => $company->address ,
            //    'contactno' => $company->contactno,
            //    'updated_by' => $this->request->getAttribute('identity')->getIdentifier() ,
            //    'company_type' => $company->company_type,

            //]); 

            //if ($response->getJson()['Status'] == 0) { 
            if ($this->Company->save($company)) {
                $this->Flash->success(__('The company has been saved.'));
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully updated company with id = ' . $company->id,
                    'request' => $this->request,
                ]);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The company could not be saved. Please, try again.'));
            //$this->Flash->error(__($response->getJson()['Description'])); //get API error
            $this->Common->dblogger([
                //change depending on action
                'message' => 'The company could not be saved. Please, try again.',
                'request' => $this->request,
                'status' => 'error',
            ]);
        }
        $this->set(compact('company'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $company = $this->Company->get($id);
        $this->Authorization->authorize($company, 'delete');

        // $http = new Client();
        // $response = $http->delete(getEnv('INVENTORY_API_URI').'/DELETE_COMPANY/'.$id);  
        // $response = $http->post('https://ubpdev.myubplus.com.ph/api/DELETE_COMPANY/'.$id);  
        // if ($response->getJson()['Status'] == 0) {

        if ($this->Company->delete($company)) {
            $this->Flash->success(__('The company has been deleted.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Successfully deleted company with id = ' . $id,
                'request' => $this->request,
            ]);
        } else {
            $this->Flash->error(__('The company could not be deleted. Please, try again.'));
            // $this->Flash->error(__($response->getJson()['Description'])); //get API error
            $this->Common->dblogger([
                //change depending on action
                'message' => 'The company could not be deleted. Please, try again.',
                'request' => $this->request,
                'status' => 'error',
            ]);
        }

        return $this->redirect(['action' => 'index']);
    }
}
