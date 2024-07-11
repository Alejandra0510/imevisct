import Swal from 'sweetalert2';
import '@sweetalert2/theme-dark/dark.min.css';

import { sel, deshabilitarboton, habilitaboton, hide, show } from '../../helpers/general';

document.addEventListener("DOMContentLoaded", function(){

    $('#vialidad').select2({
        placeholder: 'Seleccione una opción'
    });
    $('#id_col').select2({
        placeholder: 'Seleccione una opción',
        width: '100%'
    });
    $('#id_col').select2('open');

});


const frm_new = sel('#frm_new');
if(frm_new != null){
    frm_new.addEventListener('submit', function(event){
        event.preventDefault();
        handleSubmitNew( frm_new );
    });
}

const handleSubmitNew = ( frm ) => {

    deshabilitarboton('btn_guardar', 1);

    const ruta = 'business/catalogos/calles/ajax/insert_reg.php';
    const data = new FormData( frm );

    fetch(ruta,{
        method: 'POST',
        body:   data
    })
    .then((resultado) => resultado.json())
    .then(function({ done, resp, icon }){
        if(done){
            Swal.fire({
                icon: icon,
                title: 'Listo',
                text: resp,
                allowOutsideClick: false
            })
            .then(() => {
                let ruta = sel("#current_file").value;
                window.location.assign(`${ruta}index`);
            })
        } else {
            Swal.fire({
                icon: icon,
                title: ':(...',
                text: resp,
                allowOutsideClick: false
            });
            habilitaboton('btn_guardar');
        }
    })
    .catch(function(error) {
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


const handleSubmitEdit = ( frm_edit ) => {

    deshabilitarboton('btn_guardar_e', 1);

    const ruta = 'business/catalogos/calles/ajax/update_reg.php';
    const data = new FormData( frm_edit );

    fetch(ruta,{
        method: 'POST',
        body:   data
    })
    .then((resultado) => resultado.json())
    .then(function({ done, resp, icon }){
        if(done){
            Swal.fire({
                icon: icon,
                title: 'Listo',
                text: resp,
                allowOutsideClick: false
            })
            .then(() => {
                let ruta = sel("#current_file").value;
                window.location.assign(`${ruta}index`);
            })
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