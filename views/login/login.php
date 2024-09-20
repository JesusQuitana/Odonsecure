<section class="login">   
    <h2>Login</h2>
    
    <?php mostrarAlertas($alertas); ?>

    <form method="post" class="formulario">
        <div class="campo">
            <label for="user">Usuario</label>
            <input type="text" id="user" name="user" placeholder="Ingresa tu Usuario">
        </div>
        <div class="campo">
            <label for="passw">Contraseña</label>
            <input type="password" id="passw" name="passw" placeholder="Ingresa tu Contraseña">
        </div>
        <input type="submit" value="Enviar" class="btn verde">
    </form>
    <p class="inicio_sesion">Presiona el siguiente enlace si no tienes cuenta &raquo; <a href="/register">Registrarse</a></p>
    <p class="inicio_sesion">¿Olvidaste tu clave? &raquo; <a href="/forget">Reestablece ahora</a></p>
</section>

<?php scripts("removerAlerta"); ?>
