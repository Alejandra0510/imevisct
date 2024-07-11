<?php 
session_start();
$dir_fc = "../../../../";
/*-----------------------------------------------------------------------------------------------*/
include_once $dir_fc."connections/trop.php";
include_once $dir_fc."connections/php_config.php";
include_once $dir_fc."common/function.class.php";
include_once $dir_fc."data/cat_calles.class.php";

$cData = new cCalles();
$cFn   = new cFunction();

$done = false;
$icon = "error";
$resp = "";

$id_calle   = "";
$id_col     = "";    
$vialidad   = "";        
$name_calle = "";        

$id_usr_cap = "";

extract($_REQUEST);

try{

    if(!isset($id_col) || !isset($vialidad) || !isset($name_calle) || !isset($id_calle) ||
       $id_col == ""   || $vialidad == ""   || $name_calle == ""   || $id_calle == ""){
        throw new Exception("No se recibieron los parámetros correctamente");
    }

    if(!isset($_SESSION[id_usr]) || $_SESSION[id_usr] == ""){
        throw new Exception("Inicia sesión nuevamente");
    }

    $id_usr_cap = $_SESSION[id_usr];

    $data = array(
        $id_col,
        $vialidad,
        $id_usr_cap,
        $cFn->get_sub_string($name_calle, 60),
        $id_calle
    );

    // var_dump($data);

    $update = $cData->updateReg( $data );
    if(!is_numeric($update)){
        throw new Exception("Error al editar el registro, intetaló nuevamente");
    }

    $done = true;
    $icon = "success";
    $resp = "Registro editado correctamente";

    
}catch(\Exception $e){

    $resp .= $e->getMessage();

}

$cData->closeOut();

echo json_encode(array("done" => $done,     
                       "resp" => $resp,
                       "icon" => $icon));
