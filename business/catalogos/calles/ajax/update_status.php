<?php 
session_start();
$dir_fc = "../../../../";
/*-----------------------------------------------------------------------------------------------*/
include_once $dir_fc."connections/trop.php";
include_once $dir_fc."connections/php_config.php";
include_once $dir_fc."data/cat_calles.class.php";

$cData = new cCalles();

$done = false;
$icon = "error";
$resp = "";

$id    = "";  
$tipo  = "";      
extract($_REQUEST);

try{

     if(!isset($id)   || !is_numeric($id)   || $id == ""   || 
        !isset($tipo) || !is_numeric($tipo) || $tipo == ""){
        throw new Exception("No se recibieron los parámetros adecuadamente");
    }


    $cData->setId_calle($id);
    if($tipo == 3){

        $do = $cData->deleteReg();

        $action = 4;
        $txt_r  = "eliminado";

    }else{

        $do = $cData->updateStatus($tipo);

        $action = 3;
        if($tipo == 0){
            $txt_r = "inactivo";
        }else{
            $txt_r  = "activado";
        }
    }

    if(!is_numeric($do)){
        $txte = "Error al actualizar el registro";
        throw new Exception("Ocurrió un inconveniente");
    }

    $done = true;
    $icon = "success";
    $resp = "Registro $txt_r";   
    
}catch(\Exception $e){

    $resp .= $e->getMessage();

}

$cData->closeOut();

echo json_encode(array("done" => $done,     
                       "resp" => $resp,
                       "icon" => $icon));

