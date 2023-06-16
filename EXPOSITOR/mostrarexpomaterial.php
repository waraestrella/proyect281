<?php
session_start();

// Verificar si el usuario ha iniciado sesión como participante
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'expositor') {
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
  <title>PAGINA EXPOSITOR</title>

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

<!-- Agregar enlaces a los estilos de Bootstrap para la tabla de mostrar material -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

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

          <li class="nav-header">SUBIR MATERIAL</li>
        
            
            
              <li class="nav-item">
                <a href="listado_de_eventos_expo.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lista de Actividades</p>
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
            <h1 class="m-0" style="text-align: center;">Bienvenido Expositor</h1>
            <h1 class="m-0" style="text-align: center; font-family: cursive;"> Haga click en MI PERFIL para Modificar sus DATOS ACTUALES</h1>
          </div><!-- /.col -->
        
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- contenido debajo de sistema de gestion de eventos-->
    <section class="content">
<?php
    // Verificar si se ha enviado el ID de la actividad como parámetro
    if (isset($_GET['actividad_id'])) {
        $actividadId = $_GET['actividad_id'];

        // Realizar consultas a la base de datos para obtener el material relacionado con la actividad

        // Establecer la conexión a la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "base_chat";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Consultar el material relacionado con la actividad
        $sqlMaterial = "SELECT * FROM material WHERE actividad_id = $actividadId";
        $resultMaterial = $conn->query($sqlMaterial);

        if ($resultMaterial->num_rows > 0) {
            // Mostrar la tabla con el material relacionado
            echo '<table class="table">';
            echo '<thead class="thead-dark">';
            echo '<tr><th>Nombre de archivo</th><th>Tipo de archivo</th><th>Acciones</th></tr>';
            echo '</thead>';
            echo '<tbody>';

            // Recorrer los resultados de la consulta y mostrar el material en filas de la tabla
            while ($rowMaterial = $resultMaterial->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $rowMaterial['nombre_archivo'] . '</td>';
                echo '<td>' . $rowMaterial['tipo_archivo'] . '</td>';
                echo '<td>';
                echo '<button type="button" class="btn btn-danger btn-sm btn-eliminar-material" data-id="' . $rowMaterial['id'] . '"><i class="fa fa-trash"></i> Eliminar</button>';
                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p class="alert alert-info">No se encontró material para esta actividad.</p>';
        }

        // Mostrar botón para subir nuevo material
        echo '<button type="button" class="btn btn-success btn-subir-material" data-actividad-id="' . $actividadId . '"><i class="fa fa-upload"></i> Subir Material</button>';

        // Mostrar botón para volver a la página anterior
        echo '<button type="button" class="btn btn-primary btn-volver" onclick="history.back()"><i class="fa fa-arrow-left"></i> Volver</button>';

        // Cerrar la conexión a la base de datos
        $conn->close();
    } else {
        // Si no se ha proporcionado el ID de la actividad, mostrar un mensaje de error o redirigir a la página anterior
        echo '<p class="alert alert-danger">Error: No se ha proporcionado el ID de la actividad.</p>';
    }
    ?>

    
      
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
<!-- Importar la biblioteca de Font Awesome y jQuery -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script>
        // Manejar el clic del botón "Eliminar Material"
        $(document).on('click', '.btn-eliminar-material', function() {
            var materialId = $(this).data('id');
            eliminarMaterial(materialId);
        });

        // Función para eliminar el material mediante una solicitud AJAX
        function eliminarMaterial(materialId) {
            if (confirm('¿Estás seguro de que deseas eliminar este material?')) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'eliminar_material.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        console.log(xhr.responseText);
                        // Actualizar la página o realizar otras acciones después de eliminar el material
                       // Recargar la página después de eliminar el material
                location.reload();
                    }
                };
                xhr.send('material_id=' + materialId);
            }
        }

        // Manejar el clic del botón "Subir Material"
        $(document).on('click', '.btn-subir-material', function() {
            var actividadId = $(this).data('actividad-id');
            // Redirigir a la página de subir material con el ID de la actividad como parámetro
            window.location.href = 'subir_material.php?actividad_id=' + actividadId;
        });
    </script>

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
