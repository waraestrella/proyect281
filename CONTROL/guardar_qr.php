<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_chat";

// Obtener los datos del código QR enviado por AJAX
$qr_code = $_POST['qr_code'];

// Obtener la fecha y hora actual
$fecha_registro = date("Y-m-d");
$hora_registro = date("H:i:s");

// Realizar la conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Error al conectar a la base de datos: " . $conn->connect_error);
}

// Consulta para obtener los datos del usuario y la actividad relacionada con el código QR
$query = "SELECT u.usuario_id, u.nombre_apellido AS nombre_apellido_usuario, a.evento_id, a.actividad_id, a.nombre_actividad
          FROM usuarios u
          INNER JOIN actividades a ON u.usuario_id = a.usuario_id
          WHERE u.qr_code = '$qr_code'";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    // Obtener los datos del resultado de la consulta
    $row = $result->fetch_assoc();
    $usuario_id = $row['usuario_id'];
    $nombre_apellido_usuario = $row['nombre_apellido_usuario'];
    $evento_id = $row['evento_id'];
    $actividad_id = $row['actividad_id'];
    $nombre_actividad = $row['nombre_actividad'];

    // Insertar los datos en la tabla 'asistencia'
    $insertQuery = "INSERT INTO asistencia (usuario_id, nombre_apellido_usuario, evento_id, actividad_id, nombre_actividad, fecha_registro, hora_registro)
                    VALUES ('$usuario_id', '$nombre_apellido_usuario', '$evento_id', '$actividad_id', '$nombre_actividad', '$fecha_registro', '$hora_registro')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "Datos guardados en MySQL.";
    } else {
        echo "Error al guardar los datos: " . $conn->error;
    }
} else {
    echo "Código QR no válido.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
