import Swal from 'sweetalert2';
import '@sweetalert2/theme-dark/dark.min.css';

import { sel, deshabilitarboton, habilitaboton } from '../../helpers/general';

const btn_search = sel('#btnSearch');
const frm_search = sel('#frmSearch');
const mdl_search = $('#idModalSearch');

if(btn_search != null){
    btn_search.addEventListener("click", function(e){
        openModalSearch();
    });
}

const openModalSearch = () => {
    mdl_search.modal('show');
    mdl_search.on('shown.bs.modal', function(e){
        sel('#txtBuscar').focus();
    });
}

if(frm_search != null){
    frm_search.addEventListener('submit', function(event){
        event.preventDefault();
        handleSubmitSearch( frm_search );
    });
}

const handleSubmitSearch = ( frm ) =>  {

    deshabilitarboton('btn_search', 1);

    const ruta = 'business/catalogos/comunidades/ajax/busqueda.php';
    const data = new FormData( frm );

    fetch(ruta,{
        method: 'POST',
        body:   data
    })
    .then((resultado) => resultado.json())
    .then(function({ done, resp, icon }){
        if(done){
            const ref = window.location.search;
            const urlSearch = `${ ref }&busqueda=${ resp }`;
            window.location = urlSearch;
        }else{
            Swal.fire({
                icon: icon,
                title: 'Oops...',
                text: resp,
                allowOutsideClick: false
            });
            habilitaboton('btn_search');
        }
    })
    .catch(function(error){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: error,
            allowOutsideClick: false
        })
        habilitaboton('btn_search');
    });
}


window.handleDeleteReg = ( id, type, nivel ) => {

    const icon = (type == 3) ? 'warning' : 'info';
    const showDelete = (type == 0) ? ' dar de baja' :
        (type == 3) ? ' eliminar' : ' dar de alta';

    Swal.fire({
        title: `¿Estás seguro de ${ showDelete } el registro?`,
        text: "",
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar'
    }).then((result) => {

        if (result.isConfirmed) {
            changeStatus(id, type);
        }
    });

}

const changeStatus = (id, status) => {

    const data = new FormData();

    data.append('id', id);
    data.append('tipo', status);

    const url = 'business/catalogos/comunidades/ajax/update_status.php';

    fetch(url, {
            method: 'POST',
            body: data
        })
        .then((resp) => resp.json())
        .then(function({ done, resp, icon }) {
            if (done == 1) {
                Swal.fire({
                        title: '¡Listo!',
                        text: resp,
                        icon: icon
                    })
                    .then(() => {
                        location.reload()
                    });
            } else {
                Swal.fire({
                    icon: icon,
                    title: 'Oops...',
                    text: resp
                });
            }
            habilitaboton('btn_aceptar_cpw');
        })
        .catch(function(error) {
            Swal.fire({
                icon: 'error',
                title: ':( ...',
                text: error
            });
            habilitaboton('btn_aceptar_cpw');
        });
}