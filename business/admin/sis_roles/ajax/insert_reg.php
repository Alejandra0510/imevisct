<?php 
session_start();
$dir_fc = "../../../../";
/*-----------------------------------------------------------------------------------------------*/
include_once $dir_fc."connections/trop.php";
include_once $dir_fc."connections/php_config.php";
include_once $dir_fc."common/function.class.php";
include_once $dir_fc."data/rol.class.php";

$cData = new cRol();
$cFn   = new cFunction();

$done     = false;
$icon     = "warning";
$resp     = "";
$resp_dtl = "";

$rol              = "";   
$desc_rol         = "";
$menus            = array();
$grupo            = array();
$permiso_imp      = array();   
$permiso_nuevo    = array();   
$permiso_edit     = array();   
$permiso_elim     = array();   
$permiso_exportar = array();     

$imp        = 0;
$nue        = 0;
$edt        = 0;
$exp        = 0;
$elm        = 0;
$id_usr_cap = "";

extract($_REQUEST);

try{
    if(!isset($_SESSION[id_usr]) || !isset($rol) || !isset($desc_rol) ||
       $_SESSION[id_usr] == ""   || $rol == ""   || $desc_rol == ""){
        throw new Exception("Debes de completar los campos obligatorios");
    }


    $id_usr_cap = $_SESSION[id_usr];

    $data = array(
        0,
        $cFn->get_sub_string($rol, 100),
        $cFn->get_sub_string($desc_rol, 250)
    );


    $insert = $cData->insertReg( $data );
    if(!is_numeric($insert)){
        $icon = "error";
        throw new Exception("No se creó el registro, intentalo nuevamente");
    }


    if(isset($menus)){
        foreach ($menus as $key => $value) {
            if(isset($grupo)){
                $gpo = $grupo[$value];
                if($gpo <> 0){
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
                    $insert,
                    $value,
                    $imp,
                    $edt,
                    $elm,
                    $nue,
                    $exp
                );

                $insert_dtl = $cData->insertRegdtl( $data_dtl );
            }
        }
    }

    if(!is_numeric($insert_dtl)){
        $icon = "warning";
        $resp_dtl = "no se creó el detalle";
    }else{
        $icon = "success";
        $resp_dtl = "y detalle agregado correctamente";
    }


    $done = true;
    $resp = "Registro creado correctamente ".$resp_dtl;


}catch(\Exception $e){
    $resp .= $e->getMessage();
}


$cData->closeOut();

echo json_encode(array("done" => $done,
                       "resp" => $resp,
                       "icon" => $icon));