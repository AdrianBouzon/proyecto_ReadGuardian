<?php

if (isset($_GET['busqueda'])) {
    $busqueda = mysqli_real_escape_string($conn, $_GET['busqueda']);
    $query = "SELECT * FROM alumnos WHERE nombre LIKE '%$busqueda%' OR numCarnet LIKE  '%$busqueda%' OR curso LIKE '%$busqueda%'";
} else {
    $query = "SELECT * FROM alumnos LIMIT $inicio, $alumnos_por_pagina";
}

$result = mysqli_query($conn, $query);
?>