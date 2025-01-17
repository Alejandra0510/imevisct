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

$rol_parent = $cNuevo->parentsMenu();

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
                <div class="section-body contain-md">
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
                                    <header class="text-uppercase">
                                        Creando nuevo <?php echo $titulo_curr?>
                                    </header>
                                </div>
                                <div class="card-body">
                                    <form class="form" role="form" id="frm_new">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <input type="hidden" name="current_file" id="current_file" value="<?php echo $param?>">
                                                <fieldset>
                                                    <p class="lead">
                                                        Datos del <?php echo $titulo_curr?>
                                                    </p>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text"
                                                                       class="form-control"
                                                                       id="rol"
                                                                       name="rol"
                                                                       autocomplete="off"
                                                                       required />
                                                                <label for="rol">
                                                                    Rol <span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text"
                                                                       class="form-control"
                                                                       id="desc_rol"
                                                                       name="desc_rol"
                                                                       autocomplete="off"
                                                                       required />
                                                                <label for="desc_rol">
                                                                    Descripción <span class="text-danger">*</span>
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
                                                                    <?php 
                                                                    while($rw_parent = $rol_parent->fetch(PDO::FETCH_OBJ)){
                                                                        ?>
                                                                        <div id="<?php echo $rw_parent->id?>">
                                                                            <div class="checkbox checkbox-styled checkbox-danger">
                                                                                <span id="btn_mostrar_<?php echo $rw_parent->id?>"
                                                                                      class="btn-plus-ne mostrar">
                                                                                    <i class="fa fa-plus-square-o"></i>    
                                                                                </span>
                                                                                <span id="btn_ocultar_<?php echo $rw_parent->id?>"
                                                                                      class="btn-plus-ne ocultar">
                                                                                    <i class="fa fa-minus-square-o"></i>
                                                                                </span>
                                                                                <label>
                                                                                    <input type="checkbox"
                                                                                           id="menu_<?php echo $rw_parent->id?>"
                                                                                           name="menus[]"
                                                                                           value="<?php echo $rw_parent->id?>"
                                                                                           title="<?php echo $rw_parent->texto?>" />
                                                                                    <?php echo $rw_parent->texto?>
                                                                                </label>
                                                                            </div>
                                                                            <input type="hidden" 
                                                                                   name="grupo[<?php echo $rw_parent->id?>]"
                                                                                   id="grupo_m_<?php echo $rw_parent->id?>"
                                                                                   value="<?php echo $rw_parent->id_grupo?>" />
                                                                        </div>
                                                                        <?php
                                                                        $rol_childs = $cNuevo->childsMenu( $rw_parent->id );
                                                                        ?>
                                                                        <div id="child-menu_<?php echo $rw_parent->id?>" class="child-menu">
                                                                            <?php 
                                                                                while($rw_childs = $rol_childs->fetch(PDO::FETCH_OBJ)){
                                                                                    ?>
                                                                                    <input type="hidden" 
                                                                                           name="grupo[<?php echo $rw_childs->id?>]"
                                                                                           id="grupo_m_<?php echo $rw_childs->id?>"
                                                                                           value="<?php echo $rw_childs->id_grupo?>" />
                                                                                    <div class="checkbox checkbox-styled checkbox-danger">
                                                                                        <label class="separador-desc">
                                                                                            <input type="checkbox"
                                                                                                   name="menus[]"
                                                                                                   id="child_<?php echo $rw_childs->id?>"
                                                                                                   value="<?php echo $rw_childs->id?>"
                                                                                                   title="<?php echo $rw_childs->texto?>">
                                                                                            <?php echo $rw_childs->texto?>
                                                                                        </label>
                                                                                        <label class="separador">
                                                                                            <input type="checkbox" 
                                                                                                name="permiso_imp[<?php echo $rw_childs->id?>]" 
                                                                                                value="1" 
                                                                                                title="Editar" 
                                                                                                id="permiso_imp<?php echo $rw_childs->id?>" >
                                                                                            Imprimir
                                                                                        </label>
                                                                                        <label class="separador">
                                                                                            <input type="checkbox" 
                                                                                                name="permiso_nuevo[<?php echo $rw_childs->id?>]" 
                                                                                                value="1" 
                                                                                                title="Editar" 
                                                                                                id="permiso_nuevo<?php echo $rw_childs->id?>">
                                                                                            Nuevo
                                                                                        </label>
                                                                                        <label class="separador">
                                                                                            <input type="checkbox" 
                                                                                                name="permiso_edit[<?php echo $rw_childs->id?>]" 
                                                                                                value="1" 
                                                                                                title="Editar" 
                                                                                                id="permiso_edit<?php echo $rw_childs->id?>">
                                                                                            Editar
                                                                                        </label>
                                                                                        <label class="separador">
                                                                                            <input type="checkbox" 
                                                                                                name="permiso_elim[<?php echo $rw_childs->id?>]" 
                                                                                                value="1" 
                                                                                                title="Editar" 
                                                                                                id="permiso_elim<?php echo $rw_childs->id?>">
                                                                                            Eliminar
                                                                                        </label>
                                                                                        <label class="separador">
                                                                                            <input type="checkbox" 
                                                                                                name="permiso_exportar[<?php echo $rw_childs->id?>]" 
                                                                                                value="1" 
                                                                                                title="Editar" 
                                                                                                id="permiso_exportar<?php echo $rw_childs->id?>">
                                                                                            Exportar
                                                                                        </label>
                                                                                    </div>
                                                                                    <?php
                                                                                }
                                                                            ?>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </article>
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
    <?php include("dist/components/roles.magnament.php");?>
</body>
</html>