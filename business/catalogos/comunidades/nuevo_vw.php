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

$sys_id_men   = 6;
$sys_tipo     = 0;

$titulo_curr  = "Comunidad"; 
$ruta_app     = "";

include_once $dir_fc."common/function.class.php";
include_once $dir_fc."data/inicial.class.php";
include_once $dir_fc."data/cat_comunidades.class.php";

$cInicial = new cInicial();
$cFn      = new cFunction();
$cNuevo   = new cComunidades();

include 'business/sys/check_session.php';

$get_asentamiento = $cNuevo->getTAsentamiento();

?>
<!DOCTYPE html>
<html>
<head>
    <title> Nuevo <?php echo $titulo_curr?> | <?php echo $titulo_paginas?> </title>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <?php include("dist/inc/headercommon.php"); ?>
    <link rel="stylesheet" type="text/css" href="dist/assets/css/select2.min.css?v=1.001">
</head>
<body class="menubar-hoverable header-fixed">
    <?php include($dir_fc."inc/header.php")?>
    <div id="base">
        <div class="offcavas"></div>
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
                                        Lista de Comunidades
                                    </a>
                                </li>
                                <li class="active">
                                    Nueva <?php echo $titulo_curr?>
                                </li>
                            </ol>
                        </div>
                    </div>
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
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include($dir_fc."inc/menucommon.php")?>
    </div>
    <?php include("dist/components/comunidades.magnament.php");?>
    <script src="dist/assets/js/select2.full.min.js"></script>
</body>

