<?php
    include 'conexion_be.php';
    
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contrasena = $_POST['password'];
    $identificacion = $_POST['identificacion'];
    $telefono = $_POST['telefono'];

    $query = "INSERT INTO usuarios(Identificacion , nombre, email, contrasena, telefono) 
              VALUES('$identificacion', '$nombre', '$email', '$contrasena', '$telefono')";

    $ejecutar = mysqli_query($conexion, $query);

    if($ejecutar){
        echo '
            <script>
                alert("Usuario almacenado exitosamente");
                window.location = "../index.php";
            </script>
        ';
    }else{
        echo '
            <script>
                alert("Error: El usuario no se almacenado, Intentelo nuevamente");
            </script>
        ';
    }

    mysqli_close($conexion);
?>