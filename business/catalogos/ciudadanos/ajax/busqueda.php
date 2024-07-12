<?php 
session_start();
$dir_fc = "../../../../";
/*-----------------------------------------------------------------------------------------------*/
include_once $dir_fc."connections/trop.php";
include_once $dir_fc."connections/php_config.php";
include_once $dir_fc."data/cat_ciudadanos.class.php";

$cData = new cCiudadanos();

$done = false;
$icon = "error";
$resp = "";

$txtBuscar = "";          
$mun_s     = "";      
$col_s     = "";      
$cont_s    = "";      
$ciud_s    = "";      

$_SESSION[array_filtros] = array();

extract($_REQUEST);

try{

    if($txtBuscar == "" && $col_s == "" && $mun_s == "" && $cont_s == "" && $ciud_s == ""){
        throw new Exception("Debes de agregar un termino de busqueda como minímo");
    }

    $_SESSION[array_filtros] = array(
        "ciu_b" => $txtBuscar,
        "col_b" => $col_s,
        "mun_b" => $mun_s,
        "ctt_b" => $cont_s,
        "tcd_b" => $ciud_s
    );

    if($txtBuscar != ""){
        $resp .= "Ciudadano: ".$txtBuscar;
    }

    if($col_s != ""){
        $get_comunidades = $cData->getComunidades();

        $resp .= " Comunidad: ".$get_comunidades[$col_s];
    }

    if($mun_s != ""){
        $get_municipios  = $cData->getMunicipios();

        $resp .= " Municipio: ".$get_municipios[$mun_s];
    }

    if($ciud_s != ""){
        $get_tciudadanos = $cData->getTCiudadanos();

        $resp .= " Tipo de ciudadano: ".$get_tciudadanos[$ciud_s];
    }

    if($cont_s != ""){
        $get_tcontacto   = $cData->getTContacto();

        $resp .= " Tipo de contacto: ".$get_tcontacto[$cont_s];
    }

    $done = true;

}catch(\Exception $e){
    $resp .= $e->getMessage();
}

$cData->closeOut();

echo json_encode(array("done" => $done,
                       "resp" => $resp,
                       "icon" => $icon));

