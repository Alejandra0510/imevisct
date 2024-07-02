<?php 
session_start();
$dir_fc = "../../../../";
/*-----------------------------------------------------------------------------------------------*/
include_once $dir_fc."connections/trop.php";
include_once $dir_fc."connections/php_config.php";

$done = false;
$icon = "error";
$resp = "";

$txtBuscar = "";      
$desc_s    = "";  

$_SESSION[array_filtros] = array();

extract($_REQUEST);

try {
    
    if($txtBuscar == "" && $desc_s == ""){
        throw new Exception("Debes ingresar un término de busqueda como mínimo");
    }

    $_SESSION[array_filtros] = array(
        "rolb" => $txtBuscar,
        "desb" => $desc_s
    );

    if($txtBuscar != ""){
        $resp .= " Rol: ".$txtBuscar;
    }

    if($desc_s != ""){
        $resp .= " Descripción: ".$desc_s;
    }

    $done = true;


} catch (\Throwable $th) {
    $resp .= $th;
}

echo json_encode(array("done" => $done,
                       "resp" => $resp,
                       "icon" => $icon));