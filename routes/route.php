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
        /*PETICIONES GET CON FILTRO*/
        if(isset($_GET["linkTo"]) && isset($_GET["equalTo"])){
           
            $response = new GetController();
            $response->getFilterData(explode("?", $routesArray[1])[0], $_GET["linkTo"], $_GET["equalTo"]);

    /* Peticiones GET de TABLAS RELACIONADAS sin filtro */
        }else if(isset($_GET["rel"]) && isset($_GET["type"]) && explode("?", $routesArray[1])[0]== "relations"){
            $response = new GetController();
            $response->getRelData( $_GET["rel"], $_GET["type"]);    
        
        }else{

         /*PETICIONES GET SIN FILTRO*/
            $response = new GetController();
            $response -> getData($routesArray[1]);
        }

    }
    /*PETICIONES POST*/
    if (count($routesArray) == 1 &&
        isset($_SERVER["REQUEST_METHOD"]) &&
        $_SERVER["REQUEST_METHOD"] == "POST"
    ) {

        $json = array(
                "status" => 200,
                "result" => "POST"
            );
        echo json_encode($json, http_response_code($json["status"]));

        return;


}
    /*PETICIONES PUT*/
    if (
        count($routesArray) == 1 &&
        isset($_SERVER["REQUEST_METHOD"]) &&
        $_SERVER["REQUEST_METHOD"] == "PUT"
    ) {

        $json = array(
                "status" => 200,
                "result" => "PUT"
            );
        echo json_encode($json, http_response_code($json["status"]));

        return;
    }

    /*PETICIONES DELETE*/
    if (
        count($routesArray) == 1 &&
        isset($_SERVER["REQUEST_METHOD"]) &&
        $_SERVER["REQUEST_METHOD"] == "DELETE"
    ) {

        $json = array(
                "status" => 200,
                "result" => "DELETE"
            );
        echo json_encode($json, http_response_code($json["status"]));

        return;
    }

}