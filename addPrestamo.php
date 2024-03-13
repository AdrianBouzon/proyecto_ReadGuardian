<?php

include_once 'conexion.php';
session_start();

if (isset($_POST['submitPrestamo'])) {
    $id_libro = $_POST['libro'];
    $usuario = $_POST['usuario'];
    $num_carnet = $_POST['num_carnet'];
    $fecha_prestamo = $_POST['fecha_prestamo'];

    // Obtener el id del usuario
    $queryUsuario = "SELECT id FROM Usuarios WHERE usuario = ?";
    $stmtUsuario = mysqli_prepare($conn, $queryUsuario);
    mysqli_stmt_bind_param($stmtUsuario, 's', $usuario);
    mysqli_stmt_execute($stmtUsuario);
    mysqli_stmt_bind_result($stmtUsuario, $id_usuario);
    mysqli_stmt_fetch($stmtUsuario);
    mysqli_stmt_close($stmtUsuario);

    // Obtener el id del alumno
    $queryAlumno = "SELECT CodAlumno FROM Alumnos WHERE numCarnet = ?";
    $stmtAlumno = mysqli_prepare($conn, $queryAlumno);
    mysqli_stmt_bind_param($stmtAlumno, 's', $num_carnet);
    mysqli_stmt_execute($stmtAlumno);
    mysqli_stmt_bind_result($stmtAlumno, $id_alumno);
    mysqli_stmt_fetch($stmtAlumno);
    mysqli_stmt_close($stmtAlumno);

    // Calcular la fecha de devolución (14 días después de la fecha de préstamo)
    $fecha_devolucion = date('Y-m-d', strtotime($fecha_prestamo . ' + 14 days'));

    // Comprobar si hay libros disponibles para el préstamo
    $queryStock = "SELECT cantidad FROM StockLibros WHERE id_libro = ?";
    $stmtStock = mysqli_prepare($conn, $queryStock);
    mysqli_stmt_bind_param($stmtStock, 'i', $id_libro);
    mysqli_stmt_execute($stmtStock);
    mysqli_stmt_bind_result($stmtStock, $cantidad_disponible);
    mysqli_stmt_fetch($stmtStock);
    mysqli_stmt_close($stmtStock);

    if ($cantidad_disponible > 0) {
        // Restar una unidad del stock del libro
        $queryUpdateStock = "UPDATE StockLibros SET cantidad = cantidad - 1 WHERE id_libro = ?";
        $stmtUpdateStock = mysqli_prepare($conn, $queryUpdateStock);

        if ($stmtUpdateStock) {
            mysqli_stmt_bind_param($stmtUpdateStock, 'i', $id_libro);
            $resultadoUpdateStock = mysqli_stmt_execute($stmtUpdateStock);

            if ($resultadoUpdateStock) {
                // Insertar el préstamo
                $queryInsert = "INSERT INTO Prestamos (id_libro, id_usuario, id_alumno, fecha_prestamo, fecha_devolucion) VALUES (?, ?, ?, ?, ?)";
                $stmtInsert = mysqli_prepare($conn, $queryInsert);

                if ($stmtInsert) {
                    mysqli_stmt_bind_param($stmtInsert, 'iiiss', $id_libro, $id_usuario, $id_alumno, $fecha_prestamo, $fecha_devolucion);
                    $resultadoInsert = mysqli_stmt_execute($stmtInsert);

                    if ($resultadoInsert) {
                        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                     icon: 'success',
                     title: 'Prestamo añadido correctamente',
                     showConfirmButton: false,
                     timer: 1500
                   }).then(() => {
                window.location.href = 'index.php';
                });
               });
              </script>";
                    } else {
                        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Error al añadir el prestamo',
            text: 'Ocurrió un problema al intentar añadir el prestamo. Por favor, inténtalo de nuevo.',
            showConfirmButton: false,
            timer: 2000  // El mensaje de error desaparecerá después de 2 segundos
        }).then(function() {
            window.location.href = 'Modales/modalPrestamo.php';  
        });
    </script>";
                    }

                    mysqli_stmt_close($stmtInsert);
                } else {
                    echo "Error al preparar la consulta de inserción" . mysqli_error($conn);
                }
            } else {
                echo "Error al actualizar el stock del libro. Por favor, inténtalo de nuevo" . mysqli_error($conn);
            }

            mysqli_stmt_close($stmtUpdateStock);
        } else {
            echo "Error al preparar la consulta de actualización de stock" . mysqli_error($conn);
        }
    } else {
        echo "El libro seleccionado no tiene unidades disponibles para préstamo.";
    }

    mysqli_close($conn);
}
?>
