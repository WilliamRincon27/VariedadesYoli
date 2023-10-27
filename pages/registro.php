<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/registro.css">
    <title>Registro</title>
</head>
<body>
    <form action="../php/registro_usuari_be.php" method="POST" class="form-register">
        <h4>Formulario de Registro</h4>
        <input class="controls" type="text" name="nombre" id="nombre" placeholder="Nombre">
        <input class="controls" type="text" name="apellido" id="apellido" placeholder="Apellido">
        <input class="controls" type="email" name="email" id="email" placeholder="Email">
        <input class="controls" type="password" name="password" id="password" placeholder="Contraseña">
        <select class="controls" name="documento" id="documento">
            <option value="value0">Tipo de documento</option>
            <option value="value1">cedula de ciudadania</option>
            <option value="value2">Tarjeta de identidad</option>
        </select>
        <input class="controls" type="text" name="identificacion" id="identificacion" placeholder="Numero de identificacion">
        <input class="controls" type="text" name="telefono" id="telefono" placeholder="Telefono">
        <button class="btn">Registrarse</button>
        <a href="../index.php">¿Ya tienes una cuenta?</a>
    </form>
</body>
</html>