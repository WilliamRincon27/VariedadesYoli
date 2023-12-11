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

    include "../php/conexion_be.php"
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/dash.css">
    <script src="https://kit.fontawesome.com/071e681d3e.js" crossorigin="anonymous"></script>
    <title>Productos</title>
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
                    <?php

                        $busqueda = strtolower($_REQUEST['busqueda']);

                        if(empty($busqueda)){
                            header("Location: productos.php");
                        }else{
                            $sql_registe = mysqli_query($conexion, "SELECT COUNT(*) as total_registro FROM producto WHERE( codProducto LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%' OR precio LIKE '%$busqueda%' OR proovedor LIKE '%$busqueda%' OR existencia LIKE '%$busqueda%')");
                        }

                    ?>
                    <h1>Lista de Productos</h1>
                    <a href="crear_producto.php" class="btn_new">Crear Producto</a>

                    <form action="buscar_producto.php" method="get" class="form_search">
                        <input type="text" name="busqueda" id="busqueda" value="<?php echo $busqueda; ?>" placeholder="Buscar">
                        <input type="submit" value="Buscar" class="btn_search">
                    </form>

                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Descripcion</th>
                            <th>Proveedor</th>
                            <th>Precio</th>
                            <th>Existencias</th>
                            <th>Acciones</th>
                        </tr>
                        <?php
                            $query = mysqli_query($conexion, "SELECT * FROM producto WHERE( codProducto LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%' OR precio LIKE '%$busqueda%' OR proovedor LIKE '%$busqueda%' OR existencia LIKE '%$busqueda%')");
                            $result = mysqli_num_rows($query);

                            if($result > 0){
                                while($data = mysqli_fetch_array($query)){
                             
                        ?>        
                                    <tr>
                                        <td><?php echo $data["codProducto"];?></td>
                                        <td><?php echo $data["descripcion"];?></td>
                                        <td><?php echo $data["proovedor"];?></td>
                                        <td><?php echo $data["precio"];?></td>
                                        <td><?php echo $data["existencia"];?></td>
                                        <td>
                                            <a class="link_edit" href="editar_producto.php?id=<?php echo $data["codProducto"];?>">Editar</a>
                                            |
                                            <a class="link_delete" href="eliminar_confirmar_producto.php?id=<?php echo $data["codProducto"];?>">Eliminar</a>
                                        </td>
                                    </tr>
                        <?php        
                                }
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
</body>
</html>