
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_chat";

// Establecer conexión con la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$aforo_maximo = $_POST['aforo_maximo'];
$tipo = $_POST['tipo'];
$ubicacion = $_POST['ubicacion'];
$imagen = $_FILES['imagen']['name'];
$imagen_temp = $_FILES['imagen']['tmp_name'];
$num_sillas = $_POST['num_sillas'];
$num_mesas = $_POST['num_mesas'];
$num_datas = $_POST['num_datas'];
$num_pizarras = $_POST['num_pizarras'];
$obj_adicionales = $_POST['obj_adicionales'];

// Mover la imagen cargada a la carpeta de destino
move_uploaded_file($imagen_temp, '../imgambientes/'.$imagen);

// Insertar datos en la tabla "Infraestructura"
$sql_infraestructura = "INSERT INTO infraestructurafisica (num_sillas, num_mesas, num_datas, num_pizarras, obj_adicionales) 
                        VALUES ('$num_sillas', '$num_mesas', '$num_datas', '$num_pizarras', '$obj_adicionales')";

if ($conn->query($sql_infraestructura) === TRUE) {
    // Obtener el ID de la última inserción en la tabla "Infraestructura"
    $id_infraestructura = $conn->insert_id;
    
    // Insertar datos en la tabla "Ambiente"
    $sql_ambiente = "INSERT INTO ambiente (nombre, aforo_maximo, tipo, ubicacion,estado, imagen, id_infraestructura_fisica) 
                     VALUES ('$nombre', '$aforo_maximo', '$tipo', '$ubicacion','disponible', '$imagen', '$id_infraestructura')";
    
    if ($conn->query($sql_ambiente) === TRUE) {
    	header("Location: Admi_CrudAmbientes.php");
        echo "Registro exitoso";
    } else {
        echo "Error al registrar el ambiente: " . $conn->error;
    }
} else {
    echo "Error al registrar la infraestructura: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
