<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/INSERT_TRANSACTIONS',function(Request $request, Response $response){
    $user_id = $request->getParam('user_id');
    $item_id = $request->getParam('item_id');
    $transaction_type_id = $request->getParam('transaction_type_id');
    $quantity = $request->getParam('quantity');
    $company_from = $request->getParam('company_from');
    $company_to = $request->getParam('company_to');
    $subject = $request->getParam('subject');
    $received_by = $request->getParam('received_by');
    $received_date = $request->getParam('received_date');
    $status = $request->getParam('status');
    $added_by = $request->getParam('added_by');

    $sql = "CALL `INSERT_TRANSACTIONS` ($user_id,$item_id,$transaction_type_id,$quantity, $company_from, $company_to, '$subject', '$received_by', '$received_date', $status, $added_by)";
    postData($sql, $response);
});

$app->get('/GET_ALL_TRANSACTIONS',function(Request $request, Response $response){
    $sql = "CALL `GET_ALL_TRANSACTIONS`";
    getDataList($sql, $response, "GetAllTransactions");
});

$app->get('/GET_TRANSACTIONS_BY_ID/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];
    $sql = "CALL `GET_TRANSACTIONS_BY_ID` ($id)";
    getData($sql, $response, "GetTransactionByID");
});

$app->put('/UPDATE_TRANSACTIONS/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];
    $user_id = $request->getParam('user_id');
    $item_id = $request->getParam('item_id');
    $transaction_type_id = $request->getParam('transaction_type_id');
    $quantity = $request->getParam('quantity');
    $company_from = $request->getParam('company_from');
    $company_to = $request->getParam('company_to');
    $subject = $request->getParam('subject');
    $received_by = $request->getParam('received_by');
    $received_date = $request->getParam('received_date');
    $status = $request->getParam('status');
    $updated_by = $request->getParam('updated_by');

    $sql = "CALL `UPDATE_TRANSACTIONS` ($id, $user_id,$item_id,$transaction_type_id,$quantity, $company_from, $company_to, '$subject', '$received_by', '$received_date', $status, $updated_by)";
  
    postData($sql, $response);
});

$app->delete('/DELETE_TRANSACTIONS/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];

    $sql = "CALL `DELETE_TRANSACTIONS` ($id)";
    postData($sql, $response);
});