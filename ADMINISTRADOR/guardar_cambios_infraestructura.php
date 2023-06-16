<?php
// Obtener los datos enviados por la solicitud POST
$idInfraestructura = $_POST['id_infraestructura'];
$numSillas = $_POST['num_sillas'];
$numMesas = $_POST['num_mesas'];
$numDatas = $_POST['num_datas'];
$numPizarras = $_POST['num_pizarras'];
$objAdicionales = $_POST['obj_adicionales'];

// Realizar las consultas necesarias para guardar los cambios en la base de datos

// Ejemplo de consulta
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_chat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

// Actualizar los valores en la tabla de infraestructura física
$sql = "UPDATE 	infraestructurafisica SET num_sillas = '$numSillas', num_mesas = '$numMesas', num_datas = '$numDatas', num_pizarras = '$numPizarras', obj_adicionales = '$objAdicionales' WHERE id = $idInfraestructura";

if ($conn->query($sql) === TRUE) {
  echo "success";
} else {
  echo "error";
}

$conn->close();
?>
