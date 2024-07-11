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

$txtBuscar = "";      
$col_s     = "";

$_SESSION[array_filtros] = array();

extract($_REQUEST);

try{

    if($txtBuscar == "" && $col_s == ""){
        throw new Exception("Debes de agregar un termino de busqueda como minímo");
    }

    $_SESSION[array_filtros] = array(
        "str_b" => $txtBuscar,
        "col_b" => $col_s
    );

    if($txtBuscar != ""){
        $resp .= "Calle: ".$txtBuscar;
    }


    if($col_s != ""){
        $get_comunidades = $cData->getComunidades();

        $resp .= " Comunidad: ".$get_comunidades[$col_s];
    }

    $done = true;

}catch(\Exception $e){
    $resp .= $e->getMessage();
}

$cData->closeOut();

echo json_encode(array("done" => $done,
                       "resp" => $resp,
                       "icon" => $icon));

