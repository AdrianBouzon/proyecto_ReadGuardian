<?php
include_once 'conexion.php';
?>          
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="modal fade" id="nuevoPrestamoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Contenido del modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Prestamo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- Formulario de nuevos libros -->
                <form method="POST" action="addPrestamo.php" enctype="multipart/form-data">
                    <h1>Nuevo Prestamo</h1>

                    <div class="form-group">

                        <label for="libro">Libro:</label>
                        <select class="form-control" id="libro" name="libro" onchange="seleccionarLibro()">
                            <option value="" disabled selected>Selecciona un libro</option>
                            <?php
                            // Consulta para obtener todos los libros
                            $queryLibros = " SELECT id, nombre, 
                        COALESCE(StockLibros.cantidad, 0) AS cantidad_disponible 
                 FROM Libros 
                 LEFT JOIN StockLibros ON Libros.id = StockLibros.id_libro 
                 GROUP BY Libros.id, Libros.nombre";
                            $resultLibros = mysqli_query($conn, $queryLibros);

                            // Mostrar opciones en el select
                            while ($rowLibro = mysqli_fetch_assoc($resultLibros)) {
                                echo "<option value='{$rowLibro['id']}' data-cantidad-disponible='{$rowLibro['cantidad_disponible']}'>{$rowLibro['nombre']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="usuario">Usuario:</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo $_SESSION['usuario']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="usuario">NºCarnet:</label>
                        <input type="text" class="form-control" id="num_Carnet" name="num_carnet" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha_prestamo">Fecha de Préstamo:</label>
                        <input type="date" class="form-control" id="fecha_prestamo" name="fecha_prestamo" required>
                    </div>


                    <button type="submit" class="btn btn-primary" name="submitPrestamo">Guardar Préstamo</button>

                </form>

                <script>
                    $(document).ready(function () {

                        function seleccionarLibro() {
                            var idLibroSeleccionado = $('#libro').val();
                            $('#id_libro').val(idLibroSeleccionado);
                        }

                        $('#nuevoPrestamoModal form').submit(function (event) {
                            // Obtener la cantidad disponible del libro seleccionado
                            var cantidadDisponible = $('#libro option:selected').data('cantidad-disponible');

                            // Verificar si la cantidad es mayor a 0
                            if (cantidadDisponible <= 0) {
                                // Mostrar SweetAlert en lugar de alert
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'El libro seleccionado no tiene unidades disponibles para préstamo.'
                                });
                                event.preventDefault(); // Evita que el formulario se envíe
                            }
                        });

                    });
                </script>
            </div>
        </div>
    </div>
</div>
