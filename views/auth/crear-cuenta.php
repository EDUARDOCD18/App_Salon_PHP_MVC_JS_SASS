<h1 class="nombre-pagina">Crea una cuenta</h1>
<p class="descripcion-pagina">Completa este formulario para crear tu cuenta</p>

<?php include_once __DIR__ . "/../templates/alertas.php" ?>

<form action="/crear-cuenta" class="formulario" method="post">
    <div class="campo">
        <label for="nombre">Nombres</label>
        <input
            type="text"
            id="nombre"
            name="nombre"
            placeholder="Tu nombre"
            value="<?php echo s($usuario->nombre); ?>">
    </div>
    <div class="campo">
        <label for="nombre">Apellidos</label>
        <input
            type="text"
            id="apellido"
            name="apellido"
            placeholder="Tu apellido"
            value="<?php echo s($usuario->apellido); ?>">
    </div>
    <div class="campo">
        <label for="telefono">Teléfono</label>
        <input
            type="tel"
            id="telefono"
            name="telefono"
            placeholder="Tu número de teléfono"
            value="<?php echo s($usuario->telefono); ?>">
    </div>
    <div class="campo">
        <label for="email">Correo</label>
        <input
            type="email"
            id="email"
            name="email"
            placeholder="Tu correo"
            value="<?php echo s($usuario->email); ?>">
    </div>
    <div class="campo">
        <label for="password">Tu clave</label>
        <input
            type="password"
            id="password"
            name="password"
            placeholder="Tu clave">
    </div>

    <input type="submit" value="Registrar" class="boton">

    <div class="acciones">
        <a href="/">¿Ya posees cuenta? Inicia sesión</a>
        <a href="/olvide">¿Olvidaste te clave? Recupérala aquí</a>
    </div>
</form>