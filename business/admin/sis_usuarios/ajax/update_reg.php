<?php 
session_start();
$dir_fc = "../../../../";
/*-----------------------------------------------------------------------------------------------*/
include_once $dir_fc."connections/trop.php";
include_once $dir_fc."connections/php_config.php";
include_once $dir_fc."common/function.class.php";
include_once $dir_fc."data/users.class.php";

$cData = new cUsers();
$cFn   = new cFunction();

$done     = false;
$icon     = "error";
$resp     = "";
$resp_dtl = "";

$id_usuario       = "";
$nombre           = "";       
$ape_pa           = "";       
$ape_ma           = "";       
$user_n           = "";       
$password         = "";           
$correo           = "";       
$genero           = "";       
$id_direccion     = "";               
$id_area          = "";           
$id_t_usr         = "";           
$id_rol_usr       = ""; 
$permiso_imp      = array();   
$permiso_nuevo    = array();    
$permiso_edit     = array();   
$permiso_elim     = array();   
$permiso_exportar = array();       
$grupo            = array();

$externo    = "";
$id_usr_cap = "";
$img        = "";
$user_admin = "";

extract($_REQUEST);

try{

    if(!isset($nombre)      || !isset($ape_pa)          || !isset($ape_ma) || !isset($user_n) || !isset($genero)      || !isset($id_rol_usr)      || 
        $nombre == ""       || $ape_pa == ""            || $ape_ma == ""   || $user_n == ""   || !is_numeric($genero) || !is_numeric($id_rol_usr) ||
        !isset($id_usuario) || !is_numeric($id_usuario) || $id_usuario == ""){
        throw new Exception("No se recibieron los parámetros adecuadamente");
    }

    if(!isset($_SESSION[id_usr]) || !is_numeric($_SESSION[id_usr]) || $_SESSION[id_usr] == ""){
        throw new Exception("Inicia sesión nuevamente");
    }

    if($correo != "" && $correo != null){
        if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){
            throw new Exception("Dirección de correo no válida");
        }
    }

    $id_usr_cap = $_SESSION[id_usr];

    $externo = ( $id_direccion == "" || $id_direccion == NULL ) ? 1 : NULL;

    $direccion = ($id_direccion == "") ? NULL : $id_direccion;
    $area      = ($id_area == "") ? NULL : $id_area;

    if(isset($_SESSION[admin]) && $_SESSION[admin] == 1){
        $user_admin = $id_t_usr;
    }else{
        $user_admin = 0;
    }

    $img = ( $genero == 1) ? 'avatar_1.png' : 'avatar_2.png';

    $data = array(
        $direccion,
        $area,
        $id_rol_usr,
        $genero,
        $id_usr_cap,
        $cFn->get_sub_string($nombre, 150),
        $cFn->get_sub_string($ape_pa, 150),
        $cFn->get_sub_string($ape_ma, 150),
        $cFn->get_sub_string($correo, 100),
        $user_admin,
        $img,
        $externo,
        $id_usuario
    );

    $update = $cData->updateReg( $data );
    if(!is_numeric($update)){
        $icon = "error";
        throw new Exception("Error al editar el registro, intentaló nuevamente");
    }

    $delete = $cData->deleteDtl( $id_usuario );
    
    if(isset($menus)){
 
        foreach ($menus as $key => $value) {

            $imp        = 0;
            $nue        = 0;
            $edt        = 0;
            $exp        = 0;
            $elm        = 0;

            if(isset($grupo)){

                $gpo = $grupo[$value];
                if($gpo != 0){
                    if(isset($permiso_imp[$value])){
                        $imp = $permiso_imp[$value];
                    }

                    if(isset($permiso_nuevo[$value])){
                        $nue = $permiso_nuevo[$value];
                    }

                    if(isset($permiso_edit[$value])){
                        $edt = $permiso_edit[$value];
                    }

                    if(isset($permiso_exportar[$value])){
                        $exp = $permiso_exportar[$value];
                    }

                    if(isset($permiso_elim[$value])){
                        $elm = $permiso_elim[$value];
                    }   
                }

                $data_dtl = array(
                    $id_usuario,
                    $value,
                    $imp,
                    $edt,
                    $elm,
                    $nue,
                    $exp
                );

                $insert_dtl = $cData->insertRegDtl( $data_dtl );
                if(!is_numeric($insert_dtl)){
                    $icon     = "warning";
                    $resp_dtl = ", error al agregar los permisos";
                }else{
                    $icon     = "success";
                    $resp_dtl = "permisos agregados";
                }
            }
        }

    }

    $done = true;
    $resp = "Registro editado correctamente ".$resp_dtl;   
    
}catch(\Exception $e){

    $resp .= $e->getMessage();

}

$cData->closeOut();

echo json_encode(array("done" => $done,     
                       "resp" => $resp,
                       "icon" => $icon));

