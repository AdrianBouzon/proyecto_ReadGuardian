<?php

include_once 'conexion.php';

$usuario = $_POST['username'];
$pass = $_POST['password'];
$correo = $_POST['email'];

//Login


if (isset($_POST['submitLogin'])) {
    $query = mysqli_query($conn, "SELECT usuario,password FROM usuarios WHERE usuario = '$usuario' AND password = '$pass'");
    $nr = mysqli_num_rows($query);
    //print_r($nr);
    
    if ($nr == 1) {
        session_start();
        $_SESSION['usuario'] = $usuario;
        if ($usuario == 'admin') {
            header("Location:index.php");
            
        } else {
              header("Location:index.php");
            //header("Location:indexUsers.php"); Aqui irá el login para alumnos.
        }
    } else {
        header("Location:login.html");
    }
}

//Registro  

if (isset($_POST['submitRegistrar'])) {
    $insertUser = "INSERT INTO usuarios(usuario,password,email) VALUES ('$usuario','$pass','$correo')";

    if (mysqli_query($conn, $insertUser)) {
        echo "<script>alert('Usuario registrado correctamente: $usuario'); window.location='login.html'</script>";
    } else {
        echo "Error: " . mysql_error($onn);
    }
}
?>