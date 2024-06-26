<?php
//Incluyendo la conexión a la base de datos
require_once $dir_fc."connections/conn_data.php";
require_once $dir_fc."connections/php_config.php";

class cDbFunction extends BD
{
    private $conn;

    function __construct()
    {

        $this->conn = new BD();
    }

    function getCatalogo($tabla, $limit=NULL, $where=NULL)
    {
        $response = [];

        $query = "SELECT * FROM 
                $tabla
                WHERE 1 = 1 $where
                $limit";

        $result = $this->conn->prepare($query);
        $result->execute();

        if($result->rowCount())
        {
            while($rows = $result->fetch(PDO::FETCH_ASSOC))
            {
                $response[] = $rows;
            }
        }
        return $response;
    }

    function getInputSelect($options,$value,$name,$sel = NULL,$data = NULL)
    {
        $response[] = '<option value=""><!--Selecciona una opción--></option>';
        if(is_array($options))
        {
            foreach($options AS $option)
            {
                $selected=$sel==$option[$value] ? 'selected' : NULL;
                $response[]="<option $selected value='$option[$value]'>$option[$name]</option>";
            }
        }

        if(is_array($data))
        {
            foreach($options AS $key=>$option)
            {
                foreach($data AS $name)
                {
                    $response[$key+1]=str_replace("'>", "' data-$name='{$option[$name]}'>",$response[$key+1]);
                }
            }
        }

        return implode('',$response);
    }

    function getArrayCatalogo($tabla, $idKey, $column)
    {
        $response = [];

        $query = "SELECT * FROM $tabla";

        $result = $this->conn->prepare($query);
        $result->execute();

        if($result->rowCount())
        {
            while($rows = $result->fetch(PDO::FETCH_ASSOC))
            {
                $response[$rows[$idKey]] = $rows[$column];
            }
        }
        return $response;
    }

    function getArrayCatalogoToSelect($array) {
        $response = '<option value=""></option>';
        foreach($array AS $key => $value) {
            $response.= "<option value='$key'>$value</option>";
        }
        return $response;
    }

}