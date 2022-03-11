<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/INSERT_ITEMS',function(Request $request, Response $response){
    $category_id = $request->getParam('category_id');
    $item_name = $request->getParam('item_name');
    $serial_no = $request->getParam('serial_no');
    $item_description = $request->getParam('item_description');
    $issued_date = $request->getParam('issued_date');
    $warranty = $request->getParam('warranty');
    $quantity = $request->getParam('quantity');
    $supplier_id = $request->getParam('supplier_id');
    $item_type_id = $request->getParam('item_type_id');
    $quality = $request->getParam('quality');
    $remarks = $request->getParam('remarks');
    $part_no = $request->getParam('part_no');
    $operating_system = $request->getParam('operating_system');
    $kernel = $request->getParam('kernel');
    $header_type = $request->getParam('header_type');
    $firmware = $request->getParam('firmware');
    $features = $request->getParam('features');
    $added_by = $request->getParam('added_by');

    $sql = "CALL `INSERT_ITEMS` ($category_id,'$item_name','$serial_no','$item_description','$issued_date','$warranty',$quantity,$supplier_id,$item_type_id,$quality,'$remarks','$part_no','$operating_system','$kernel','$header_type','$firmware','$features',$added_by)";
    postData($sql, $response);
});

$app->get('/GET_ALL_ITEMS',function(Request $request, Response $response){
    $sql = "CALL `GET_ALL_ITEMS`";
    getDataList($sql, $response, "GetAllItems");
});

$app->get('/GET_ITEMS_BY_ID/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];
    $sql = "CALL `GET_ITEMS_BY_ID` ($id)";
    getData($sql, $response, "GetItemsByID");
});

$app->put('/UPDATE_ITEMS/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];
    $category_id = $request->getParam('category_id');
    $item_name = $request->getParam('item_name');
    $serial_no = $request->getParam('serial_no');
    $item_description = $request->getParam('item_description');
    $issued_date = $request->getParam('issued_date');
    $warranty = $request->getParam('warranty');
    $quantity = $request->getParam('quantity');
    $supplier_id = $request->getParam('supplier_id');
    $item_type_id = $request->getParam('item_type_id');
    $quality = $request->getParam('quality');
    $remarks = $request->getParam('remarks');
    $part_no = $request->getParam('part_no');
    $operating_system = $request->getParam('operating_system');
    $kernel = $request->getParam('kernel');
    $header_type = $request->getParam('header_type');
    $firmware = $request->getParam('firmware');
    $features = $request->getParam('features');
    $updated_by = $request->getParam('updated_by');

    $sql = "CALL `UPDATE_ITEMS` ($id, $category_id,'$item_name','$serial_no','$item_description','$issued_date','$warranty',$quantity,$supplier_id,$item_type_id,$quality,'$remarks','$part_no','$operating_system','$kernel','$header_type','$firmware','$features',$updated_by)";
     postData($sql, $response);
});

$app->delete('/DELETE_ITEMS/{id}',function(Request $request, Response $response, array $args){
    $id =  $args['id'];

    $sql = "CALL `DELETE_ITEMS` ($id)";
    postData($sql, $response);
});