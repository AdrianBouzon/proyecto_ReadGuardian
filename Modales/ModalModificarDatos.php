
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Contenido del modal para modificar datos -->
<div class="modal fade" id="modificarDatosModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Contenido del modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modificar Datos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Contenido del formulario para modificar datos -->
                <form method="POST" action="addModificarDatos.php" enctype="multipart/form-data">
                    <div class="input-box">
                        <input type="email" id="nuevoCorreo" name="nuevoCorreo" placeholder="Nuevo Correo">
                        <ion-icon name="mail-outline" class="icon"></ion-icon>
                    </div>
                    <div class="input-box">
                        <input type="password" id="nuevoPassword" name="nuevoPassword" placeholder="Nueva Contraseña">
                        <ion-icon name="lock-closed-outline" class="icon"></ion-icon>
                    </div>
                    <input type="submit" name="submitGuardar" value="Guardar Cambios" class="btnForm">
                </form>
            </div>
        </div>
    </div>
</div>
