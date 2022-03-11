<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/INSERT_ITEM_TYPE',function(Request $request, Response $response){
    $type_name = $request->getParam('type_name');

    $sql = "CALL `INSERT_ITEM_TYPE` ('$type_name')";
    postData($sql, $response);
});

$app->get('/GET_ALL_ITEM_TYPE',function(Request $request, Response $response){
    $sql = "CALL `GET_ALL_ITEM_TYPE`";
    getDataList($sql, $response, "GetAllItemType");
});

$app->get('/GET_ITEM_TYPE_BY_ID/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];
    $sql = "CALL `GET_ITEM_TYPE_BY_ID` ($id)";
    getData($sql, $response, "GetItemTypeByID");
});

$app->put('/UPDATE_ITEM_TYPE/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];
    $type_name = $request->getParam('type_name');
   
    $sql = "CALL `UPDATE_ITEM_TYPE` ($id, '$type_name')";
    postData($sql, $response);
});

$app->delete('/DELETE_ITEM_TYPE/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];

    $sql = "CALL `DELETE_ITEM_TYPE` ($id)";
    postData($sql, $response);
});