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

$sys_id_men   = 5;
$sys_tipo     = 1;

$titulo_curr  = "Ciudadano"; 
$ruta_app     = "";

include_once $dir_fc."common/function.class.php";
include_once $dir_fc."data/inicial.class.php";
include_once $dir_fc."data/cat_ciudadanos.class.php";

$cInicial = new cInicial();
$cFn      = new cFunction();
$cEditar  = new cCiudadanos();

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
        $id_ciudadano      = $arrEdi->id_ciudadano;                          
        $id_tipo_ciudadano = $arrEdi->id_tipo_ciudadano;                              
        $id_tipo_contacto  = $arrEdi->id_tipo_contacto;                              
        $id_municipio      = $arrEdi->id_municipio;                          
        $id_colonia        = $arrEdi->id_colonia;                      
        $id_calle          = $arrEdi->id_calle;                      
        $id_entre_calle    = $arrEdi->id_entre_calle;                          
        $id_entre_calle2   = $arrEdi->id_entre_calle2;                              
        $nombre            = $arrEdi->nombre;                  
        $apepat            = $arrEdi->apepat;                  
        $apemat            = $arrEdi->apemat;                  
        $numero_exterior   = $arrEdi->numero_exterior;                              
        $numero_interior   = $arrEdi->numero_interior;                              
        $cp                = $arrEdi->cp;              
        $telefono_fijo     = $arrEdi->telefono_fijo;                          
        $telefono_cel      = $arrEdi->telefono_cel;                          
        $email             = $arrEdi->email;                  
    } else {
        $showinfo = false;
    }

}

$get_comunidades = $cEditar->getComunidades();
$get_municipios  = $cEditar->getMunicipios();
$get_tciudadanos = $cEditar->getTCiudadanos();
$get_tcontacto   = $cEditar->getTContacto();

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
                                        Lista de Ciudadanos
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
                                    <form role="form" class="form" id="frm_edit" name="frm_edit">
                                        <input type="hidden" name="id_ciudadano" id="id_ciudadano" value="<?php echo $id?>">
                                        <input type="hidden" name="current_file" id="current_file" value="<?php echo $param?>">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                <fieldset>
                                                    <p class="lead">
                                                        <?php echo 'Datos del '. $titulo_curr?>
                                                    </p>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="text" 
                                                                       name="nombre" 
                                                                       id="nombre"
                                                                       class="form-control"
                                                                       autocomplete="off"
                                                                       value="<?php echo $nombre?>"
                                                                       required />
                                                                <label for="nombre">
                                                                    Nombre(s) <span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>                                                            
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="text" 
                                                                       name="apepa" 
                                                                       id="apepa"
                                                                       class="form-control"
                                                                       autocomplete="off"
                                                                       value="<?php echo $apepat?>"
                                                                       required />
                                                                <label for="apepa">
                                                                    Apellido Paterno <span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>                            
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="text" 
                                                                       name="apema" 
                                                                       id="apema"
                                                                       class="form-control"
                                                                       autocomplete="off"
                                                                       value="<?php echo $apemat?>"
                                                                       required />
                                                                <label for="apema">
                                                                    Apellido Materno <span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>            
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <select name="id_t_c" 
                                                                        id="id_t_c"
                                                                        class="form-control">
                                                                    <option value=""></option>
                                                                    <?php 
                                                                        foreach ($get_tciudadanos as $key_c => $value_c) {
                                                                            $sel_tc = "";
                                                                            if($key_c == $id_tipo_ciudadano){
                                                                                $sel_tc = "selected";
                                                                            }
                                                                            ?>
                                                                                <option value="<?php echo $key_c?>" <?php echo $sel_tc?> >
                                                                                    <?php echo $value_c?> 
                                                                                </option>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                                <label for="id_t_c">
                                                                    Tipo de ciudadano <span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>                            
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <select name="id_t_t" 
                                                                        id="id_t_t"
                                                                        class="form-control">
                                                                    <option value=""></option>
                                                                    <?php 
                                                                        foreach ($get_tcontacto as $key_to => $value_to) {
                                                                            $sel_tt = "";
                                                                            if($key_to == $id_tipo_contacto){
                                                                                $sel_tt = "selected";
                                                                            }
                                                                            ?>
                                                                                <option value="<?php echo $key_to?>" <?php echo $sel_tt ?>> 
                                                                                    <?php echo $value_to?> 
                                                                                </option>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                                <label for="id_t_t">
                                                                    Tipo de contacto <span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>     
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <select name="id_edo" 
                                                                        id="id_edo"
                                                                        class="form-control">
                                                                    <option value=""></option>
                                                                    <option value="15" selected>Estado de México</option>
                                                                </select>
                                                                <label for="id_edo">
                                                                    Estado <span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>   
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <select name="id_mpo" 
                                                                        id="id_mpo"
                                                                        class="form-control">
                                                                    <option value=""></option>
                                                                    <option value="105" <?php if($id_municipio == "105"){ echo "selected"; }?>>
                                                                        Tlalnepantla de Baz
                                                                    </option>
                                                                </select>
                                                                <label for="id_mpo">
                                                                    Municipio <span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>     
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <select name="id_col" 
                                                                        id="id_col"
                                                                        class="form-control">
                                                                    <option value=""></option>
                                                                    <?php 
                                                                        foreach ($get_comunidades as $key_cm => $value_cm) {
                                                                            $sel_cm = "";
                                                                            if($key_cm == $id_colonia){
                                                                                $sel_cm = "selected";
                                                                            }
                                                                            ?>
                                                                                <option value="<?php echo $key_cm?>" <?php echo $sel_cm?>> 
                                                                                    <?php echo $value_cm?> 
                                                                                </option>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                                <label for="id_col">
                                                                    Comunidad <span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>  
                                                        <input type="hidden" name="calle" id="calle" value="<?php echo $id_calle?>">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <select name="id_calle" 
                                                                        id="id_calle"
                                                                        class="form-control">
                                                                </select>
                                                                <label for="id_calle">
                                                                    Calle <span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>    
                                                    </div> 
                                                    <div class="row">
                                                        <input type="hidden" name="calle_1" id="calle_1" value="<?php echo $id_entre_calle?>">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <select name="id_calle_1" 
                                                                        id="id_calle_1"
                                                                        class="form-control">
                                                                </select>
                                                                <label for="id_calle_1">
                                                                    Entre calle
                                                                </label>
                                                            </div>
                                                        </div> 
                                                        <input type="hidden" name="calle_2" id="calle_2" value="<?php echo $id_entre_calle2?>">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <select name="id_calle_2" 
                                                                        id="id_calle_2"
                                                                        class="form-control">
                                                                </select>
                                                                <label for="id_calle_2">
                                                                    Y calle
                                                                </label>
                                                            </div>
                                                        </div>                          
                                                    </div>  
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="number" 
                                                                       name="cp" 
                                                                       id="cp"
                                                                       class="form-control"
                                                                       autocomplete="off" 
                                                                       value="<?php echo $cp?>"/>
                                                                <label for="cp">
                                                                    Código postal <span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>   
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="text" 
                                                                       name="num_ext" 
                                                                       id="num_ext"
                                                                       class="form-control"
                                                                       autocomplete="off" 
                                                                       value="<?php echo $numero_exterior?>"/>
                                                                <label for="num_ext">
                                                                    Número exterior <span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="text" 
                                                                       name="num_int" 
                                                                       id="num_int"
                                                                       class="form-control"
                                                                       autocomplete="off" 
                                                                       value="<?php echo $numero_interior?>"/>
                                                                <label for="num_int">
                                                                    Número interior
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>     
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="text" 
                                                                       name="tel_fijo" 
                                                                       id="tel_fijo"
                                                                       class="form-control"
                                                                       autocomplete="off" 
                                                                       value="<?php echo $telefono_fijo?>" />
                                                                <label for="tel_fijo">
                                                                    Teléfono fijo
                                                                </label>
                                                            </div>
                                                        </div>                                
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="text" 
                                                                       name="tel_cel" 
                                                                       id="tel_cel"
                                                                       class="form-control"
                                                                       autocomplete="off" 
                                                                       value="<?php echo $telefono_cel?>" />
                                                                <label for="tel_cel">
                                                                    Teléfono celular
                                                                </label>
                                                            </div>
                                                        </div>  
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="email" 
                                                                       name="correo" 
                                                                       id="correo" 
                                                                       class="form-control"
                                                                       autocomplete="off" 
                                                                       required 
                                                                       value="<?php echo $email?>" />
                                                                <label for="correo">
                                                                    Email <span class="text-danger">*</span>
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
    <?php include("dist/components/ciudadanos.magnament.php");?>
    <script src="dist/assets/js/select2.full.min.js"></script>
</body>
</html>
