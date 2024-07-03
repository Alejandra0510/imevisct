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
        sel('#name_s').focus();
    });
}


if(frm_search != null){
    
}