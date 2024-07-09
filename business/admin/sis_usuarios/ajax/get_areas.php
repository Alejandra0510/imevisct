<?php 
session_start();
$dir_fc = "../../../../";
/*-----------------------------------------------------------------------------------------------*/
include_once $dir_fc."connections/trop.php";
include_once $dir_fc."connections/php_config.php";
include_once $dir_fc."common/function.class.php";

$cFn = new cFunction();

$done = false;
$icon = "error";
$resp = "";

$dependencia = "";
$area        = "";

extract($_REQUEST);

try{

     if(!isset($dependencia) || !is_numeric($dependencia) || $dependencia == ""){
        throw new Exception("No se recibieron los parámetros adecuadamente");
    }

    $areas = $cFn->getApiAreaByDir( $dependencia, 0, 0, 1 );
    foreach ($areas as $value) {
        
        $sel = "";
        if($value->id == $area){
            $sel = "selected";
        }

       $resp .= "<option value='$value->id' $sel > $value->nombre </option>";
    }

    $done = true;
    
    
}catch(\Exception $e){

    $resp .= $e->getMessage();

}

echo json_encode(array("done" => $done,     
                       "resp" => $resp,
                       "icon" => $icon));

