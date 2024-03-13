
<div class="modal fade" id="nuevoAlumnoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Contenido del modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Añadir Nuevo Alumno</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              
                <!-- Formulario de nuevos libros -->
                <form method="POST" action="addAlumno.php" enctype="multipart/form-data">
                <h1>Nuevo Alumno</h1>
                <div class="input-box">
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre Alumno" required>          
                </div>
                   <div class="input-box">
                    <input type="text" id="apellido1" name="apellido1" placeholder="Primer Apellido" required>
                </div>
                <div class="input-box">
                    <input type="text" id="apellido2" name="apellido2" placeholder="Segundo Apellido" required>
                </div>
                <div class="input-box">
                    <input type="text" id="curso" name="curso" placeholder="Curso" required>
                </div>
                 <div class="input-box">
                    <input type="text" id="numCarnet" name="numCarnet" placeholder="Nºde Carnet" required>
                </div>

                <input type="submit" name="submitAlumno" value="Añadir" class="btnForm">

            </form>
            </div>
        </div>
    </div>
</div>
   