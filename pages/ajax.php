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

    include "../php/conexion_be.php";

    if(!empty($_POST)){
        
        //Buscar Cliente
        if($_POST['action'] == 'searchCliente'){
            if(!empty($_POST['cliente'])){
                $nit = $_POST['cliente'];

                $query = mysqli_query($conexion, "SELECT * FROM cliente WHERE idCliente LIKE '$nit'");
                mysqli_close($conexion);
                $result = mysqli_num_rows($query);

                $data = '';

                if($result > 0){
                    $data = mysqli_fetch_assoc($query);
                }else{
                    $data = 0;
                }
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
            }
            exit;
        }

        //Extraer datos del producto
        if($_POST['action'] == 'infoProducto'){
            $producto_id = $_POST['producto'];

            $query = mysqli_query($conexion, "SELECT codProducto, descripcion, existencia, precio FROM producto WHERE codProducto = $producto_id");

            mysqli_close($conexion);

            $result = mysqli_num_rows($query);

            if($result > 0){
                $data = mysqli_fetch_assoc($query);
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
                exit;
            }
            echo 'error';
            exit;
        }

        //Agregar producto al detalle temporal
        if($_POST['action'] == 'addProductoDetalle'){
            if(empty($_POST['producto']) || empty($_POST['cantidad'])){
                echo 'error';
            }else{
                $codProducto = $_POST['producto'];
                $cantidad = $_POST['cantidad'];
                $token = md5($_SESSION['usuario']);

                $query_iva = mysqli_query($conexion, "SELECT iva FROM configuracion");
                $result_iva = mysqli_num_rows($query_iva);

                $query_detallet_temp = mysqli_query($conexion, "CALL add_detallet_temp($codProducto,$cantidad,'$token')");
                $result = mysqli_num_rows($query_detallet_temp);

                $detalleTabla = '';
                $sub_total = 0;
                $iva = 0;
                $total = 0;
                $arrayData = array();

                if($result > 0){
                    if($result_iva > 0){
                        $info_iva = mysqli_fetch_assoc($query_iva);
                        $iva = $info_iva['iva'];
                    }

                    while($data = mysqli_fetch_assoc($query_detallet_temp)){
                        $precioTotal = round($data['cantidad']*$data['precioVenta'], 2);
                        $sub_total = round($sub_total + $precioTotal, 2);
                        $total = round($total + $precioTotal, 2);

                        $detalleTabla .= '
                            <tr>
                                <td>'.$data['codProducto'].'</td>
                                <td colspan="2">'.$data['descripcion'].'</td>
                                <td class="textcenter">'.$data['cantidad'].'</td>
                                <td class="textright">'.$data['precioVenta'].'</td>
                                <td class="textright">'.$precioTotal.'</td>
                                <td class=""><a href="#" class="link_delete" onclick="event.preventDefault(); del_producto_detalle('.$data['correlativo'].');"><i class="far fa-trash-alt"></i></a></td>
                            </tr>
                        ';


                    }

                    $impuesto = round($sub_total * ($iva/100),2);
                    $tl_sniva = round($sub_total-$impuesto,2);
                    $total = round($tl_sniva + $impuesto,2);

                    $detalleTotales = '
                        <tr>
                            <td colspan="5" class="textright"> SUBTOTAL Q.</td>
                            <td id="textright">'.$tl_sniva.'</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="textright"> IVA ('.$iva.'%) Q.</td>
                            <td id="textright">'.$impuesto.'</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="textright"> TOTAL Q.</td>
                            <td id="textright">'.$total.'</td>
                        </tr>
                        ';
                    
                    $arrayData['detalle'] = $detalleTabla;
                    $arrayData['totales'] = $detalleTotales;

                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                    
                }else{
                    echo 'error';
                }
                mysqli_close($conexion);
            }
            exit;
        }

        //Extrae datos del detalle temporal
        if($_POST['action'] == 'serchForDetalle'){
            if(empty($_POST['user'])){
                echo 'error';
            }else{
                $token = md5($_SESSION['usuario']);

                $query = mysqli_query($conexion, "SELECT tmp.correlativo,
                                                    tmp.tokenUser,
                                                    tmp.cantidad,
                                                    tmp.precioVenta,
                                                    p.codProducto,
                                                    p.descripcion 
                                                    FROM detalle_temp tmp 
                                                    INNER JOIN producto p 
                                                    ON tmp.codProducto = p.codProducto 
                                                    WHERE tokenUser = '$token'");

                $result = mysqli_num_rows($query);
                
                $query_iva = mysqli_query($conexion, "SELECT iva FROM configuracion");
                $result_iva = mysqli_num_rows($query_iva);

            

                $detalleTabla = '';
                $sub_total = 0;
                $iva = 0;
                $total = 0;
                $arrayData = array();

                if($result > 0){
                    if($result_iva > 0){
                        $info_iva = mysqli_fetch_assoc($query_iva);
                        $iva = $info_iva['iva'];
                    }

                    while($data = mysqli_fetch_assoc($query)){
                        $precioTotal = round($data['cantidad']*$data['precioVenta'], 2);
                        $sub_total = round($sub_total + $precioTotal, 2);
                        $total = round($total + $precioTotal, 2);

                        $detalleTabla .= '
                            <tr>
                                <td>'.$data['codProducto'].'</td>
                                <td colspan="2">'.$data['descripcion'].'</td>
                                <td class="textcenter">'.$data['cantidad'].'</td>
                                <td class="textright">'.$data['precioVenta'].'</td>
                                <td class="textright">'.$precioTotal.'</td>
                                <td class=""><a href="#" class="link_delete" onclick="event.preventDefault(); del_producto_detalle('.$data['correlativo'].');"><i class="far fa-trash-alt"></i></a></td>
                            </tr>
                        ';


                    }

                    $impuesto = round($sub_total * ($iva/100),2);
                    $tl_sniva = round($sub_total-$impuesto,2);
                    $total = round($tl_sniva + $impuesto,2);

                    $detalleTotales = '
                        <tr>
                            <td colspan="5" class="textright"> SUBTOTAL Q.</td>
                            <td id="textright">'.$tl_sniva.'</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="textright"> IVA ('.$iva.'%) Q.</td>
                            <td id="textright">'.$impuesto.'</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="textright"> TOTAL Q.</td>
                            <td id="textright">'.$total.'</td>
                        </tr>
                        ';
                    
                    $arrayData['detalle'] = $detalleTabla;
                    $arrayData['totales'] = $detalleTotales;

                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                    
                }else{
                    echo 'error';
                }
                mysqli_close($conexion);
            }
            exit;
        }

        if($_POST['action'] == 'delproductodetalle'){
            if(empty($_POST['id_detalle'])){
                echo 'error';
            }else{
                $id_detalle = $_POST['id_detalle']; 
                $token = md5($_SESSION['usuario']);

                $query_iva = mysqli_query($conexion, "SELECT iva FROM configuracion");
                $result_iva = mysqli_num_rows($query_iva);

                $query_detalle_temp = mysqli_query($conexion, "CALL del_detalle_temp($id_detalle, '$token')");
                $result = mysqli_num_rows($query_detalle_temp);

                $detalleTabla = '';
                $sub_total = 0;
                $iva = 0;
                $total = 0;
                $arrayData = array();

                if($result > 0){
                    if($result_iva > 0){
                        $info_iva = mysqli_fetch_assoc($query_iva);
                        $iva = $info_iva['iva'];
                    }

                    while($data = mysqli_fetch_assoc($query_detalle_temp)){
                        $precioTotal = round($data['cantidad']*$data['precioVenta'], 2);
                        $sub_total = round($sub_total + $precioTotal, 2);
                        $total = round($total + $precioTotal, 2);

                        $detalleTabla .= '
                            <tr>
                                <td>'.$data['codProducto'].'</td>
                                <td colspan="2">'.$data['descripcion'].'</td>
                                <td class="textcenter">'.$data['cantidad'].'</td>
                                <td class="textright">'.$data['precioVenta'].'</td>
                                <td class="textright">'.$precioTotal.'</td>
                                <td class=""><a href="#" class="link_delete" onclick="event.preventDefault(); del_producto_detalle('.$data['correlativo'].');"><i class="far fa-trash-alt"></i></a></td>
                            </tr>
                        ';


                    }

                    $impuesto = round($sub_total * ($iva/100),2);
                    $tl_sniva = round($sub_total-$impuesto,2);
                    $total = round($tl_sniva + $impuesto,2);

                    $detalleTotales = '
                        <tr>
                            <td colspan="5" class="textright"> SUBTOTAL Q.</td>
                            <td id="textright">'.$tl_sniva.'</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="textright"> IVA ('.$iva.'%) Q.</td>
                            <td id="textright">'.$impuesto.'</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="textright"> TOTAL Q.</td>
                            <td id="textright">'.$total.'</td>
                        </tr>
                        ';
                    
                    $arrayData['detalle'] = $detalleTabla;
                    $arrayData['totales'] = $detalleTotales;

                    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                    
                }else{
                    echo 'error';
                }
                mysqli_close($conexion);
            }
            exit;
        }

        //Anular Venta
        if($_POST['action'] == 'anularVenta'){
            $token = md5($_SESSION['usuario']);
            $query_del = mysqli_query($conexion, "DELETE FROM  detalle_temp WHERE tokenUser = '$token'");
            mysqli_close($conexion);
            if($query_del){
                echo 'ok';
            }else{
                echo 'error';
            }
            exit;
        }

        if($_POST['action'] == 'procesarVenta'){
            if(empty($_POST['codCliente'])){
                $codCliente = 6;
            }else{
                $codCliente = $_POST['codCliente'];
            }

            $token = md5($_SESSION['usuario']);
            $usuario = $_POST['codVendedor'];

            $query = mysqli_query($conexion, "SELECT * FROM detalle_temp WHERE tokenUser = '$token'");
            $result = mysqli_num_rows($query);

            if($result > 0){
                $query_procesar = mysqli_query($conexion, "CALL procesar_venta($usuario, $codCliente, '$token')");
                $result_detalle = mysqli_num_rows($query_procesar);

                if($result_detalle > 0){
                    $data = mysqli_fetch_assoc($query_procesar);
                    echo json_encode($data, JSON_UNESCAPED_UNICODE);

                }else{
                    echo "error";
                }
            }else{
                echo"error";
            }
            mysqli_close($conexion);
            exit;

        }
    }
    

    exit;
?>