<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/INSERT_TRANSACTION_TYPE',function(Request $request, Response $response){
    $transaction_name = $request->getParam('transaction_name');

    $sql = "CALL `INSERT_TRANSACTION_TYPE` ('$transaction_name')";
    postData($sql, $response);
});

$app->get('/GET_ALL_TRANSACTION_TYPE',function(Request $request, Response $response){
    $sql = "CALL `GET_ALL_TRANSACTION_TYPE`";
    getDataList($sql, $response, "GetAllTransactionType");
});

$app->get('/GET_TRANSACTION_TYPE_BY_ID/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];
    $sql = "CALL `GET_TRANSACTION_TYPE_BY_ID` ($id)";
    getData($sql, $response, "GetTransactionTypeByID");
});

$app->put('/UPDATE_TRANSACTION_TYPE/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];
    $transaction_name = $request->getParam('transaction_name');

    $sql = "CALL `UPDATE_TRANSACTION_TYPE` ($id, '$transaction_name')";
    postData($sql, $response);
});

$app->delete('/DELETE_TRANSACTION_TYPE/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];

    $sql = "CALL `DELETE_TRANSACTION_TYPE` ($id)";
    postData($sql, $response);
});