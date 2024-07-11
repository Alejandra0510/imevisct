<?php 
$dir_fc = "";
/*-----------------------------------------------------------------------------------------------*/
include_once $dir_fc."connections/trop.php";
include_once $dir_fc."connections/php_config.php";

$busqueda   = "";

extract($_REQUEST);

$current_file = basename($_SERVER["PHP_SELF"]);
$dir          = dirname($_SERVER["PHP_SELF"])."/".$controller;
$checkMenu    = $server_name.$dir."/";
$param        = "?controller=".$controller."&action=";

$sys_id_men = 7;
$sys_tipo   = 0;
$real_sis   = "catalogos/calles";

include_once $dir_fc."common/function.class.php";
include_once $dir_fc."data/inicial.class.php";
include_once $dir_fc."data/cat_calles.class.php";

$cInicial = new cInicial();
$cLista   = new cCalles();
$cFn      = new cFunction();

include_once 'business/sys/check_session.php';

$registros = c_num_reg;

if (isset($_GET["pag"])) { $pag = $_GET["pag"];} else { $pag = 1;}
if (is_numeric($pag)) { $inicio = (($pag - 1) * $registros);} else {$inicio = 0;}

$ingreso = 1; 
if ($busqueda == "") {
    $filtro      = "";
    $fPaginacion = "";
    $back        = "";
    $MSJresult   = "";
} else {
    $filtro      = $busqueda;
    $fPaginacion = "&busqueda=".$busqueda;
    
    $back = "   <a type='button' 
                   class='btn btn-accent-dark btn-floating-action ink-reaction btn-sm'  
                   href='".$param."index' 
                   title='(Eliminar filtro de búsqueda)'>
                    <span class='fa fa-filter'></span>
                </a>";
                
    $MSJresult = $cFn->custom_alert("info", " ", "Resultados encontrados con la busqueda: " . $busqueda . "", 1, 1);
}

if(isset($_SESSION[array_filtros])){ $cLista->setArraySearch( $_SESSION[array_filtros] ); }

$cLista->setFiltro( $filtro );
$cLista->setInicio( $inicio );
$cLista->setFin( $registros );
$cLista->setLimite( 0 );

$rs_count = $cLista->getAllReg();
$cout_reg = $rs_count->rowCount();
$num_total_pag = ceil($cout_reg/$registros);

$cLista->setLimite(1);
$rsRegShow = $cLista->getAllReg();

$ruta_app = "";

$get_comunidades = $cLista->getComunidades();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> Calles | <?php echo $titulo_paginas?> </title>
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
                        <div class="col-lg-8">
                            <h1 class="text-primary main-title">
                                Calles 
                                <span class="badge">
                                    <?php echo $cout_reg?>
                                </span>
                            </h1>
                        </div>
                        <div class="col-lg-4">
                            <ol class="breadcrumb pull-right">
                                <li>
                                    <a href="<?php echo $raiz?>">
                                        Inicio
                                    </a>
                                </li>
                                <li class="active">
                                    Lista de Calles
                                </li>
                            </ol>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-head style-accent-bright">
                            <div class="tools pull-left">
                                <?php 
                                if($_SESSION[nuev] == "1"){
                                    ?>
                                    <a href="<?php echo $param."nuevo"?>"
                                       class="btn ink-reaction btn-floating-action"
                                       style="background-color: #00796b; color: #fff;"
                                       title="Agregar un nuevo registro">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="tools">
                                <?php echo $back; ?>
                                <div class="navbar-search">
                                    <button type="button" 
                                            class="btn btn-icon-toggle ink-reaction"
                                            id="btnSearch">
                                        <i class="fa fa-search"></i>    
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="respuesta_ajax">
                                        <?php echo $MSJresult?>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <?php 
                                if($cout_reg >= 1){
                                    ?>
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <td width="2%"></td>
                                                        <th class="text-center">#</th>
                                                        <th class="text-center">Calle</th>
                                                        <th class="text-center">Comunidad</th>
                                                        <th class="text-center">Funciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        while($row_reg = $rsRegShow->fetch(PDO::FETCH_OBJ)){
                                                            $id_calle     = $row_reg->id_calle;              
                                                            $id_comunidad = $row_reg->id_comunidad;                  
                                                            $calle        = $row_reg->calle;          
                                                            $descripcion  = $row_reg->descripcion;                  
                                                            $activo       = $row_reg->activo;          
                                                            $colonia      = $row_reg->colonia;                  

                                                            if($activo == 1){
                                                                $showEstatus = "fa fa-check-circle text-success";
                                                                $bajaAlta    = 0;
                                                                $icoAB       = "fa fa-ban";
                                                                $titleAB     = "Dar de baja";
                                                            }else{
                                                                $showEstatus = "fa fa-times-circle text-danger";
                                                                $bajaAlta    = 1;
                                                                $icoAB       = "fa fa-check";
                                                                $titleAB     = "Dar de Alta";
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td> 
                                                                    <span class="pull-left <?php echo $showEstatus?>"></span>
                                                                </td>
                                                                <td class="text-center"><?php echo $id_calle?></td>
                                                                <td class="text-center"><?php echo $calle?></td>
                                                                <td class="text-center"><?php echo $colonia?></td>
                                                                <td class="text-center">
                                                                    <a href="javascript:void(0)"
                                                                       onclick="openMyLink(0, <?php echo $id_calle?>, '<?php echo $param.'ver&pag='.$pag.$fPaginacion?>')"
                                                                       class="btn ink-reaction btn-icon-toggle"
                                                                       data-toggle="tooltip"
                                                                       data-placement="top"
                                                                       title="Ver registro">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                    <?php 
                                                                    if($activo == 1){
                                                                        if($_SESSION[edit] == 1){
                                                                            ?>
                                                                            <a href="javascript:void(0)"
                                                                               onclick="openMyLink(1, <?php echo $id_calle?>, '<?php echo $param.'ver&pag='.$pag.$fPaginacion?>')"
                                                                               class="btn ink-reaction btn-icon-toggle"
                                                                               data-toggle="tooltip"
                                                                               data-placement="top"
                                                                               title="Editar registro">
                                                                                <span class="glyphicon glyphicon-pencil"></span>
                                                                            </a>
                                                                            <?php
                                                                        }
                                                                        if($_SESSION[elim] == 1){
                                                                            ?>
                                                                            <a  onclick="handleDeleteReg(<?php echo $id_calle.','.$bajaAlta ?>, 1)" 
                                                                                data-toggle="tooltip"
                                                                                class="btn ink-reaction btn-icon-toggle" 
                                                                                data-placement="top" 
                                                                                title="<?php echo $titleAB?>">
                                                                                <span class="<?php echo $icoAB?>"></span>
                                                                            </a>
                                                                            <?php
                                                                        }   
                                                                    }

                                                                    if($_SESSION[elim] == 1 && $_SESSION[admin] == 1){
                                                                        ?>
                                                                        <a  onclick="handleDeleteReg(<?php echo $id_calle?>, 3)" 
                                                                            data-toggle="tooltip"
                                                                            class="btn ink-reaction btn-icon-toggle" 
                                                                            data-placement="top" 
                                                                            title="Eliminar">
                                                                            <span class="fa fa-trash"></span>
                                                                        </a>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    echo $cFn->custom_alert("info", "", "No se encontraron registros en la base de datos. ", 1, 1);
                                }
                                ?>
                            </div>
                            <div class="row">
                                <?php 
                                    echo $cFn->fn_paginacion($pag, $num_total_pag, $raiz, $param."index", $fPaginacion);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include($dir_fc."inc/menucommon.php")?>
    </div>
    <?php include("dist/components/calles.php");?>
    <!-- Modal Search -->
    <div class="modal small fade" id="idModalSearch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3 class="modal-title">
                        Búsqueda Avanzada
                    </h3>
                </div>              
                <form role="form" id="frmSearch" class="form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group floating-label">
                                    <input 
                                        type="text" 
                                        class="form-control dirty" 
                                        name="txtBuscar" 
                                        id="txtBuscar" 
                                        autocomplete="off"/>
                                    <label for="txtBuscar">
                                        Calle: <span class="text-danger">*</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="col_s" 
                                            id="col_s"
                                            class="form-control">
                                        <option value="">Seleccione una opción</option> 
                                        <?php 
                                        foreach ($get_comunidades as $key => $value) {
                                            ?>
                                            <option value="<?php echo $key?>"> <?php echo $value?> </option>
                                            <?php
                                        }
                                        ?>   
                                    </select>
                                    <label for="col_s">
                                        Comunidad: <span class="text-danger">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" 
                                class="btn ink-reaction btn-danger" 
                                data-dismiss="modal">
                            Cerrar
                        </button>
                        <button type="submit" 
                                id="btn_search" 
                                class="btn bg-success ink-reaction" >
                            Buscar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Search -->
</body>
</html>