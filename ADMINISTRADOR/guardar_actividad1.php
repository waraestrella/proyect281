<?php
// Obtener los datos enviados por el formulario
$nombre = $_POST['nombre'];
$tipo = $_POST['tipo'];

$descripcion = $_POST['descripcion'];
$duracion = $_POST['duracion'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$id_evento = $_POST['id_evento'];
$expositor_id = $_POST['expositor'];
$ambiente_id = $_POST['ambiente'];

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

// Procesar la imagen
// Código para mover la imagen a una carpeta en el servidor y guardar la ruta en la base de datos
$imagen = $_FILES["imagen"]["name"];
$imagen_temporal = $_FILES["imagen"]["tmp_name"];
$ruta_imagen = "../imgactividad/" . $imagen;
move_uploaded_file($imagen_temporal, $ruta_imagen);
// Aquí debes adaptar el código para tu caso específico

// Guardar los datos de la actividad en la tabla "actividades"
$conexion = new mysqli("localhost", "root", "", "base_chat");
$query = "INSERT INTO actividad (nombre, tipo, imagen, descripcion, duracion, fecha, hora, id_evento, expositor_id, ambiente_id, nomExpo, nomAmbiente) VALUES ('$nombre', '$tipo', '$imagen', '$descripcion', '$duracion', '$fecha', '$hora', '$id_evento', '$expositor_id', '$ambiente_id', '$nomExpo', '$nomAmbiente')";
$conexion->query($query);
$conexion->close();

// Redireccionar al formulario de actividades o a otra página de tu elección
header("Location: Admi_CrudEventos.php");
exit();
?>
