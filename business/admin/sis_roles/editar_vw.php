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
$sys_tipo     = 1;

$titulo_curr  = "Rol"; 
$ruta_app     = "";

include_once $dir_fc."common/function.class.php";
include_once $dir_fc."data/inicial.class.php";
include_once $dir_fc."data/rol.class.php";

$cInicial = new cInicial();
$cFn      = new cFunction();
$cEditar  = new cRol();

include 'business/sys/check_session.php';

$showinfo    = true;
$titulo_edi  = "Visualizando";

if(!isset($pag)){ $pag=1;}
if(!isset($busqueda) || $busqueda == ""){$busqueda = "";}
$return_paginacion = "&pag=".$pag."&busqueda=".$busqueda;

if(!isset($_SESSION[_editar_]) || !is_numeric($_SESSION[_editar_]) || $_SESSION[_editar_]<= 0){
    $showinfo = false;
}else {
    $id = $_SESSION[_editar_];
    $cEditar->setId($id);
    $rsEditar = $cEditar->getRolbyId();
    if ($rsEditar->rowCount() > 0) {
        $arrEdi         = $rsEditar->fetch(PDO::FETCH_OBJ);
        $id_rol         = $arrEdi->id_rol;
        $rol            = $arrEdi->rol;
        $descripcion    = $arrEdi->descripcion;
        $isActive       = $arrEdi->activo;
    } else {
        $showinfo = false;
    }

}
if($_SESSION[_is_view_] == 1){
    $titulo_edi = "Editando";
}

$rol_parent = $cEditar->parentsMenu();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $titulo_edi." ".$titulo_curr?> | <?php echo $titulo_paginas?></title>
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
                                    <a href="<?php echo $param."index".$return_paginacion?>">
                                        Lista de Roles
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
                                        <a href='<?php echo $param."index".$return_paginacion?>'  
                                           class="btn ink-reaction btn-floating-action" 
                                           style="background-color: #00796b; color: #ffffff;"
                                           title="Regresar a la lista">
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    </div>
                                    <header class="text-uppercase">
                                        <?php echo $titulo_edi.' '.$titulo_curr?> 
                                    </header>
                                </div>
                                <div class="card-body">
                                    <form class="form" role="form" id="frm_edit">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <input type="hidden" name="current_file" id="current_file" value="<?php echo $param?>">
                                                <input type="hidden" name="master_val" id="master_val" value="<?php echo $id?>">
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
                                                                       value="<?php echo $rol?>"
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
                                                                       value="<?php echo $descripcion?>"
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

                                                                        $chk = "";
                                                                        // $cEditar->setId_menu($rw_parent->id);
                                                                        $checked_r  = $cEditar->checarRol_menu( $rw_parent->id );
                                                                        if ($checked_r->rowCount() > 0) {
                                                                            $chk = "checked";
                                                                        }

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
                                                                                           title="<?php echo $rw_parent->texto?>" 
                                                                                           <?php echo $chk?> />
                                                                                    <?php echo $rw_parent->texto?>
                                                                                </label>
                                                                            </div>
                                                                            <input type="hidden" 
                                                                                   name="grupo[<?php echo $rw_parent->id?>]"
                                                                                   id="grupo_m_<?php echo $rw_parent->id?>"
                                                                                   value="<?php echo $rw_parent->id_grupo?>" />
                                                                        </div>
                                                                        <?php
                                                                        $rol_childs = $cEditar->childsMenu( $rw_parent->id );
                                                                        ?>
                                                                        <div id="child-menu_<?php echo $rw_parent->id?>" class="child-menu">
                                                                            <?php 
                                                                                while($rw_childs = $rol_childs->fetch(PDO::FETCH_OBJ)){
                                                                                    $chk_imp     = "";
                                                                                    $chk_edit    = "";
                                                                                    $chk_nvo     = "";
                                                                                    $chk_elim    = "";
                                                                                    $chk_xport   = "";
                                                                                    $chk_2       = "";

                                                                                    // $cEditar->setId_menu( $rw_childs->id );
                                                                                    $checked_r_2 = $cEditar->checarRol_menu( $rw_childs->id );
                                                                                    if ($checked_r_2->rowCount() > 0) {
                                                                                        $rw_check = $checked_r_2->fetch(PDO::FETCH_OBJ);
                                                                                        $chk_2    = "checked";
                                                                                        $chk_imp  = $rw_check->imp;
                                                                                        $chk_edit = $rw_check->edit;
                                                                                        $chk_nvo  = $rw_check->new;
                                                                                        $chk_elim = $rw_check->elim;
                                                                                        $chk_xport= $rw_check->export;
                                                                                    }
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
                                                                                                   title="<?php echo $rw_childs->texto?>"
                                                                                                   <?php echo $chk_2?> />
                                                                                            <?php echo $rw_childs->texto?>
                                                                                        </label>
                                                                                        <label class="separador">
                                                                                            <input type="checkbox" 
                                                                                                   name="permiso_imp[<?php echo $rw_childs->id?>]" 
                                                                                                   value="1" 
                                                                                                   title="Editar" 
                                                                                                   id="permiso_imp<?php echo $rw_childs->id?>" 
                                                                                                   <?php if($chk_imp == 1){ echo "checked"; }?> />
                                                                                                Imprimir
                                                                                        </label>
                                                                                        <label class="separador">
                                                                                            <input type="checkbox" 
                                                                                                   name="permiso_nuevo[<?php echo $rw_childs->id?>]" 
                                                                                                   value="1" 
                                                                                                   title="Editar" 
                                                                                                   id="permiso_nuevo<?php echo $rw_childs->id?>" 
                                                                                                   <?php if($chk_nvo == 1){ echo "checked"; }?> />
                                                                                                Nuevo
                                                                                        </label>
                                                                                        <label class="separador">
                                                                                            <input type="checkbox" 
                                                                                                   name="permiso_edit[<?php echo $rw_childs->id?>]" 
                                                                                                   value="1" 
                                                                                                   title="Editar" 
                                                                                                   id="permiso_edit<?php echo $rw_childs->id?>" 
                                                                                                   <?php if($chk_edit == 1){ echo "checked"; }?> />
                                                                                            Editar
                                                                                        </label>
                                                                                        <label class="separador">
                                                                                            <input type="checkbox" 
                                                                                                   name="permiso_elim[<?php echo $rw_childs->id?>]" 
                                                                                                   value="1" 
                                                                                                   title="Editar" 
                                                                                                   id="permiso_elim<?php echo $rw_childs->id?>" 
                                                                                                   <?php if($chk_elim == 1){ echo "checked"; }?> />
                                                                                            Eliminar
                                                                                        </label>
                                                                                        <label class="separador">
                                                                                            <input type="checkbox" 
                                                                                                   name="permiso_exportar[<?php echo $rw_childs->id?>]" 
                                                                                                   value="1" 
                                                                                                   title="Editar" 
                                                                                                   id="permiso_exportar<?php echo $rw_childs->id?>"
                                                                                                   <?php if($chk_xport == 1){ echo "checked"; }?> />
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
        <?php include($dir_fc."inc/menucommon.php");?>
    </div>
    <?php include("dist/components/roles.magnament.php"); ?>
</body>
