<?php
require_once "connection.php";
class GetModel
{
    /*Peticiones GET sin filtros */
    static public function getData($table)
    {
        $stmt = Connection::connect()->prepare("SELECT * FROM $table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /*Peticiones GET CON filtros */
    static public function getFilterData($table, $linkTo, $equalTo)
    {
        $stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $linkTo= :$linkTo");
        $stmt->bindParam(":" . $linkTo, $equalTo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

   /* Peticiones GET de TABLAS RELACIONADAS sin filtro */
    static public function getRelData($rel, $type)
    {
        $relArray = explode(",", $rel);
        $typeArray = explode(",", $type);
        $on1 = $relArray[0].".id_".$typeArray[0];
        $on2 = $relArray[1] . ".id_" . $typeArray[1];

        $stmt = Connection::connect()->prepare("SELECT * FROM $relArray[0] INNER JOIN $relArray[1] ON $on1 = $on2");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS);
        
    }
}


?>   