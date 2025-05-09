<!-- VISTA PARA ELEGIR LOS SERVICIOS A AGENDAR EN UNA MISMA CITA -->

<h1 class="nombre-pagina">Registra tu nueva cita</h1>
<p class="descripcion-pagina">Elije tus servicio y coloca tus datos</p>

<?php include_once __DIR__ . '/../templates/barra.php' ?>

<div id="app">

    <!-- PESTEÑAS -->
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Información cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>

    <!-- PASO 1 -->
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuación</p>

        <div class="listado-servicios" id="servicios"></div>
    </div>

    <!-- PASO 2 -->
    <div id="paso-2" class="seccion">

        <h2>Tus datos y citas</h2>
        <p class="text-center">Coloca tus datos y fecha de la cita</p>

        <!-- FORMULARIO PARA EL REGISTRO DE LA CITA -->
        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="Tu nombre" value="<?php echo $nombre; ?>" disabled>
            </div>
            <div class="campo">
                <label for="nombre">Fecha</label>
                <input type="date" id="fecha" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
            </div>
            <div class="campo">
                <label for="nombre">Hora</label>
                <input type="time" id="hora">
            </div>
            <input type="hidden" id="id" value="<?php echo $id; ?>">
        </form>
    </div>

    <!--  PASO 3-->
    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Verificar que la información sea correcta</p>
    </div>

    <!-- PAGINACIÓN -->
    <div class="paginacion">
        <button class="boton" id="anterior">&laquo; Anterior</button>
        <button class="boton" id="siguiente">Siguiente &raquo;</button>
    </div>
</div>

<?php $script = "

<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script src='build/js/app.js'></script>";
?>