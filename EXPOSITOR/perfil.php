
<?php
// ... conexión a la base de datos y otras configuraciones
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
  // Obtener los datos del formulario
  $id = $_POST['id'];
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $telefono = $_POST['telefono'];
  $email = $_POST['email'];


  // Verificar si se ha subido una nueva imagen
  if (!empty($_FILES['imagen']['name'])) {
    $nombre_archivo = $_FILES['imagen']['name'];
    $tipo_archivo = $_FILES['imagen']['type'];
    $tamano_archivo = $_FILES['imagen']['size'];
    $temp_archivo = $_FILES['imagen']['tmp_name'];

    // Verificar que el archivo sea una imagen válida
    $permitidos = array("image/jpg", "image/jpeg", "image/png");
    if (in_array($tipo_archivo, $permitidos)) {
      // Mover el archivo a la carpeta de imágenes
      move_uploaded_file($temp_archivo, "../imgusuarios/$nombre_archivo");

      // Actualizar la imagen del usuario en la base de datos
      $sql_imagen = "UPDATE usuario SET imagen = '$nombre_archivo' WHERE id = $id";
      mysqli_query($conn, $sql_imagen);
    } else {
      echo "Solo se permiten archivos JPG, JPEG o PNG.";
    }
  }

  // Actualizar los demás campos del usuario en la base de datos
  $sql = "UPDATE usuario SET nombre = '$nombre', apellido = '$apellido', telefono = '$telefono', email = '$email' WHERE id = $id";
  if (mysqli_query($conn, $sql)) {
    // Si la actualización fue exitosa, redirigir a la página de usuarios
    header("Location: expositor.php");
    exit();
  } else {
    // Si hubo un error en la actualización, mostrar un mensaje de error
    echo "Error al actualizar el usuario: " . mysqli_error($conn);
  }
}

// ... cierre de la conexión y otros recursos
$conn->close();
?>
