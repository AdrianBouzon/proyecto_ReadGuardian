<div class="modal fade" id="modalModificarFecha" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modificar Fecha de Devolución</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="nombreLibro">Nombre del Libro:</label>
                <input type="text" class="form-control" id="nombreLibro" name="nombreLibro" readonly>

                <label for="nombreAlumno">Nombre del Alumno:</label>
                <input type="text" class="form-control" id="nombreAlumno" name="nombreAlumno" readonly>
                
                <label for="nuevaFecha">Nueva Fecha de Devolución:</label>
                <input type="date" class="form-control" id="nuevaFecha" name="nuevaFecha">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal"onclick="guardarNuevaFecha()">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>
<?php
include_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['codPrestamo']) && isset($_POST['nuevaFecha'])) {
        $codPrestamo = $_POST['codPrestamo'];
        $nuevaFecha = $_POST['nuevaFecha'];

        // Realiza la actualización en la base de datos
        $queryUpdateFecha = "UPDATE Prestamos SET fecha_devolucion = '$nuevaFecha' WHERE CodPrestamo = $codPrestamo";
        $resultUpdateFecha = mysqli_query($conn, $queryUpdateFecha);

        if ($resultUpdateFecha) {
            // La actualización fue realizada con exito
            echo 'Fecha actualizada correctamente';
        } else {
            // Hubo un error en la actualización
            echo 'Error al actualizar la fecha';
        }
    } else {
        // Los datos necesarios no fueron proporcionados
        echo 'Datos insuficientes para actualizar la fecha';
    }
}
?>