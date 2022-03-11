<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/INSERT_USERS',function(Request $request, Response $response){
    $username  = $request->getParam('username');
    $email  = $request->getParam('email');
    $firstname = $request->getParam('firstname');
    $middlename = $request->getParam('middlename');
    $lastname = $request->getParam('lastname');
    $contactno = $request->getParam('contactno');
    $added_by = $request->getParam('added_by');
    $role_id = $request->getParam('role_id');
    
    $password = md5(str_rot13(md5(str_rot13("qwerty123"))));
    $sql = "CALL `INSERT_USERS` ('$username', '$email' ,'$password','$firstname','$middlename','$lastname',$contactno,$added_by,$role_id)";
    postData($sql, $response);
});

$app->get('/GET_ALL_USERS',function(Request $request, Response $response){
    $sql = "CALL `GET_ALL_USERS`";
    getDataList($sql, $response, "GetAllTransactionStatus");
});

$app->get('/GET_USERS_BY_ID/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];
    $sql = "CALL `GET_USERS_BY_ID` ($id)";
    getData($sql, $response, "GetTransactionStatusByID");
});

$app->put('/UPDATE_USERS/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];
    $username  = $request->getParam('username');
    $email  = $request->getParam('email');
    $firstname = $request->getParam('firstname');
    $middlename = $request->getParam('middlename');
    $lastname = $request->getParam('lastname');
    $contactno = $request->getParam('contactno');
    $updated_by = $request->getParam('updated_by');
    $role_id = $request->getParam('role_id');

    $sql = "CALL `UPDATE_USERS` ($id, '$username', '$email','$firstname','$middlename','$lastname',$contactno,$updated_by,$role_id)";
    postData($sql, $response);
});

$app->delete('/DELETE_USERS/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];

    $sql = "CALL `DELETE_USERS` ($id)";
    postData($sql, $response);
});

$app->post('/LOGIN_USERS',function(Request $request, Response $response){
    $username  = $request->getParam('username');
    $password  = $request->getParam('password');
    $passdecrypt = md5(str_rot13(md5(str_rot13($password))));
    $sql = "CALL `LOGIN_USERS` ('$username', '$passdecrypt')";
    postData($sql, $response);
});

$app->post('/CHANGE_PASSWORD/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];
    $currentpassword  = $request->getParam('currentpassword');
    $newpassword  = $request->getParam('newpassword');
    $retypepassword  = $request->getParam('retypepassword');
    $currentpasswordencrypt = $currentpassword;
    $newpasswordencrypt = $newpassword;
    $retypepasswordencrypt = $retypepassword;
    $sql = "CALL `CHANGE_PASSWORD` ($id, '$currentpasswordencrypt', '$newpasswordencrypt','$retypepasswordencrypt')";
    postData($sql, $response);
});