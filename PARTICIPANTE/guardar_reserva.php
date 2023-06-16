<?php
// Obtener los datos del formulario de reserva
$usuarioId = $_POST['usuarioId'];
$eventoId = $_POST['eventoId'];

// Realizar la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_chat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Insertar el registro de reserva en la tabla correspondiente
$sql = "INSERT INTO reserva (usuario_id, evento_id) VALUES ('$usuarioId', '$eventoId')";

if ($conn->query($sql) === TRUE) {
    // El registro se guardó correctamente
    echo "success";
} else {
    // Ocurrió un error al guardar el registro
    echo "Error al guardar el registro de reserva: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
