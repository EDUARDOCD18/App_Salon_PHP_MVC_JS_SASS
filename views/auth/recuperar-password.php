<!-- FORMULARIO PARA NUEVA CLAVE DE ACCESO -->

<h1 class="nombre-pagina">Recupera tu clave de acceso</h1>

<?php include_once __DIR__ . "/../templates/alertas.php" ?> <!-- Importa el template de las alertas -->

<?php if($error) return null; ?>

<p class="descripcion-pagina">Coloca tu nueva clave de acceso a continuación</p>

<form class="fomulario" method="POST">
    <div class="campo">
        <label for="password">Clave</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Tu nueva clave">
    </div>
    <input type="submit" value="Guardar clave" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes cuenta? Inicar Sesión</a>
    <a href="/crear-cuenta">¿No tienes cuenta? Crea una aquí</a>
</div>