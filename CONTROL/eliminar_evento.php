<?php
// ... conexión a la base de datos y otras configuraciones
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_chat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];

  // Eliminar las actividades relacionadas al evento
  $stmt_actividades = $conn->prepare("DELETE FROM actividad WHERE id_evento = ?");
  $stmt_actividades->bind_param("i", $id);
  $stmt_actividades->execute();
  $stmt_actividades->close();

  // Eliminar el evento
  $stmt_evento = $conn->prepare("DELETE FROM evento WHERE id = ?");
  $stmt_evento->bind_param("i", $id);

  if ($stmt_evento->execute()) {
    // Si la eliminación fue exitosa, redirigir a la página de eventos
    header("Location: Admi_CrudEventos.php");
    exit();
  } else {
    // Si hubo un error en la eliminación, mostrar un mensaje de error
    echo "Error al eliminar el evento: " . mysqli_error($conn);
  }

  $stmt_evento->close();
}

// ... cierre de la conexión y otros recursos
$conn->close();
?>
