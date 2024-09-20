<section class="forget">
    <h2>Olvido de Contraseña</h2>
    <?php mostrarAlertas($alertas); ?>
    <form method="post" class="formulario">
        <div class="campo">
            <label for="email">E-Mail</label>
            <input type="email" id="email" name="email" placeholder="Tu E-Mail Registrado">
        </div>
        <input type="submit" value="Enviar" class="btn verde">
    </form>
    <p class="inicio_sesion">Ya tienes cuenta? Ingresa en el siguiente link &raquo; <a href="/">Iniciar Sesion</a></p>

</section>
