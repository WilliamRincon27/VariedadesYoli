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
    <title>Usuarios</title>
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
                    <h1>Lista de Usuarios</h1>

                    <form action="buscar_usuario.php" method="get" class="form_search">
                        <input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
                        <input type="submit" value="Buscar" class="btn_search">
                    </form>

                    <table>
                        <tr>
                            <th>Identificacion</th>
                            <th>nombre</th>
                            <th>Email</th>
                            <th>telefono</th>
                        </tr>
                        <?php
                            $query = mysqli_query($conexion, "SELECT * FROM usuarios");
                            $result = mysqli_num_rows($query);

                            if($result > 0){
                                while($data = mysqli_fetch_array($query)){
                             
                        ?>        
                                    <tr>
                                        <td><?php echo $data["Identificacion"];?></td>
                                        <td><?php echo $data["nombre"];?></td>
                                        <td><?php echo $data["email"];?></td>
                                        <td><?php echo $data["telefono"];?></td>
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