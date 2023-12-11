<?php
    include "../php/conexion_be.php";

    if(!empty($_POST)){
        $idCliente = $_POST['idCliente'];
        
        $query_delete = mysqli_query($conexion, "DELETE FROM cliente WHERE idCliente = $idCliente");
        
        if($query_delete){
            header("Location: clientes.php");
        }else{
            echo "Error al eliminar";
        }

    }

    if(empty($_REQUEST['id'])){
        header("Location: clientes.php");
    }else{
        

        $idCliente = $_REQUEST['id'];

        $query = mysqli_query($conexion, "SELECT * FROM cliente WHERE idCliente = $idCliente");
        $result = mysqli_num_rows($query);

        if($result > 0){
            while($data = mysqli_fetch_array($query)){
                $identificacion = $data['identificacion'];
                $nombre = $data['nombre'];
                $telefono = $data['telefono'];
                $direccion = $data['direccion'];
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
    <title>Eliminar Cliente</title>
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
                    <div class="data_delete">
                        <h2>¿Esta seguro de eliminar el siguiente cliente?</h2>
                        <p>Identificacion: <span><?php echo $identificacion; ?></span></p>
                        <p>Nombre: <span><?php echo $nombre; ?></span></p>
                        <p>Telefono: <span><?php echo $telefono; ?></span></p>
                        <p>Direccion: <span><?php echo $direccion; ?></span></p>

                        <form action="" method="post">
                            <input type="hidden" name="idCliente" value="<?php echo $idCliente?>">
                            <a href="clientes.php" class="btn_cancel">Cancelar</a>
                            <input type="submit" value="Aceptar" class="btn_ok">
                        </form>
                    </div>                
                </div>
            </div>
        </div>
    </section>
</body>
</html>