<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<div class="modal" id="modalCrearPDF_Morosos" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Opciones de PDF</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Selecciona una opción:</p>
                <button class="btn btn-primary" onclick="generarPDF_devueltos('todos')">Listado Completo</button>
                <button class="btn btn-warning" onclick="generarPDF_devueltos('usuario')">Listado Propio</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function generarPDF_devueltos(opcion) {
        // Pasa la opción seleccionada al archivo generarPDF_Devueltos.php usando AJAX
        $.ajax({
            type: 'POST',
            url: 'generarPDF_devueltos.php',
            data: { opcion: opcion },
            success: function(data) {
                 Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '¡El PDF se generó exitosamente!'
                });
            }
        });

        // Cierra el modal después de seleccionar una opción
        $('#modalCrearPDF_Morosos').modal('hide');
    }
</script>
