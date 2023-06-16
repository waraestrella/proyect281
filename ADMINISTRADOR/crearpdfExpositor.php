<?php
require('../fpdf/fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        // Logo
        $this->Image('../imagenes/logo.png', 165, 10, 30);
        // Título
        $this->SetFont('Arial','B',16);
        $this->Cell(0,10,'Sistema de Eventos Academicos',0,1,'C');
        // Subtítulo
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,'Usuarios Expositores',0,1,'C');
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

// Crear un objeto PDF
$pdf = new PDF();
$pdf->AddPage();


// Establecer fuente y tamaño de letra para el contenido
$pdf->SetFont('Arial','',12);

 // Encabezado de la tabla
$pdf->Cell(10, 10, 'ID', 1, 0, 'C');
$pdf->Cell(30, 10, 'Nombre', 1, 0, 'L');
$pdf->Cell(30, 10, 'Apellido', 1, 0, 'L');
$pdf->Cell(30, 10, 'Telefono', 1, 0, 'L');
$pdf->Cell(50, 10, 'Email', 1, 0, 'L');

$pdf->Cell(20, 10, 'Estado', 1, 1, 'L');

// Datos de la tabla
$cell_width = 10;
$name_width = 30;
$cell_align = 'L';
$state_align = 'C';

// Consultar los usuarios de la base de datos
$sql = "SELECT * FROM usuario where tipo_usuario = 'expositor'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
   

while ($row = $result->fetch_assoc()) {
    $pdf->Cell($cell_width, 10, $row["id"], 1, 0, $cell_align);
    $pdf->Cell($name_width, 10, $row["nombre"], 1, 0, $cell_align);
    $pdf->Cell($name_width, 10, $row["apellido"], 1, 0, $cell_align);
    $pdf->Cell($name_width, 10, $row["telefono"], 1, 0, $cell_align);
    $pdf->Cell(50, 10, $row["email"], 1, 0, $cell_align);
    
    $pdf->Cell($name_width, 10, $row["estado"], 1, 1, $state_align);
}

    }
 else {
    $pdf->Cell(0,10,'No se encontraron usuarios.',0,1);
}

// Salida del PDF
$pdf->Output();
?>
