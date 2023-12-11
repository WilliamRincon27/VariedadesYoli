<?php
    
    
    include 'conexion_be.php';

    $correo = $_POST['email'];
    $contrasena = $_POST['password'];

    $validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email='$correo' and contrasena='$contrasena'");
    $result = mysqli_num_rows($validar_login);

    if($result > 0){
        $data = mysqli_fetch_array($validar_login);
        session_start();

        $_SESSION['usuario'] = $correo;
        $_SESSION['idUser'] = $data['Identificacion'];
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