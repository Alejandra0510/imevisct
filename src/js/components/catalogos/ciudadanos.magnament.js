import Swal from 'sweetalert2';
import '@sweetalert2/theme-dark/dark.min.css';

import { sel, deshabilitarboton, habilitaboton } from '../../helpers/general';

let calle   = $('#calle').val();
let calle_1 = $('#calle_1').val();
let calle_2 = $('#calle_2').val();

document.addEventListener("DOMContentLoaded", function(){
    
    sel('#nombre').focus();
    $('#id_t_c').select2({
        placeholder: 'Seleccione una opción'
    });
    $('#id_t_t').select2({
        placeholder: 'Seleccione una opción'
    });
    $('#id_mpo').select2({
        placeholder: 'Seleccione una opción'
    });
    $('#id_col').select2({
        placeholder: 'Seleccione una opción'
    });
    $('#id_calle').select2({
        placeholder: 'Seleccione una opción'
    });
    $('#id_calle_1').select2({
        placeholder: 'Seleccione una opción'
    });
    $('#id_calle_2').select2({
        placeholder: 'Seleccione una opción'
    });
    $('#id_edo').select2({
        placeholder: 'Seleccione una opción'
    });

    if(calle != "" && calle != null){
        getCalles( calle, calle_1, calle_2 );
    }

});


$('#id_t_c').on('change', function(){

    let idtc = sel('#id_t_c').value;
    if(idtc == 1){
        $('#id_t_t').val('2').trigger('change');
    }else{
        $('#id_t_t').val('').trigger('change');
    }

});


$('#id_col').on('change', function(){

    let idcol = sel('#id_col').value;
    if(idcol != ""){
        fetch(`business/catalogos/ciudadanos/ajax/get_calles.php?colonia=${ idcol }`)
        .then((result) => result.json())
        .then(function({ done, resp, icon, calles, codpos }){
            if(done){
                sel('#id_calle').innerHTML  = calles;
                sel('#id_calle_1').innerHTML  = calles;
                sel('#id_calle_2').innerHTML  = calles;
                sel('#cp').value  = codpos;
            }else{ 
                Swal.fire({
                    icon: icon,
                    title: ':(...',
                    text: resp
                });
            }
        })
        .catch(function(error){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: error
            });
        });
    }

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

    const ruta = 'business/catalogos/ciudadanos/ajax/insert_reg';
    const data = new FormData( frm_new );

    fetch(ruta,{
        method: 'POST',
        body:   data
    })
    .then((result) => result.json())
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


const getCalles = ( calle, calle_1, calle_2 ) => {

    let idcol = sel('#id_col').value;
    if(idcol != ""){
        fetch(`business/catalogos/ciudadanos/ajax/get_calles.php?colonia=${ idcol }`)
        .then((result) => result.json())
        .then(function({ done, resp, icon, calles }){
            if(done){
                sel('#id_calle').innerHTML  = calles;
                sel('#id_calle_1').innerHTML  = calles;
                sel('#id_calle_2').innerHTML  = calles;
                $('#id_calle').val(calle).trigger('change');
                $('#id_calle_1').val(calle_1).trigger('change');
                $('#id_calle_2').val(calle_2).trigger('change');
            }else{ 
                Swal.fire({
                    icon: icon,
                    title: ':(...',
                    text: resp
                });
            }
        })
        .catch(function(error){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: error
            });
        });
    }

}


const frm_upt = sel('#frm_edit');
if(frm_upt != null){
    frm_upt.addEventListener('submit', function(event){
        event.preventDefault();
        handleSubmitUpdate( frm_upt );
    });
}

const handleSubmitUpdate = ( frm_upt ) => {
    
    deshabilitarboton('btn_guardar_e', 1);

    const ruta = 'business/catalogos/ciudadanos/ajax/update_reg.php';
    const data = new FormData( frm_upt );

    fetch(ruta,{
        method: 'POST',
        body:   data
    })
    .then((result) => result.json())
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