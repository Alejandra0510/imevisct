import Swal from 'sweetalert2';
import '@sweetalert2/theme-dark/dark.min.css';

import { sel, deshabilitarboton, habilitaboton } from '../../helpers/general';

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

});