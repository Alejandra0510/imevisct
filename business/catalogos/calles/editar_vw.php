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

$sys_id_men   = 7;
$sys_tipo     = 1;

$titulo_curr  = "Calle"; 
$ruta_app     = "";

include_once $dir_fc."common/function.class.php";
include_once $dir_fc."data/inicial.class.php";
include_once $dir_fc."data/cat_calles.class.php";

$cInicial = new cInicial();
$cFn      = new cFunction();
$cEditar  = new cCalles();

include 'business/sys/check_session.php';

$showinfo    = true;
$titulo_edi  = "Visualizando";

if($_SESSION[_is_view_] == 1){
    $titulo_edi = "Editando";
}

if(!isset($pag)){ $pag=1;}
if(!isset($busqueda) || $busqueda == ""){ $busqueda = ""; }
$return_paginacion = "&pag=".$pag."&busqueda=".$busqueda;

if(!isset($_SESSION[_editar_]) || !is_numeric($_SESSION[_editar_]) || $_SESSION[_editar_]<= 0){
    $showinfo = false;
}else {
    $id = $_SESSION[_editar_];
    $rsEditar = $cEditar->getRegbyid( $id );
    if ($rsEditar->rowCount() > 0) {
        $arrEdi           = $rsEditar->fetch(PDO::FETCH_OBJ); 
        $id_comunidad     = $arrEdi->id_comunidad;           
        $id_tipo_vialidad = $arrEdi->id_tipo_vialidad;               
        $calle            = $arrEdi->calle;   
    } else {
        $showinfo = false;
    }

}

$get_comunidades = $cEditar->getComunidades();
$get_vialidades  = $cEditar->getVialidades();

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
                                        Lista de Calles
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
                                    <input type="hidden" name="id_calle" id="id_calle" value="<?php echo $id?>">
                                    <input type="hidden" name="current_file" id="current_file" value="<?php echo $param?>">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <fieldset>
                                                    <p class="lead">
                                                        Datos de la <?php echo $titulo_curr?>
                                                    </p>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <select name="id_col" 
                                                                        id="id_col"
                                                                        class="form-control"
                                                                        required>
                                                                    <option value=""></option>
                                                                    <?php 
                                                                    foreach ($get_comunidades as $id_col => $col) {
                                                                        $sel = "";
                                                                        if($id_col == $id_comunidad){
                                                                            $sel = "selected";
                                                                        }
                                                                        ?>
                                                                        <option value="<?php echo $id_col?>" <?php echo $sel?> > <?php echo $col?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <label for="id_col">
                                                                    Comunidad <span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <select name="vialidad" 
                                                                        id="vialidad"
                                                                        class="form-control"
                                                                        required>
                                                                    <option value=""></option>
                                                                    <?php 
                                                                        foreach ($get_vialidades as $key => $value) {
                                                                            $sel_v = "";
                                                                            if($key == $id_tipo_vialidad){
                                                                                $sel_v = "selected";
                                                                            }
                                                                            ?>
                                                                            <option value="<?php echo $key?>" <?php echo $sel_v?> > <?php echo $value?> </option>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                                <label for="vialidad">
                                                                    Vialidad <span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text" 
                                                                       name="name_calle"
                                                                       id="name_calle" 
                                                                       class="form-control"
                                                                       autocomplete="off"
                                                                       required
                                                                       value="<?php echo $calle?>" />
                                                                <label for="name_calle">
                                                                    Calle <span class="text-danger">*</span>
                                                                </label>
                                                            </div>
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
    <?php include("dist/components/calles.magnament.php");?>
    <script src="dist/assets/js/select2.full.min.js"></script>
</body>
</html>
