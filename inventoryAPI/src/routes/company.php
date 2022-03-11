<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/INSERT_COMPANY',function(Request $request, Response $response){
    $company_name = $request->getParam('company_name');
    $address = $request->getParam('address');
    $contactno = $request->getParam('contactno');
    $added_by = $request->getParam('added_by');
    $company_type = $request->getParam('company_type');

    $sql = "CALL `INSERT_COMPANY` ('$company_name','$address',$contactno, $added_by, $company_type)";
    postData($sql, $response);
});

$app->get('/GET_ALL_COMPANY',function(Request $request, Response $response){
    $sql = "CALL `GET_ALL_COMPANY`";
    getDataList($sql, $response, "GetAllCompany");
});

$app->get('/GET_COMPANY_BY_ID/{company_id}',function(Request $request, Response $response, array $args){
    $company_id =  $args['company_id'];
    $sql = "CALL `GET_COMPANY_BY_ID` ($company_id)";
    getData($sql, $response, "GetCategoriesByID");
});

$app->get('/GET_COMPANY_SUPPLIER',function(Request $request, Response $response){
    $sql = "CALL `GET_COMPANY_SUPPLIER`";
    getData($sql, $response, "GetCompanySupplier");
});

$app->get('/GET_COMPANY_CLIENTS',function(Request $request, Response $response){
    $sql = "CALL `GET_COMPANY_CLIENTS`";
    getData($sql, $response, "GetCompanyClient");
});

$app->put('/UPDATE_COMPANY/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];
    $company_name = $request->getParam('company_name');
    $address = $request->getParam('address');
    $contactno = $request->getParam('contactno');
    $updated_by = $request->getParam('updated_by');
    $company_type = $request->getParam('company_type');

    $sql = "CALL `UPDATE_COMPANY` ($id, '$company_name','$address',$contactno,$updated_by,$company_type)";
    postData($sql, $response);
});

$app->delete('/DELETE_COMPANY/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];

    $sql = "CALL `DELETE_COMPANY` ($id)";
    postData($sql, $response);
});