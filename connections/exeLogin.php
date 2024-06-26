<?php
$dir_fc = "../";
/*--------------------------------------------------------------------------------------------------------*/
include_once $dir_fc.'connections/php_config.php';
include_once $dir_fc.'connections/trop.php';
include_once $dir_fc.'data/users.class.php';
include_once $dir_fc.'common/function.class.php';

$cUsers	 =	new cUsers();
$cFn	 =	new cFunction();

$txtPass = "";
$txtUser = "";

$user          = "";
$pass          = "";
$in_out        = 1; //entrada
$id_usr        = NULL;
$id_aplicativo = NULL;

$done    = false;
$icon    = "error";
$resp    = "";

extract($_REQUEST);

try{

    if(!isset($txtUser) || empty($txtUser) || empty($txtPass)){
        throw new Exception("Lo campos están vacios");
    }

    $cUsers->setUsuario($cFn->get_sub_string($txtUser,40));
    $cUsers->setClave(md5($txtPass));

    $selectUser = $cUsers->getUser();

    $num_rows   = 0;
    $carpeta_go = "";
    $tipo       = gettype($selectUser);
    
    if($tipo == "string"){
        $user   = $txtUser;
        $pass   = md5($txtPass);
        $reject = 1;
        throw new Exception("Ocurrió un incoveniente con los datos insertados.");
    }

    $datos = $selectUser->fetch(PDO::FETCH_ASSOC);
    if($selectUser->rowCount() == 0){

        $user   = $txtUser;
        $pass   = md5($txtPass);
        $reject = 1;
        // $bandera_log = true;
        $resp   = "No existen coincidencias con las credenciales ingresadas";


    }else{

        session_start();
            
        $_SESSION[s_ncompleto]  = $datos['nombrecompleto'];
        $_SESSION[s_nombre]     = $datos['nombre'];
        $_SESSION[s_sexo]       = $datos['sexo'];
        $_SESSION[s_img]        = $datos['img'];
        $_SESSION[s_f_i]        = $datos['fecha_ingreso'];
        $_SESSION[id_usr]       = $datos['id_usuario'];
        $_SESSION[user]         = $datos['usuario'];
        $_SESSION[id_rol]       = $datos['id_rol'];
        $_SESSION[rol]          = $datos['rol'];
        $_SESSION[admin]        = $datos['admin'];     
        $_SESSION[id_direccion] = $datos['id_direccion'];
        $_SESSION[id_area]      = $datos['id_area'];
        $carpeta_go		        = $datos["carpeta"];  

        $cUsers->setId_usuario($_SESSION[id_usr]);

        if($carpeta_go == ""){
            
            $resp = "?controller=business&action=show";

        }else{

            $resp = $carpeta_go;
        }

        $icon = "success";
        $done = true;
    }    
    
}catch(\Exception $e){
    $resp .= $e->getMessage();
    
}

echo json_encode(array("done" => $done,
                       "goto" => $resp,
                       "icon" => $icon));
