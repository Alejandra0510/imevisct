import Swal from 'sweetalert2';
import '@sweetalert2/theme-dark/dark.min.css';

import { sel, deshabilitarboton, habilitaboton } from '../../helpers/general';

const frm_account = sel('#frmAccount');

if (frm_account != null) {
    frm_account.addEventListener('submit', function(event) {
        event.preventDefault();
        handleSubmitAccount(frm_account);
    });
}

const handleSubmitAccount = (form) => {

    deshabilitarboton('btn_guardar', 1);

    const data = new FormData(form);
    const url = 'business/sys/ajax/edit_acount.php';

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
                    .then((result) => {
                        let ruta = sel("#current_file").value;
                        window.location.assign(`${ruta}`);
                    });
            } else {
                Swal.fire({
                        icon: icon,
                        title: 'Oops...',
                        text: resp
                    })
                    .then(() => {
                        sel("#nombre").focus();
                    });
            }
            habilitaboton('btn_guardar');
        })
        .catch(function(error) {
            Swal.fire({
                icon: 'error',
                title: ':( ...',
                text: error
            });
            habilitaboton('btn_guardar');
        });
}

//Cambiar contraseña
const frm_pass   = sel('#idCPW');
const modal_pass = $('#idModalcpw');

window.cpwModal = () => {
    modal_pass.modal('show');
    modal_pass.on('shown.bs.modal', function(e){
    });
}

sel('#pass_random').addEventListener('change', function(){
    let check_pass = sel('#pass_random');

    if(check_pass.checked){
        let pass_g = "";
        let caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        for (var i = 0; i < 16; i++) {
            pass_g += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
        }

        sel('#nuevaclave').value = pass_g;
        sel('#confclave').value = pass_g;

    }else{
        sel('#nuevaclave').value = "";
        sel('#confclave').value = "";
    }
});


window.view_password = (id_b) => {
    if(id_b != null){
        if(id_b == 1){
            let pass = sel('#clave');
            let btn  = $('#p');
            if(pass.type == 'password'){
                pass.type = 'text';
                btn.removeClass('fa fa-eye-slash');
                btn.addClass('fa fa-eye');
            }else{
                pass.type = 'password';
                btn.removeClass('fa fa-eye');
                btn.addClass('fa fa-eye-slash');
            }
        }else if(id_b == 2){
            let pass_1 = sel('#nuevaclave');
            let btn_1  = $('#p1');
            if(pass_1.type == 'password'){
                pass_1.type = 'text';
                btn_1.removeClass('fa fa-eye-slash');
                btn_1.addClass('fa fa-eye');
            }else{
                pass_1.type = 'password';
                btn_1.removeClass('fa fa-eye');
                btn_1.addClass('fa fa-eye-slash');
            }
        }else{
            let pass_2 = sel('#confclave');
            let btn_2  = $('#p2');
            if(pass_2.type == 'password'){
                pass_2.type = 'text';
                btn_2.removeClass('fa fa-eye-slash');
                btn_2.addClass('fa fa-eye');
            }else{
                pass_2.type = 'password';
                btn_2.removeClass('fa fa-eye');
                btn_2.addClass('fa fa-eye-slash');
            }
        }
    }
}


window.validate_pass = (id_i) => {
    if(id_i != null){
        let password;
        let div_p1;
        let span_txt;

        if(id_i == 2){
            password = sel('#nuevaclave').value;
            div_p1   = $('#div_p1');
            span_txt = sel('#pass_validate_error');
        }else{
            password = sel('#confclave').value;
            div_p1   = $('#div_p2');
            span_txt = sel('#pass_validate_error_2');
        }

        if(password != "" && password.length > 0 && password != null){
            if(password.length < 8){
                div_p1.addClass('has-error');
                span_txt.innerHTML = 'Contraseña no segura, debe tener como mínimo 8 caracteres';
            }else if(password.length > 16){
                div_p1.addClass('has-error');
                span_txt.innerHTML = 'No debe de tener más de 16 caracteres';
            }else if(!password.match(/\d/)){
                div_p1.addClass('has-error');
                span_txt.innerHTML = 'Debe de tener como mínimo un número';
            }else if(!password.match(/[A-z]/)){
                div_p1.addClass('has-error');
                span_txt.innerHTML = 'Debe de tener como mínimo una letra';
            }


            if(password.length > 8 && password.length <= 16 && password.match(/[A-z]/) && password.match(/\d/)){

                div_p1.removeClass('has-error');
                div_p1.addClass('has-success');
                span_txt.innerHTML = 'Contraseña segura';  

                let password_1 = sel('#nuevaclave').value;
                let password_2 = sel('#confclave').value;
                
                if(password_1 != "" && password_2 != ""){
                    if(password_1 != password_2){
                        $('#div_p2').removeClass('has-success');
                        $('#div_p2').addClass('has-error');
                        sel('#pass_validate_error_2').innerHTML = 'No coinciden las contraseñas';
                    }
                }
            }

        }else{
            div_p1.removeClass('has-error');
            div_p1.removeClass('has-success');
            span_txt.innerHTML = '';
        }
    }
}


    

if (frm_pass != null) {
    frm_pass.addEventListener('submit', function(event) {
        event.preventDefault();
        handleSubmitPassword(frm_pass);
    });
}

const handleSubmitPassword = (form) => {

    deshabilitarboton('btn_guardar', 1);

    const data = new FormData(form);
    const url  = 'business/sys/ajax/cwp.php';

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
                    .then((result) => {
                        let ruta = sel("#current_file").value;
                        window.location.assign(`${ruta}`);
                    });
            } else {
                Swal.fire({
                        icon: icon,
                        title: 'Oops...',
                        text: resp
                    })
                    .then(() => {
                        sel("#nombre").focus();
                    });
            }
            habilitaboton('btn_guardar');
        })
        .catch(function(error) {
            Swal.fire({
                icon: 'error',
                title: ':( ...',
                text: error
            });
            habilitaboton('btn_guardar');
        });
}