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
            <a href="material_participante.php" class="nav-link">
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
        <?php
// Obtener el usuario actual (puedes obtenerlo de la sesión o de otra manera)
$usuario_id = $_GET['usuarioId'];

// Consulta SQL para obtener los eventos a los que el usuario se ha inscrito junto con sus actividades
$sql = "SELECT evento.id AS evento_id, evento.nombre AS evento_nombre, actividad.id AS actividad_id, actividad.nombre AS actividad_nombre
        FROM inscripcion
        INNER JOIN evento ON inscripcion.evento_id = evento.id
        INNER JOIN actividad ON actividad.id_evento = evento.id
        WHERE inscripcion.usuario_id = $usuario_id";

// Ejecutar la consulta y obtener los resultados de la base de datos
// Aquí debes utilizar tu método preferido para conectarte a la base de datos y ejecutar la consulta SQL

// Ejemplo de conexión y ejecución de consulta utilizando PDO
$dsn = 'mysql:host=localhost;dbname=base_chat';
$username = 'root';
$password = '';

try {
    $db = new PDO($dsn, $username, $password);
    $stmt = $db->query($sql);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}
?>

<div class="container">
        <h1>Materiales del Participante</h1>

        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Evento</th>
                    <th scope="col">Actividad</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row) : ?>
                    <tr>
                        <td><?php echo $row['evento_nombre']; ?></td>
                        <td><?php echo $row['actividad_nombre']; ?></td>
                        <td><a href="material_act.php?actividadId=<?php echo $row['actividad_id']; ?>" class="btn btn-primary">Ver material</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </section>
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
<!-- ./wrapper -->

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

</body>
</html>
