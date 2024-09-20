<?php 
        verificarSesionAdmin();
?>

<section class="admin">
    <div class="header">
        <h1>OdonSecure</h1>
        <nav>
            <a href="/cerrarSession" class="btn verdeClaro">Cerrar Sesion</a>
        </nav>
    </div>

    <p class="log_nombre">Bienvenido, Admin.</p><hr>

    <form class="formulario">
        <div class="campo">
            <label for="date">Fecha</label>
            <input type="date" name="date" id="date">
        </div>
        <div class="campo">
            <label for="user">Cliente</label>
            <input type="text" name="user" id="user">
        </div>
    </form>

    <div class="citasBody">
        
    </div>

</section>

<?php
    scripts("admin");
?>