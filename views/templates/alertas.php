<?php
foreach ($alertas as $key => $mensajes) :
    foreach ($mensajes as $mensaje) :
?>

        <div class="alerta <?php echo $key; ?> animar">
            <?php echo $mensaje; ?>
        </div>

<?php
    endforeach;
endforeach;
?>