<?php 
        verificarSesion();
        echo $json;
?>

<section class="inicio">
    <div class="header">
        <h1>OdonSecure</h1>
        <nav>
            <a href="/cerrarSession" class="btn verdeClaro">Cerrar Sesion</a>
        </nav>
    </div>

    <p class="log_nombre">Bienvenido, <?php echo $_SESSION["nombre"]; ?>. Que deseas agendar</p><hr>

    <div class="paginador">
        <button data-paso="1" id="tab1" class="tab verde seleccionado" style="cursor: pointer;">SERVICIOS</button>
        <button data-paso="2" id="tab2" class="tab verde" style="cursor: pointer;">DETALLES</button>
        <button data-paso="3" id="tab3" class="tab verde" style="cursor: pointer;">RESUMEN</button>
    </div>

    <div class="alertas"></div>

    <form class="formulario">
        <div id="paso1" class="paginaTab mostrar">
            <h2>Servicios</h2>
            <div class="servicios">

            </div> 
        </div>

        <div id="paso2" class="paginaTab">
            <h2>Detalles</h2>

            <div class="campo">
                <label>Nombre</label>
                <input type="text" value="<?php echo $_SESSION["nombre"]; ?>" disabled name="nombre" id="nombre">
            </div>
            <div class="campo">
                <label for="date">Fecha</label>
                <input type="date" id="date" name="date" min=<?php echo date("Y-m-d"); ?>>
            </div>
            <div class="campo">
                <label for="time">Fecha</label>
                <input type="time" id="time" name="time">                
            </div>
        </div>

        <div id="paso3" class="paginaTab">
            <h2>Resumen</h2>
            <div class="resumen">
                <p class="nombreCliente"></p>
                <p class="fechaCita"></p>
                <p class="horaCita"></p>
                <p class="nombreServicios"></p>
                <p class="total"></p>
            </div>
            <div class="botonAgendar" style="margin-top: 30px;">
                <a class="button_agendar btn verde" style="display: none;">Agendar Cita</a>
            </div>
        </div>
    </form>
    

    <div class="botones_paginador">
        <button class="btn verdeClaro ocultar_btn" id="anterior">&laquo; Anterior</button>
        <button class="btn verdeClaro" id="siguiente">Siguiente &raquo;</button>
    </div>
</section>

<?php
    scripts("paginador");
?>