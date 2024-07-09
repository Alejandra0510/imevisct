import Swal from 'sweetalert2';
import '@sweetalert2/theme-dark/dark.min.css'

import { sel, deshabilitarboton, habilitaboton, hide, show } from '../../helpers/general';

document.addEventListener("DOMContentLoaded", function(){
    $('#name_calle').focus();
    $('#id_vialidad').select2();
    $('#id_col').select2();
});