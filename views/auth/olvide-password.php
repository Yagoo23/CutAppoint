<h1 class="nombre-pagina">Olvidé contraseña</h1>
<p class="descripcion-pagina">Restablece tu contraseña escribiendo tu email a continuación</p>

<form action="/olvide" method="post" class="formulario">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Tu Email" required>
    </div>
    <input type="submit" value="Enviar instrucciones" class="boton">
    <div class="acciones">
        <a href="/">¿Ya tienes cuenta? Inicia Sesión</a>
        <a href="/crear-cuenta">¿Aún no tienes cuenta? Crea una</a>
</form>