<?php
require('../fpdf/fpdf.php');
require('../phpqrcode/qrlib.php');

// Obtener los parámetros del eventoId y usuarioId
$eventoId = $_GET['eventoId'];
$usuarioId = $_GET['usuarioId'];

// Obtener los datos del evento
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_chat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset('utf8'); // Establecer el conjunto de caracteres a UTF-8

// Obtener los datos del evento
$evento_query = "SELECT * FROM evento WHERE id = $eventoId";
$evento_result = $conn->query($evento_query);

if ($evento_result->num_rows > 0) {
    $evento_row = $evento_result->fetch_assoc();
    $nombreEvento = $evento_row['nombre'];
} else {
    $nombreEvento = 'Evento no encontrado';
}

// Obtener los datos del usuario
$usuario_query = "SELECT * FROM usuario WHERE id = $usuarioId";
$usuario_result = $conn->query($usuario_query);

if ($usuario_result->num_rows > 0) {
    $usuario_row = $usuario_result->fetch_assoc();
    $nombreUsuario = $usuario_row['nombre'] . ' ' . $usuario_row['apellido'];
    $emailUsuario = $usuario_row['email'];
    $celularUsuario = $usuario_row['telefono'];
} else {
    echo "Error en la consulta del usuario: " . $conn->error;
    $nombreUsuario = 'Usuario no encontrado';
    $emailUsuario = '';
    $celularUsuario = '';
}

// Obtener las actividades relacionadas con el evento
$actividades_query = "SELECT * FROM actividad WHERE id_evento = $eventoId";
$actividades_result = $conn->query($actividades_query);

// Crear la clase PDF personalizada
class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('../imagenes/logo.png', 10, 10, 30);
        // Título principal
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 20, 'BOLETA DE INSCRIPCION', 0, 1, 'C');
        // Salto de línea
        $this->Ln(10);
    }

    // Pie de página
    function Footer()
    {
        // Posición a 1.5 cm del final
        $this->SetY(-15);
        // Fuente Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Generar QR para la asistencia a las actividades
    function GenerateQR($userId, $userName, $eventId, $activityId, $activityName)
    {
        $data = "userId: $userId, userName: $userName, eventId: $eventId, activityId: $activityId";

        // Ruta donde se guardarán los archivos de QR
        $qrPath = '../qrcodes/';

        // Nombre del archivo de QR
        $qrFilename = "qr_$activityId.png";

        // Generar el QR
        QRcode::png($data, $qrPath . $qrFilename, QR_ECLEVEL_L, 5);

        // Insertar el QR en el PDF
        $this->SetX($this->GetX() + 50); // Mover a la posición adecuada
        $this->Cell(0, 10, 'Actividad: ' . $activityName, 0, 1, 'C');
        $this->Image($qrPath . $qrFilename, $this->GetX() + 25, $this->GetY(), 30);
        $this->Ln(30); // Salto de línea después del código QR
    }
}

// Crear el objeto PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

// Agregar los datos del evento
$pdf->SetFont('Arial', 'I', 12);
$pdf->Cell(0, 10, $nombreEvento, 0, 1, 'C');
$pdf->Ln(10);

// Agregar los datos del usuario
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Nombre: ' . $nombreUsuario, 0, 1);
$pdf->Cell(0, 10, 'Email: ' . $emailUsuario, 0, 1);
$pdf->Cell(0, 10, 'Celular: ' . $celularUsuario, 0, 1);
$pdf->Ln(10);

// Agregar la tabla de datos del evento
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 10, 'Descripcion', 1, 0, 'C');
$pdf->Cell(40, 10, 'Fecha de inicio', 1, 0, 'C');
$pdf->Cell(40, 10, 'Fecha de fin', 1, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(60, 10, $evento_row['descripcion'], 1, 0);
$pdf->Cell(40, 10, $evento_row['fecha_inicio'], 1, 0);
$pdf->Cell(40, 10, $evento_row['fecha_fin'], 1, 1);

$pdf->Ln(10);

// Agregar la línea de "ACTIVIDADES DEL EVENTO"
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'ACTIVIDADES DEL EVENTO', 0, 1, 'C');
$pdf->Ln(10);

// Agregar la tabla de actividades
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, 'Nombre', 1, 0, 'C');
$pdf->Cell(40, 10, 'Tipo', 1, 0, 'C');
$pdf->Cell(40, 10, 'Duracion', 1, 0, 'C');
$pdf->Cell(50, 10, 'Fecha', 1, 1, 'C');

$pdf->SetFont('Arial', '', 12);
while ($actividad_row = $actividades_result->fetch_assoc()) {
    $pdf->Cell(50, 10, $actividad_row['nombre'], 1, 0);
    $pdf->Cell(40, 10, $actividad_row['tipo'], 1, 0);
    $pdf->Cell(40, 10, $actividad_row['duracion'], 1, 0);
    $pdf->Cell(50, 10, $actividad_row['fecha'], 1, 1);

    // Generar QR para cada actividad
    $pdf->GenerateQR($usuarioId, $nombreUsuario, $eventoId, $actividad_row['id'], $actividad_row['nombre']);
}

// Salida del PDF
$pdf->Output();
?>
