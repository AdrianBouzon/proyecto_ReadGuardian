<?php
include_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['codPrestamo'])) {
        $codPrestamo = $_POST['codPrestamo'];

        // Obtener la fecha actual
        $fechaDevolucionReal = date("Y-m-d");

        // Obtener el ID del libro y la cantidad prestada
        $selectInfoLibro = "SELECT id_libro FROM Prestamos WHERE CodPrestamo = $codPrestamo";
        $resultInfoLibro = mysqli_query($conn, $selectInfoLibro);

        if ($resultInfoLibro && $rowInfoLibro = mysqli_fetch_assoc($resultInfoLibro)) {
            $idLibro = $rowInfoLibro['id_libro'];

            // Actualizar la cantidad en la tabla StockLibros
            $updateStockLibros = "UPDATE StockLibros SET cantidad = cantidad + 1 WHERE id_libro = $idLibro";
            $resultStockLibros = mysqli_query($conn, $updateStockLibros);

            if ($resultStockLibros) {
                // Actualizar la fecha de devolución real en la tabla de Prestamos
                $updatePrestamo = "UPDATE Prestamos SET fechaDevolucionReal = '$fechaDevolucionReal' WHERE CodPrestamo = $codPrestamo";
                $resultPrestamo = mysqli_query($conn, $updatePrestamo);

                if ($resultPrestamo) {
                    echo $fechaDevolucionReal;
                } else {
                    echo "Error al actualizar la fecha de devolución real.";
                }
            } else {
                echo "Error al actualizar la cantidad en StockLibros.";
            }
        } else {
            echo "Error al obtener la información del libro.";
        }
    } else {
        echo "Error: Parámetros incompletos.";
    }
} else {
    echo "Error: Método de solicitud incorrecto.";
}
?>
