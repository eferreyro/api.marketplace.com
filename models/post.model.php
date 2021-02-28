            <?php 

require_once "connection.php";

class PostModel{

    /*=============================
    Peticion para capturar los nombres de columnas en la DB
     =============================*/
    static public function getColumnsData($table, $database){
        return Connection::connect()->query("SELECT COLUMN_NAME AS item FROM information_schema = '$database' AND table_name = '$table'")
                                    ->fetchAll(PDO::FETCH_OBJ);
        

    }
    /*=============================
    Peticion POST para crear datos
     =============================*/
     static public function postData($table, $data){

        $columns = " (";
        $params = "(";
        foreach ($data as $key => $value) {
            $columns .= $key.",";
            $params .= ":" .$key . ",";
            
        }
        $columns = substr($columns, 0 ,-1); //El 0 no toca los caracteres y el -1 borra desde la derecha el primero.
        $params = substr($columns, 0, -1);
        $columns .= ")";
        $params .= ")";
        $stmt = Connection::connect()->prepare("INSERT INTO $table $columns VALUES $params");
        
        foreach ($data as $key => $value) {
            $stmt->bindparam(":".$key, $data[$key], PDO::PARAM_STR);
        }

        if($stmt->execute()){
            return"The process was successful";
        }else{
            echo Connection::connect()->errorInfo();
        }
        


     }
}