           
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="modal fade" id="nuevoLibroModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Contenido del modal -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Añadir Nuevo Libro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              
                <!-- Formulario de nuevos libros -->
                <form method="POST" action="addLibro.php" enctype="multipart/form-data">
                <h1>Nuevo Libro</h1>
                <div class="input-box">
                    <input type="text" id="nombre" name="nombre" placeholder="Título" required>   
                </div>
                   <div class="input-box">
                    <input type="text" id="autor" name="autor" placeholder="Autor" required>
                </div>
                <div class="input-box">
                    <input type="text" id="genero" name="genero" placeholder="Género" required>
                </div>
                <div class="input-box">
                    <input type="text" id="paginas" name="paginas" placeholder="Páginas" required>
                </div>
                  <div class="input-box">
                    <input type="text" id="cantidad" name="cantidad" placeholder="Cantidad" required>
                </div>
                 <div class="input-box">
                    <input type="file" id="portada" name="portada" accept="image/*">
                </div>
              
                <input type="submit" name="submitAgregar" value="Añadir" class="btnForm">

            </form>
            </div>
        </div>
    </div>
</div>
