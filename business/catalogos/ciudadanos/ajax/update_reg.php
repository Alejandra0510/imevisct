<?php 
session_start();
$dir_fc = "../../../../";
/*-----------------------------------------------------------------------------------------------*/
include_once $dir_fc."connections/trop.php";
include_once $dir_fc."connections/php_config.php";
include_once $dir_fc."common/function.class.php";
include_once $dir_fc."data/cat_ciudadanos.class.php";

$cData = new cCiudadanos();
$cFn   = new cFunction();

$done = false;
$icon = "error";
$resp = "";

$id_ciudadano = "";
$nombre       = "";         
$apepa        = "";         
$apema        = "";         
$id_t_c       = "";         
$id_t_t       = "";         
$id_edo       = "";         
$id_mpo       = "";         
$id_col       = "";         
$id_calle     = "";             
$id_calle_1   = "";             
$id_calle_2   = "";             
$cp           = "";     
$num_ext      = ""; 
$num_int      = "";
$tel_fijo     = "";             
$tel_cel      = "";   
$correo       = "";

$id_usr_cap = "";

extract($_REQUEST);

try{

    if(!isset($nombre) || !isset($apema)  || !isset($apepa)  || !isset($id_t_c)   || !isset($id_t_t)       || 
       !isset($id_edo) || !isset($id_mpo) || !isset($id_col) || !isset($id_calle) || !isset($id_ciudadano) ||
       $nombre == ""   || $apepa == ""    || $apema == ""    || $id_t_c == ""     || $id_t_t == ""         || 
       $id_edo == ""   || $id_mpo == ""   || $id_col == ""   || $id_calle == ""   || $id_ciudadano == ""){
        throw new Exception("No se recibieron correctamente los parámetros");
    }

    if(!isset($_SESSION[id_usr]) || $_SESSION[id_usr] == "" || !is_numeric($_SESSION[id_usr])){
        throw new Exception("Inicia sesión nuevamente");
    }

    if(isset($correo) && $correo != ""){
        if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){
            throw new Exception("Email inválido");
        }
    }

    $id_usr_cap = $_SESSION[id_usr];

    $data = array(
        $id_t_c,
        $id_t_t,
        $id_col,
        $id_calle,
        $id_calle_1,
        $id_calle_2,
        $id_usr_cap,
        $cFn->get_sub_string($nombre, 200),
        $cFn->get_sub_string($apepa, 200),
        $cFn->get_sub_string($apema, 200),
        $num_ext,
        $num_int,
        $cp,
        $tel_fijo,
        $tel_cel,
        $cFn->get_sub_string($correo, 80),
        $id_ciudadano
    );

    $update = $cData->updateReg( $data );
    if(!is_numeric($update)){
        $icon = "error";
        throw new Exception("Error al actualizar el registro");
    }

    $done = true;
    $icon = "success";
    $resp = "Registro editado correctamente";
    
}catch(\Exception $e){
    $resp .= $e->getMessage();
}

$cData->closeOut();

echo json_encode(array("done" => $done,     
                       "resp" => $resp,
                       "icon" => $icon));

