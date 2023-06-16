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

// Procesar la información del formulario y guardarla en la tabla "usuarios"
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT); // Encriptar la contraseña
$imagen = $_FILES['imagen']['name'];
$imagen_temp = $_FILES['imagen']['tmp_name'];

// Mover la imagen subida a la carpeta "img"
move_uploaded_file($imagen_temp, '../imgusuarios/'.$imagen);

$sql = "INSERT INTO usuario (nombre, apellido, telefono, email, contrasena, imagen,tipo_usuario,estado) VALUES ('$nombre', '$apellido', '$telefono', '$email', '$contrasena', '$imagen','control','activo')";

if ($conn->query($sql) === TRUE) {
	echo "<script>alert('Registro guardado exitosamente.')</script>";
   header("Location: Admi_CrudControl.php"); 
} else {
  echo "<script>alert('Error al guardar registro: " . $conn->error . "')</script>";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
