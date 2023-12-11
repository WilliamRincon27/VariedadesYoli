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
    <link rel="stylesheet" href="../styles/dash.css">
    <script src="https://kit.fontawesome.com/071e681d3e.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/icons.js"></script>
    <script type="text/javascript" src="../js/functions.js"></script>
    <title>Nueva Venta</title>
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
                    <div class="datos_cliente" id="datos_cliente">
                        <h4>Datos del Cliente</h4>
                        <form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos">
                            <input type="hidden" id="idCliente" name="idCliente" value="" required>
                            <div class="wd30">
                                <label>Nit</label>
                                <input type="text" name="nit_cliente" id="nit_cliente">
                            </div>
                            <div class="wd30">
                                <label>Nombre</label>
                                <input type="text" name="nom_cliente" id="nom_cliente" disabled required>
                            </div>
                            <div class="wd30">
                                <label>Telefono</label>
                                <input type="number" name="tel_cliente" id="tel_cliente" disbled required>
                            </div>
                            <div class="wd100">
                                <label>Direccion</label>
                                <input type="text" name="dir_cliente" id="dir_cliente" disabled required>
                            </div>
                            <div class="wd100">
                                <label>Codigo Vendedor</label>
                                <input type="number" name="cod_vendedor" id="cod_vendedor" required>
                            </div>
                        </form>
                    </div>
                    <div class="datos_venta" id="datos_venta">
                        <h4>Datos de Venta</h4>
                        <div class="datos">
                            <div class="wd50">
                                <label>Vendedor</label>
                                <p><?php echo $_SESSION['usuario'];?></p>
                            </div>
                            <div class="wd50">
                                <label>Acciones</label>
                                <div id="acciones_venta">
                                    <a href="#" class="btn_ok textcenter" id="btn_anular_venta"><i class="fas fa-ban"></i> Anular</a>
                                    <a href="#" class="btn_new textcenter" id="btn_facturar_venta"><i class="far fa-edit"></i> Procesar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="tbl_venta">
                        <thead>
                            <tr>
                                <th width="100px">Codigo</th>
                                <th>Descripcion</th>
                                <th>Existencias</th>
                                <th width="100px">Cantidad</th>
                                <th class="textright">Precio</th>
                                <th class="textright">Precio Total</th>
                                <th>Accion</th>
                            </tr>
                            <tr>
                                <td><input type="text" name="txt_cod_producto" id="txt_cod_producto"></td>
                                <td id="txt_descripcion">-</td>
                                <td id="txt_existencia">-</td>
                                <td><input type="text" name="txt_cant_producto" id="txt_cant_producto" value="0" min="1" disabled></td>
                                <td id="txt_precio" class="textright">0.00</td>
                                <td id="txt_precio_total" class="textright">0.00</td>
                                <td><a href="#" id="add_producto_venta" class="link_add"><i id="fas fa-plus"></i> Agregar</a></td>
                            </tr>
                            <tr>
                                <th>Codigo</th>
                                <th colspan="2">Descripcion</th>
                                <th>Cantidad</th>
                                <th class="textright">Precio</th>
                                <th class="textright">Precio Total</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody id="detalle_venta">
                            <!--Contenido Ajax-->
                        </tbody>
                        <tfoot id="detalle_totales">
                            <!--Contenido Ajax-->
                        </tfoot>
                    </table>
                </div>   
            </div>
        </div>
    </section>
    <script type="text/javascript">
        $(document).ready(function(){
            var usuarioId = '<?php echo $_SESSION['usuario']?>';
            serchForDetalle(usuarioId);
        });
    </script>
</body>
</html>