<?php
    session_start();

    if(!isset($_SESSION['usuario'])){
        echo '
            <script>
                alert("Se debe iniciar sesion para acceder");
                window.location = "../index.php";
            </script>
        ';
        session_destroy();
        die();
    }

    

    if(!empty($_POST)){
        $alert='';
        if(empty($_POST['identificacion']) || empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion'])){
            $alert='<p class="msg_error">Todos los campos son obligatorios</p>';
        }else{
            include "../php/conexion_be.php";

            $identificacion = $_POST['identificacion'];
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];

            $query = mysqli_query($conexion, "SELECT * FROM cliente WHERE identificacion = '$identificacion'");
            $result = mysqli_fetch_array($query);

            if($result > 0){
                $alert='<p class="msg_error">Este cliente ya esta registrado</p>';
            }else{
                $query_insert = mysqli_query($conexion, "INSERT INTO cliente(identificacion, nombre, telefono, direccion) VALUES('$identificacion', '$nombre', '$telefono', '$direccion')");

                if($query_insert){
                    $alert='<p class="msg_save">Cliente registrado correctamente</p>';
                }else{
                    $alert='<p class="msg_error">Error al registrar el cliente</p>';
                }
            }

        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/dash.css">
    <script src="https://kit.fontawesome.com/071e681d3e.js" crossorigin="anonymous"></script>
    <title>Registrar cliente</title>
</head>
<body>
    <header class="header">
        <nav>
            <h2 class="tHeader">Variedades Yoli</h2>
        </nav>
    </header>
    <section>
        <div class="wrapper">
            <div class="sidebar">
                <h2>Menu</h2>
                <ul>
                <li><a href="productos.php"><i class="fa-solid fa-box"></i>Productos</a></li>
                    <li><a href="#"><i class="fa-solid fa-gears"></i>Proveedores</i></a></li>
                    <li><a href="usuarios.php"><i class="fa-solid fa-users"></i>Usuarios</a></li>
                    <li><a href="clientes.php"><i class="fa-solid fa-user-large"></i>Clientes</a></li>
                    <li><a href="venta.php"><i class="fa-solid fa-cart-shopping"></i>Nueva Venta</a></li>
                    <li><a href="#"><i class="fa-regular fa-file"></i>Reportes</a></li>
                    <li><a href="../php/cerrar_sesion.php"><i class="fa-solid fa-right-from-bracket"></i>Cerrar sesion</a></li>
                </ul>
            </div>
            <div class="main_content">
                <div class="header_sidebar">Bienvenido al panel de geston de Variedades Yoli</div>
                <div class="info">
                    <div class="form_register">
                        <h1>Registrar cliente</h1>
                        <hr>
                        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

                        <form action="" method="post">
                            <label for="nombre">Identificacion</label>
                            <input type="text" name="identificacion" id="identificacion" placeholder="Identificacion del cliente">
                            <label for="precio">Nombre</label>
                            <input type="text" name="nombre" id="nombre" placeholder="Nombre del cliente">
                            <label for="proovedor">Telefono</label>
                            <input type="number" name="telefono" id="telefono" placeholder="Telefono">
                            <label for="existencia">Direccion</label>
                            <input type="text" name="direccion" id="direccion" placeholder="Direccion del cliente">
                            <input type="submit" value="Registrar Cliente" class="btn_save">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>