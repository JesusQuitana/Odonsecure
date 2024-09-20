<section class="register">
    <h2>Registrate</h2>

    <?php
        mostrarAlertas($alertas);
    ?>

    <div class="alertas"></div>

    <form class="formulario" method="post">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" placeholder="Tu Nombre">
        </div>
        <div class="campo">
            <label for="apellido">Apellido</label>
            <input type="text" id="apellido" name="apellido" placeholder="Tu Apellido">
        </div>
        <div class="campo">
            <label for="email">E-Mail</label>
            <input type="email" id="email" name="email" placeholder="Tu E-Mail">
        </div>
        <div class="campo">
            <label for="telf">Telefono</label>
            <input type="number" id="telf" name="telf" placeholder="Tu Telefono" min="0">
        </div>
        <div class="campo">
            <label for="user">Usuario</label>
            <input type="text" id="user" name="user" placeholder="Tu Usuario">
        </div>
        <div class="campo">
            <label for="passw">Contraseña</label>
            <input type="password" id="passw" name="passw" placeholder="Tu Contraseña">
        </div>
        <div class="campo">
            <label for="passw_confirm">Repite Contraseña</label>
            <input type="password" id="passw_confirm" name="passw_confirm" placeholder="Repite Contraseña">
        </div>
        <input type="submit" class="btn verde" value="Enviar" id="submit">
    </form>

    <p class="inicio_sesion">Ya tienes cuenta? Ingresa en el siguiente link &raquo; <a href="/">Iniciar Sesion</a></p>
</section>

<?php
    scripts("removerAlerta");
    scripts("correoRepetido");
?>