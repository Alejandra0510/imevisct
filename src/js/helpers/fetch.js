import { inArray } from "jquery";
import Swal from 'sweetalert2';
import '@sweetalert2/theme-dark/dark.min.css';

const sel = selector => document.querySelector(selector);

export const fetchWithOutToken = (endpoint, data, method = 'POST') => {

    if (method === 'GET') {
        return fetch(endpoint);
    } else {
        return fetch(endpoint, {
            method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
    }
}

const apiAddress = (id_d, type, period, select, focusItem) => {
    const data = new FormData();
    const selectDireccion = sel(select);
    let option;

    data.append('id', id_d);
    data.append('tipo', type);
    data.append('periodo', period);

    // const url = 'http://192.1.1.37/adminSTI/rest/dependencias/direccion.php';
    const url = 'business/ajax/getDataDireccionesApi.php';

    if( selectDireccion !== null ){

        fetch(url, {
                method: 'POST',
                body: data
        })
        .then((resp) => resp.json())
        .then(function({ done, direccion }) {
            if (done == 1) {
                option = `<option value=''> </option>`;
                direccion.map(({ id, nombre }) => {

                    let selected;
                    if (id_d == id) {
                        selected = "selected";
                    }
                    option = option + `<option value='${id}' ${selected}> ${nombre} </option>`;
                })

                selectDireccion.innerHTML = option;
                // focusItem.focus();
            }
        });
    }else{
        focusItem.focus();
    }

}


const apiArea = (id_dir, id_area ,type, period, select) => {
    
    const data = new FormData();
    const selectArea = sel(select);
    let option;

    data.append('id_direccion', id_dir);
    data.append('id_area', id_area);
    data.append('type', type);
    data.append('periodo', period);

    const url = 'http://192.1.1.37/adminSTI/rest/dependencias/area.php';
    // const url = 'business/ajax/getDataAreasApi.php';
    

    fetch(url, {
            method: 'POST',
            body: data
        })
        .then((resp) => resp.json())
        .then(function({ done, area }) {
            if (done == 1) {
                option = `<option value=''> </option>`;
                area.map(({ id, nombre }) => {

                    let selected;
                    if (id_area == id) {
                        selected = "selected";
                    }
                    option = option + `<option value='${id}' ${selected}> ${nombre} </option>`;
                })

                selectArea.innerHTML = option;
            }
        })
}

const apiArrayAddress = (arrayD, type, period, select, focusItem) => {

    const data = new FormData();
    const selectDireccion = sel(select);
    let option;
    
    data.append('id', arrayD);
    data.append('tipo', type);
    data.append('periodo', period);

    // const url = 'http://192.1.1.37/adminSTI/rest/dependencias/direccion.php';
    const url = 'business/ajax/getDataDireccionesApi.php';

    if( selectDireccion !== null ){
        fetch(url, {
                method: 'POST',
                body: data
        })
        .then((resp) => resp.json())
        .then(function({ done, direccion }) {
            if (done == 1) {
                option = `<option value=''> </option>`;
                direccion.map(({ id, nombre }) => {
                   
                    let selected;
                    for (let i = 0; i < arrayD.length; i++) {

                        if (arrayD[i].indexOf(id) > -1) {
                            selected = "selected";
                        }
                    }                     
                    option = option + `<option value='${id}' ${selected}> ${nombre} </option>`;
                })

                selectDireccion.innerHTML = option;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: direccion
                });
            }
        });
    }else{
        focusItem.focus();
    }

}


const ApiDirectorio = (id_d, type, period) => {

    const data = new FormData();

    data.append('id', id_d);
    data.append('tipo', type);
    data.append('periodo', period);

    // const url = 'http://192.1.1.37/adminSTI/rest/dependencias/direccion.php';
    const url = 'business/ajax/getDirectorioApi.php';

    fetch(url, {
            method: 'POST',
            body: data
        })
        .then((resp) => resp.json())
        .then(function({ done, direccion }) {
            console.log(direccion);
            if (done == 1) {
                direccion.map(({ id_direccion, funcionario, cargo }) => {

                    if(id_d == id_direccion){
                        sel('#nombre_remitente').value = funcionario;
                        sel('#cargo_remitente').value = cargo;
                    }

                })
                // focusItem.focus();
            }
        });

}


const ApiADirectorio = (id_d, id_a, type, period) => {

    const data = new FormData();

    data.append('id_direccion', id_d);
    data.append('id_area', id_a);
    data.append('type', type);
    data.append('periodo', period);

    // const url = 'http://192.1.1.37/adminSTI/rest/dependencias/area.php';
    const url = 'business/ajax/getADirectorio.php';
    

    fetch(url, {
            method: 'POST',
            body: data
        })
        .then((resp) => resp.json())
        .then(function({ done, area }) {
            if (done == 1) {
                console.log(area);
                area.map(({ id_area, funcionario, puesto  }) => {

                    if(id_a == id_area){
                        sel('#nombre_remitente').value = funcionario;
                        sel('#cargo_remitente').value = puesto;
                    }

                })

            }
        })

}


export {
     apiAddress, apiArea, apiArrayAddress, ApiDirectorio, ApiADirectorio
}