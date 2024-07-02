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

    const ruta = 'business/admin/sis_roles/ajax/busqueda.php';
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
            icon: icon,
            title: 'Oops...',
            text: error,
            allowOutsideClick: false
        })
        habilitaboton('btn_search');
    });
}