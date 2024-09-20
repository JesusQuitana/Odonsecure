let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    "nombre": "",
    "fecha" : "",
    "hora" : "",
    "servicios" : []
}

document.addEventListener("DOMContentLoaded", function() {
    
    initApp();
});


function initApp() {
    getServicios();
    getNombre();
    fechasDisponibles();
    horasDisponibles();
    tabs();
    botonesPaginador();
}

//CREAR ALERTAS
function alerta($color, $mensaje) {
    if(document.querySelector(".alerta")) {
        return;
    }

    const alerta = document.createElement("P");
    alerta.classList.add("alerta");
    alerta.classList.add($color);
    alerta.innerHTML = $mensaje;
    document.querySelector(".alertas").appendChild(alerta);
    setTimeout(()=>{
        alerta.remove();
    }, 2000);
}

//OBTENER CITA
function getCita() {

    if(Object.values(cita).includes('')) {
        alerta("rojo", "Debe agregar datos para generar la cita");
    } else {
        createResumen();
    }
}

//CREAR ELEMENTOS DEL RESUMEN
function createResumen() {
    const resumenCita = document.querySelector(".resumen")
    const botonAgendar = document.querySelector(".botonAgendar");


    const {nombre, fecha, hora, servicios} = cita;
    let precioTotal = 0;

    const fechaObj = new Date(fecha);
    const year = fechaObj.getFullYear();
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() +2;
    const opciones = {weekday: 'long', year: "numeric", month: 'long', day: 'numeric'}
    const fechaUTC = new Date(Date.UTC(year, mes, dia)).toLocaleDateString("es-CO", opciones);

    servicios.forEach((servicio)=>{
        precioTotal += parseFloat(servicio.precio);
    })

    const nombreCliente = document.querySelector(".nombreCliente")
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    const fechaCita = document.querySelector(".fechaCita")
    fechaCita.innerHTML = `<span>Dia:</span> ${fechaUTC}`;

    const horaCita = document.querySelector(".horaCita")
    horaCita.innerHTML = `<span>Hora:</span> ${hora} horas`;

    const nombreServicios = document.querySelector(".nombreServicios")
    nombreServicios.innerHTML = `<span>Servicios:</span> `;
    servicios.forEach((servicio)=>{
        nombreServicios.innerHTML += `${servicio.nombre}, `;
    })

    const total = document.querySelector(".total")
    total.innerHTML = `<span>Total:</span> ${precioTotal}<span class='precio'>$</span>`;

    const agendarCita = document.querySelector(".button_agendar");
    agendarCita.setAttribute("style", "display: inline-block")
    botonAgendar.addEventListener("click", ()=>{
        enviarCita();
    })

    if(resumenCita!==null) {
        resumenCita.appendChild(nombreCliente);
        resumenCita.appendChild(fechaCita);
        resumenCita.appendChild(horaCita);
        resumenCita.appendChild(nombreServicios);
        resumenCita.appendChild(total);
    }
}

//ENVIAR DATOS AL SERVIDOR
async function enviarCita() {
    const {nombre, fecha, hora, servicios} = cita;
    const serviciosId = servicios.map(servicio => servicio.id);

    const datos = new FormData();
    datos.append("nombre", nombre);
    datos.append("fecha", fecha);
    datos.append("hora", hora);
    datos.append("servicios", serviciosId);

    
    try {
        const url = `${location.origin}/resumen`;
        const resultado = await fetch(url, {
            method : "POST",
            body : datos
        })
        const respuesta = await resultado.json();

        if(respuesta.resultado===true) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Tu cita ha sido agendada, estaremos enviado por correo el resumen",
                confirmButtonText: "Ok"
              }).then( (result)=>{
                window.location.reload()
              } );
        } else {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Ocurrio un error al registrar su cita!",
              }).then( (result)=>{
                window.location.reload()
              } )
        }
    }
    catch(error) {
        console.log(respuesta)
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Ocurrio un error al registrar su cita!",
          }).then( ()=> {
            window.location.reload()
          } )
    }
}

//OBTENER SERVICIO CON FETCH API
async function getServicios() {
    try {
    const url = `${location.origin}/user/api`;
    const resultado = await fetch(url);
    const servicios = await resultado.json();

    mostrarServicios(servicios);

    } catch (error) {
        console.log(error)
    }
}

//MOSTRAR SERVICIOS
function mostrarServicios(json) {
    json.forEach((servicio)=>{
        const {id, nombre, precio} = servicio;
        const servicios = document.querySelector(".servicios");

        const service = document.createElement("DIV");
        const nombreServicio = document.createElement("P");
        const precioServicio = document.createElement("P");
        const informacionServicio = document.createElement("P");

        service.classList.add("servicio");
        nombreServicio.innerHTML = nombre;
        precioServicio.innerHTML = `${precio}<span>$</span>`;
        informacionServicio.innerHTML = "Haz click para seleccionar";

        service.appendChild(nombreServicio);
        service.appendChild(precioServicio);
        service.appendChild(informacionServicio);

        servicios.appendChild(service);

        service.addEventListener("click", ()=>{
            seleccionarServicio(servicio, service);
        });

    });
}

//SELECCION DE SERVICIOS
function seleccionarServicio(servicio, service) {
    const {servicios} = cita;

    if(servicios.some((agregado) => agregado.id === servicio.id)) {
        cita.servicios = servicios.filter( (agregado) => agregado.id !== servicio.id);
        service.classList.remove("seleccionado");
    } else {
        cita.servicios = [...servicios, servicio];
        service.classList.add("seleccionado");
    }
}

//ALAMCENAR EN EL OBJETO DE CITA EL NOMBRE
function getNombre() {
    const nombre = document.querySelector("#nombre");
    cita.nombre = nombre.value;
}

//FECHAS DISPONIBLES
function fechasDisponibles() {
    const date = document.querySelector("#date");

    date.addEventListener("input", (e) => {
        const fecha = new Date(e.target.value).getUTCDay();
        
        if([6, 0].includes(fecha)) {
            e.target.value = "";
            alerta("rojo", "Fines de Semana no Disponible");
        } else {
            cita.fecha = e.target.value;
        }
    });
}

//HORAS DISPONIBLES
function horasDisponibles() {
    const time = document.querySelector("#time");

    time.addEventListener("input", (e) => {
        const hora = e.target.value.split(":")[0];

        if(hora < 8 || hora > 17) {
            e.target.value = "";
            alerta("rojo", "Horario Comprendido entre las 08:00am y las 05:00pm")
        } else {
            cita.hora = e.target.value;
        }
    });
}

//PAGINADOR -- SELECCIONAR SECCION
function seleccionarSeccion() {
    const seccion = document.querySelector(`#paso${paso}`);
    const seccionAnterior = document.querySelector(".mostrar");
    const tabSeleccionado = document.querySelector(`#tab${paso}`);
    const tabSeleccionadoAnterior = document.querySelector(".seleccionado");

    if(seccionAnterior===seccion) return;
    if(tabSeleccionadoAnterior===tabSeleccionado) return;

    mostrarBotones();

    seccion.classList.add("mostrar");
    seccionAnterior.classList.remove("mostrar");
    tabSeleccionado.classList.add("seleccionado");
    tabSeleccionadoAnterior.classList.remove("seleccionado");
}

//TABS DEL PAGINADOR
function tabs() {
    const tabs = document.querySelectorAll(".paginador button");
    
    tabs.forEach(tab => {
        tab.addEventListener("click", (e) => {
            paso = parseInt( e.target.dataset.paso );
            seleccionarSeccion();
        });
    });
}

//BOTONES DE ANTERIOR Y SIGUIENTE DEL PAGINADOR
function botonesPaginador() {
    const botonAnterior = document.querySelector("#anterior");
    const botonSiguiente = document.querySelector("#siguiente");

    botonAnterior.addEventListener("click", (e) => {
        botonSiguiente.classList.remove("ocultar_btn");
        if(paso<=pasoInicial) return;
        paso -= 1;
        seleccionarSeccion();
    });

    botonSiguiente.addEventListener("click", (e) => {
        botonAnterior.classList.remove("ocultar_btn");
        if(paso>=pasoFinal) return;
        paso += 1;
        seleccionarSeccion();
    });
}

//BOTONOS DEL PAGINADOR INTERACTIVOS
function mostrarBotones() {
    const botonAnterior = document.querySelector("#anterior");
    const botonSiguiente = document.querySelector("#siguiente");

    if(paso===pasoInicial) {
        botonAnterior.classList.add("ocultar_btn");
        botonSiguiente.classList.remove("ocultar_btn");
    } else if(paso===pasoFinal) {
        botonSiguiente.classList.add("ocultar_btn");
        botonAnterior.classList.remove("ocultar_btn");
        getCita();
    } else {
        botonAnterior.classList.remove("ocultar_btn");
        botonSiguiente.classList.remove("ocultar_btn");
    }
}
