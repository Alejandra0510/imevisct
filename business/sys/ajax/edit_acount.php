<?php
session_start();
$dir_fc = "../../../";
/*-----------------------------------------------------------------------------------------------*/
include_once $dir_fc.'connections/trop.php'; //Inclueye configuración de fecha y  hora de mexico
include_once $dir_fc.'connections/php_config.php'; //Inclueye configuración de fecha y  hora de mexico
include_once $dir_fc.'data/users.class.php';

$cData = new cUsers();

$id_usuario = 0;
$id_rol     = 0;
$usuario    = "";
$nombre     = "";
$apepat     = "";
$apemat     = "";
$correo     = "";
$sexo       = "";
$clave      = "";

$done = false;
$resp = "";
$icon = "warning";

extract($_REQUEST);

try{

    if($usuario == "" || $nombre == "" || $apepat == "" || $apemat == "" || $sexo == ""){
        throw new Exception("Debes de ingresar correctamente los datos");
    }

    if(!isset($_SESSION[id_usr]) ||  $_SESSION[id_usr] == ""){
        throw new Exception("Inicia sesión nuevamente");
    }

    $id_usr_cap = $_SESSION[id_usr];

    $cData->setUsuario($usuario);
    $cData->setId_usuario($id_usr_cap);

    $userCoincidencia = $cData->foundUserConcidencia();
    if ($userCoincidencia == 1){
        //Si se encuentra coincidencia quiere decir que no cambio su nombre de usuario
        $userFound = 0;
    }else{
        //De lo contrario buscar si existe un usuario con el mismo nombre
        $userFound = $cData->foundUser();
    }

    if ($userFound>0) {
        throw new Exception("El usuario ya existe en la base de datos, favor de intentar con otro nombre de usuario");
    } 

    $cData->setNombre($nombre);
    $cData->setApePa($apepat);
    $cData->setApeMa($apemat);
    $cData->setCorreo($correo);
    $cData->setSexo($sexo);

    $update = $cData->updateRegacount();
    if(!is_numeric($update)){
        $icon = "error";
        throw new Exception("Error al actualizar la cuenta");
    } 

    $done = true;
    $resp = "Tu cuenta a sido actualizada correctamente.";
    $icon = "success";

}catch(\Exception $e){
    $resp .= $e->getMessage();

}

$cData->closeOut(); 

echo json_encode(array("done" => $done,
                       "resp" => $resp,
                       "icon" => $icon));
