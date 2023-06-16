<?php
// Configurar la conexión a la base de datos MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_chat";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

// Procesar la información del formulario y guardarla en la tabla "eventos"
$nombre = $_POST['nombre'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$descripcion = $_POST['descripcion'];
$cupo_maximo = $_POST['cupo_maximo'];
$numActividades = $_POST['numActividades']; 
$imagen = $_FILES['imagen']['name'];
$imagen_temp = $_FILES['imagen']['tmp_name'];

// Mover la imagen subida a la carpeta "img"
move_uploaded_file($imagen_temp, '../imgeventos/'.$imagen);

$sql = "INSERT INTO evento (nombre, fecha_inicio, fecha_fin, descripcion, cupo_maximo, imagen, numActividades, estado) VALUES ('$nombre', '$fecha_inicio', '$fecha_fin', '$descripcion', '$cupo_maximo', '$imagen','$numActividades','activo')";

if ($conn->query($sql) === TRUE) {
	echo "<script>alert('Registro guardado exitosamente.')</script>";
   header("Location: Admi_CrudEventos.php"); // Redireccionar después de 3 segundos
} else {
  echo "<script>alert('Error al guardar registro: " . $conn->error . "')</script>";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
