<!-- FORMULARIO PARA EL CASO EN QUE AL USUARIO SE LE OLVIDE LA CONTRASEÑA -->

<h1 class="nombre-pagina">Olvide clave</h1>
<p class="descripcion-pagina">Restablecer clave. Indica el correo asociado en la cuenta a continuación</p>

<?php include_once __DIR__ . "/../templates/alertas.php" ?> <!-- Importa el template de las alertas -->

<form action="/olvide" class="formulario" method="post">
    <div class="campo">
        <label for="email">Ingresa el correo</label>
        <input ç
            type="email"
            name="email"
            id="email"
            placeholder="correo@correo.com">
    </div>
    <input type="submit" class="boton" value="Enviar token">
</form>

<div class="acciones">
    <a href="/">¿Ya posees cuenta? Inicia sesión</a>
    <a href="/crear-cuenta">¿Aún no posees cuenta? Regístrate</a>
</div>