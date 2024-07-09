<?php
session_start();
$dir_fc = "../../../";
/*------------------------------------------------------------------------------------------*/
include_once $dir_fc.'connections/trop.php'; 
include_once $dir_fc.'connections/php_config.php'; 
include_once $dir_fc.'data/users.class.php';

$cData = new cUsers();

$nuevaclave = "";
$confclave  = "";
$clave      = "";

$done = false;
$resp = "";
$icon = "warning";


extract($_REQUEST);

try{

    if(!isset($clave) || !isset($confclave) || !isset($nuevaclave) || 
       $clave == ""   || $confclave == ""   || $nuevaclave == ""){
        throw new Exception("Debes ingresar correctamente los datos");
    }

    
    $cData->setId_usuario($id_usr_cap);
    $cData->setClave(md5($clave));
    
    $rows   = $cData->getRegbyPW();
    if($rows == 0){
        $icon = "error";
        throw new Exception("Contraseña actual incorrecta");
    }

    if($nuevaclave != $confclave){
        $icon = "error";
        throw new Exception("Confirmación de contraseña no coincide");
    }

    $cData->setNvaclave(md5($nuevaclave));

    $msg = $cData->updateRegPW($current_date);
    if(!is_numeric($msg)){
        $icon = "error";
        throw new Exception("No se actualizó la contraseña, intentaló nuevamente");
    } 

    $done = true;
    $resp = "Tu contraseña ah sido actualizada correctamente. Reinicia tu sesión.";
    $icon = "success";

}catch(\Exception $e){
    $resp .= $e->getMessage();

}

$cData->closeOut(); 

echo json_encode(array("done" => $done,
                       "resp" => $resp,
                       "icon" => $icon));



