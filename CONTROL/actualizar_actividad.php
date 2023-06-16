<?php
// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Obtener los datos enviados
  $id_actividad = $_POST["id_actividad"];
  $nombre = $_POST["nombre"];
  $tipo = $_POST["tipo"];
  $descripcion = $_POST["descripcion"];
  $fecha = $_POST["fecha"];
  $hora = $_POST["hora"];
  $duracion = $_POST["duracion"];
  $expositor = $_POST["expositor"];
  $ambiente = $_POST["ambiente"];

  // Obtener el nombre del expositor seleccionado
function obtenerNombreExpositor($id) {
  $conexion = new mysqli("localhost", "root", "", "base_chat");
  $query = "SELECT nombre FROM usuario WHERE id = $id";
  $resultado = $conexion->query($query);
  $nombreExpositor = $resultado->fetch_assoc()['nombre'];
  $conexion->close();
  return $nombreExpositor;
}

$nomExpo = obtenerNombreExpositor($expositor_id);

// Obtener el nombre del ambiente seleccionado
function obtenerNombreAmbiente($id) {
  $conexion = new mysqli("localhost", "root", "", "base_chat");
  $query = "SELECT nombre FROM ambiente WHERE id = $id";
  $resultado = $conexion->query($query);
  $nombreAmbiente = $resultado->fetch_assoc()['nombre'];
  $conexion->close();
  return $nombreAmbiente;
}

$nomAmbiente = obtenerNombreAmbiente($ambiente_id);

  // Validar los datos recibidos (agrega tus propias validaciones según tus requerimientos)
  if (empty($nombre) || empty($tipo) || empty($descripcion) || empty($fecha) || empty($hora) || empty($duracion) || empty($expositor) || empty($ambiente)) {
    // Algunos campos están vacíos, mostrar mensaje de error
    echo "Por favor, completa todos los campos.";
    exit; // Detener la ejecución del script
  }

  // Realizar las operaciones de actualización en la base de datos (agrega tu lógica según tus requerimientos)

  // Conexión a la base de datos (modifica los valores de acuerdo a tu configuración)
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "base_chat";

  $conn = new mysqli($servername, $username, $password, $database);

  // Verificar la conexión
  if ($conn->connect_error) {
    die("Error al conectar a la base de datos: " . $conn->connect_error);
  }

  // Actualizar la actividad en la base de datos
  $sql = "UPDATE actividad SET nombre = '$nombre', tipo = '$tipo', descripcion = '$descripcion', fecha = '$fecha', hora = '$hora', duracion = '$duracion', nomExpo = '$nomExpo', nomAmbiente = '$nomAmbiente' WHERE id = '$id_actividad'";

  if ($conn->query($sql) === TRUE) {
    // La actividad se ha actualizado correctamente
    echo "La actividad se ha actualizado correctamente.";
    echo '<script>window.location.href = "actividades.php";</script>';
  } else {
    // Error al actualizar la actividad
    echo "Error al actualizar la actividad: " . $conn->error;
  }

  // Cerrar la conexión a la base de datos
  $conn->close();
} else {
  // Si no se reciben los datos por POST, redirigir al formulario
  header("Location: formulario_actividad.php");
  exit; // Detener la ejecución del script
}
?>
