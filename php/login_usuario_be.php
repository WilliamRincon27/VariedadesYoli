<?php
    session_start();
    
    include 'conexion_be.php';

    $correo = $_POST['email'];
    $contrasena = $_POST['password'];

    $validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email='$correo' and contrasena='$contrasena'");

    if(mysqli_num_rows($validar_login) > 0){
        $_SESSION['usuario'] = $correo;
        header("location: ../dashboard.php");
        exit;
    }else{
        echo '
            <script>
                alert("Usuario no exite, porfavor verificar los datos introducidos");
                window.location = "../index.php";
            </script>
        ';
    }
?>