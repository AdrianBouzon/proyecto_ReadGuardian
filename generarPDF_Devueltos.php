<?php
require_once('TCPDF/tcpdf.php');
session_start();
include_once 'conexion.php';

$opcion = $_POST['opcion'];

if ($opcion === 'todos') {
    $consulta = "SELECT Prestamos.id_libro, Libros.nombre AS nombre_libro, Usuarios.usuario AS nombre_bibliotecario, 
        Alumnos.nombre AS nombre_alumno, Alumnos.apellido1, Alumnos.apellido2, Alumnos.curso, Alumnos.numCarnet, Prestamos.CodPrestamo,
        Prestamos.fecha_prestamo, Prestamos.fecha_devolucion, Prestamos.fechaDevolucionReal
        FROM Prestamos
        INNER JOIN Usuarios ON Prestamos.id_usuario = Usuarios.id
        INNER JOIN Alumnos ON Prestamos.id_alumno = Alumnos.CodAlumno
        INNER JOIN Libros ON Prestamos.id_libro = Libros.id
        WHERE Prestamos.fechaDevolucionReal IS NOT NULL";
} elseif ($opcion === 'usuario') {
    $nombreUsuario = $_SESSION['usuario'];

      // Obtener el ID del usuario
    $query = "SELECT id FROM Usuarios WHERE usuario = '$nombreUsuario'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $idUsuario = $row['id'];
    } else {
        die("Error: No se encontró el ID del usuario.");
    }
    
    $consulta = "SELECT Prestamos.id_libro, Libros.nombre AS nombre_libro, Usuarios.usuario AS nombre_bibliotecario, 
        Alumnos.nombre AS nombre_alumno, Alumnos.apellido1, Alumnos.apellido2, Alumnos.curso, Alumnos.numCarnet, Prestamos.CodPrestamo,
        Prestamos.fecha_prestamo, Prestamos.fecha_devolucion, Prestamos.fechaDevolucionReal
        FROM Prestamos
        INNER JOIN Usuarios ON Prestamos.id_usuario = Usuarios.id
        INNER JOIN Alumnos ON Prestamos.id_alumno = Alumnos.CodAlumno
        INNER JOIN Libros ON Prestamos.id_libro = Libros.id
        WHERE Prestamos.fechaDevolucionReal IS NOT NULL
        AND Prestamos.id_usuario = $idUsuario";
}

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->AddPage();

$pdf->SetXY(10, 10);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 10, 'Listado de Devoluciones', 0, 1, 'C');
$pdf->Ln(10);

// Establece la posición para la fecha en la esquina superior derecha
$pdf->SetXY(150, 10);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 0, 'Fecha: ' . date('d-m-Y'), 0, 1, 'R'); // la R indica alineacion a la derecha.
$pdf->Ln(10);
$result = mysqli_query($conn, $consulta);

$pdf->SetFont('helvetica', '', 8);
$pdf->Cell(45, 10, 'ID libro', 1);
$pdf->Cell(25, 10, 'ID bibliotecario', 1);
$pdf->Cell(40, 10, 'ID alumno', 1);
$pdf->Cell(15, 10, 'Nº Carnet', 1);
$pdf->Cell(20, 10, 'Curso', 1);
$pdf->Cell(25, 10, 'Fecha préstamo', 1);
$pdf->Cell(25, 10, 'Fecha devolución', 1);
$pdf->Ln();

$pdf->SetFont('helvetica', '', 8);

while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(45, 10, $row['nombre_libro'], 1);
    $pdf->Cell(25, 10, $row['nombre_bibliotecario'], 1);
    $pdf->Cell(40, 10, $row['nombre_alumno'] . ' ' . $row['apellido1'] . ' ' . $row['apellido2'], 1);
    $pdf->Cell(15, 10, $row['numCarnet'], 1);
    $pdf->Cell(20, 10, $row['curso'], 1);
    $pdf->Cell(25, 10, $row['fecha_prestamo'], 1);
    $pdf->Cell(25, 10, $row['fechaDevolucionReal'], 1);
    $pdf->Ln();
}

$carpetaPDF = __DIR__ . '/PDF/';

if (!file_exists($carpetaPDF)) {
    mkdir($carpetaPDF, 0777, true);
}

$fechaActual = date('Y-m-d');
$numeroSecuencial = obtenerNumeroSecuencial();
$nombreArchivoPDF = 'listado_devueltos_' . $nombreUsuario . '_' . $fechaActual . '_' . $numeroSecuencial . '.pdf';
$pdfFilePath = $carpetaPDF . $nombreArchivoPDF;
$pdf->Output($pdfFilePath, 'F');

mysqli_close($conn);

function obtenerNumeroSecuencial() {
    $archivoContador = 'contador3.txt';

    if (file_exists($archivoContador)) {
        $contador = intval(file_get_contents($archivoContador));
        $contador++;
    } else {
        $contador = 1;
    }

    file_put_contents($archivoContador, $contador);

    return $contador;
}
?>