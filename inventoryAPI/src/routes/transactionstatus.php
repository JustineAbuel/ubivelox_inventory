<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/INSERT_TRANSACTION_STATUS',function(Request $request, Response $response){
    $status_name = $request->getParam('status_name');
    $added_by = $request->getParam('added_by');

    $sql = "CALL `INSERT_TRANSACTION_STATUS` ('$status_name',$added_by)";
    postData($sql, $response);
});

$app->get('/GET_ALL_TRANSACTION_STATUS',function(Request $request, Response $response){
    $sql = "CALL `GET_ALL_TRANSACTION_STATUS`";
    getDataList($sql, $response, "GetAllTransactionStatus");
});

$app->get('/GET_TRANSACTION_STATUS_BY_ID/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];
    $sql = "CALL `GET_TRANSACTION_STATUS_BY_ID` ($id)";
    getData($sql, $response, "GetTransactionStatusByID");
});

$app->put('/UPDATE_TRANSACTION_STATUS/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];
    $status_name = $request->getParam('status_name');
    $updated_by = $request->getParam('updated_by');

    $sql = "CALL `UPDATE_TRANSACTION_STATUS` ($id, '$status_name',$updated_by)";
    postData($sql, $response);
});

$app->delete('/DELETE_TRANSACTION_STATUS/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];

    $sql = "CALL `DELETE_TRANSACTION_STATUS` ($id)";
    postData($sql, $response);
});