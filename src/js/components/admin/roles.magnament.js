import Swal from 'sweetalert2';
import '@sweetalert2/theme-dark/dark.min.css';

import { sel, deshabilitarboton, habilitaboton, hide, show } from '../../helpers/general';

document.addEventListener("DOMContentLoaded", function(){

    sel('#rol').focus();
    $('.child-menu').hide();
    $('.ocultar').hide();

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
        // hide("#btn_ocultar_" + id);
        $('#btn_ocultar_'+ id).hide();
        // show("#btn_mostrar_" + id);
        $('#btn_mostrar_'+ id).show();
    });
});


const selectElement = sel('#ckSelectAll');

selectElement.addEventListener('change', () => {
    if (selectElement.checked) {
        $("#permisos input[type=checkbox]").prop('checked', true);
    } else {
        $("#permisos input[type=checkbox]").prop('checked', false);
    }
});


const frm_new = sel('#frm_new');
if(frm_new != null){
    frm_new.addEventListener('submit', function(event){
        event.preventDefault();
        handleSubmitNew( frm_new );
    });
}


const handleSubmitNew = ( frm_new ) => {

    deshabilitarboton('btn_guardar', 1);

    const ruta = 'business/admin/sis_roles/ajax/insert_reg.php';
    const data = new FormData( frm_new );

    fetch(ruta,{
        method: 'POST',
        body:   data
    })
    .then((resultado) => resultado.json())
    .then(function({ done, resp, icon }){
        if(done){
            Swal.fire({
                title: '¡Listo!',
                text: resp,
                icon: icon
            })
            .then((result) => {
                let ruta = sel("#current_file").value;
                window.location.assign(`${ruta}index`);
            });
        }else{
            Swal.fire({
                title: '¡Error!',
                icon: icon,
                text: resp,
                allowOutsideClick: false
            })
            habilitaboton('btn_guardar');
        }
    })
    .catch(function(error){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: error,
            allowOutsideClick: false
        })
        habilitaboton('btn_guardar');
    });
}


const frm_edit = sel('#frm_edit');
if(frm_edit != null){
    console.log(frm_edit);
    frm_edit.addEventListener('submit', function(event){
        event.preventDefault();
        handleSubmitEdit( frm_edit );
    });
}


const handleSubmitEdit = ( frm_edit ) => {

    deshabilitarboton('btn_guardar_e', 1);

    const ruta = 'business/admin/sis_roles/ajax/update_reg.php';
    const data = new FormData( frm_edit );

    fetch(ruta,{
        method: 'POST',
        body:   data
    })
    .then((result) => result.json())
    .then(function({ done, resp, icon }){
        if(done){
            Swal.fire({
                title: '¡Listo!',
                text: resp,
                icon: icon
            })
            .then((result) => {
                let ruta = sel("#current_file").value;
                window.location.assign(`${ruta}index`);
            });
        }else{
            Swal.fire({
                title: '¡Error!',
                icon: icon,
                text: resp,
                allowOutsideClick: false
            })
            habilitaboton('btn_guardar_e');
        }
    })
    .catch(function(error){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: error,
            allowOutsideClick: false
        })
        habilitaboton('btn_guardar_e');
    })
}