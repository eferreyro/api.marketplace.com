<?php 
class GetController{
 /* Peticiones GET sin filtros */   
 public function getData($table){
     $response = GetModel::getData($table);
     $return = new GetController();
     $return -> fncResponse($response, "getData");
     
    }

    /* Peticiones GET con filtros */

    public function getFilterData($table, $linkTo, $equalTo)
    {
        $response = GetModel::getFilterData($table, $linkTo, $equalTo);
        $return = new GetController();
        $return->fncResponse($response, "getFilterData");
    }
    /* =================================================
    Peticiones GET de TABLAS RELACIONADAS sin filtro 
    =================================================*/
    public function getRelData($rel, $type)
    {
        $response = GetModel::getRelData($rel, $type);
        $return = new GetController();
        $return->fncResponse($response, "getRelData");
    }

    /* =================================================
    Peticiones GET de TABLAS RELACIONADAS CON filtro 
    =================================================*/
    public function getRelFilterData($rel, $type, $linkTo, $equalTo)
    {
        $response = GetModel::getRelFilterData($rel, $type, $linkTo, $equalTo);
        $return = new GetController();
        $return->fncResponse($response,
            "getRelData"
        );
    }
    /* =================================================
        Funcion GET para el Buscador
     =================================================*/
    
    public function getSearchData($table, $linkTo, $search)
    {
        $response = GetModel::getSearchData($table, $linkTo, $search);
        $return = new GetController();
        $return->fncResponse($response,
            "getSearchData"
        );
    }
    /* =================================================
        Funcion de Respuesta GET del Controller
     =================================================*/
    public function fncResponse($response, $method){
        if (!empty($response)) {
            $json = array(
                "status" => 200,
                "total" => count($response),
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
