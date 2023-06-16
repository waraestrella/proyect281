<?php 
ob_start(); // inicia buffer de salida

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_chat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuario WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
  $row = $result->fetch_assoc();
  if (password_verify($password, $row['contrasena'])) {
    // Iniciar sesión
    session_start();
    $_SESSION['usuario_id'] = $row['id'];
    $_SESSION['usuario_tipo'] = $row['tipo_usuario'];
    // Redireccionar a la página correspondiente
    if ($row['tipo_usuario'] == 'administrador') {
      header('Location: ADMINISTRADOR/admi.php');
      exit();
    } elseif ($row['tipo_usuario'] == 'control') {
      header('Location: CONTROL/control.php');
      exit();
    } elseif ($row['tipo_usuario'] == 'participante') {
      header('Location: PARTICIPANTE/participante.php');
      exit();
    } elseif ($row['tipo_usuario'] == 'expositor') {
      header('Location: EXPOSITOR/expositor.php');
      exit();
    }
  } else {
    $mensaje = "Contraseña incorrecta.";
  }
} else {
  $mensaje = "El usuario no existe.";
}

$conn->close();

ob_end_flush(); // envía buffer de salida al navegador
?>
