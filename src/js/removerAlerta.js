document.addEventListener("DOMContentLoaded", function() {
    quitarAlertas();
})

function quitarAlertas() {
    const alertas = document.querySelectorAll(".alerta");
    setTimeout(()=> {
        alertas.forEach((alerta)=> {
            alerta.remove();
        });
    }, 2000);
}