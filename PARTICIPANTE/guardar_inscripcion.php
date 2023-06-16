<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_chat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Obtener los datos enviados a través de la petición AJAX
  $usuarioId = $_POST["usuarioId"];
  $eventoId = $_POST["eventoId"];

  // Función para guardar el registro de inscripción
  function guardar_inscripcion($usuario_id, $evento_id) {
    global $conn;

    $inscripcion_query = "INSERT INTO inscripcion (usuario_id, evento_id) VALUES ('$usuario_id', '$evento_id')";
    if ($conn->query($inscripcion_query) === TRUE) {
      // Registro de inscripción guardado exitosamente
      return "success";
    } else {
      // Error al guardar el registro de inscripción
      return $conn->error;
    }
  }

  // Guardar el registro de inscripción
  $resultado = guardar_inscripcion($usuarioId, $eventoId);

  echo $resultado;
}
?>
