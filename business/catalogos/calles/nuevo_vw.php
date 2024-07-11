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
$sys_tipo     = 0;

$titulo_curr  = "Calle"; 
$ruta_app     = "";

include_once $dir_fc."common/function.class.php";
include_once $dir_fc."data/inicial.class.php";
include_once $dir_fc."data/cat_calles.class.php";

$cInicial = new cInicial();
$cFn      = new cFunction();
$cNuevo   = new cCalles();

include 'business/sys/check_session.php';

$get_comunidades = $cNuevo->getComunidades();
$get_vialidades  = $cNuevo->getVialidades();

?>

<!DOCTYPE html>
<html>
<head>
    <title> Nueva <?php echo $titulo_curr?> | <?php echo $titulo_paginas?> </title>
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
                                    Nueva <?php echo $titulo_curr?>
                                </li>
                            </ol>
                        </div>
                    </div>
                    <?php
                        if($_SESSION[nuev] == "1"){
                            ?>
                            <div class="card">
                                <div class="card-head style-accent-bright">
                                    <div class="tools pull-left">
                                        <a href="<?php echo $param."index"?>"
                                           class="btn ink-reaction btn-floating-action"
                                           style="background-color: #00796b; color: #fff;"
                                           title="Regresar a la lista">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                    <header class="text-uppercase">
                                        Creando nueva <?php echo $titulo_curr?>
                                    </header>
                                </div>
                                <div class="card-body">
                                    <form class="form" role="form" id="frm_new">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <input type="hidden" name="current_file" id="current_file" value="<?php echo $param?>">
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
                                                                        ?>
                                                                        <option value="<?php echo $id_col?>"> <?php echo $col?></option>
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
                                                                            ?>
                                                                            <option value="<?php echo $key?>"> <?php echo $value?> </option>
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
                                                                       required />
                                                                <label for="name_calle">
                                                                    Calle <span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>                                                        
                                                </fieldset>
                                                <fieldset>
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-4 col-xs-12 col-lg-4 col-md-offset-8">
                                                            <button type="submit" 
                                                                    id="btn_guardar"
                                                                    class="btn ink-reaction btn-block btn-primary">
                                                                <span class="glyphicon glyphicon-floppy-disk"></span> 
                                                                Guardar
                                                            </button>
                                                        </div>  
                                                    </div>
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