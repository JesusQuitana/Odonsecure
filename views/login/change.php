<section class="change">
    <h2>Reestablecer Contraseña</h2>

    <?php mostrarAlertas($alertas); ?>
    
    <form method="post" class="formulario">
        <div class="campo">
            <label for="password">Nueva Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Ingrese la Nueva Contraseña">
        </div>
        <div class="campo">
            <label for="repeat_password">Confirme Contraseña</label>
            <input type="password" id="repeat_password" name="repeat_password" placeholder="Repita la Nueva Contraseña">
        </div>
        <input type="submit" value="Enviar" class="btn verde">
    </form>
    <p class="inicio_sesion">Ya tienes cuenta? Ingresa en el siguiente link &raquo; <a href="/">Iniciar Sesion</a></p>

</section>
<?php scripts("removerAlerta"); ?>
