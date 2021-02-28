<?php

class PostController{
    /*=============================
        Peticion para capturar los nombres de columnas de una DB
    =============================*/
    static public function getColumnsData($table, $database){
        $response = PostModel::getColumnsData($table, $database);
        return $response;
    }
    /*=============================
        Peticion POST para crear DATOS
    =============================*/
    public function postData($table, $data){
        $response = PostModel::postData($table, $data);
        $return = new PostController();
        $return -> fncResponse($response, "postData");
       
    }
     /*=============================
        Respuesta del Controlador
     =============================*/
    public function fncResponse($response, $method){
    if (!empty($response)) {
     $json = array(
        "status" => 200,
        "result" => $response
        );
    } else {
        $json = array(
            "status" => 404,
            "result" => "Not Found",
            "method" => $method
        );
    }
    echo json_encode($json, http_response_code($json["status"]));

    return;
    }
}