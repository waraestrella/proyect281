<?php
session_start();

// Verificar si el usuario ha iniciado sesión como participante
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'participante') {
  header('Location: ../index.html');
  exit();
}
// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "base_chat";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

// Obtener los datos del usuario que ha iniciado sesión
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT * FROM usuario WHERE id = $usuario_id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
  $row = $result->fetch_assoc();
  $nombre = $row['nombre'];
  $apellido = $row['apellido'];
  $telefono = $row['telefono'];
  $email = $row['email'];
  $imagen = '../imgusuarios/' . $row['imagen']; // Ruta de la imagen de usuario en la carpeta 'imgusuarios'

  $tipo_usuario = $row['tipo_usuario'];
} else {
  die("Error al obtener los datos del usuario.");
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PAGINA PARTICIPANTE</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
  <!-- Estilos de Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Estilos de Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<!-- Scripts de Bootstrap (requiere jQuery) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Scripts de Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
<!-- Agrega el enlace al archivo CSS de Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 <!-- Agrega el enlace al archivo JS de Bootstrap -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<!--estilos para los botones de usuario-->
<style >
  .dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-menu {
  display: none;
  position: absolute;
  z-index: 1;
}

.dropdown:hover .dropdown-menu {
  display: block;
}

.dropdown-menu a {
  display: block;
  padding: 10px;
  text-decoration: none;
  color: #333;
}

.dropdown-menu a:hover {
  background-color: #eee;
}
.img-circle {
  display: inline-block;
  width: 80px;
  height: 80px;
  border-radius: 50%;
  object-fit: cover;
}


.card-group {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
  }

  .card {
    width: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    overflow: hidden;
    transition: transform 0.3s;
  }

  .card:hover {
    transform: scale(1.05);
  }

  .card-img-top {
    width: 100%;
    height: 150px;
    object-fit: cover;
  }

  .card-body {
    padding: 10px;
  }

  .card-title {
    font-size: 18px;
    margin-bottom: 5px;
  }

  .card-text {
    font-size: 14px;
    color: #666;
  }

  .list-group-item {
    font-size: 12px;
    padding: 5px;
  }

  .card-footer {
    padding: 10px;
    background-color: #f5f5f5;
  }

  .btn {
    display: block;
    width: 100%;
    margin-bottom: 5px;
  }

  .btn-ver-actividades {
    background-color: #28a745;
    color: #fff;
  }

  .btn-inscribirse {
    background-color: #007bff;
    color: #fff;
  }

  .btn-reservar {
    background-color: #dc3545;
    color: #fff;
  }


</style>


</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
    
      <!-- Messages Dropdown Menu -->
      
      <!-- Notifications Dropdown Menu -->
      
      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Sistema Eventos</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $imagen; ?>" class="img-circle " alt="User Image">
        </div>
        <div class="info">
        <a href="#" class="menu"><?php echo $nombre; ?> <i class="fa fa-caret-down"></i></a>

        <div class="opcionesMenu">
          <form action="../cerrar_sesion.php" method="post">
            <button type="submit"  class='btn btn-primary'>Cerrar Sesión</button>
          </form>
        </div>
      </div>

          
      </div>

      <!-- SidebarSearch Form -->
      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header">Modificar Perfil</li>

              <li class="nav-item">
                <a  class="nav-link" onclick="mostrarFormulario()">
                  <i class="far fa-circle nav-icon"></i>
                  <p>MI PERFIL</p>
                </a>
              </li>

          <li class="nav-header">MIS RESERVAS</li>
        
            
            
              <li class="nav-item">
                <a href="listado_de_reservas.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reservas</p>
                </a>
              </li>
              
          <li class="nav-header">MIS EVENTOS</li>  
         
          <li class="nav-item">
            <a href="listado_de_inscripciones.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Eventos Inscritos
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>
           <li class="nav-item">
              <a href="material_participante.php?usuarioId=<?php echo $usuario_id; ?>" class="nav-link">
                  <i class="nav-icon fas fa-th"></i>
                  <p>
                      Material
                      <span class="right badge badge-danger"></span>
                  </p>
              </a>
            </li>


          <li class="nav-header">CERTIFICADOS</li>  

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Mis Certificados
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>

          <li class="nav-header">EVENTOS</li>  

          <li class="nav-item">
            <a href="listado_de_eventos.php" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Lista de Eventos
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>
         
         
          
          

      
          
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Contenido de la pagina -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0" style="text-align: center;">SISTEMA DE GESTION DE EVENTOS</h1>
            <h1 class="m-0" style="text-align: center;">Bienvenido Participante</h1>
            <h1 class="m-0" style="text-align: center; font-family: cursive;"> Haga click en MI PERFIL para Modificar sus DATOS ACTUALES</h1>
          </div><!-- /.col -->
        
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- contenido debajo de sistema de gestion de eventos-->
    <section class="content">
  <div class="card-group">
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "base_chat";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
      die("Error de conexión: " . $conn->connect_error);
    }
    // Consultar los eventos de la base de datos
    $sql = "SELECT * FROM evento WHERE estado = 'activo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // Mostrar los eventos en forma de tarjetas
      while ($row = $result->fetch_assoc()) {
        echo '<div class="card card-sm card-hover">';
        echo '<img src="../imgeventos/' . $row["imagen"] . '" class="card-img-top" alt="Imagen del evento">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . $row["nombre"] . '</h5>';
        echo '<p class="card-text">' . $row["descripcion"] . '</p>';
        echo '<ul class="list-group list-group-flush">';
        echo '<li class="list-group-item"><strong>Fecha de Inicio:</strong> ' . $row["fecha_inicio"] . '</li>';
        echo '<li class="list-group-item"><strong>Fecha Fin:</strong> ' . $row["fecha_fin"] . '</li>';
        echo '<li class="list-group-item"><strong>Cupo Maximo:</strong> ' . $row["cupo_maximo"] . '</li>';
        echo '<li class="list-group-item"><strong>Estado:</strong> ' . $row["estado"] . '</li>';
        echo '</ul>';
        echo '</div>';
        echo '<div class="card-footer">';

        // Verificar si el usuario actual está inscrito en el evento actual
        $inscrito = false; // Variable para almacenar el estado de inscripción del usuario
        $inscripcion_query = "SELECT * FROM inscripcion WHERE usuario_id = '$usuario_id' AND evento_id = '" . $row["id"] . "'";
        $inscripcion_result = $conn->query($inscripcion_query);

        if ($inscripcion_result->num_rows > 0) {
          $inscrito = true;
        }

        if ($inscrito) {
          echo '<button type="button" class="btn btn-danger" disabled><i class="fa fa-check"></i> Inscrito</button>';
        } else {
          echo '<button type="button" class="btn btn-primary btn-inscribirse" data-toggle="modal" data-target="#inscribirseModal" data-id="' . $row["id"] . '"><i class="fa fa-edit"></i> Inscribirse</button>';
        }

        echo '<button type="button" class="btn btn-success btn-ver-actividades" data-id="' . $row["id"] . '"><i class="fa fa-search"></i> Ver Actividades</button>';

        // Verificar si el evento actual está reservado por el usuario
        $reservado = false; // Variable para almacenar el estado de reserva del usuario
        $reserva_query = "SELECT * FROM reserva WHERE usuario_id = '$usuario_id' AND evento_id = '" . $row["id"] . "'";
        $reserva_result = $conn->query($reserva_query);

        if ($reserva_result->num_rows > 0) {
          $reservado = true;
        }

        if ($reservado) {
          echo '<button type="button" class="btn btn-primary" disabled style="background-color: blue;"><i class="fa fa-file" style="color: white;"></i> Reservado</button>';
        } else {
          echo '<button type="button" class="btn btn-danger btn-reservar" style="background-color: orange;" data-toggle="modal" data-target="#reservarModal" data-id="' . $row["id"] . '"><i class="fa fa-file" style="color: white;"></i> Reservar</button>';
        }

        echo '</div>';
        echo '</div>';
      }
    } else {
      echo '<div class="card">';
      echo '<div class="card-body">';
      echo '<p class="card-text">No se encontraron eventos.</p>';
      echo '</div>';
      echo '</div>';
    }
    ?>
  </div>
</section>

<!-- Modal para la inscripción -->
<div class="modal fade" id="inscribirseModal" tabindex="-1" role="dialog" aria-labelledby="inscribirseModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="inscribirseModalLabel">Inscribirse al evento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>¿Estás seguro de que deseas inscribirte a este evento?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnConfirmarInscripcion">Inscribirse</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  // Manejar el click en el botón de inscribirse
  $(".btn-inscribirse").click(function() {
    var eventoId = $(this).data("id");
    $("#btnConfirmarInscripcion").data("evento-id", eventoId); // Almacenar el ID del evento en el botón de confirmación

    // Mostrar el modal de inscripción
    $("#inscribirseModal").modal("show");
  });

  // Manejar el click en el botón de confirmar inscripción
  $("#btnConfirmarInscripcion").click(function() {
    var eventoId = $(this).data("evento-id");

    // Realizar la petición AJAX para guardar la inscripción
    $.ajax({
      url: "guardar_inscripcion.php",
      type: "POST",
      data: { usuarioId: <?php echo $usuario_id; ?>, eventoId: eventoId },
      success: function(response) {
        if (response === "success") {
          // Si el registro se guarda exitosamente, cambiar el botón a "Inscrito"
          $(".btn-inscribirse[data-id='" + eventoId + "']").removeClass("btn-primary").addClass("btn-danger").prop("disabled", true).html("<i class='fa fa-check'></i> Inscrito");
        } else {
          // Mostrar el mensaje de error si no se guarda el registro
          alert("Error al guardar el registro de inscripción: " + response);
        }
      },
      error: function(xhr, status, error) {
        // Mostrar el mensaje de error si ocurre un error en la petición AJAX
        alert("Error en la petición AJAX: " + error);
      }
    });

    // Cerrar el modal de inscripción
    $("#inscribirseModal").modal("hide");
  });

  // Manejar el click en el botón de reservar
  $(".btn-reservar").click(function() {
    var eventoId = $(this).data("id");

    // Realizar la petición AJAX para guardar la reserva
    $.ajax({
      url: "guardar_reserva.php",
      type: "POST",
      data: { usuarioId: <?php echo $usuario_id; ?>, eventoId: eventoId },
      success: function(response) {
        if (response === "success") {
          // Si el registro se guarda exitosamente, cambiar el botón a "Reservado"
          $(".btn-reservar[data-id='" + eventoId + "']").removeClass("btn-danger").addClass("btn-primary").css("background-color", "blue").prop("disabled", true).html("<i class='fa fa-file' style='color: white;'></i> Reservado");
        } else {
          // Mostrar el mensaje de error si no se guarda el registro
          alert("Error al guardar el registro de reserva: " + response);
        }
      },
      error: function(xhr, status, error) {
        // Mostrar el mensaje de error si ocurre un error en la petición AJAX
        alert("Error en la petición AJAX: " + error);
      }
    });
  });
});
</script>


    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; Sistema de Gestion de Eventos </strong>
    Todos los Derechos Reservados.
    <div class="float-right d-none d-sm-inline-block">
      <b>Materia</b> 281
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- scrip para el boton inscribirse -->


<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../dist/js/pages/dashboard.js"></script>


<!--scrip para elo menu del usuario(editar y cerrar sesion)-->
<script>
function desplegarMenu() {
  document.getElementById("opcionesMenu").classList.toggle("show");
}

// Cerrar el menú si el usuario hace clic en cualquier parte de la página
window.onclick = function(event) {
  if (!event.target.matches('.menu')) {
    var opciones = document.getElementsByClassName("opcionesMenu");
    for (var i = 0; i < opciones.length; i++) {
      var opcion = opciones[i];
      if (opcion.classList.contains('show')) {
        opcion.classList.remove('show');
      }
    }
  }
}
</script>

<!--para el menu de editar y cerrar sesiomn-->
<script>
    document.addEventListener('DOMContentLoaded', function() {
      var menu = document.querySelector('.menu');
      var opcionesMenu = document.querySelector('.opcionesMenu');
      
      menu.addEventListener('click', function(e) {
        e.preventDefault();
        opcionesMenu.style.display = opcionesMenu.style.display === 'block' ? 'none' : 'block';
      });
    });
  </script>
<!--editar perfil-->
  <script>
    function mostrarFormulario() {
      document.getElementById("perfil").style.display = "block";
    }
  </script>
<!--mostrar las actividades-->
<script >
  function mostrarActividades(eventoId) {
  // Realiza una petición AJAX o consulta a la base de datos para obtener las actividades que coinciden con el eventoId

  // Supongamos que obtienes las actividades en forma de arreglo llamado "actividades"
  const actividades = obtenerActividadesPorEvento(eventoId);

  // Obtiene el elemento contenedor donde se mostrarán las cards de actividades
  const contenedorActividades = document.getElementById("contenedor-actividades");

  // Limpia el contenedor antes de mostrar las nuevas cards
  contenedorActividades.innerHTML = "";

  // Recorre las actividades y crea una card para cada una
  actividades.forEach((actividad) => {
    const card = document.createElement("div");
    card.classList.add("card");

    const imagen = document.createElement("img");
    imagen.src = actividad.imagen;
    imagen.classList.add("card-img-top");

    const cardBody = document.createElement("div");
    cardBody.classList.add("card-body");

    const titulo = document.createElement("h5");
    titulo.classList.add("card-title");
    titulo.textContent = actividad.nombre;

    const tipo = document.createElement("p");
    tipo.classList.add("card-text");
    tipo.textContent = actividad.tipo;

    const descripcion = document.createElement("p");
    descripcion.classList.add("card-text");
    descripcion.textContent = actividad.descripcion;

    // Crea los demás elementos de la card con la información deseada

    // Agrega los elementos al card
    cardBody.appendChild(titulo);
    cardBody.appendChild(tipo);
    cardBody.appendChild(descripcion);

    // Agrega los elementos al contenedor
    card.appendChild(imagen);
    card.appendChild(cardBody);
    contenedorActividades.appendChild(card);
  });
}

function obtenerActividadesPorEvento($eventoId) {
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "base_chat";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
  }

  // Consulta las actividades por ID de evento
  $sql = "SELECT * FROM actividad WHERE id_evento = $eventoId";
  $result = $conn->query($sql);

  $actividades = array();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      // Crea un arreglo con la información de cada actividad
      $actividad = array(
        "nombre" => $row["nombre"],
        "tipo" => $row["tipo"],
        "imagen" => $row["imagen"],
        "descripcion" => $row["descripcion"],
        "duracion" => $row["duracion"],
        "fecha" => $row["fecha"],
        "hora" => $row["hora"],
        "nomExpo" => $row["nomExpo"],
        "nomAmbiente" => $row["nomAmbiente"]
      );

      // Agrega la actividad al arreglo de actividades
      $actividades[] = $actividad;
    }
  }

  // Cierra la conexión a la base de datos
  $conn->close();

  // Retorna el arreglo de actividades
  return $actividades;
}


</script>
<!--sccrip para las actividades-->
<script>
  $(document).ready(function() {
  // Capturar el evento clic del botón "Ver Actividades"
  $(document).on('click', '.btn-ver-actividades', function() {
    // Obtener el ID del evento desde el atributo data-id del botón
    var eventoID = $(this).data('id');
    
    // Realizar alguna acción con el ID del evento (por ejemplo, redirigir a una página de actividades)
    // Aquí puedes modificar este código según tus necesidades
    window.location.href = 'actividadespart.php?id=' + eventoID;
  });
});

</script>

</body>
</html>
