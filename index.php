<?php
include_once 'conexion.php';
session_start();


$totalQuery = "SELECT COUNT(*) AS total
               FROM libros
               LEFT JOIN StockLibros stock ON libros.id = stock.id_libro";



$totalResult = mysqli_query($conn, $totalQuery);

if ($totalResult && mysqli_num_rows($totalResult) > 0) {
    $totalRow = mysqli_fetch_assoc($totalResult);
    $totalRegistros = $totalRow['total'];
} else {
    $totalRegistros = 0;
}

$registrosPorPagina = 8;

// Calcular el número total de páginas
$num_paginas = ceil($totalRegistros / $registrosPorPagina);

// Obtener la página actual 
$pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

// Calcular el inicio del conjunto de registros actual
$inicio = ($pagina_actual - 1) * $registrosPorPagina;
?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Página de Inicio - Libros</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <link rel="stylesheet" href="Css/stylesIndex.css">
        <link rel="stylesheet" href="Css/ModalPrestamo.css"> 
        <link rel="stylesheet" href="Css/ModalLibro.css">
        <link rel="stylesheet" href="Css/ModalModificarDatos.css">

        <style>

         
            .btn-primary.nuevo-libro-btn, btn-primary.nuevo-prestamo-btn {
                margin-right: 60px; 
            }

            /*Boton crear PDF*/
            .btn{
                margin-left: 20px;
                margin-right: 20px;
                margin-bottom: 10px;
            }

            
            .pagination {
                margin-top: 1.2rem;
            }
            
           


        </style>
    </head>
    <body>
        <!-- Encabezado -->
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
                            Prestamos
                        </a>
                    </li>
                    <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'indexDevueltos.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="indexDevueltos.php">
                            Devoluciones
                        </a>
                    </li>
                    <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'indexMorosos.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="indexMorosos.php">
                            Morosos
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid main-container">
         
            <main role="main" class="col-12 col-md-9 ml-sm-auto col-lg-10 px-4 main-content">

                <h1>Listado de Libros</h1>

                <!-- Formulario de búsqueda -->
                <form action="" method="GET" class="form-inline mt-2 mt-md-0">
                    <input class="form-control mr-sm-2" type="text" placeholder="Buscar por título, autor o género" name="busqueda" aria-label="Search">
                    <button class="btn">
                        <span><i class='bx bx-search' style='color:#d70ff7; font-size:40px;'></i></i>Buscar</span>
                    </button>
                    <button type="button" class="btn nuevo-libro-btn ml-auto" data-toggle="modal" data-target="#nuevoLibroModal">
                        <span><i class='bx bx-book-add' style='color:#0871fc; font-size:40px;'></i>Nuevo libro </span>
                    </button>
                    <button type="button" class="btn nuevo-prestamo-btn ml-auto" data-toggle="modal" data-target="#nuevoPrestamoModal">
                        <span><i class='bx bx-list-plus' style='color:#fc08ed; font-size:40px;'  ></i>Prestamo nuevo</span>
                    </button>
                </form>

                <?php
                include 'Modales/modalLibros.php';
                include 'Modales/modalPrestamo.php';
                ?>
                <div class="row" style="margin-left: 20px;">
                    <?php
                    include 'Consultas/ConsultaBuscador.php';
                    ?>

                    <?php
                 
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col-md-3 mb-4">';
                        echo '<div class="card h-100 custom-cards" style="position: relative; overflow: hidden;">';

                        // Verifica la cantidad disponible
                        if ($row['cantidad_disponible'] <= 0) {
                            echo '<p class="card-text" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-60deg); color: red; font-weight: bold; z-index: 1; white-space: nowrap; font-size: 50px;">No disponible</p>';
                        }

                        echo '<img src="portadas/' . $row['portada'] . '" class="card-img-top img-fluid" alt="' . $row['nombre'] . '">';

                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $row['nombre'] . '</h5>';
                        echo '<p class="card-text">' . $row['autor'] . '</p>';
                        echo '<p class="card-text">' . $row['genero'] . '</p>';

                        // Combinar número de páginas y cantidad disponible
                        if ($row['cantidad_disponible'] > 0) {
                            echo '<p class="card-text">' . 'Páginas: ' . $row['paginas'] . ' | Stock: ' . $row['cantidad_disponible'] . '</p>';
                        } else {
                            echo '<p class="card-text">' . 'Páginas: ' . $row['paginas'] . '</p>';
                        }

                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                   
                    mysqli_close($conn);
                    ?>

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
