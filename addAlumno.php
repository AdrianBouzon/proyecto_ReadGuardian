<?php

include_once 'conexion.php';
session_start();

if (isset($_POST['submitAlumno'])) {
    if (isset($_POST['nombre'], $_POST['apellido1'], $_POST['apellido2'], $_POST['curso'], $_POST['numCarnet'])) {
        // Obtén los datos del formulario
        $nombre = $_POST['nombre'];
        $apellido1 = $_POST['apellido1'];
        $apellido2 = $_POST['apellido2'];
        $curso = $_POST['curso'];
        $numCarnet = $_POST['numCarnet'];


        $query = "INSERT INTO alumnos (nombre, apellido1, apellido2, curso, numCarnet) VALUES (?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $query);

        // Verifica si la sentencia se creó correctamente
        if ($stmt) {
            
            mysqli_stmt_bind_param($stmt, 'sssss', $nombre, $apellido1, $apellido2, $curso, $numCarnet);

            // Ejecuta la sentencia 
            $result = mysqli_stmt_execute($stmt);

            // Verifica si la inserción fue correcta
            if ($result) {
          
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                     icon: 'success',
                     title: 'Alumno añadido correctamente',
                     showConfirmButton: false,
                     timer: 1500
                   }).then(() => {
                window.location.href = 'indexAlumnos.php';
                });
               });
              </script>";
        } else {
            echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Error al añadir el alumno',
            text: 'Ocurrió un problema al intentar añadir el alumno. Por favor, inténtalo de nuevo.',
            showConfirmButton: false,
            timer: 3000  // El mensaje de error desaparecerá después de 3 segundos
        }).then(function() {
            window.location.href = 'Modales/ModalAlumnos.php'; 
        });
    </script>";
        }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error al preparar la sentencia: " . mysqli_error($conn);
        }
    }

    mysqli_close($conn);
}
?>
