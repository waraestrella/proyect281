<!DOCTYPE html>
<html>
<head>
    <style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card {
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .card h3 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .card p {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .card button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin-top: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <?php
        // Conexión a la base de datos MySQL
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
        // Consulta para obtener los datos de la tabla "EVENTO"
        $query = "SELECT * FROM EVENTO";
        $result = $conn->query($query);

        // Recorremos los resultados y mostramos cada evento en una tarjeta
        while ($row = $result->fetch_assoc()) {
            $nombre = $row['nombre'];
            $fechaInicio = $row['fecha_inicio'];
            $fechaFin = $row['fecha_fin'];
            $descripcion = $row['descripcion'];
            $cupoMaximo = $row['cupo_maximo'];
            $imagen = $row['imagen'];
            $numActividades = $row['numActividades'];

            echo "<div class='card'>";
            echo "<img src='imgeventos/$imagen'>";
            echo "<h3>$nombre</h3>";
            echo "<p>Fecha de inicio: $fechaInicio</p>";
            echo "<p>Fecha de fin: $fechaFin</p>";
            echo "<p>$descripcion</p>";
            echo "<p>Cupo máximo: $cupoMaximo</p>";
            echo "<p>Número de actividades: $numActividades</p>";
            echo "<button onclick='mostrarInformacion(\"$nombre\")'>Más Información</button>";
            echo "</div>";
        }

        // Cerramos la conexión a la base de datos
        $conn->close();
        ?>
    </div>

    <script>
        function mostrarInformacion(nombreEvento) {
            // Aquí puedes implementar la lógica para mostrar más información del evento seleccionado
            // Puedes utilizar JavaScript o enviar una solicitud AJAX al servidor
            // En este ejemplo, simplemente mostraremos una alerta con el nombre del evento
            alert("Más información de " + nombreEvento);
        }
    </script>
</body>
</html>
