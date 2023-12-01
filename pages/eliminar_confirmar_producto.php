<?php
    include "../php/conexion_be.php";

    if(!empty($_POST)){
        $idproducto = $_POST['idproducto'];
        
        $query_delete = mysqli_query($conexion, "DELETE FROM producto WHERE codProducto = $idproducto");
        
        if($query_delete){
            header("Location: productos.php");
        }else{
            echo "Error al eliminar";
        }

    }

    if(empty($_REQUEST['id'])){
        header("Location: productos.php");
    }else{
        

        $idproducto = $_REQUEST['id'];

        $query = mysqli_query($conexion, "SELECT * FROM producto WHERE codProducto = $idproducto");
        $result = mysqli_num_rows($query);

        if($result > 0){
            while($data = mysqli_fetch_array($query)){
                $nombre = $data['descripcion'];
                $precio = $data['precio'];
                $proovedor = $data['proovedor'];
                $existencia = $data['existencia'];
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
    <title>Eliminar Usuario</title>
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
                    <li><a href="productos.php"><i class="fa-solid fa-box"></i>  Productos</a></li>
                    <li><a href="#"><i class="fa-solid fa-gears"></i>  Proovedores</i></a></li>
                    <li><a href="#"><i class="fa-solid fa-users"></i>  Usuarios</a></li>
                    <li><a href="#"><i class="fa-solid fa-user-large"></i>  Clientes</a></li>
                    <li><a href="#"><i class="fa-regular fa-file"></i>  Reportes</a></li>
                    <li><a href="../php/cerrar_sesion.php"><i class="fa-solid fa-right-from-bracket"></i>  Cerrar sesion</a></li>
                </ul>
            </div>
            <div class="main_content">
                <div class="header_sidebar">Bienvenido al panel de geston de Variedades Yoli</div>
                <div class="info">
                    <div class="data_delete">
                        <h2>¿Esta seguro de eliminar el siguiente producto?</h2>
                        <p>Descripcion: <span><?php echo $nombre; ?></span></p>
                        <p>Precio: <span><?php echo $precio; ?></span></p>
                        <p>Proveedor: <span><?php echo $proovedor; ?></span></p>
                        <p>Existencias: <span><?php echo $existencia; ?></span></p>

                        <form action="" method="post">
                            <input type="hidden" name="idproducto" value="<?php echo $idproducto?>">
                            <a href="productos.php" class="btn_cancel">Cancelar</a>
                            <input type="submit" value="Aceptar" class="btn_ok">
                        </form>
                    </div>                
                </div>
            </div>
        </div>
    </section>
</body>
</html>