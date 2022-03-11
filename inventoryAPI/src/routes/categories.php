<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/INSERT_CATEGORIES',function(Request $request, Response $response){
    $category_name = $request->getParam('category_name');
    $category_description = $request->getParam('category_description');
    $added_by = $request->getParam('added_by');

    $sql = "CALL `INSERT_CATEGORIES` ('$category_name','$category_description', $added_by)";
    postData($sql, $response);
});

$app->get('/GET_ALL_CATEGORIES',function(Request $request, Response $response){
    $sql = "CALL `GET_ALL_CATEGORIES`";
    getDataList($sql, $response, "GetAllCategories");
});

$app->get('/GET_CATEGORIES_BY_ID/{category_id}',function(Request $request, Response $response, array $args){
    $category_id =  $args['category_id'];
    $sql = "CALL `GET_CATEGORIES_BY_ID` ($category_id)";
    getData($sql, $response, "GetCategoriesByID");
});

$app->put('/UPDATE_CATEGORIES/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];
    $category_name = $request->getParam('category_name');
    $category_description = $request->getParam('category_description');
    $updated_by = $request->getParam('updated_by');

    $sql = "CALL `UPDATE_CATEGORIES` ($id,'$category_name','$category_description', $updated_by)";
    postData($sql, $response);
});

$app->delete('/DELETE_CATEGORIES/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];

    $sql = "CALL `DELETE_CATEGORIES` ($id)";
    postData($sql, $response);
});