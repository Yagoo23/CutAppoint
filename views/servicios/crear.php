<h1 class="nombre-pagina">Nuevo servicio</h1>
<p class="descripcion-pagina">Llena todos los campos para añadir un nuevo servicio</p>
<?php 
    include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
 ?>

<form class="formulario" action="/servicios/crear" method="post">
    <?php include_once __DIR__ . '/formulario.php'; ?>
    <input type="submit" value="Guardar servicio" class="boton">
</form>