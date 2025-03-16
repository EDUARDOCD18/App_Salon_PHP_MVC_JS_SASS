<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>

<form action="/" class="formulario" method="post">
    <div class="campo">
        <label for="email">Correo</label>
        <input
            type="email"
            placeholder="Tu correo electrónico"
            id="email"
            name="email" />
    </div>

    <div class="campo">
        <label for="password">Clave</label>
        <input
            type="password"
            placeholder="Tu clave"
            id="passwordd¡"
            name="password" />
    </div>

    <input type="submit" class="boton" value="Iniciar sesión">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿No te has registrado? Crea tu cuenta</a>
    <a href="/olvide">¿Olvidaste te clave? Recupérala aquí</a>
</div>