<?php

declare(strict_types=1);

namespace App\Controller;

use DateTime;
use Cake\I18n\Time;
use Cake\Http\Client;
use Cake\I18n\FrozenTime;
use Cake\Collection\Collection;
use CodeItNow\BarcodeBundle\Utils\QrCode;

/**
 * Items Controller
 *
 * @property \App\Model\Table\ItemsTable $Items
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadModel('Users');
        $this->loadModel('Categories');
        $this->loadModel('Subcategories');
        $this->loadModel('ItemType');
        $this->loadModel('Company');
        $this->loadModel('Incoming');
        $this->loadModel('Outgoing');

        // $this->Authorization->skipAuthorization(); 
    }

    public function dashboard()
    {
        $this->Authorization->skipAuthorization();
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>' . $this->request->getParam('action') . ' page',
            'request' => $this->request,
        ]);
        $this->viewBuilder()->setLayout('dashboard');
        $items = $this->Items->find()->count();
        $users = $this->Users->find()->count();
        $categories = $this->Categories->find()->count();


        $stocklevel = $this->Items->find()
            ->where([
                'quantity <=' => 100
            ])
            ->count();

        $month = date('Y-m');
        $condition = [
            'date_added >' => date('Y-m-01 00:00:00'),
            'date_added <=' => date('Y-m-t 23:59:59')
        ];
        $query = $this->Items->Incoming->find()->where($condition);
        $incoming = $query->select([
            'month' => $query->func()->month([
                'Incoming.date_added' => 'identifier'
            ]),
            'day' => $query->func()->day([
                'Incoming.date_added' => 'identifier'
            ]),
            'totalQuantity' => $query->func()->sum('Incoming.quantity')
        ])->group(['day'])->all();
        // dd($incoming);


        $addedThisMonth = $this->Items->find('all')->where(['date_added >' => date('Y-m-01 00:00:00'), 'date_added <' => date('Y-m-t 23:59:59')])->count();
        // dd($items);
        $returnedItems = $this->Outgoing->find()->where(['OR' => ['status IS' => 5, 'status' => 4]])->count();
        $returnedWithoutDamage = $this->Outgoing->find()->where(['status IS' => 5])->count();
        $damagedItem = $this->Outgoing->find()->where(['status IS' => 4])->count();

        // dd($damagedItem);

        $query = $this->Items->Outgoing->query();
        $outgoing = $query->select([
            'month' => $query->func()->month([
                'Outgoing.date_added' => 'identifier'
            ]),
            'day' => $query->func()->day([
                'Outgoing.date_added' => 'identifier'
            ]),
            'totalQuantity' => $query->func()->sum('Outgoing.quantity')
        ])
            ->group(['day'])->all();
        // dd($outgoing); 

        // items that has highest stocks
        // $topItems = $this->Items->find('all',[
        //     'quantity' => array('quantity' => 'MAX(Items.quantity)'),
        //     'limit' => 4
        //  ])->all();  

        $latestitems = $this->Items->find('all', ['order' => ['id' => 'DESC'], 'limit' => 4])->all();
        //items that has highest stocks
        $lowstocksitems = $this->Items->find('all', [
            'conditions' => [
                'category_id' => 3,
                'item_type_id IS ' => 2
            ],
            'limit' => 4
        ])->order(['quantity ASC'])->all();
        // dd($latestitems);
        // $outgoing = $this->Items->Outgoing; 
        // $query = $outgoing->find()
        //     ->select([
        //         'id',
        //         'transaction_id',
        //         'item_id',
        //         'month' => $query->func()->month([
        //             'Outgoing.date_added' => 'identifier'
        //         ]),
        //         'day' => $query->func()->day([
        //             'Outgoing.date_added' => 'identifier'
        //         ]),
        //         'totalQuantity' => $query->func()->sum('TransactionItems.quantity'),
        //     ])
        //     // // ->select($outgoing->TransactionItems)
        //     // ->select($outgoing->Transactions)
        //     ->contain(['TransactionItems'])
        //     // ->where(['Outgoing.transaction_id = TransactionItems.transaction_id'])

        //     ->group([ 'day'])->all();
        //     dd($query); 
        $this->set(compact('items', 'users', 'categories', 'stocklevel', 'incoming', 'outgoing', 'addedThisMonth', 'returnedItems', 'returnedWithoutDamage', 'damagedItem', 'latestitems', 'lowstocksitems'));
    }

    public function downloaditemform()
    {
        $this->Authorization->skipAuthorization();
        $file_path = WWW_ROOT . 'forms' . DS . 'UBP_MASS_ITEMS_FORM.csv';
        $response = $this->response->withFile(
            $file_path,
            ['download' => true, 'name' => 'UBP_MASS_ITEMS_FORM.csv']
        );
        return $response;
    }

    public function index()
    {
        $item = $this->Items->newEmptyEntity();
        $this->Authorization->authorize($item, 'index');

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>' . $this->request->getParam('action') . ' page',
            'request' => $this->request,
        ]);

        $this->paginate = [
            'contain' => ['Categories', 'Company', 'ItemType', 'Subcategories'],
            'conditions' => [
                'trashed IS ' => NULL
            ],
            'order' => ['id' => 'DESC']
        ];
        $items = $this->paginate($this->Items);

        $contain = ['contain' => ['Categories', 'Company', 'ItemType', 'Subcategories']];
        $order =  ['Items.id' => 'DESC'];
        $condition =  ['trashed IS ' => NULL];
        // $users = $this->paginate($this->Users);
        $items = $this->Items->find('all', $contain)->order($order)->where($condition)->all();


        $qrCode = new QrCode();

        $identity = $this->request->getAttribute('identity')->getIdentifier();
        if (isset($_POST["submit"])) {

            //check if uploaded file is csv
            if ($_FILES['file']['type'] != 'text/csv') {
                $this->Flash->error(__('Uploaded file is not CSV. Please download the correct form and try again..'));
                return $this->redirect(['action' => 'index']);
            }

            $filename = $_FILES["file"]["tmp_name"];

            if ($_FILES["file"]["size"] > 0) {

                $requiredHeaders = [
                    '*Item Name', 'Serial No.', 'Item Description', '*Issued Date (FORMAT SAMPLE:01/31/2022  1:00)', '*Manufacturer Warranty (FORMAT SAMPLE:01/31/2022)', '*Quantity', '*Item Type ID, 1=Internal, 2=External',
                    '*Quality, 0=Brand New, 1=Used', 'Remarks', 'Part No.', 'Operating System', 'Kernel', 'Header Type', 'Firmware', 'Features'
                ];
                $file = fopen($filename, "r");
                $firstLine = fgets($file);
                $num = 0;
                $counter = 0;
                $errorCounter = 0;
                $itemExists = 0;

                $foundHeaders = str_getcsv(trim($firstLine), ',', '"');
                if ($foundHeaders !== $requiredHeaders) {
                    $this->Flash->error(__('Uploaded CSV is not the correct Items CSV template. Please, try again'));
                    $this->Common->dblogger([
                        //change depending on action
                        'message' => 'Uploaded CSV is not the correct Items CSV template. Please, try again.',
                        'request' => $this->request,
                        'status' => 'error',
                    ]);
                    return $this->redirect(['controller' => 'Items', 'action' => 'index']);
                    die();
                }
                while ($data = fgetcsv($file)) {
                    // if ($num == 0) { //skip header names in CSV file
                    //     $num++;
                    // } else {
                    $item = $this->Items->newEmptyEntity();
                    $item = $this->Items->patchEntity($item, $this->request->getData());
                    // $date = new DateTime($data[3]);  
                    // dd(strtotime($data[3] ? $data[3] . ':00' : $data[3]));
                    if ($data[0] == '' || $data[3] == '' || $data[4] == '' || $data[5] == '' || $data[6] == '' || $data[7] == '') {

                        $this->Common->dblogger([
                            //change depending on action
                            'message' => 'Mass upload[Items] - Could not save row record',
                            'request' => $this->request,
                            'status' => 'error'
                        ]);

                        $errorCounter++;
                    } elseif ($this->Items->findByItemName($data[0])->count() > 0) {

                        $this->Common->dblogger([
                            //change depending on action
                            'message' => 'Mass upload[Items] - Item already exists',
                            'request' => $this->request,
                            'status' => 'error'
                        ]);

                        $itemExists++;
                    } else {



                        $item->category_id = $item->category_id;
                        $item->subcategory_id = $item->subcategory_id;
                        $item->supplier_id = $item->supplier_id;
                        $item->base_quantity = 100;
                        $item->item_name = $data[0];
                        $item->serial_no = $data[1];
                        $item->item_description = $data[2];
                        $item->issued_date =  DateTime::createFromFormat('d/m/Y H:i', $data[3])->format('Y-m-d H:i:s');
                        // $ts = $dt->getTimestamp();
                        $item->manufacturer_warranty = DateTime::createFromFormat('d/m/Y', $data[4])->format('Y-m-d');
                        $item->quantity = $data[5];
                        $item->item_type_id = $data[6];
                        $item->quality = $data[7];
                        $item->remarks = $data[8];
                        $item->part_no = $data[9];
                        $item->operating_system = $data[10];
                        $item->kernel = $data[11];
                        $item->header_type = $data[12];
                        $item->firmware = $data[13];
                        $item->features = $data[14];
                        $item->date_added = date('Y-m-d H:i:s');
                        $item->added_by = $identity;
                        // dd($item);
                        if ($item = $this->Items->save($item)) {

                            $this->Common->dblogger([
                                //change depending on action
                                'message' => 'Mass upload - Successfully added item with id = ' . $item->item_name,
                                'request' => $this->request,
                            ]);
                            $incomingTable = $this->Items->Incoming;
                            $incoming = $incomingTable->newEmptyEntity();

                            $incoming->item_id = $item->id;
                            $incoming->quantity = $data[5];
                            $incoming->added_by = $identity;
                            $incoming->date_added = date('Y-m-d H:i:s');
                            $incomingTable->save($incoming);
                        }


                        $counter++;
                    }
                    // }
                }
                if ($counter > 0) {
                    $this->Flash->success(__('Items CSV has been uploaded. {0} items saved.', $counter));
                    if ($errorCounter > 0) {
                        $this->Flash->error(__('Items CSV has been uploaded. {0} items could not be saved.', $errorCounter));
                    }
                    return $this->redirect(['controller' => 'Items', 'action' => 'index']); //redirect to company main
                } elseif ($errorCounter > 0) {
                    $this->Flash->error(__('Items CSV has been uploaded. {0} items could not be saved.', $errorCounter));
                } elseif ($itemExists > 0) {
                    $this->Flash->error(__('Items CSV has been uploaded. {0} items already exists.', $itemExists));
                } else {
                    $this->Flash->error(__('Items CSV data could not be saved. Please, try again.'));
                }

                fclose($file);
            }
        }

        $categories = $this->Categories->find('list')->innerJoinWith('Subcategories')->all();
        $subcategories = $this->Items->Subcategories->find('list')->all();
        $supplier = $this->Company->find('list')->all();
        $this->set('title', 'List of Items');
        $this->set(compact('items', 'qrCode', 'categories', 'subcategories', 'supplier'));
    }

    /**
     * View method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {


        $item = $this->Items->get($id, [
            // 'contain' => ['Categories', 'Suppliers', 'ItemTypes', 'Transactions'],
            'contain' => ['Categories', 'Subcategories', 'Company', 'ItemType'],
        ]);

        $this->Authorization->authorize($item, 'view');

        $this->Common->dblogger([
            'message' => 'Viewed Item with id = ' . $this->request->getParam('pass')[0],
            'request' => $this->request,
        ]);

        $this->set(compact('item'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $item = $this->Items->newEmptyEntity();
        $this->Authorization->authorize($item, 'add');

        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>' . $this->request->getParam('action') . ' page',
            'request' => $this->request,
        ]);

        if ($this->request->is('post')) {
            $item = $this->Items->patchEntity($item, $this->request->getData());

            // if ($this->Items->findByItemName($item->item_name)->count() > 0) {
            //     $this->Flash->error(__('The item already exists. Please, try again.'));
            //     return $this->redirect(['action' => 'index']);
            // }
            // dd($item);
            $identity = $this->request->getAttribute('identity')->getIdentifier();
            $item->added_by = $identity;
            // dd($item);

            $image = $this->request->getData('image_file');
            $fileName = $image->getClientFilename();
            $item->image = $fileName;
            // dd($item);

            if ($item = $this->Items->save($item)) {
                //upload image to webroot
                if (!$item->getErrors()) {
                    // never trust anything in `$image` if you haven't properly validated it!!!

                    if (!is_dir(WWW_ROOT . 'img/uploads/itemimages' . DS . $item->id))
                        mkdir(WWW_ROOT . 'img/uploads/itemimages' . DS . $item->id);
                    if ($fileName) {
                        $image->moveTo(WWW_ROOT . 'img/uploads/itemimages' . DS . $item->id . DS . $fileName);
                    }
                }
                $this->Flash->success(__('The item has been saved.'));

                $incomingTable = $this->Items->Incoming;
                $incoming = $incomingTable->newEmptyEntity();

                $incoming->item_id = $item->id;
                $incoming->quantity = $this->request->getData('quantity');
                $incoming->added_by = $identity;
                $incoming->date_added = date('Y-m-d H:i:s');
                $incomingTable->save($incoming);

                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully added item with id = ' . $item->item_name,
                    'request' => $this->request,
                ]);
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to add an item',
                'request' => $this->request,
            ]);
        }


        $quality =  ['BRAND NEW', 'USED'];
        // $categories = $this->Categories->find('list', ['contain' => ['Subcategories']])->all();  
        $categories = $this->Categories->find('list')->innerJoinWith('Subcategories')->all();
        $subcategories = $this->Items->Subcategories->find('list')->all();
        $company = $this->Items->Company->find('list', ['limit' => 200])->all();
        $itemTypes = $this->Items->ItemType->find('list', ['limit' => 200])->all();

        $this->set(compact('item', 'categories', 'subcategories', 'company', 'itemTypes', 'quality'));
    }

    public function addStocksQuantity()
    {
        $this->Authorization->skipAuthorization();

        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            // $item = $this->Items->find('all')->where(['id' => $this->request->getData('item_id')])->first();
            $item = $this->Items->get($this->request->getData('item_id'));
            $quantity = $this->request->getData('quantity');
            $identity = $this->request->getAttribute('identity')->getIdentifier();
            $item = $this->Items->patchEntity(
                $item,
                ['quantity' => $item->quantity += $quantity]
            );

            if ($this->Items->save($item)) {
                $this->Flash->success(__('Stocks added for ' . $item->item_name));

                $incomingTable = $this->Items->Incoming;
                $incoming = $incomingTable->newEmptyEntity();

                $incoming->item_id = $item->id;
                $incoming->quantity = $quantity;
                $incoming->added_by = $identity;
                $incoming->date_added = date('Y-m-d H:i:s');
                $incomingTable->save($incoming);

                $msg = 1;
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully added stocks for item with id = ' . $item->id,
                    'request' => $this->request,
                ]);
            } else {
                $msg = 2;
                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Could not add stocks for item with id = ' . $item->id,
                    'request' => $this->request,
                ]);
                $this->Flash->error(__('Could not add stocks'));
            }

            $response = $this->response->withType('application/json')
                ->withStringBody(json_encode(['data' => $item, 'msg' => $msg]));
            return $response;
        }
    }

    public function getsubcategories()
    {
        $this->Authorization->skipAuthorization();

        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $subcategories = $this->Items->Subcategories->find('all')->where(['category_id' => $this->request->getData('category_id')])->all();
            $option = '';
            foreach ($subcategories as $subcategory) {
                $option .= '<option value=' . $subcategory->id . '>' . $subcategory->subcategory_name . '</option>';
            }
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'subcategories' => $option
                    // 'subcategories' => $subcategories
                ]));
        }
    }
    /**
     * Edit method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $item = $this->Items->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($item, 'edit');
        $this->Common->dblogger([
            //change depending on action
            'message' => 'Accessed ' . $this->request->getParam('controller') . '>' . $this->request->getParam('action') . ' page',
            'request' => $this->request,
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $item = $this->Items->patchEntity($item, $this->request->getData());

            $item->updated_by = $this->request->getAttribute('identity')->getIdentifier();
            $this->Items->touch($item, 'Items.updated');

            if (!$item->getErrors()) {
                // never trust anything in `$image` if you haven't properly validated it!!!
                $image = $this->request->getData('image_file');
                $fileName = $image->getClientFilename();

                if (!is_dir(WWW_ROOT . 'img/uploads/itemimages' . DS . $item->id))
                    mkdir(WWW_ROOT . 'img/uploads/itemimages' . DS . $item->id);
                if ($fileName) {
                    $image->moveTo(WWW_ROOT . 'img/uploads/itemimages' . DS . $item->id . DS . $fileName);

                    $item->image = $fileName;
                }
            }
            // $item->date_added = date('Y-m-d H:i:s');
            // dd($item);
            if ($this->Items->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                $this->Common->dblogger([
                    //change depending on action
                    'message' => 'Successfully updated an item with id = ' . $item->id,
                    'request' => $this->request,
                ]);
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to update item',
                'request' => $this->request,
            ]);
        }


        $quality =  ['BRAND NEW', 'USED'];
        $categories = $this->Categories->find('list')->innerJoinWith('Subcategories')->all();
        $subcategories = $this->Items->Subcategories->find('list')->all();
        $company = $this->Items->Company->find('list', ['limit' => 200])->all();
        $itemTypes = $this->Items->ItemType->find('list', ['limit' => 200])->all();
        $this->set(compact('item', 'categories', 'company', 'itemTypes', 'subcategories', 'quality'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {

        $this->request->allowMethod(['put', 'post', 'delete']);
        $item = $this->Items->get($id);
        $this->Authorization->authorize($item, 'delete');

        $item->trashed = date('Y-m-d H:i:s');

        if ($this->Items->save($item)) {
            $this->Flash->success(__('The item has been deleted.'));

            $this->Common->dblogger([
                //change depending on action
                'message' => 'Successfully deleted item with id = ' . $id,
                'request' => $this->request,
            ]);
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
            $this->Common->dblogger([
                //change depending on action
                'message' => 'Unable to delete item',
                'request' => $this->request,
            ]);
        }

        return $this->redirect(['action' => 'index']);
    }
}
