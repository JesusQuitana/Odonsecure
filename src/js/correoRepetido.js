const datosRegistro = {
    "email" : "",
    "user" : ""
};

document.addEventListener("DOMContentLoaded", ()=>{
    init();
})

function init() {
    correoRepetido();
}

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

function correoRepetido() {
    const email = document.querySelector("#email");
    const user = document.querySelector("#user");

    email.addEventListener("input", (e) => {
        verificar(datosRegistro.email = e.target.value);
    })

    user.addEventListener("input", (e) => {
        verificar(datosRegistro.user = e.target.value);
    })
}

async function verificar(dato) {
    const url = `${location.origin}/log/repeat`;
    const emailInput = document.querySelector("#email");
    const userInput = document.querySelector("#user");

    const {email, user} = datosRegistro;

    const datos = new FormData();
    datos.append("email", email);
    datos.append("user", user);

    const respuesta = await fetch(url, {
        method : "POST",
        body : datos
    })
    const resultado = await respuesta.json();

    if(resultado[0]!==null || resultado[1]!==null) {
        emailInput.value = "";
        userInput.value = "";
        alerta("rojo", "Contraseña o Usuario ya registrado");
        datosRegistro.user = "";
        datosRegistro.email = "";
    }
}