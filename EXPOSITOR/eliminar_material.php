<?php
// Verificar si se ha enviado el ID del material como parámetro
if (isset($_POST['material_id'])) {
    $materialId = $_POST['material_id'];

    // Realizar las acciones necesarias para eliminar el material de la base de datos

    // Establecer la conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "base_chat";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Realizar la eliminación del material
    $sql = "DELETE FROM material WHERE id = $materialId";
    if ($conn->query($sql) === true) {
        echo "Material eliminado con éxito.";
    } else {
        echo "Error al eliminar el material: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    // Si no se ha proporcionado el ID del material, mostrar un mensaje de error o redirigir a la página anterior
    echo "Error: No se ha proporcionado el ID del material.";
}
?>
