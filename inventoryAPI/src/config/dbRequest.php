<?php
 function getData($sql, $response, $modelName){
     try{
        $db = new db();
        $pdo = $db->connect();

        $stmt = $pdo->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $post_item = $row;
        $modelArray = array($modelName=>$post_item);
        $requetArray =  array(
                        "RequestModel" => 
                        array(
                            "Status" => 0,
                            "Request" => "OK",
                            "Description" => "Success"));
        $result = array_merge($requetArray, $modelArray);
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(200);
    }catch (PDOException $e){
        $error = array(
            "RequestModel" => 
            array(
                "Status" => 1,
                "Request" => "Failed",
                "Description" => $e->errorInfo[2])
        );
        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(500);
    }
}
function getDataList($sql, $response, $modelName){
    try{
        $db = new db();
        $pdo = $db->connect();

        $stmt = $pdo->query($sql);
        $post_arr = array();
        $post_arr[$modelName] = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $post_item = $row;
            array_push($post_arr[$modelName], $post_item);
        }
        $requetArray =  array(
                        "RequestModel" => 
                        array(
                            "Status" => 0,
                            "Request" => "OK",
                            "Description" => "Success"));
        $result = array_merge($requetArray, $post_arr);
        $response->getBody()->write(json_encode($result));
        return $response
               ->withHeader('content-type','application/json')
               ->withStatus(200);
   }catch (PDOException $e){
       $error = array(
           "RequestModel" => 
           array(
               "Status" => 1,
               "Request" => "Failed",
               "Description" => $e->errorInfo[2])
       );
       $response->getBody()->write(json_encode($error));
       return $response
           ->withHeader('content-type','application/json')
           ->withStatus(500);
   }
}
function postData($sql, $response){
    try{
        $db = new db();
        $db = $db->connect();

        $stmt = $db->query($sql);
        
        $db = null;

        $result = array(
            "Status" => 0,
            "Request" => "OK",
            "Description" => "Success"
        );
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(200);
    }catch (PDOException $e){
        $error = array(
            "Status" => 1,
            "Request" => "Failed",
            "Description" => $e->errorInfo[2]
        );
        $response->getBody()->write(json_encode($error));
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(500);
    }
}
?>