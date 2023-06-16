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

  // Usar sentencias preparadas para evitar inyecciones SQL
  $stmt = $conn->prepare("DELETE FROM actividad WHERE id = ?");
  $stmt->bind_param("i", $id);

  if ($stmt->execute()) {
    // Si la eliminación fue exitosa, redirigir a la página de usuarios
    header("Location: Admi_CrudEventos.php");
    exit();
  } else {
    // Si hubo un error en la eliminación, mostrar un mensaje de error
    echo "Error al eliminar la actividad: " . mysqli_error($conn);
  }

  $stmt->close();
}

// ... cierre de la conexión y otros recursos
$conn->close();
?>
