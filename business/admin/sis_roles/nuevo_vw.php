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

$sys_id_men   = 3;
$sys_tipo     = 0;
$titulo_curr  = "Rol"; 
$ruta_app     = "";

include_once $dir_fc."common/function.class.php";
include_once $dir_fc."data/inicial.class.php";
include_once $dir_fc."data/rol.class.php";

$cInicial = new cInicial();
$cFn      = new cFunction();
$cNuevo   = new cRol();

include 'business/sys/check_session.php';

?>
<!DOCTYPE html>
<html>
<head>
    <title> Nuveo <?php echo $titulo_curr?> | <?php echo $titulo_paginas?> </title>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <?php include("dist/inc/headercommon.php"); ?>
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
                                    <a href="<?php echo $raiz?>"></a>
                                </li>
                                <li>
                                    <a href="<?php echo $param."index"?>">
                                        Lista de Roles
                                    </a>
                                </li>
                                <li class="active">
                                    Nuevo <?php echo $titulo_curr?>
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
    <?php include("dist/components/roles.magnament.php");?>
</body>
</html>