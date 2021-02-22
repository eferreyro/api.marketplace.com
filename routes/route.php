<?php 

$routesArray = explode("/", $_SERVER['REQUEST_URI']);
$routesArray = array_filter($routesArray);
/*CUANDO NO SE HACE UNA PETICION A LA API*/
if(count($routesArray)==0){
    $json = array(
        "status" => 404,
        "result" => "Not found"
    );
    echo json_encode($json, http_response_code($json["status"]));
    return;
}else{

    /*PETICIONES GET*/
if(count($routesArray) == 1 && 
    isset($_SERVER["REQUEST_METHOD"]) &&
    $_SERVER["REQUEST_METHOD"] == "GET"){
        
            $json = array(
                "status" => 200,
                "result" => "GET"
            );
            echo json_encode($json, http_response_code($json["status"]));
            
            return;


    }


}


?>
