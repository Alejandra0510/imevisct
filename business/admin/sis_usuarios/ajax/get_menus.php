<?php 
session_start();
$dir_fc = "../../../../";
/*-----------------------------------------------------------------------------------------------*/
include_once $dir_fc."connections/trop.php";
include_once $dir_fc."connections/php_config.php";
include_once $dir_fc."data/users.class.php";

$cData = new cUsers();

$done = false;
$icon = "error";
$resp = "";
$resp_child = "";

$perfil  = "";
$usuario = "";


extract($_REQUEST);

try{

    if(!isset($perfil) || !is_numeric($perfil) || $perfil == ""){
        throw new Exception("No se recibieron los parámetros correctamente");
    }
        //traer los menús
        $rol_parent = $cData->parentsMenu();
        while($rw_parent = $rol_parent->fetch(PDO::FETCH_OBJ)){

            $chk = "";

            $cData->setId_rol($perfil);
            $cheked_m = $cData->checarRol_menu( $rw_parent->id );

            if($cheked_m->rowCount() > 0){
                $chk = "checked";
            }
            ?>
            <div id='<?php echo $rw_parent->id?>'>
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
                        <span>
                            <?php echo $rw_parent->texto?>
                        </span>
                    </label>
                </div>
                <input type="hidden" 
                        name="grupo[<?php echo $rw_parent->id?>]"
                        id="grupo_m_<?php echo $rw_parent->id?>"
                        value="<?php echo $rw_parent->id_grupo?>" />
            </div>
            <?php 
            $rol_childs = $cData->childsMenu( $rw_parent->id );
            ?>
            <div id="child-menu_<?php echo $rw_parent->id?>" class="child-menu">
                <?php
                if($rol_childs->rowCount() > 0){

                    while($rw_childs = $rol_childs->fetch(PDO::FETCH_OBJ)){
                        $chk_imp     = "";
                        $chk_edit    = "";
                        $chk_nvo     = "";
                        $chk_elim    = "";
                        $chk_xport   = "";
                        $chk_2       = "";
    
                        if($usuario != ""){
                            $checked_r_2 = $cData->checarUserMenu( $rw_childs->id, $usuario );
                        } else{
                            $checked_r_2 = $cData->checarRol_menu( $rw_childs->id );
                        }

                        if ($checked_r_2->rowCount() > 0) {
                            $rw_check  = $checked_r_2->fetch(PDO::FETCH_OBJ);
                            $chk_2     = "checked";
                            $chk_imp   = $rw_check->imp;
                            $chk_edit  = $rw_check->edit;
                            $chk_nvo   = $rw_check->new;
                            $chk_elim  = $rw_check->elim;
                            $chk_xport = $rw_check->export;
                        }
    
                        ?>
                        <input type="hidden"
                                name="grupo[<?php echo $rw_childs->id?>]"
                                id="grupo_m_<?php echo $rw_childs->id?>"
                                value="<?php echo $rw_childs->id_grupo?>" />
                        <div class='checkbox checkbox-styled checkbox-danger'>
                            <label class="separador-desc">
                                <input type='checkbox'
                                    name='menus[]'
                                    id='child_<?php echo $rw_childs->id?>'
                                    value='<?php echo $rw_childs->id?>'
                                    title='<?php echo $rw_childs->texto?>'
                                    <?php echo $chk_2?> />
                                <span>
                                    <?php echo $rw_childs->texto?>
                                </span>
                            </label>
                            <label class="separador">
                                <input type="checkbox" 
                                        name="permiso_imp[<?php echo $rw_childs->id?>]"
                                        value="1"
                                        title="Editar" 
                                        id="permiso_imp<?php echo $rw_childs->id?>" 
                                        <?php if($chk_imp == "1"){ echo "checked"; }?> />
                                    <span>
                                        Imprimir
                                    </span>
                            </label>
                            <label class="separador">
                                <input type="checkbox" 
                                        name="permiso_nuevo[<?php echo $rw_childs->id?>]"
                                        value="1" 
                                        title="Editar" 
                                        id="permiso_nuevo<?php echo $rw_childs->id?>" 
                                        <?php if($chk_nvo == "1"){ echo "checked"; }?> />
                                    <span>
                                        Nuevo
                                    </span>
                            </label>
                            <label class="separador">
                                <input type="checkbox" 
                                        name="permiso_edit[<?php echo $rw_childs->id?>]" 
                                        value="1" 
                                        title="Editar" 
                                        id="permiso_edit<?php echo $rw_childs->id?>" 
                                        <?php if($chk_edit == "1"){ echo "checked"; } ?> />
                                    <span>
                                        Editar
                                    </span>
                            </label>
                            <label class="separador">
                                <input type="checkbox" 
                                        name="permiso_elim[<?php echo $rw_childs->id?>]" 
                                        value="1" 
                                        title="Eliminar" 
                                        id="permiso_elim<?php echo $rw_childs->id?>" 
                                        <?php if($chk_elim == "1"){ echo "checked"; } ?> />
                                    <span>
                                        Eliminar
                                    </span>
                            </label>
                            <label class="separador">
                                <input type="checkbox" 
                                        name="permiso_exportar[<?php echo $rw_childs->id?>]" 
                                        value="1" 
                                        title="Editar" 
                                        id="permiso_exportar<?php echo $rw_childs->id?>" 
                                        <?php if($chk_xport == "1"){ echo "checked"; } ?> />
                                    <span>
                                        Exportar
                                    </span>
                            </label>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <?php
        }                     
    ?>

    <?php 
    $done = true;
    
}catch(\Exception $e){

    echo $e->getMessage();

}

$cData->closeOut();


