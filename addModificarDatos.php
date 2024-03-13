<?php

include_once 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar datos del formulario
    $nuevoCorreo = $_POST['nuevoCorreo'];
    $nuevaContrasena = $_POST['nuevoPassword'];
  
    $usuario = $_SESSION['usuario'];

    // Verificar si se enviaron datos y realizar las actualizaciones necesarias
    $correoActualizado = false;
    $contrasenaActualizada = false;

    if (!empty($nuevoCorreo)) {
        $consultaCorreo = $conn->prepare("UPDATE Usuarios SET email = ? WHERE usuario = ?");
        $consultaCorreo->bind_param("ss", $nuevoCorreo, $usuario);

        if ($consultaCorreo->execute()) {
            $correoActualizado = true;
        }

        $consultaCorreo->close();
    }

    if (!empty($nuevaContrasena)) {
        $consultaContrasena = $conn->prepare("UPDATE Usuarios SET password = ? WHERE usuario = ?");
        $consultaContrasena->bind_param("ss", $nuevaContrasena, $usuario);

        if ($consultaContrasena->execute()) {
            $contrasenaActualizada = true;
        }

        $consultaContrasena->close();
    }

    if ($correoActualizado && $contrasenaActualizada) {
        mostrarSweetAlert('success', 'Cambios realizados correctamente.', 'index.php');
    } elseif ($correoActualizado) {
        mostrarSweetAlert('success', 'Correo cambiado con éxito.', 'index.php');
    } elseif ($contrasenaActualizada) {
        mostrarSweetAlert('success', 'Contraseña cambiada con éxito.', 'index.php');
    } else {
        mostrarSweetAlert('error', 'Error al actualizar la información. Por favor, inténtalo de nuevo.');
    }
}

function mostrarSweetAlert($icon, $title, $redirect = null) {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: '{$icon}',
                    title: '{$title}',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {";

    if ($redirect) {
        echo "window.location.href = '{$redirect}';";
    }

    echo "});
            });
          </script>";
    exit();
}

?>
