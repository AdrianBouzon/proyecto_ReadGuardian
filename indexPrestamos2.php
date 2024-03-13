<?php
include_once 'conexion.php';
session_start();

require_once('tcpdf/tcpdf.php');

$totalQuery = "SELECT COUNT(*) AS total FROM Prestamos
               INNER JOIN Usuarios ON Prestamos.id_usuario = Usuarios.id
               INNER JOIN Alumnos ON Prestamos.id_alumno = Alumnos.CodAlumno
               INNER JOIN Libros ON Prestamos.id_libro = Libros.id
               WHERE Prestamos.fechaDevolucionReal IS NULL";

$totalResult = mysqli_query($conn, $totalQuery);

if ($totalResult && mysqli_num_rows($totalResult) > 0) {
    $totalRow = mysqli_fetch_assoc($totalResult);
    $totalRegistros = $totalRow['total'];
} else {
    $totalRegistros = 0;
}

$registrosPorPagina = 5;

// Calcular el número total de páginas
$num_paginas = ceil($totalRegistros / $registrosPorPagina);

// Obtener la página actual 
$pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

$inicio = ($pagina_actual - 1) * $registrosPorPagina;
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Préstamos</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <link rel="stylesheet" href="Css/stylesIndex.css">
        <link rel="stylesheet" href="Css/ModalModificarDatos.css">
        <link rel="stylesheet" href="Css/stylesPrestamos.css">

    </head>
    <body>
        <div class="header">
            <div class="header-logo">
                <img src="Imagenes/logo2.png" alt="Logo de la aplicación" style="height:300px;">
            </div>
            <div class="header-user">
                <?php
                // Verifica si el usuario está conectado
                if (isset($_SESSION['usuario'])) {
                    echo '<span style="font-weight: bold; margin-right: 10px; font-size:20px;">¡Hola, ' . $_SESSION['usuario'] . '!</span>';
                }
                ?>
                <button type="button" class="btn nuevo-modificar-datos-btn ml-auto" data-toggle="modal" data-target="#modificarDatosModal">
                    <span><i class='bx bxs-edit' style='color:#37f83c; font-size:40px;'></i></span>
                </button>

                <a href="logout.php" class="btn logout-btn ml-auto">
                    <span><i class='bx bx-log-out bx-rotate-180' style='color:#fc0808; font-size:40px;'></i></span>
                </a>

            </div>
        </div>
        <?php include 'Modales/ModalModificarDatos.php'; ?>
        <!-- Menú lateral -->
        <nav class="navbar-lateral navbar-expand-lg navbar-dark bg-dark">
            <div class="collapse navbar-collapse" id="navbarMenu">
                <ul class="navbar-nav flex-column">
                    <img src="Imagenes/libros-remove.png" alt="Logo de la aplicación" width="160px" height="100px">
                    <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="index.php">
                            Inicio
                        </a>
                    </li>
                    <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'indexProfesores.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="indexProfesores.php">
                            Profesores
                        </a>
                    </li>
                    <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'indexAlumnos.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="indexAlumnos.php">
                            Alumnos
                        </a>
                    </li>
                    <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'indexPrestamos2.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="indexPrestamos2.php">
                            Préstamos
                        </a>
                    </li>
                     <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'indexDevueltos.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="indexDevueltos.php">
                            Devoluciones
                        </a>
                    </li>
                    <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'indexMorosos.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="indexMorosos.php">
                            Registros Morosos
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid main-container">
            <main role="main" class="col-12 col-md-9 ml-sm-auto col-lg-10 px-4 main-content">


                <?php
                // Obtiene el nombre de usuario de la sesión
                $nombreUsuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;

// Verifica si el usuario está conectado
                if (!empty($nombreUsuario)) {
                    $query = "SELECT id FROM Usuarios WHERE usuario = '$nombreUsuario'";
                    $result = mysqli_query($conn, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $idUsuario = $row['id'];
                    } else {
                        die("Error: No se encontró el ID del usuario.");
                    }
                } else {
                    die("Error: El nombre de usuario no está en la sesión.");
                }

// Consulta para obtener los préstamos según la opción seleccionada
                $opcion = isset($_GET['opcion']) ? $_GET['opcion'] : 'todos';

                if ($opcion === 'todos') {
                    $query = "SELECT Prestamos.id_libro, Libros.nombre AS nombre_libro, Usuarios.usuario AS nombre_bibliotecario, 
          Alumnos.nombre AS nombre_alumno, Alumnos.apellido1, Alumnos.apellido2, Alumnos.curso, Alumnos.numCarnet,Prestamos.CodPrestamo,
          Prestamos.fecha_prestamo, DATE_ADD(Prestamos.fecha_prestamo, INTERVAL 14 DAY) AS fecha_devolucion
          FROM Prestamos
          INNER JOIN Usuarios ON Prestamos.id_usuario = Usuarios.id
          INNER JOIN Alumnos ON Prestamos.id_alumno = Alumnos.CodAlumno
          INNER JOIN Libros ON Prestamos.id_libro = Libros.id
          WHERE Prestamos.fechaDevolucionReal IS NULL
          OR Prestamos.fechaDevolucionReal = '0000-00-00'
          OR Prestamos.fechaDevolucionReal = '1970-01-01'  /* Fecha predeterminada para NULL */
          LIMIT $inicio, $registrosPorPagina";
                } elseif ($opcion === 'usuario' && isset($idUsuario)) {
                    $query = "SELECT Prestamos.id_libro, Libros.nombre AS nombre_libro, Usuarios.usuario AS nombre_bibliotecario, 
          Alumnos.nombre AS nombre_alumno, Alumnos.apellido1, Alumnos.apellido2, Alumnos.curso, Alumnos.numCarnet,Prestamos.CodPrestamo,
          Prestamos.fecha_prestamo, DATE_ADD(Prestamos.fecha_prestamo, INTERVAL 14 DAY) AS fecha_devolucion
          FROM Prestamos
          INNER JOIN Usuarios ON Prestamos.id_usuario = Usuarios.id
          INNER JOIN Alumnos ON Prestamos.id_alumno = Alumnos.CodAlumno
          INNER JOIN Libros ON Prestamos.id_libro = Libros.id
          WHERE Prestamos.id_usuario = $idUsuario
          AND (Prestamos.fechaDevolucionReal IS NULL
               OR Prestamos.fechaDevolucionReal = '0000-00-00'
               OR Prestamos.fechaDevolucionReal = '1970-01-01')  
          LIMIT $inicio, $registrosPorPagina";
                }

                $result = mysqli_query($conn, $query);
                ?>

                <h2>Listado de Prestamos</h2>

                <button class="btn" data-toggle="modal" data-target="#modalCrearPDF" style="margin-left:700px;">
                    <i class='bx bxs-file-pdf' style='color:#FF0000; font-size: 40px;'></i>
                </button>

                <!-- Formulario de búsqueda -->
                <form action="" method="GET" class="form-inline mt-2 mt-md-0">
                    <input class="form-control mr-sm-2" type="text" placeholder="Buscar prestamo" name="busqueda" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>


                <div class="row">
  <?php
                    include 'Consultas/BuscadorPrestamos.php';
                    ?>
                    <table class="table table-bordered table-prestamos">
                        <thead>
                            <tr>
                                <th>Libro</th>
                                <th>Bibliotecario</th>
                                <th>Alumno</th>
                                <th>NºCarnet</th>
                                <th>Curso</th>
                                <th>Fecha prestamo</th>
                                <th>Fecha devolución</th>
                                <th>Ampliar</th>
                                <th>Devolucion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            function obtenerFechaDevolucion($codPrestamo) {
                                $dbhost = "localhost:3308";
                                $dbuser = "root";
                                $dbpass = "";
                                $dbname = "bibliotecaprueba";

                                $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
                                if (!$conn) {
                                    die("No hay conexion: " . mysqli_connect_error());
                                }
                                $query = "SELECT fecha_devolucion FROM Prestamos WHERE CodPrestamo = $codPrestamo";
                                $result = mysqli_query($conn, $query);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    $row = mysqli_fetch_assoc($result);
                                    return $row['fecha_devolucion'];
                                } else {
                                    return 'Fecha no disponible';
                                }
                            }
                            ?>
                  
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>';
                                echo '<td>' . $row['nombre_libro'] . '</td>';
                                echo '<td>' . $row['nombre_bibliotecario'] . '</td>';
                                echo '<td>' . $row['nombre_alumno'] . ' ' . $row['apellido1'] . ' ' . $row['apellido2'] . '</td>';
                                echo '<td>' . $row['numCarnet'] . '</td>';
                                echo '<td>' . $row['curso'] . '</td>';
                                echo '<td>' . $row['fecha_prestamo'] . '</td>';
                                echo '<td id="fechaDev_' . $row['CodPrestamo'] . '">' . obtenerFechaDevolucion($row['CodPrestamo']) . '</td>';
                                echo '<td><button class="btn btn-warning" data-toggle="modal" data-target="#modalModificarFecha" data-nombre-libro="' . $row['nombre_libro'] . '" data-nombre-alumno="' . $row['nombre_alumno'] . ' ' . $row['apellido1'] . ' ' . $row['apellido2'] . '" onclick="cargarDatosModal(' . $row['CodPrestamo'] . ')">Modificar</button></td>';
                                echo '<td><button class="btn btn-success" data-cod-prestamo="' . $row['CodPrestamo'] . '" onclick="devolverLibro(' . $row['CodPrestamo'] . ');">Devolver</button></td>';
                                echo '</tr>';
                            }
                            ?>

                        </tbody>
                    </table>

                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <?php if ($pagina_actual > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?pagina=<?php echo $pagina_actual - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $num_paginas; $i++): ?>
                            <li class="page-item <?php if ($pagina_actual == $i) echo 'active'; ?>"><a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        <?php endfor; ?>
                        <?php if ($pagina_actual < $num_paginas): ?>
                            <li class="page-item">
                                <a class="page-link" href="?pagina=<?php echo $pagina_actual + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </main>
        </div>
        <?php include_once 'Modales/modalPDF_bueno.php'; ?>
        <?php include_once 'ModificarFechaDevolucion.php'; ?>
        <script>
            var codigoPrestamoActual;

            function cargarDatosModal(codPrestamo) {
                codigoPrestamoActual = codPrestamo;

                // Obtener el nombre del libro y del alumno desde los atributos de datos del botón
                var nombreLibro = $('button[data-target="#modalModificarFecha"]:focus').data('nombre-libro');
                var nombreAlumno = $('button[data-target="#modalModificarFecha"]:focus').data('nombre-alumno');


                // Llenar los campos del modal con los datos
                $('#nombreLibro').val(nombreLibro);
                $('#nombreAlumno').val(nombreAlumno);

            }

            function guardarNuevaFecha() {
                var nuevaFecha = document.getElementById('nuevaFecha').value;
                if (nuevaFecha !== null && nuevaFecha !== "") {
                    // Realiza una solicitud AJAX para actualizar la fecha de devolución.
                    $.ajax({
                        type: 'POST',
                        url: 'ModificarFechaDevolucion.php',
                        data: {codPrestamo: codigoPrestamoActual, nuevaFecha: nuevaFecha},
                        success: function (data) {
                            // Actualiza la fecha en la tabla con la nueva fecha
                            $('#fechaDev_' + codigoPrestamoActual).text(nuevaFecha);

                            // Cierra el modal
                            $('#modalModificarFecha').modal('hide');
                        }
                    });
                }
            }


        </script>

        <script>
            function devolverLibro(codPrestamo) {
                // Realizar una solicitud AJAX para devolver el libro y actualizar el stock
                $.ajax({
                    type: 'POST',
                    url: 'DevolverLibro.php',
                    data: {codPrestamo: codPrestamo},
                    success: function (data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Devolución Correcta',
                            text: 'El libro ha sido devuelto correctamente.',
                        });
                    }
                });
            }
        </script>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>
