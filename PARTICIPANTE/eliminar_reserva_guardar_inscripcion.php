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
  $reservaId = $_POST["reservaId"];
  $usuarioId = $_POST["usuarioId"];

  // Obtener el evento_id correspondiente a la reserva
  $obtener_evento_id_query = "SELECT evento_id FROM reserva WHERE id = '$reservaId'";

  $resultado = $conn->query($obtener_evento_id_query);

  if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $eventoId = $fila["evento_id"];

    // Eliminar la reserva
    $eliminar_reserva_query = "DELETE FROM reserva WHERE id = '$reservaId' AND usuario_id = '$usuarioId'";

    if ($conn->query($eliminar_reserva_query) === TRUE) {
      // Guardar la inscripción
      $guardar_inscripcion_query = "INSERT INTO inscripcion (usuario_id, evento_id) VALUES ('$usuarioId', '$eventoId')";

      if ($conn->query($guardar_inscripcion_query) === TRUE) {
        echo "success";
      } else {
        echo "Error al guardar la inscripción: " . $conn->error;
      }
    } else {
      echo "Error al eliminar la reserva: " . $conn->error;
    }
  } else {
    echo "No se encontró el evento correspondiente a la reserva.";
  }
}

$conn->close();
?>
