<?php 
session_start();
$dir_fc = "../../../../";
/*-----------------------------------------------------------------------------------------------*/
include_once $dir_fc."connections/trop.php";
include_once $dir_fc."connections/php_config.php";
include_once $dir_fc."data/users.class.php";

$cData = new cUsers();

$done = false;
$icon = "error";
$resp = "";

$name_s = "";
$user_s = "";
$id_r_s = "";

$_SESSION[array_filtros] = array();

extract($_REQUEST);

try{

    if($name_s == "" && $user_s == "" && $id_r_s == ""){
        throw new Exception("Debes ingresar un término de busqueda como mínimo");
    }

    $_SESSION[array_filtros] = array(
        "idrs" => $id_r_s,
        "nams" => $name_s,
        "usrs" => $user_s
    );

    if($name_s != ""){
        $resp .= " Nombre: ".$name_s;
    }

    if($user_s != ""){
        $resp .= " Usuario: ".$user_s;
    }

    if($id_r_s != ""){
        $get_roles = $cData->getRoles( $_SESSION[id_rol] );
        $resp .= " Perfil: ".$get_roles[$id_r_s];
    }
    
    $done = true;   

}catch(\Exception $e){
    $resp .= $e->getMessage();
}

$cData->closeOut();

echo json_encode(array("done" => $done,
                       "resp" => $resp,
                       "icon" => $icon));