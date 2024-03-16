<?php

include_once 'conexion.php';

// Verifica si se ha enviado el formulario de búsqueda
if (isset($_GET['busqueda'])) {
    $busqueda = mysqli_real_escape_string($conn, $_GET['busqueda']);

    // Modifica la consulta para incluir la condición de búsqueda
    $query = "SELECT Prestamos.id_libro, Libros.nombre AS nombre_libro, Usuarios.usuario AS nombre_bibliotecario, 
            Alumnos.nombre AS nombre_alumno, Alumnos.apellido1, Alumnos.apellido2, Alumnos.curso, Alumnos.numCarnet, Prestamos.CodPrestamo,
            Prestamos.fecha_prestamo, Prestamos.fecha_devolucion
            FROM Prestamos
            INNER JOIN Usuarios ON Prestamos.id_usuario = Usuarios.id
            INNER JOIN Alumnos ON Prestamos.id_alumno = Alumnos.CodAlumno
            INNER JOIN Libros ON Prestamos.id_libro = Libros.id
            WHERE Prestamos.fecha_devolucion <= CURRENT_DATE()
        AND (Alumnos.nombre LIKE '%$busqueda%' OR Alumnos.numCarnet LIKE '%$busqueda%')
        LIMIT $inicio, $registrosPorPagina";
} else {
    // Si no se ha enviado el formulario, muestra todos los morosos
    $query = "SELECT Prestamos.id_libro, Libros.nombre AS nombre_libro, Usuarios.usuario AS nombre_bibliotecario, 
            Alumnos.nombre AS nombre_alumno, Alumnos.apellido1, Alumnos.apellido2, Alumnos.curso, Alumnos.numCarnet, Prestamos.CodPrestamo,
            Prestamos.fecha_prestamo, Prestamos.fecha_devolucion
            FROM Prestamos
            INNER JOIN Usuarios ON Prestamos.id_usuario = Usuarios.id
            INNER JOIN Alumnos ON Prestamos.id_alumno = Alumnos.CodAlumno
            INNER JOIN Libros ON Prestamos.id_libro = Libros.id
            WHERE Prestamos.fecha_devolucion <= CURRENT_DATE()
        LIMIT $inicio, $registrosPorPagina";
}

$result = mysqli_query($conn, $query);
?>
