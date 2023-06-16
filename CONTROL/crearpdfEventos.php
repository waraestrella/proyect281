<?php
require('../fpdf/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        // Logo
        $this->Image('../imagenes/logo.png', 10, 10, 30);
        // Título
        $this->SetFont('Arial','B',16);
        $this->Cell(0,10,'Sistema de Eventos Academicos',0,1,'C');
        // Subtítulo
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,'REGISTRO DE EVENTOS',0,1,'C');
        // Salto de línea
        $this->Ln(20);
    }
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_chat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Crear un objeto PDF en orientación horizontal
$pdf = new PDF('L');
$pdf->AddPage();

// Establecer fuente y tamaño de letra para el contenido
$pdf->SetFont('Arial','',12);

// Encabezado de la tabla
$pdf->Cell(15, 10, 'ID', 1, 0, 'C');
$pdf->Cell(30, 10, 'Nombre', 1, 0, 'L');
$pdf->Cell(30, 10, 'Fecha de Inicio', 1, 0, 'L');
$pdf->Cell(30, 10, 'Fecha Fin', 1, 0, 'L');
$pdf->Cell(70, 10, 'Descripcion', 1, 0, 'L'); // Aumenta el ancho de la celda para la descripción
$pdf->Cell(30, 10, 'Cupo Maximo', 1, 0, 'L');
$pdf->Cell(30, 10, 'Numero de Actividades', 1, 0, 'L');
$pdf->Cell(30, 10, 'Estado', 1, 1, 'L');

// Datos de la tabla
$cell_width = 15;
$name_width = 30;
$cell_align = 'L';
$state_align = 'C';

// Consultar los eventos de la base de datos
$sql = "SELECT * FROM evento ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell($cell_width, 10, $row["id"], 1, 0, $cell_align);
        $pdf->Cell($name_width, 10, $row["nombre"], 1, 0, $cell_align);
        $pdf->Cell($name_width, 10, $row["fecha_inicio"], 1, 0, $cell_align);
        $pdf->Cell($name_width, 10, $row["fecha_fin"], 1, 0, $cell_align);
        $pdf->MultiCell(70, 10, $row["descripcion"], 1, $cell_align); // Utiliza MultiCell para permitir saltos de línea en la descripción
        $pdf->Cell($name_width, 10, $row["cupo_maximo"], 1, 0, $cell_align);
        $pdf->Cell($name_width, 10, $row["numActividades"], 1, 0, $cell_align);
        $pdf->Cell($name_width, 10, $row["estado"], 1, 1, $state_align);
    }
} else {
    $pdf->Cell(0,10,'No se encontraron eventos.',0,1);
}

// Salida del PDF
$pdf->Output();
?>
