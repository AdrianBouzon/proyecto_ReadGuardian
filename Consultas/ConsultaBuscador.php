<?php

// Verifica si se ha enviado el formulario de búsqueda
if (isset($_GET['busqueda'])) {
    $busqueda = mysqli_real_escape_string($conn, $_GET['busqueda']);

    // Modifica la consulta para incluir la condición de búsqueda
    $query = "SELECT libros.*, COALESCE(stock.cantidad, 0) as cantidad_disponible
              FROM libros
              LEFT JOIN StockLibros stock ON libros.id = stock.id_libro
              WHERE nombre LIKE '%$busqueda%' OR autor LIKE '%$busqueda%' OR genero LIKE '%$busqueda%'
            LIMIT $inicio, $registrosPorPagina";
} else {
    // Si no se ha enviado el formulario, muestra todos los libros
    $query = "SELECT libros.*, COALESCE(stock.cantidad, 0) as cantidad_disponible
              FROM libros
              LEFT JOIN StockLibros stock ON libros.id = stock.id_libro
            LIMIT $inicio, $registrosPorPagina";
}
$result = mysqli_query($conn, $query);

?>