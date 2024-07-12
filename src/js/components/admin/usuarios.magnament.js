import Swal from 'sweetalert2';
import '@sweetalert2/theme-dark/dark.min.css'

import { sel, deshabilitarboton, habilitaboton, hide, show } from '../../helpers/general';

let area_val = sel('#area_val').value;
let user_val = sel('#id_usuario').value;

document.addEventListener("DOMContentLoaded", function(){
   
    sel('#nombre').focus();
    $('#id_direccion').select2();
    $('#genero').select2();
    $('#id_area').select2({
        placeholder: 'Seleccione una opción'
    });
    $('#id_t_usr').select2();
    $('#id_rol_usr').select2();
    $('#id_dir_ext').select2();

    if(area_val != null){
        getApiAreaDtl( area_val );
    }

    if(user_val != null){
        getMenusByUsr( user_val );
    }
});


window.viewPassword = () => {

    let pass = sel('#password').value;

    if(pass != "" || pass != null){
        document.getElementById('viewbtn').disabled = false;
    }else{
        document.getElementById('viewbtn').disabled = true;
    }
}


window.showPass = () => {

    let pass = sel('#password');

    if(pass.type == "text"){
        pass.type = "password";
        $('#view_icon').removeClass("fa fa-eye-slash");
        $('#view_icon').addClass("fa fa-eye");
    }else{
        pass.type = "text";
        $('#view_icon').removeClass("fa fa-eye");
        $('#view_icon').addClass("fa fa-eye-slash");
    }
}


const id_direccion = $('#id_direccion');

id_direccion.on('change', function(){

    let val  = id_direccion.val();

    if(val != "" && val != null){

        fetch(`business/admin/sis_usuarios/ajax/get_areas.php?dependencia=${ val }`)
        .then((result) => result.json())
        .then(function({ done, resp, icon }){
            if(done){
                sel('#id_area').innerHTML = resp;
            }
        })
        .catch(function(error){
            sel('#id_area').innerHTML = error;
        })
    
    } else {
        // $('#id_area').val(null).trigger('change');
        $('#id_area').html('').select2({data: [{id: '', text: ''}]});
    }
});


const getApiAreaDtl = ( area ) => {

    let direccion = $('#id_direccion').val();
    if(direccion != "" && direccion != null && area != "" && area != null){

        fetch(`business/admin/sis_usuarios/ajax/get_areas.php?dependencia=${ direccion }&area=${ area }`)
        .then((result) => result.json())
        .then(function({ done, resp, icon }){
            if(done){
                sel('#id_area').innerHTML = resp;
            }
        })
        .catch(function(error){
            sel('#id_area').innerHTML = error;
        })
    
    } else {
        // $('#id_area').val(null).trigger('change');
        $('#id_area').html('').select2({data: [{id: '', text: ''}]});
    }
}


window.getMenus = () => {

    let rol_val = sel('#id_rol_usr').value;

    if(rol_val != null && rol_val != ""){
        
        fetch(`business/admin/sis_usuarios/ajax/get_menus.php?perfil=${ rol_val }`)
        .then((result) => result.text())
        .then(function( resp ){   
            sel('#permisos_ajax').innerHTML = resp;
            $('.ocultar').hide();
            $('.child-menu').hide();
        })
        .catch(function(error){
            sel('#permisos_ajax').innerHTML = error;
        })
    }
}


const getMenusByUsr = ( usr_val ) => {

    let rolv = sel('#id_rol_usr').value;

    if(rolv != null && rolv != ""){
        
        fetch(`business/admin/sis_usuarios/ajax/get_menus.php?perfil=${ rolv }&usuario=${ usr_val }`)
        .then((result) => result.text())
        .then(function( resp ){   
            sel('#permisos_ajax').innerHTML = resp;
            $('.mostrar').hide();
        })
        .catch(function(error){
            sel('#permisos_ajax').innerHTML = error;
        })
    }
}


const selectElement = sel('#ckSelectAll');

selectElement.addEventListener('change', () => {
    if (selectElement.checked) {
        $("#permisos input[type=checkbox]").prop('checked', true);
    } else {
        $("#permisos input[type=checkbox]").prop('checked', false);
    }
});



$(document).on('change', '[name="menus[]"]', function() {
    let menu_id = this.id; //menu_id
    let isChecked = document.getElementById(menu_id).checked;
    if (isChecked) {
        $("#child-" + menu_id + " input[type=checkbox]").prop('checked', true);
    } else {
        $("#child-" + menu_id + " input[type=checkbox]").prop('checked', false);
    }
});


$(document).on('click', '.mostrar', function() {
    let elemSeleccionado = this.parentElement.parentElement;
    let id = elemSeleccionado.id;
    $("#child-menu_" + id).show(150, function() {
        // show("#btn_ocultar_" + id);
        $('#btn_ocultar_'+ id).show();
        // hide("#btn_mostrar_" + id);
        $('#btn_mostrar_'+ id).hide();
    });
});


$(document).on('click', '.ocultar', function() {
    let elemSeleccionado = this.parentElement.parentElement;
    let id = elemSeleccionado.id;
    $("#child-menu_" + id).hide(150, function() {
        $('#btn_ocultar_'+ id).hide();
        $('#btn_mostrar_'+ id).show();
    });
});


const frm_new = sel('#frm_new');
if(frm_new != null){
    frm_new.addEventListener('submit', function(event){
        event.preventDefault();
        handleSubmitInsert( frm_new );
    });
}


const handleSubmitInsert = ( frm_new ) => {

    deshabilitarboton('btn_guardar', 1);

    const ruta = 'business/admin/sis_usuarios/ajax/insert_reg.php';
    const data = new FormData( frm_new );

    fetch(ruta,{
        method: 'POST',
        body:   data
    })
    .then((result) => result.json())
    .then(function ({ done, resp, icon }) {
        if(done){
            Swal.fire({
                title: '¡Listo!',
                text: resp,
                icon: icon,
                allowOutsideClick: false
            })
            .then((result) => {
                let ruta = sel("#current_file").value;
                window.location.assign(`${ruta}index`);
            });
        }else{
            Swal.fire({
                icon: icon,
                title: ':(...',
                text: resp,
                allowOutsideClick: false
            });
            habilitaboton('btn_guardar');
        }
    })
    .catch(function(error){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: error,
            allowOutsideClick: false
        });
        habilitaboton('btn_guardar');
    })
}


const frm_edit = sel('#frm_edit');
if(frm_edit != null){
    frm_edit.addEventListener('submit', function(event){
        event.preventDefault();
        handleSubmitEdit( frm_edit );
    });
}


const handleSubmitEdit = ( frm_e ) => {

    deshabilitarboton('btn_guardar_e', 1);

    const ruta = 'business/admin/sis_usuarios/ajax/update_reg';
    const data = new FormData( frm_e );

    fetch(ruta,{
        method: 'POST',
        body:   data
    })
    .then((resul) => resul.json())
    .then(function({ done, resp, icon }){
        if(done){
            Swal.fire({
                title: '¡Listo!',
                text: resp,
                icon: icon,
                allowOutsideClick: false
            })
            .then((result) => {
                let ruta = sel("#current_file").value;
                window.location.assign(`${ruta}index`);
            });
        } else {
            Swal.fire({
                icon: icon,
                title: ':(...',
                text: resp,
                allowOutsideClick: false
            });
            habilitaboton('btn_guardar_e');
        }
    })
    .catch(function(error){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: error,
            allowOutsideClick: false
        });
        habilitaboton('btn_guardar_e');
    })
}