
<?php

include_once 'conexion.php';
session_start();

if (isset($_POST['submitAgregar'])) {
    // Obtén los datos del formulario
    $nombre = $_POST['nombre'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];
    $paginas = $_POST['paginas'];
    $cantidad = $_POST['cantidad'];

    // Verificar si se envió el archivo
    if (isset($_FILES['portada'])) {
        $portada = $_FILES['portada']['name'];
        $temp_file = $_FILES['portada']['tmp_name'];
        $uploads_dir = 'portadas/'; // Directorio donde se guardarán las portadas

        move_uploaded_file($temp_file, $uploads_dir . $portada);
    } else {
        // Si no se envió un archivo, establece $portada como null o cualquier valor predeterminado según tus necesidades
        $portada = null;
    }


    $query = "INSERT INTO libros (nombre, autor, genero, paginas, portada) VALUES (?, ?, ?, ?, ?)";

    $stmtLibros = mysqli_prepare($conn, $query);

    // Verifica si la sentencia  se creó correctamente
    if ($stmtLibros) {
        //La cadena de definición de tipos es 'sssss', lo que significa que se espera enlazar cinco variables de tipo string
        mysqli_stmt_bind_param($stmtLibros, 'sssss', $nombre, $autor, $genero, $paginas, $portada);

        // Ejecuta la sentencia
        $resultLibros = mysqli_stmt_execute($stmtLibros);

        // Verifica si la inserción fue exitosa
        if ($resultLibros) {

            // Obtén el ID del libro recién insertado
            $id_libro = mysqli_insert_id($conn);

            // Inserta la cantidad de libros en la tabla StockLibros
            $queryStock = "INSERT INTO StockLibros (id_libro, cantidad) VALUES (?, ?)";
            $stmtStock = mysqli_prepare($conn, $queryStock);

            if ($stmtStock) {
                mysqli_stmt_bind_param($stmtStock, 'ii', $id_libro, $cantidad);
                $resultStock = mysqli_stmt_execute($stmtStock);

                // Verifica si la inserción en la tabla StockLibros fue correcta
                if (!$resultStock) {
                    echo "Error al agregar la cantidad de libros en StockLibros: " . mysqli_error($conn);
                }

                // Cierra la sentencia StockLibros
                mysqli_stmt_close($stmtStock);
            } else {
                echo "Error al preparar la sentencia para StockLibros: " . mysqli_error($conn);
            }


            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                     icon: 'success',
                     title: 'Libro agregado correctamente',
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
            title: 'Error al agregar el libro',
            text: 'Ocurrió un problema al intentar agregar el libro. Por favor, inténtalo de nuevo.',
            showConfirmButton: false,
            timer: 3000  // El mensaje de error desaparecerá después de 3 segundos
        }).then(function() {
            window.location.href = 'Modales/modalLibros.php';  // Redirige al modalLibros.php para volver a intentarlo
        });
    </script>";
        }

        // Cierra la sentencia 
        mysqli_stmt_close($stmtLibros);
    } else {
        echo "Error al preparar la sentencia: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
