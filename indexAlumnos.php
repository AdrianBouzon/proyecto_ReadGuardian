<?php
include_once 'conexion.php';
session_start();

$query = "SELECT COUNT(*) AS num_alumnos FROM alumnos";
$resultado = mysqli_query($conn, $query);
$fila = mysqli_fetch_assoc($resultado);
$num_alumnos = $fila['num_alumnos'];

$alumnos_por_pagina = 6;

// Calcular el número de páginas
$num_paginas = ceil($num_alumnos / $alumnos_por_pagina);
?>



<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Alumnos</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <link rel="stylesheet" href="Css/stylesIndex.css">
        <link rel="stylesheet" href="Css/stylesAlumnos.css">
        <link rel="stylesheet" href="Css/ModalModificarDatos.css">
        <link rel="stylesheet" href="Css/ModalAlumnos.css">

        <style>


            .pagination {
                margin-top: 1.2rem;
            }
        </style>
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
// Consulta para obtener los usuarios alumnos
                $query = "SELECT * FROM Alumnos";
                $result = mysqli_query($conn, $query);
                ?>
                <h1>Listado de Alumnos</h1>

                <!-- Formulario de búsqueda -->
                <form action="" method="GET" class="form-inline mt-2 mt-md-0">
                    <input class="form-control mr-sm-2" type="text" placeholder="Buscar por nombre" name="busqueda" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                    <button type="button" class="btn nuevo-alumno-btn ml-auto" data-toggle="modal" data-target="#nuevoAlumnoModal" style="margin-right: 250px;">
                        <span><i class='bx bxs-user-plus' style='color:#f1ce09; font-size:40px;'></i>Nuevo Alumno </span>
                    </button>

                </form>
                <?php include 'Modales/modalAlumnos.php'; ?>
                <div class="row">

                    <table class="table table-bordered table-alumnos">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Curso</th>
                                <th>NºCarnet</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (isset($_GET['pagina']) && is_numeric($_GET['pagina'])) {
                                $pagina_actual = (int) $_GET['pagina'];
                            } else {
                                $pagina_actual = 1; // Por defecto, mostrar la primera página
                            }


                            $inicio = ($pagina_actual - 1) * $alumnos_por_pagina;

                            include 'Consultas/BuscadorAlumnos.php';
                            ?>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>';
                                echo '<td>' . $row['CodAlumno'] . '</td>';
                                echo '<td>' . $row['nombre'] . '</td>';
                                echo '<td>' . $row['apellido1'] . ' ' . $row['apellido2'] . '</td>';
                                echo '<td>' . $row['curso'] . '</td>';
                                echo '<td>' . $row['numCarnet'] . '</td>';
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
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
