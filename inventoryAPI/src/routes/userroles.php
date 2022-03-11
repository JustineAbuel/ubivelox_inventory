<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/INSERT_USER_ROLES',function(Request $request, Response $response){
    $role_name  = $request->getParam('role_name');
    $added_by  = $request->getParam('added_by');
    
    $sql = "CALL `INSERT_USER_ROLES` ('$role_name', $added_by)";
    postData($sql, $response);
});

$app->get('/GET_ALL_USER_ROLES',function(Request $request, Response $response){
    $sql = "CALL `GET_ALL_USER_ROLES`";
    getDataList($sql, $response, "GetAllTransactionStatus");
});

$app->get('/GET_USER_ROLES_BY_ID/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];
    $sql = "CALL `GET_USER_ROLES_BY_ID` ($id)";
    getData($sql, $response, "GetTransactionStatusByID");
});

$app->put('/UPDATE_USER_ROLES/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];
    $role_name  = $request->getParam('role_name');
    $updated_by = $request->getParam('updated_by');

    $sql = "CALL `UPDATE_USER_ROLES` ($id, '$role_name', $updated_by)";
    postData($sql, $response);
});

$app->delete('/DELETE_USER_ROLES/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];

    $sql = "CALL `DELETE_USER_ROLES` ($id)";
    postData($sql, $response);
});
