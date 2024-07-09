<?php
function call($controller, $action) {
    
    require_once($controller . '/index_ctrl.php');
    switch($controller) {
        case 'controlador':
            $controller = new Inicio();
            break;
        case 'controlador/business':
            $controller = new Business();
            break;
        case 'controlador/sys':
            $controller = new Sys();
            break;
        case 'controlador/admin/sis_roles':
            $controller = new admin_roles();
            break;
        case 'controlador/admin/sis_usuarios':
            $controller = new admin_usuarios();
            break;
        case 'controlador/catalogos/ciudadanos':
            $controller = new cat_ciudadanos();
            break;
        case 'controlador/catalogos/calles':
            $controller = new cat_calles();
            break;
        case 'controlador/catalogos/comunidades':
            $controller = new cat_comunidades();
            break;
        case 'controlador/catalogos/documentos':
            $controller = new cat_documentos();
            break;
        case 'controlador/catalogos/identificacion':
            $controller = new cat_identificaciones();
            break;
        case 'controlador/catalogos/modalidades':
            $controller = new cat_modalidades();
            break;
        case 'controlador/catalogos/rumbos':
            $controller = new cat_rumbos();
            break;
    }

    $controller->{ $action }();
}

$controllers = array(
    'controlador'                            => ['index'],
    'controlador/business'                   => ['show'],
    'controlador/sys'                        => ['account'],
    'controlador/admin/sis_roles'            => ['ver', 'index', 'nuevo'],
    'controlador/admin/sis_usuarios'         => ['ver', 'index', 'nuevo'],
    'controlador/catalogos/ciudadanos'       => ['ver', 'index', 'nuevo'],
    'controlador/catalogos/calles'           => ['ver', 'index', 'nuevo'],     
    'controlador/catalogos/comunidades'      => ['ver', 'index', 'nuevo'],         
    'controlador/catalogos/documentos'       => ['ver', 'index', 'nuevo'],         
    'controlador/catalogos/identificacion'   => ['ver', 'index', 'nuevo'],             
    'controlador/catalogos/modalidades'      => ['ver', 'index', 'nuevo'],         
    'controlador/catalogos/rumbos'           => ['ver', 'index', 'nuevo'],     
);

if (array_key_exists($controller, $controllers)) {

    if (in_array($action, $controllers[$controller])) {
        call($controller, $action);
    } else {
        call('business/', 'error');
    }

} else {
    call('business/', 'error');
}