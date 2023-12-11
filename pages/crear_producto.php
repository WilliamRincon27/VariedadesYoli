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
        if(empty($_POST['nombre']) || empty($_POST['precio']) || empty($_POST['proovedor']) || empty($_POST['existencia'])){
            $alert='<p class="msg_error">Todos los campos son obligatorios</p>';
        }else{
            include "../php/conexion_be.php";

            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $proovedor = $_POST['proovedor'];
            $existencia = $_POST['existencia'];

            $query = mysqli_query($conexion, "SELECT * FROM producto WHERE descripcion = '$nombre'");
            $result = mysqli_fetch_array($query);

            if($result > 0){
                $alert='<p class="msg_error">Este producto ya esxiste</p>';
            }else{
                $query_insert = mysqli_query($conexion, "INSERT INTO producto(descripcion, precio, proovedor, existencia) VALUES('$nombre', '$precio', '$proovedor', '$existencia')");

                if($query_insert){
                    $alert='<p class="msg_save">Producto creado correctamente</p>';
                }else{
                    $alert='<p class="msg_error">Error al crear el producto</p>';
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
    <title>Crear Producto</title>
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
                        <h1>Crear Producto</h1>
                        <hr>
                        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

                        <form action="" method="post">
                            <label for="nombre">Nombre Producto</label>
                            <input type="text" name="nombre" id="nombre" placeholder="Nombre del Producto">
                            <label for="precio">Precio</label>
                            <input type="number" name="precio" id="precio" placeholder="Precio del Producto">
                            <label for="proovedor">Proovedor</label>
                            <input type="text" name="proovedor" id="proovedor" placeholder="Proveedor">
                            <label for="existencia">Existencias</label>
                            <input type="number" name="existencia" id="existencia" placeholder="Existencias del Producto">
                            <input type="submit" value="Crear Producto" class="btn_save">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>