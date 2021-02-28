<?php 

$routesArray = explode("/", $_SERVER['REQUEST_URI']);
$routesArray = array_filter($routesArray);
/* =================================================
CUANDO NO SE HACE UNA PETICION A LA API
=================================================*/
if(count($routesArray)==0){
    $json = array(
        "status" => 404,
        "result" => "Not found"
    );
    echo json_encode($json, http_response_code($json["status"]));
    return;
}else{

    /* =================================================
    PETICIONES GET
    =================================================*/
if(count($routesArray) == 1 && 
    isset($_SERVER["REQUEST_METHOD"]) &&
    $_SERVER["REQUEST_METHOD"] == "GET"){
        /* =================================================
        PETICIONES GET CON FILTRO
        =================================================*/
        if(isset($_GET["linkTo"]) && isset($_GET["equalTo"]) && !isset($_GET["rel"]) && !isset($_GET["type"])){
            if (isset($_GET["orderBy"]) && isset($_GET["orderMode"])) {
                $orderBy = $_GET["orderBy"];
                $orderMode = $_GET["orderMode"];
            } else {
                $orderBy = null;
                $orderMode = null;
            }

            $response = new GetController();
            $response->getFilterData(explode("?", $routesArray[1])[0], $_GET["linkTo"], $_GET["equalTo"], $orderBy, $orderMode);

    /* =================================================
     Peticiones GET de tablas relacionadas SIN filtro 
    =================================================*/

        }else if(isset($_GET["rel"]) && isset($_GET["type"]) && explode("?", $routesArray[1])[0]== "relations" &&
         !isset($_GET["linkTo"]) && !isset($_GET["equalTo"])){
            /* Preguntamos si vienen variables de Orden */
            if (isset($_GET["orderBy"]) && isset($_GET["orderMode"])) {
                $orderBy = $_GET["orderBy"];
                $orderMode = $_GET["orderMode"];
            } else {
                $orderBy = null;
                $orderMode = null;
            }
            
            $response = new GetController();
            $response->getRelData( $_GET["rel"], $_GET["type"], $orderBy, $orderMode);
    /* =================================================
     Peticiones GET de TABLAS RELACIONADAS con filtro 
    =================================================*/
    } else if (isset($_GET["rel"]) && isset($_GET["type"]) && explode("?", $routesArray[1])[0] == "relations" && isset($_GET["linkTo"]) && isset($_GET["equalTo"]))
    {
            /* Preguntamos si vienen variables de Orden */
            if (isset($_GET["orderBy"]) && isset($_GET["orderMode"])) {
                $orderBy = $_GET["orderBy"];
                $orderMode = $_GET["orderMode"];
            } else {
                $orderBy = null;
                $orderMode = null;
            }
        $response = new GetController();
        $response->getRelFilterData($_GET["rel"], $_GET["type"], $_GET["linkTo"], $_GET["equalTo"], $orderBy, $orderMode);
    
    /* =================================================
        Peticiones GET para el BUSCADOR
    =================================================*/
    }else if(isset($_GET["linkTo"]) && isset($_GET["search"])){
            /* Preguntamos si vienen variables de Orden */
            if (isset($_GET["orderBy"]) && isset($_GET["orderMode"])) {
                $orderBy = $_GET["orderBy"];
                $orderMode = $_GET["orderMode"];
            } else {
                $orderBy = null;
                $orderMode = null;
            }
        $response = new GetController();
        $response->getSearchData(explode("?", $routesArray[1])[0], $_GET["linkTo"], $_GET["search"], $orderBy, $orderMode);
        
    /* =================================================
              PETICIONES GET SIN FILTRO
    =================================================*/
    }else{
        if(isset($_GET["orderBy"]) && isset($_GET["orderMode"])){
            $orderBy = $_GET["orderBy"];
            $orderMode = $_GET["orderMode"];
        }else{
                $orderBy = null;
                $orderMode = null;
        }
            $response = new GetController();
            $response -> getData(explode("?", $routesArray[1])[0], $orderBy, $orderMode);
        }

    }
    /* =================================================
    PETICIONES POST
    =================================================*/
    if (count($routesArray) == 1 &&
        isset($_SERVER["REQUEST_METHOD"]) &&
        $_SERVER["REQUEST_METHOD"] == "POST")
        {
    /* =================================================
    Contamos la cantidad de columnas que tiene una tabla
    =================================================*/
    $columns = array();
    $database = RoutesController::database();
    $response =PostController::getColumnsData(explode("?", $routesArray[1])[0],$database);

            if(isset($_POST)){
    /* =================================================
    Recibimos respuesta del controlador para cerar datos en cualquier tabla
    =================================================*/
                
                $response = new PostController();
                $response -> postData(explode("?", $routesArray[1])[0], $_POST);
foreach ($responde as $key => $value) {
    array_push($columns, $value->item);
}
/* Quitamos el primer y ultimo indice del array */
    array_shift($columns);#quito el primer indice de ID
    array_pop($columns); #quito el ultimo indice de date_uldated_at que es
    /* Recibimos los valores POST */
        if(isset($_POST)){
            $count = 0;
            foreach($columns as $key => $value){
               if(array_keys($_POST)[$key] == $value){
                $count++;
               }else{
                    $json = array(
                        "status" => 400,
                        "result" => "Error! Los campos enviados no coinciden con la DB"
                    );
                    echo json_encode($json, http_response_code($json["status"]));
                    return;
               }
            }
            /* Validamos que las variables POST coinciden con la DB */
            if($count == count($columns)){
                echo "coincide";
                return;
                /* Solicito respuesta del controller para crear los datos */
                $response = new PostController();
                $response -> postData(explode("?", $routesArray[1])[0], $_POST);
            }
        }
       
    }
}
    /* =================================================
    PETICIONES PUT
    =================================================*/
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

    /* =================================================
    PETICIONES DELETE
    =================================================*/
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