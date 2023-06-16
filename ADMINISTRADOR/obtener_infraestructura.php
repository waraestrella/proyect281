<?php
// Obtener el ID de la infraestructura física desde la solicitud GET
$idInfraestructura = $_GET['id_infraestructura'];

// Realizar las consultas necesarias para obtener los detalles de la infraestructura física en base al ID proporcionado

// Ejemplo de consulta
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_chat";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

// Consultar los detalles de la infraestructura física
$sql = "SELECT * FROM infraestructurafisica WHERE id = $idInfraestructura";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Mostrar los detalles de la infraestructura física
  $row = $result->fetch_assoc();

  echo "<h3>Detalles de la Infraestructura Física</h3>";
  echo "<p><strong>Numero de Sillas:</strong> <span id='numSillas'>" . $row['num_sillas'] . "</span> <button type='button' onclick='editField(\"numSillas\")'>Editar</button></p>";
  echo "<p><strong>Numero de Mesas:</strong> <span id='numMesas'>" . $row['num_mesas'] . "</span> <button type='button' onclick='editField(\"numMesas\")'>Editar</button></p>";
  echo "<p><strong>Numero de Datas:</strong> <span id='numDatas'>" . $row['num_datas'] . "</span> <button type='button' onclick='editField(\"numDatas\")'>Editar</button></p>";
  echo "<p><strong>Numero de Pizarras:</strong> <span id='numPizarras'>" . $row['num_pizarras'] . "</span> <button type='button' onclick='editField(\"numPizarras\")'>Editar</button></p>";
  echo "<p><strong>Objetos Adicionales:</strong> <span id='objAdicionales'>" . $row['obj_adicionales'] . "</span> <button type='button' onclick='editField(\"objAdicionales\")'>Editar</button></p>";

  echo "<button type='button' onclick='saveChanges($idInfraestructura)'>Guardar Cambios</button>";
} else {
  echo "No se encontró la infraestructura física.";
}

$conn->close();
?>

<script>
  function editField(fieldId) {
    var fieldElement = document.getElementById(fieldId);
    var fieldValue = fieldElement.innerText;
    var inputElement = document.createElement("input");
    inputElement.type = "text";
    inputElement.value = fieldValue;
    fieldElement.innerHTML = "";
    fieldElement.appendChild(inputElement);
  }

  function saveChanges(idInfraestructura) {
    var numSillas = document.getElementById("numSillas").querySelector("input").value;
    var numMesas = document.getElementById("numMesas").querySelector("input").value;
    var numDatas = document.getElementById("numDatas").querySelector("input").value;
    var numPizarras = document.getElementById("numPizarras").querySelector("input").value;
    var objAdicionales = document.getElementById("objAdicionales").querySelector("input").value;

    // Realizar la solicitud AJAX para guardar los cambios en la base de datos
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        // Mostrar mensaje de éxito o error según corresponda
        var response = this.responseText;
        if (response === "success") {
          alert("Cambios guardados exitosamente");
          location.reload(); // Recargar la página para mostrar los nuevos valores actualizados
        } else {
          alert("Error al guardar los cambios");
        }
      }
    };
    xhttp.open("POST", "guardar_cambios_infraestructura.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id_infraestructura=" + idInfraestructura + "&num_sillas=" + numSillas + "&num_mesas=" + numMesas + "&num_datas=" + numDatas + "&num_pizarras=" + numPizarras + "&obj_adicionales=" + objAdicionales);
  }
</script>