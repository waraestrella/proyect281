<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Mi página principal</title>
	<link rel="stylesheet" href="estilos.css">
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
<body >
	<header>
        <nav>
            <a href="index.html">Volver</a>           
            <a href="#">Iniciar Sesion</a>
            <a href="#">Registrarse</a>
        </nav>
        <section class="textos-header">
            <h1>SGes-Eventos: </h1>

            <h2>TE OFRECEMOS LOS MEJORES EVENTOS AL ALCANCE DE TUS MANOS </h2>
        </section>
        <div class="wave" style="height: 150px; overflow: hidden;"><svg viewBox="0 0 500 150" preserveAspectRatio="none"
                style="height: 100%; width: 100%;">
                <path d="M0.00,49.98 C150.00,150.00 349.20,-50.00 500.00,49.98 L500.00,150.00 L0.00,150.00 Z"
                    style="stroke: none; fill: #b6fbff;"></path>
            </svg></div>
    </header>
	
	<main>

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
            $idEvento=$row['id'];
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
             echo "<button onclick='redireccionar(\"infevennto.php?id=$idEvento\")'>Más Información</button>";
            echo "</div>";
        }

        // Cerramos la conexión a la base de datos
        $conn->close();
        ?>
    </div>
		
	</main>
	<footer>
        <div class="contenedor-footer">
            <div class="content-foo">
                <h4>Phone</h4>
                <p>7777777</p>
            </div>
            <div class="content-foo">
                <h4>Email</h4>
                <p>sges_eventos@gmail.com</p>
            </div>
            <div class="content-foo">
                <h4>Location</h4>
                <p>La Paz, Bolivia</p>
            </div>
        </div>
        <h2 class="titulo-final">&copy; SGes-Eventos</h2>
    </footer>

<script>
    function redireccionar(idEvento) {
        window.location.href = `infoevento.php?id=${idEvento}`;
    }
</script>

</body>
</html>

