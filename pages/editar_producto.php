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

    include "../php/conexion_be.php";

    if(!empty($_POST)){
        $alert='';
        if(empty($_POST['nombre']) || empty($_POST['precio']) || empty($_POST['proovedor']) || empty($_POST['existencia'])){
            $alert='<p class="msg_error">Todos los campos son obligatorios</p>';
        }else{
            include "../php/conexion_be.php";

            $idproducto = $_POST['idProducto'];
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $proovedor = $_POST['proovedor'];
            $existencia = $_POST['existencia'];

            $query = mysqli_query($conexion, "SELECT * FROM producto WHERE codProducto = $idproducto");
            $result = mysqli_fetch_array($query);

            if($result < 0){
                $alert='<p class="msg_error">Este producto no esxiste</p>';
            }else{

                $sql_update = mysqli_query($conexion, "UPDATE producto SET descripcion = '$nombre', precio = '$precio', proovedor = '$existencia', existencia = '$existencia' WHERE codProducto = $idproducto");

                if($sql_update){
                    $alert='<p class="msg_save">Producto actualizado correctamente</p>';
                }else{
                    $alert='<p class="msg_error">Error al actualizar el producto</p>';
                }
            }

        }
    }

    //Mostrar datos
    if(empty($_GET['id'])){
        header('Location: productos.php');
    }

    $idproducto = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM producto WHERE codProducto = $idproducto");
    $resultsql = mysqli_num_rows($sql);

    if($resultsql == 0){
        header('Location: productos.php');
    }else{
        while($data = mysqli_fetch_array($sql)){
            $idproducto = $data['codProducto'];
            $nombre = $data['descripcion'];
            $precio = $data['precio'];
            $proovedor = $data['proovedor'];
            $existencia = $data['existencia'];
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
    <title>Actualizar Producto</title>
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
                        <h1>Actualizar Producto</h1>
                        <hr>
                        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

                        <form action="" method="post">
                            <input type="hidden" name="idProducto" value=<?php echo $idproducto; ?>>
                            <label for="nombre">Nombre Producto</label>
                            <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" placeholder="Nombre del Producto">
                            <label for="precio">Precio</label>
                            <input type="number" step="0.01" name="precio" id="precio" value="<?php echo $precio; ?>" placeholder="Precio del Producto">
                            <label for="proovedor">Proovedor</label>
                            <input type="text" name="proovedor" id="proovedor" value="<?php echo $proovedor; ?>" placeholder="Proveedor">
                            <label for="existencia">Existencias</label>
                            <input type="number" name="existencia" id="existencia" value="<?php echo $existencia; ?>" placeholder="Existencias del Producto">
                            <input type="submit" value="Actualizar Producto" class="btn_save">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>