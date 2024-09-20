let total = 0;

document.addEventListener("DOMContentLoaded", function() {
    iniciarApp();
});

function iniciarApp() {
    allCitas();
    foundCita();
}

async function allCitas() {
    const url = `${location.origin}/admin/all`;
    const citas = await fetch(url)
    const respuesta = await citas.json();
       
    // Crear un Map para almacenar las citas con sus servicios
    const citaServicios = new Map();

    respuesta.forEach((cita) => {
        const {id, cliente, email, fecha, hora, precio, servicio, telefono} = cita; // Desestructurar para obtener id y servicio y demas

        // Si la cita ya existe en el Map, agregar el servicio al arreglo existente
        if (citaServicios.has(id)) {
            citaServicios.get(id).total += parseFloat(precio);
            citaServicios.get(id).servicios.push(servicio);
        } else {
        // Si la cita no existe, crear una nueva entrada en el Map
        citaServicios.set(id, {
            id,
            fecha,
            hora,
            cliente,
            email,
            total : parseFloat(precio),
            servicios: [servicio]
        });
        }
    });

    // Iterar sobre el Map y mostrar las citas con todos sus servicios
    citaServicios.forEach((citaServicio) => {
        mostrarCita(citaServicio); // Aquí mostrarías la cita en tu interfaz
    });

}

function foundCita() {
    const fecha = document.querySelector("#date");
    const user = document.querySelector("#user");

    fecha.addEventListener("input", (e) => {
        const citaAnterior = document.querySelectorAll(".cita")
        if(citaAnterior!==null) {
            citaAnterior.forEach((cita)=>{
                cita.remove();
            })
        }
        consultarCita(e.target.value, user.value);
    })

    user.addEventListener("input", (e) => {
        const citaAnterior = document.querySelectorAll(".cita")
        if(citaAnterior!==null) {
            citaAnterior.forEach((cita)=>{
                cita.remove();
            })
        }
        consultarCita(fecha.value, e.target.value);
    })
}

async function consultarCita(fecha, user) {
    const url = `${location.origin}/admin/find`;
    
    const find = new FormData();
    find.append("fecha", fecha);
    find.append("user", user);

    const foundCitaDate = await fetch(url, {
        method : "POST",
        body : find
    })
    const respuesta = await foundCitaDate.json();

    // Crear un Map para almacenar las citas con sus servicios
    const citaServicios = new Map();

    respuesta.forEach((cita) => {
        const {id, cliente, email, fecha, hora, precio, servicio, telefono} = cita; // Desestructurar para obtener id y servicio y demas

        // Si la cita ya existe en el Map, agregar el servicio al arreglo existente
        if (citaServicios.has(id)) {
        citaServicios.get(id).servicios.push(servicio);
        } else {
        // Si la cita no existe, crear una nueva entrada en el Map
        citaServicios.set(id, {
            id,
            fecha,
            hora,
            cliente,
            email,
            servicios: [servicio]
        });
        }
    });

    // Iterar sobre el Map y mostrar las citas con todos sus servicios
    citaServicios.forEach((citaServicio) => {
        mostrarCita(citaServicio); // Aquí mostrarías la cita en tu interfaz
    });
}

function mostrarCita(citaServicio) {
    const citas = document.querySelector(".citasBody");
    const {id, cliente, fecha, hora, servicios, email, total} = citaServicio;

    const contenedorCita = document.createElement("DIV");
    contenedorCita.classList.add("cita");

    const idCita = document.createElement("P");
    idCita.innerHTML = `<span>Nro Cita:</span> 000${id}`;

    const nombreCliente = document.createElement("P");
    nombreCliente.innerHTML = `<span>Paciente:</span> ${cliente}`;

    const fechaCita = document.createElement("P");
    fechaCita.innerHTML = `<span>Fecha:</span> ${fecha}`;

    const horaCita = document.createElement("P");
    horaCita.innerHTML = `<span>Hora:</span> ${hora}`;

    const precioCita = document.createElement("P");
    precioCita.innerHTML = `<span>Total:</span> ${total}<span class="verde">$</span>`;

    const serviciosCita = document.createElement("P");
    serviciosCita.setAttribute("style", "display: none");
    servicios.forEach((servicio) => {
        serviciosCita.innerHTML += `${servicio}<br>`;
    })

    contenedorCita.appendChild(idCita);
    contenedorCita.appendChild(nombreCliente);
    contenedorCita.appendChild(fechaCita);
    contenedorCita.appendChild(horaCita);
    contenedorCita.appendChild(precioCita);
    contenedorCita.appendChild(serviciosCita);

    citas.appendChild(contenedorCita);

    contenedorCita.addEventListener("click", (e)=>{
        Swal.fire({
            showCloseButton : true,
            title: "<strong>Servicios</strong>",
            icon: "info",
            focusConfirm: false,
            html: `
              ${serviciosCita.innerHTML}
            `,
            confirmButtonText: `<svg  xmlns="http://www.w3.org/2000/svg"  width="18"  height="18"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-pdf"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" /><path d="M17 18h2" /><path d="M20 15h-3v6" /><path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" /></svg>`,
            confirmButtonColor: '#1cb435',
            showDenyButton: true,
            denyButtonText: `<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="18" height="18" viewBox="0 0 24 24" stroke-width="2" stroke="#fff" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M4 7l16 0" />
            <path d="M10 11l0 6" />
            <path d="M14 11l0 6" />
            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
            </svg>`

          }).then( (SweetAlertResult) => {
                if(SweetAlertResult.isConfirmed) {
                    enviarResumen(citaServicio);
                }
                else if(SweetAlertResult.isDenied) {
                    eliminarCita(citaServicio);
                }
          } )
    })

}

async function enviarResumen(datos) {
    const {id, cliente, fecha, hora, servicios, email, total} = datos;
    
    const pdf = new FormData();
    pdf.append("id", id)
    pdf.append("cliente", cliente)
    pdf.append("fecha", fecha)
    pdf.append("hora", hora)
    pdf.append("servicios", servicios)
    pdf.append("email", email)
    pdf.append("total", total)

    const url = `${location.origin}/admin/resumen`;

    const respuesta = await fetch(url, {
        method : "POST",
        body : pdf
    });
    const json = await respuesta.json();

    if(json) {
        Swal.fire({
            position: "center",
            icon: "success",
            title: "Tu cita ha sido enviada a tu correo",
            confirmButtonText: "Ok"
          }).then( ()=> {
            window.location.reload();
          } )
    } else {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Ocurrio un error al enviar su PDF!",
          }).then( ()=> {
            window.location.reload();
          } )
    }
}

async function eliminarCita(datos) {
    const {id, cliente, fecha, hora, servicios, email, total} = datos;
    const url = `${location.origin}/admin/delete`;

    datos = new FormData();
    datos.append("id", id);

    const respuesta = await fetch(url, {
        method : "POST",
        body : datos
    })
    const resultado = await respuesta.json();

    if(resultado.resultado) {
        Swal.fire({
            position: "center",
            icon: "success",
            title: "La cita ha sido eliminada",
            confirmButtonText: "Ok"
          }).then( ()=> {
            window.location.reload();
          } )
    } else {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Ocurrio un error al eliminar la cita!",
          }).then( ()=> {
            window.location.reload();
          } )
    }
}