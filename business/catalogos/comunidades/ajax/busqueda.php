<?php 
session_start();
$dir_fc = "../../../../";
/*-----------------------------------------------------------------------------------------------*/
include_once $dir_fc."connections/trop.php";
include_once $dir_fc."connections/php_config.php";
include_once $dir_fc."data/cat_comunidades.class.php";

$cData = new cComunidades();

$done = false;
$icon = "error";
$resp = "";

$txtBuscar = "";          
$ast_s     = "";      
$sec_b     = "";          

$_SESSION[array_filtros] = array();

extract($_REQUEST);

try{

    if($txtBuscar == "" && $ast_s == "" && $sec_b == "" ){
        throw new Exception("Debes de agregar un termino de busqueda como minímo");
    }

    $_SESSION[array_filtros] = array(
        "col" => $txtBuscar,
        "ast" => $ast_s,
        "sec" => $sec_b
    );

    if($txtBuscar != ""){
        $resp .= " Comunidad: ".$txtBuscar;
    }

    if($sec_b != ""){
        $resp .= " Sector: ".$sec_b;
    }

    if($ast_s != ""){
        $get_asentamiento = $cData->getTAsentamiento();
        $resp .= " Tipo de asentamiento: ".$get_asentamiento[$ast_s];
    }

    $done = true;

}catch(\Exception $e){
    $resp .= $e->getMessage();
}

$cData->closeOut();

echo json_encode(array("done" => $done,
                       "resp" => $resp,
                       "icon" => $icon));

