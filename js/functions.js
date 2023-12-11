$(document).ready(function(){
    //Buscar Cliente
    $('#nit_cliente').keyup(function(e){
        e.preventDefault();

        var cl = $(this).val();
        var action = 'searchCliente';

        $.ajax({
            url: '../pages/ajax.php',
                type: "POST",
                async: true,
                data: {action:action,cliente:cl},

                success: function(response){
                    if(response == 0){
                        $('#idCliente').val('');
                        $('#nom_cliente').val('');
                        $('#tel_cliente').val('');
                        $('#dir_cliente').val('');
                    }else{
                        var data = $.parseJSON(response);
                        $('#idCliente').val(data.idCliente);
                        $('#nom_cliente').val(data.nombre);
                        $('#tel_cliente').val(data.telefono);
                        $('#dir_cliente').val(data.direccion);
                    }
                },
                error: function(error){

                }
        });
    })
    
    //Buscar producto
    $('#txt_cod_producto').keyup(function(e){
        e.preventDefault();

        var producto = $(this).val();
        var action = 'infoProducto'

        if(producto != ''){

            $.ajax({
                url: '../pages/ajax.php',
                type: "POST",
                async: true,
                data: {action:action,producto:producto},

                success: function(response){
                    if(response != 'error'){
                        var info = JSON.parse(response);
                        $('#txt_descripcion').html(info.descripcion);
                        $('#txt_existencia').html(info.existencia);
                        $('#txt_cant_producto').val(1);
                        $('#txt_precio').html(info.precio);
                        $('#txt_precio_total').html(info.precio);

                        //Activar cantidad
                        $('#txt_cant_producto').removeAttr('disabled');

                        //Mostrar boton Agregar
                        $('#add_producto_venta').slideDown();
                    }else{
                        $('#txt_descripcion').html('-');
                        $('#txt_existencia').html('-');
                        $('#txt_cant_producto').val(0);
                        $('#txt_precio').html('0.00');
                        $('#txt_precio_total').html('0.00');

                        //Bloquear cantidad
                        $('#txt_cant_producto').attr('disabled', 'disabled');

                        //Ocultar boton agregar
                        $('#add_producto_venta').slideUp();
                    }
                },

                error: function(error){
                }
            });
        }
        
    })

    //Validar cantidad del producto antes de agregar
    $('#txt_cant_producto').keyup(function(e){
        e.preventDefault();
        var precio_total = $(this).val() * $('#txt_precio').html();
        var existencia = parseInt($('#txt_existencia').html());
        $('#txt_precio_total').html(precio_total);

        //Ocultar el boton agragar si la cantidad es menor que uno
        if( ($(this).val() < 1 || isNaN($(this).val())) || ($(this).val() > existencia) || ($(this).val() %1 != 0) ){
            $('#add_producto_venta').slideUp();
        }else{
            $('#add_producto_venta').slideDown();
        }
    });

    //Agregar producto al detalle temporal
    $('#add_producto_venta').click(function(e){
        e.preventDefault();

        if($('#txt_cant_producto').val() > 0){
            var codProducto = $('#txt_cod_producto').val();
            var cantidad = $('#txt_cant_producto').val();
            var action = 'addProductoDetalle';

            $.ajax({
                url: '../pages/ajax.php',
                type: "POST",
                async: true,
                data: {action:action,producto:codProducto,cantidad:cantidad},
                
                success: function(response){
                    if(response != 'error'){
                        var info = JSON.parse(response);
                        $('#detalle_venta').html(info.detalle);
                        $('#detalle_totales').html(info.totales);

                        $('#txt_cod_producto').val('');
                        $('#txt_descripcion').html('-');
                        $('#txt_existencia').html('-');
                        $('#txt_cant_producto').val('0');
                        $('#txt_precio').html('0.00');
                        $('#txt_precio_total').html('0.00');

                        //Bloquear Cantidad
                        $('#txt_cant_producto').attr('disabled', 'disabled');

                        //Ocultar boton agregar
                        $('#add_producto_venta').slideUp();
                    }else{
                        console.log('No Data');
                    }
                },
                error: function(error){

                }
            });
        }
    });

    //Anular Venta
    $('#btn_anular_venta').click(function(e){
        e.preventDefault();

        var rows = $('#detalle_venta tr').length;
        if(rows > 0){
            var action = 'anularVenta';

            $.ajax({
                url: '../pages/ajax.php',
                type: "POST",
                async: true,
                data: {action:action},

                success:  function(response){
                    if(response != 'error'){
                        location.reload();
                    }
                },
                error: function(error){

                }
            });
        }
    })

    //Facturar Venta
    $('#btn_facturar_venta').click(function(e){
        e.preventDefault();

        var rows = $('#detalle_venta tr').length;
        if(rows > 0){
            var action = 'procesarVenta';
            var codCliente = $('#idCliente').val();
            var codVendedor = $('#cod_vendedor').val();

            $.ajax({
                url: '../pages/ajax.php',
                type: "POST",
                async: true,
                data: {action:action,codCliente:codCliente,codVendedor:codVendedor},

                success:  function(response){
                    if(response!='error'){
                        var info = JSON.parse(response);
                        //console.log(info);

                        generarPDF(info.codCliente, info.nFactura);
                        
                        location.reload();
                    }else{
                        console.log('no data');
                    }
                },
                error: function(error){

                }
            });
        }
    })
    
});

function generarPDF(cliente, factura){
    var ancho = 1000;
    var alto = 800;

    //calcular poscicion x,y para encontrar la ventana
    var x = parseInt((window.screen.width/2) - (ancho / 2));
    var y = parseInt((window.screen.height/2) - (alto / 2));

    $url = '../factura/generaFactura.php?cl='+cliente+'&f='+factura;
    window.open($url, "Factura", "left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}

function del_producto_detalle(correlativo){
    var action = 'delproductodetalle';
    var id_detalle = correlativo;

    $.ajax({
        url: '../pages/ajax.php',
        type: "POST",
        async: true,
        data: {action:action,id_detalle:id_detalle},
        
        success: function(response){
            if(response != 'error'){
                var info = JSON.parse(response);

                $('#detalle_venta').html(info.detalle);
                $('#detalle_totales').html(info.totales);

                $('#txt_cod_producto').val('');
                $('#txt_descripcion').html('-');
                $('#txt_existencia').html('-');
                $('#txt_cant_producto').val('0');
                $('#txt_precio').html('0.00');
                $('#txt_precio_total').html('0.00');

                //Bloquear Cantidad
                $('#txt_cant_producto').attr('disabled', 'disabled');

                //Ocultar boton agregar
                $('#add_producto_venta').slideUp();
            }else{
                $('$detalle_venta').html('');
                $('$detalle_totales').html('');
            }
            viewProcesar();
        },
        error: function(error){

        }
    });

    
}

//Mostar o ocultar boton procesar
function viewProcesar(){
    if($('#detalle_venta tr').length > 0){
        $('#btn_facturar_venta').show();
    }else{
        $('#btn_facturar_venta').hide();
    }
}

function serchForDetalle(id){
    var action = 'serchForDetalle';
    var user = id;

    $.ajax({
        url: '../pages/ajax.php',
        type: "POST",
        async: true,
        data: {action:action,user:user},
        
        success: function(response){
            if(response != 'error'){
                var info = JSON.parse(response);
                $('#detalle_venta').html(info.detalle);
                $('#detalle_totales').html(info.totales);

                $('#txt_cod_producto').val('');
                $('#txt_descripcion').html('-');
                $('#txt_existencia').html('-');
                $('#txt_cant_producto').val('0');
                $('#txt_precio').html('0.00');
                $('#txt_precio_total').html('0.00');

                //Bloquear Cantidad
                $('#txt_cant_producto').attr('disabled', 'disabled');

                //Ocultar boton agregar
                $('#add_producto_venta').slideUp();
            }else{
                console.log('No Data');
            }
        },
        error: function(error){

        }
    });
}