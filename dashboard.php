<?php
    session_start();

    if(!isset($_SESSION['usuario'])){
        echo '
            <script>
                alert("Se debe iniciar sesion para acceder");
                window.location = "index.php";
            </script>
        ';
        session_destroy();
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/dash.css">
    <title>Document</title>
</head>
<body>
    <header class="header">
        <nav>
            <ul class="nav-links">
                <li><a href="#">Productos</a></li>
                <li><a href="#">Proovedores</a></li>
                <li><a href="#">Ventas</a></li>
                <li><a href="php/cerrar_sesion.php">Salir</a></li>
            </ul>
        </nav>
    </header>
    <section>

    </section>
</body>
</html>