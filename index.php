<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Variedades Yoli</title>
</head>

<body>
    <div class="logo">
        <img src="img/Logo.png" alt="Logo">
    </div>
    <div class="main">
        <div class="container">
            <div class="left-side">
                <img class="log" src="img/Logo2.jpg" alt="Logo 2">
                <p class="company-name">Una tienda, innumerables opciones: Variedades Yoli.</p>
                <div class="correo">
                    <i class="fa-solid fa-user"></i>
                    <p class="email">Variedadesyoli@gmail.com</p>
                </div>
                <p class="register-link">No te has registrado? <a class="button" href="pages/registro.php">Regístrate</a></p>
            </div>
            <form action="php/login_usuario_be.php" method="POST" class="right-side">
                <h2 class="login-header">Inicia sesión con tu cuenta</h2>
                <p class="welcome-text">Bienvenido a la tienda de variedades donde encontrarás todo lo que buscas con la
                    mejor calidad que puedes encontrar.</p>
                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="forgot-password">
                    <a href="#">¿Olvidaste la contraseña?</a>
                </div>
                <button class="button">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</body>

</html>