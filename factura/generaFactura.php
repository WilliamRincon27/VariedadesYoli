<?php

	//print_r($_REQUEST);
	//exit;
	//echo base64_encode('2');
	//exit;
	session_start();
	if(empty($_SESSION['usuario']))
	{
		header('location: ../');
	}

	include "../php/conexion_be.php";
	require_once '../dompdf/autoload.inc.php';
	use Dompdf\Dompdf;

	if(empty($_REQUEST['cl']) || empty($_REQUEST['f']))
	{
		echo "No es posible generar la factura.";
	}else{
		$codCliente = $_REQUEST['cl'];
		$noFactura = $_REQUEST['f'];
		$anulada = '';

		$query_config   = mysqli_query($conexion,"SELECT * FROM configuracion");
		$result_config  = mysqli_num_rows($query_config);
		if($result_config > 0){
			$configuracion = mysqli_fetch_assoc($query_config);
		}


		$query = mysqli_query($conexion,"SELECT f.nFactura, DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha, DATE_FORMAT(f.fecha,'%H:%i:%s') as  hora, f.codcliente,
												 v.nombre as vendedor,
												 cl.identificacion, cl.nombre, cl.telefono,cl.direccion
											FROM factura f
											INNER JOIN usuarios v
											ON f.usuario = v.identificacion
											INNER JOIN cliente cl
											ON f.codCliente = cl.idCliente
											WHERE f.nFactura = $noFactura AND f.codCliente = $codCliente");

		$result = mysqli_num_rows($query);
		if($result > 0){

			$factura = mysqli_fetch_assoc($query);
			$no_factura = $factura['nFactura'];

			$query_productos = mysqli_query($conexion,"SELECT p.descripcion,dt.cantidad,dt.precioVenta,(dt.cantidad * dt.precioVenta) as precio_total
														FROM factura f
														INNER JOIN detallefactura dt
														ON f.nFactura = dt.nFactura
														INNER JOIN producto p
														ON dt.codProducto = p.codProducto
														WHERE f.nFactura = $no_factura ");
			$result_detalle = mysqli_num_rows($query_productos);

			ob_start();
		    include(dirname('__FILE__').'/factura.php');
		    $html = ob_get_clean();

			// instantiate and use the dompdf class
			$dompdf = new Dompdf();

			$dompdf->loadHtml($html);
			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper('letter', 'portrait');
			// Render the HTML as PDF
			$dompdf->render();
			// Output the generated PDF to Browser
			$dompdf->stream('factura_'.$noFactura.'.pdf',array('Attachment'=>0));
			exit;
		}
	}

?>