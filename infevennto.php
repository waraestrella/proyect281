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
        margin-bottom: 10px;
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
</style>
</head>
<body>
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
        <div class="wave" style="height: 150px; overflow: hidden;">
            <svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;">
                <path d="M0.00,49.98 C150.00,150.00 349.20,-50.00 500.00,49.98 L500.00,150.00 L0.00,150.00 Z"
                    style="stroke: none; fill: #b6fbff;"></path>
            </svg>
        </div>
    </header>
    <main>
    <div class="card-container">
        <?php
        // Obtener el ID del evento de la consulta GET
        $idEvento = $_GET['id'];

        // Conexión a la base de datos MySQL
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "base_chat";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Consulta para obtener los detalles del evento
        $queryEvento = "SELECT * FROM EVENTO WHERE id = 1";
        $resultEvento = $conn->query($queryEvento);

        // Verificar si se encontró el evento
        if ($resultEvento->num_rows > 0) {
            $rowEvento = $resultEvento->fetch_assoc();
            $nombreEvento = $rowEvento['nombre'];
            $fechaInicio = $rowEvento['fecha_inicio'];
            $fechaFin = $rowEvento['fecha_fin'];
            $descripcionEvento = $rowEvento['descripcion'];
            $cupoMaximo = $rowEvento['cupo_maximo'];
            $imagenEvento = $rowEvento['imagen'];

            // Mostrar los detalles del evento
            echo "<div class='card'>";
            echo "<img src='imgeventos/$imagenEvento'>";
            echo "<h3>$nombreEvento</h3>";
            echo "<p>Fecha de inicio: $fechaInicio</p>";
            echo "<p>Fecha de fin: $fechaFin</p>";
            echo "<p>$descripcionEvento</p>";
            echo "<p>Cupo máximo: $cupoMaximo</p>";
            echo "</div>";
        } else {
            echo "<p>No se encontró el evento.</p>";
        }

        // Consulta para obtener las actividades relacionadas con el evento
        $queryActividades = "SELECT a.nombre, a.tipo, a.imagen, a.descripcion, a.duracion
                             FROM ACTIVIDAD a
                             INNER JOIN EVENTO_ACTIVIDAD ea ON a.id = ea.id_actividad
                             WHERE ea.id_evento = 1";
        $resultActividades = $conn->query($queryActividades);

        // Verificar si hay actividades relacionadas
        if ($resultActividades->num_rows > 0) {
            echo "<h4 style='text-align: center;'>Actividades relacionadas:</h4>";
            echo "<div style='display: flex; justify-content: center;'>";
            
            // Recorremos los resultados y mostramos cada actividad en una tarjeta
            while ($rowActividad = $resultActividades->fetch_assoc()) {
                $nombreActividad = $rowActividad['nombre'];
                $tipoActividad = $rowActividad['tipo'];
                $imagenActividad = $rowActividad['imagen'];
                $descripcionActividad = $rowActividad['descripcion'];
                $duracionActividad = $rowActividad['duracion'];

                echo "<div class='card'>";
                echo "<img src='imgactividad/$imagenActividad'>";
                echo "<h3>$nombreActividad</h3>";
                echo "<p>Tipo: $tipoActividad</p>";
                echo "<p>$descripcionActividad</p>";
                echo "<p>Duración: $duracionActividad</p>";
                echo "</div>";
            }

            echo "</div>";
        } else {
            echo "<p>No se encontraron actividades relacionadas.</p>";
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
</body>
</html>
