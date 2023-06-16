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

    // Primero eliminar los registros de la tabla ambiente que dependen de infraestructurafisica
    $stmt = $conn->prepare("DELETE FROM ambiente WHERE id_infraestructura_fisica = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt->close();

        // Luego borrar el registro de la tabla infraestructurafisica
        $stmt = $conn->prepare("DELETE FROM infraestructurafisica WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $stmt->close();

            // Si la eliminación fue exitosa, redirigir a la página de usuarios
            header("Location: Admi_CrudAmbientes.php");
            exit();
        } else {
            // Si hubo un error en la eliminación, mostrar un mensaje de error
            echo "Error al eliminar la infraestructura física: " . mysqli_error($conn);
        }
    } else {
        // Si hubo un error en la eliminación de los registros de ambiente, mostrar un mensaje de error
        echo "Error al eliminar los registros de ambiente: " . mysqli_error($conn);
    }
}

// ... cierre de la conexión y otros recursos
$conn->close();
?>
