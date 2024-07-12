<?php
$dir_fc       = "";
/*-----------------------------------------------------------------------------------------------*/
include_once $dir_fc.'connections/trop.php';
include_once $dir_fc.'connections/php_config.php';

extract($_REQUEST);

$current_file = basename($_SERVER["PHP_SELF"]);
$dir          = dirname($_SERVER['PHP_SELF'])."/".$controller;
$checkMenu    = $server_name.$dir."/";    
$param        = "?controller=".$controller."&action=";

$sys_id_men   = 2;
$sys_tipo     = 1;

$titulo_curr  = "Usuario"; 
$ruta_app     = "";

include_once $dir_fc."common/function.class.php";
include_once $dir_fc."data/inicial.class.php";
include_once $dir_fc."data/users.class.php";

$cInicial = new cInicial();
$cFn      = new cFunction();
$cEditar  = new cUsers();

include 'business/sys/check_session.php';

$showinfo    = true;
$titulo_edi  = "Visualizando";

if($_SESSION[_is_view_] == 1){
    $titulo_edi = "Editando";
}

if(!isset($pag)){ $pag=1;}
if(!isset($busqueda) || $busqueda == ""){$busqueda = "";}
$return_paginacion = "&pag=".$pag."&busqueda=".$busqueda;

if(!isset($_SESSION[_editar_]) || !is_numeric($_SESSION[_editar_]) || $_SESSION[_editar_]<= 0){
    $showinfo = false;
}else {
    $id = $_SESSION[_editar_];
    $cEditar->setId_usuario($id);
    $rsEditar = $cEditar->getRegbyid();
    if ($rsEditar->rowCount() > 0) {
        $arrEdi       = $rsEditar->fetch(PDO::FETCH_OBJ);
        $id_usuario   = $arrEdi->id_usuario;               
        $id_rol       = $arrEdi->id_rol;           
        $id_direccion = $arrEdi->id_direccion;                   
        $id_area      = $arrEdi->id_area;               
        $usuario      = $arrEdi->usuario;               
        $id_genero    = $arrEdi->id_genero;               
        $nombre       = $arrEdi->nombre;           
        $apepa        = $arrEdi->apepa;           
        $apema        = $arrEdi->apema;           
        $correo       = $arrEdi->correo;           
        $admin        = $arrEdi->admin; 
        $id_dir_ext   = $arrEdi->id_dir_ext;
    } else {
        $showinfo = false;
    }

}

$direccion    = ( isset($_SESSION[array_data_dr]) && !empty($_SESSION[array_data_dr]) ) ? $_SESSION[array_data_dr] : '';
$get_roles    = $cEditar->getRoles( $_SESSION[id_rol] );
$get_externas = $cEditar->getDepExternas();



?>
<!DOCTYPE html>
<html>
<head>
    <title> <?php echo $titulo_edi.' '.$titulo_curr?> | <?php echo $titulo_paginas?> </title>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <?php include("dist/inc/headercommon.php"); ?>
    <link rel="stylesheet" type="text/css" href="dist/assets/css/select2.min.css?v=1.001">
</head>
<body class="menubar-hoverable header-fixed">
    <?php include($dir_fc."inc/header.php")?>
    <div id="base">
        <div class="offcanvas"></div>
        <div id="content">
            <section>
                <div class="section-body contain-lg">
                    <div class="row">
                        <div class="col-lg-8"></div>
                        <div class="col-lg-4">
                            <ol class="breadcrumb pull-right">
                                <li>
                                    <a href="<?php echo $raiz?>">
                                        Inicio
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo $param."index"?>">
                                        Lista de Usuarios
                                    </a>
                                </li>
                                <li class="active">
                                    <?php echo $titulo_edi.' '.$titulo_curr?>
                                </li>
                            </ol>
                        </div>
                    </div>
                    <?php 
                    if($_SESSION[edit] == "1" && $showinfo == true){
                        ?>
                        <div class="card">
                            <div class="card-head style-accent-bright">
                                <div class="tools pull-left">
                                    <a href="<?php echo $param."index".$return_paginacion?>"
                                       class="btn ink-reaction btn-floating-action"
                                       style="background-color: #00796b; color: #fff;"
                                       title="Regresar a la lista">
                                        <i class="fa fa-arrow-left"></i>
                                    </a>
                                </div>
                                <header>
                                    <?php echo $titulo_edi.' '.$titulo_curr?>
                                </header>
                            </div>
                            <div class="card-body">
                                <form class="form" role="form" id="frm_edit">
                                    <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id?>">
                                    <input type="hidden" name="current_file" id="current_file" value="<?php echo $param?>">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <fieldset>
                                                <p class="lead">
                                                    Datos del <?php echo $titulo_curr?>
                                                </p>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="text"
                                                                    class="form-control"
                                                                    id="nombre"
                                                                    name="nombre"
                                                                    required
                                                                    autocomplete="off"
                                                                    value="<?php echo $nombre?>" />
                                                            <label for="nombre">
                                                                Nombre(s) <span class="text-danger">*</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="text"
                                                                    class="form-control"
                                                                    id="ape_pa"
                                                                    name="ape_pa"
                                                                    required
                                                                    autocomplete="off" 
                                                                    value="<?php echo $apepa?>" />
                                                            <label for="ape_pa">
                                                                Apellido Paterno <span class="text-danger">*</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="text"
                                                                    class="form-control"
                                                                    id="ape_ma"
                                                                    name="ape_ma"
                                                                    required
                                                                    autocomplete="off" 
                                                                    value="<?php echo $apema?>" />
                                                            <label for="ape_ma">
                                                                Apellido Materno <span class="text-danger">*</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="text"
                                                                    class="form-control"
                                                                    autocomplete="off"
                                                                    id="user_n"
                                                                    name="user_n"
                                                                    value="<?php echo $usuario?>" 
                                                                    readonly />
                                                            <label for="user_n">
                                                                Usuario <span class="text-danger">*</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="email"
                                                                    class="form-control"
                                                                    autocomplete="off"
                                                                    id="correo"
                                                                    name="correo"
                                                                    value="<?php echo $correo?>" />
                                                            <label for="correo">
                                                                Correo <span class="text-danger">*</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <select name="genero" 
                                                                    id="genero"
                                                                    class="form-control"
                                                                    required>
                                                                <option value="">Seleccione una opción</option>    
                                                                <option value="1" <?php if($id_genero == "1"){ echo "selected"; }?>>Femenino</option>    
                                                                <option value="2" <?php if($id_genero == "2"){ echo "selected"; }?>>Masculino</option>    
                                                            </select>
                                                            <label for="genero">
                                                                Género <span class="text-danger">*</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <select name="id_direccion" 
                                                                    id="id_direccion"
                                                                    class="form-control">
                                                                <option value="">Seleccione una opción</option>    
                                                                <?php 
                                                                    foreach ($direccion as $value) {
                                                                        $sel = "";
                                                                        if($value->id == $id_direccion){
                                                                            $sel = "selected";
                                                                        }
                                                                        ?>
                                                                        <option value="<?php echo $value->id?>" <?php echo $sel?>> <?php echo $value->nombre?> </option>
                                                                        <?php
                                                                    }
                                                                ?>
                                                            </select>
                                                            <label for="id_direccion">
                                                                Dirección
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <input type="hidden" name="area_val" id="area_val" value="<?php echo $id_area?>">
                                                            <select name="id_area" 
                                                                    id="id_area"
                                                                    class="form-control">
                                                            </select>
                                                            <label for="id_area">
                                                                Área
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <select name="id_dir_ext" 
                                                                    id="id_dir_ext"
                                                                    class="form-control">
                                                                <option value="">Seleccione una opción</option>
                                                                <?php 
                                                                foreach ($get_externas as $key_e => $value_e) {
                                                                    $sel_e = "";
                                                                    if($key_e == $id_dir_ext){
                                                                        $sel_e = "selected";
                                                                    }
                                                                    ?>
                                                                        <option value="<?php echo $key_e?>" <?php echo $sel_e?> > <?php echo $value_e?> </option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                            <label for="id_dir_ext">
                                                                Dependencia Externa
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <?php 
                                                        if(isset($_SESSION[admin]) && $_SESSION[admin] == 1){
                                                            ?>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <select name="id_t_usr" 
                                                                            id="id_t_usr"
                                                                            class="form-control">
                                                                        <option value="">Seleccione una opción</option>                                                       
                                                                        <option value="0" <?php if($admin == "0"){ echo "selected"; }?>>Usuario Estándar</option>
                                                                        <option value="1" <?php if($admin == "1"){ echo "selected"; }?>>Usuario Administrativo</option>
                                                                    </select>
                                                                    <label for="id_t_usr">
                                                                        Tipo de usuario <span class="text-danger">*</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <select name="id_rol_usr" 
                                                                        id="id_rol_usr"
                                                                        class="form-control"
                                                                        onchange="getMenus()"
                                                                        required>
                                                                    <option value="">Seleccione una opción</option>  
                                                                    <?php 
                                                                    foreach ($get_roles as $key => $value) {
                                                                        $sel_r = "";
                                                                        if($key == $id_rol){
                                                                            $sel_r = "selected";
                                                                        }
                                                                        ?>
                                                                        <option value="<?php echo $key?>" <?php echo $sel_r?>> <?php echo $value?> </option>
                                                                        <?php
                                                                    }
                                                                    ?>  
                                                                </select>
                                                                <label for="id_rol_usr">
                                                                    Perfil <span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                </div>
                                            </fieldset>
                                            <br>
                                            <!-- Menús -->
                                             <fieldset>
                                                <p class="lead">
                                                    Permisos por default
                                                </p>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <article id="permisos">
                                                            <div class="permisos-field">
                                                                <div class="checkbox checkbox-styled checkbox-danger">
                                                                    <label>
                                                                        <input type="checkbox"
                                                                            name="ckSelectAll"
                                                                            id="ckSelectAll"
                                                                            value="1"
                                                                            title="Imprimir registros" />
                                                                        <span>
                                                                            Seleccionar todos
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                <div id="permisos_ajax"></div>
                                                            </div>
                                                        </article>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <?php 
                                                if($_SESSION[_is_view_] == 1){
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-4 col-xs-12 col-lg-4 col-md-offset-8">
                                                            <button type="submit" 
                                                                    id="btn_guardar_e"
                                                                    class="btn ink-reaction btn-block btn-primary">
                                                                <span class="glyphicon glyphicon-floppy-disk"></span> 
                                                                Guardar
                                                            </button>
                                                        </div>  
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </fieldset>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                    }else{
                        include("../../sys/permissions_d.php");
                    }
                    ?>
                </div>
            </section>
        </div>
        <?php include($dir_fc."inc/menucommon.php")?>
    </div>
    <?php include("dist/components/usuarios.magnament.php");?>
    <script src="dist/assets/js/select2.full.min.js"></script>
</body>
</html>
