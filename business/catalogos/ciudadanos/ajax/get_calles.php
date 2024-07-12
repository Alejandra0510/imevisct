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

$colonia = ""; 
$calles  = "";
$cod_ps  = "";   

extract($_REQUEST);

try{

    if(!isset($colonia) || !is_numeric($colonia) || $colonia == ""){
        throw new Exception("No se recibieron correctamente los parámetros");
    }

    $get_calles = $cData->getCallesById( $colonia );
    foreach ($get_calles as $key => $value) {
        $calles .= "<option value='$key'> $value </option>";
    }
  
    $cod_ps = $cData->getCpById( $colonia );

    $done = true;

}catch(\Exception $e){
    $resp .= $e->getMessage();
}

$cData->closeOut();

echo json_encode(array("done"   => $done,
                       "resp"   => $resp,
                       "icon"   => $icon,
                       "calles" => $calles,
                       "codpos" => $cod_ps));

