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
        if(empty($_POST['idCliente']) || empty($_POST['identificacion']) || empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion'])){
            $alert='<p class="msg_error">Todos los campos son obligatorios</p>';
        }else{
            include "../php/conexion_be.php";

            $idCliente = $_POST['idCliente'];
            $identificacion = $_POST['identificacion'];
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];

            $query = mysqli_query($conexion, "SELECT * FROM cliente WHERE idCliente = $idCliente");
            $result = mysqli_fetch_array($query);

            if($result < 0){
                $alert='<p class="msg_error">Este producto no esxiste</p>';
            }else{

                $sql_update = mysqli_query($conexion, "UPDATE cliente SET identificacion = '$identificacion', nombre = '$nombre', telefono = '$telefono', direccion = '$direccion' WHERE idCliente = $idCliente");

                if($sql_update){
                    $alert='<p class="msg_save">Producto actualizado correctamente</p>';
                }else{
                    $alert='<p class="msg_error">Error al actualizar el producto</p>';
                }
            }

        }
    }

    if(empty($_GET['id'])){
        header('Location: clientes.php');
    }

    $idCliente = $_GET['id'];
    $sql = mysqli_query($conexion, "SELECT * FROM cliente WHERE idCliente = $idCliente");
    $resultsql = mysqli_num_rows($sql);

    if($resultsql == 0){
        header('Location: clientes.php');
    }else{
        while($data = mysqli_fetch_array($sql)){
            $idCliente = $data['idCliente'];
            $identificacion = $data['identificacion'];
            $nombre = $data['nombre'];
            $telefono = $data['telefono'];
            $direccion = $data['direccion'];
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
    <title>Actualizar Cliente</title>
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
                        <h1>Actualizar Cliente</h1>
                        <hr>
                        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
                        <form action="" method="post">
                            <input type="hidden" name="idCliente" value=<?php echo $idCliente; ?>>
                            <label for="identificacion">Identificacion</label>
                            <input type="text" name="identificacion" id="identificacion" value=<?php echo $identificacion; ?>>
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" placeholder="Nombre del cliente">
                            <label for="precio">Telefono</label>
                            <input type="number" step="0.01" name="telefono" id="telefono" value="<?php echo $telefono; ?>" placeholder="Telefono del cliente">
                            <label for="proovedor">Direccion</label>
                            <input type="text" name="direccion" id="direccion" value="<?php echo $direccion; ?>" placeholder="Direccion">
                            <input type="submit" value="Actualizar Cliente" class="btn_save">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>