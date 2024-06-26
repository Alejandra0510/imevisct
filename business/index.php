<?php

$dir_fc       = "";
include_once $dir_fc.'connections/trop.php';
include_once $dir_fc.'connections/php_config.php';

extract($_REQUEST);

$current_file = basename($_SERVER["PHP_SELF"]);
$dir          = dirname($_SERVER['PHP_SELF'])."/";
$checkMenu    = $server_name.$dir."?controller=business";
$param        = "?controller=business&action=";
$sys_id_men   = 0;

include_once $dir_fc.'data/inicial.class.php';
include_once $dir_fc.'common/function.class.php';
include_once $dir_fc.'data/business.class.php';

$cInicial = new cInicial();     
$cFn      = new cFunction();
$cBuss    = new cBusiness();

include_once 'sys/check_session.php'; 

$ruta_app = "";
$inhabilita = "";

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title><?php echo c_page_title?></title>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <?php include("dist/inc/headercommon.php"); ?>
    
</head>
<body class="menubar-hoverable header-fixed ">
    <?php include ($dir_fc."inc/header.php")?>
<div id="base">
    <div class="offcanvas"></div>
    <div id="content">
        <section>
            <div class="section-body contain">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body no-padding">
                                <div class="alert alert-callout alert-info no-margin">
                                    <?php
                                    $bienvenido = "Bienvenido";
                                    ?>
                                    <div align="center" style="color: #ed6611">
                                        <h2><?php echo $bienvenido; ?></h2>
                                        <h4><?php echo $_SESSION[s_ncompleto]; ?></h4>
                                        <span style="color: #ed6611" ><strong> Sistema Integral de Regularización Catastral y de la Tenencia de la Tierra </strong></span>
                                    </div>                               
                                </div><!--end .card-body -->
                            </div><!--end .card -->
                        </div><!--end .col -->
                    </div>
                </div>
            </div>
        </section>
        <?php include($dir_fc."inc/footer.php") ?>
    </div>
<?php include($dir_fc."inc/menucommon.php") ?>
<?php include("dist/components/business.php"); ?>
</div>
</body>
</html>
