<?php
session_start();

// Verificar si el usuario ha iniciado sesión como participante
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'administrador') {
  header('Location: ../index.html');
  exit();
}
// Obtener el ID del evento desde la URL
if (isset($_GET['id'])) {
  $eventoID = $_GET['id'];
} else {
  // Si no se proporciona un ID de evento, redirigir a alguna página de manejo de errores o volver a la página anterior
  header('Location: index.html');
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

// Obtener las actividades correspondientes al evento



$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>PAGINA ADMINISTRADOR</title>
 <!-- para la pagina del administrador -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
  <!--etsilos para el crud-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

 <!-- Bootstrap CSS registro usuario-->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="estiloscrudAdmi.css">
<script>
$(document).ready(function(){
  // Activate tooltip
  $('[data-toggle="tooltip"]').tooltip();
  
  // Select/Deselect checkboxes
  var checkbox = $('table tbody input[type="checkbox"]');
  $("#selectAll").click(function(){
    if(this.checked){
      checkbox.each(function(){
        this.checked = true;                        
      });
    } else{
      checkbox.each(function(){
        this.checked = false;                        
      });
    } 
  });
  checkbox.click(function(){
    if(!this.checked){
      $("#selectAll").prop("checked", false);
    }
  });
});

</script>
<style >
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
    <a href="#" class="brand-link">
      <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Sistema Eventos</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $imagen; ?>" class="img-circle elevation-2" alt="User Image">
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
                <a href="admi.php" class="nav-link" >
                  <i class="far fa-circle nav-icon"></i>
                  <p>MI PERFIL</p>
                </a>
              </li>

          <li class="nav-header">Modificar Usuarios</li>
              <li class="nav-item">
                <a href="Admi_CrudControl.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Control</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="Admi_CrudExpositor.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Expositor</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="Admi_CrudParticipante.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Paricipante</p>
                </a>
              </li>
            
         
          <li class="nav-item">
            <a href="Admi_CrudEventos.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Modificar Eventos
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="Admi_CrudAmbientes.php" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Modificar Ambientes
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>
         
         
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Auditoria de Acceso
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Modificar Pagina Principal
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
            <h1 class="m-0" style="text-align: center;">Bienvenido Administrador</h1>
          </div><!-- /.col -->
        
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- contenido debajo del titulo sistema de gestion de eventos-->
    <section class="content">

<div class="container-xl"><!--para el crud-->
  <div class="table-responsive">
      <div class="table-wrapper">
      <div class="table-title">
        <div class="row">
          <div class="col-sm-6">
            <h2><b>Actividades</b></h2>
          </div>
          <div class="col-sm-6">
            <a href="#añadirActividadModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Añadir un nueva Actividad</span></a>
                        
          </div>
          <a href="crearpdfEventos.php" class="btn btn-primary"><i class="bi bi-printer"></i> Imprimir</a>
          <a href="Admi_CrudEventos.php" class="btn btn-success"><i class="bi bi-arrow-left"></i> Volver al evento</a>

        </div>

      </div>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Descripcion</th>
            <th>Duracion</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Imagen</th>
            <th>Expositor</th> <!-- Nuevo campo -->
            <th>Ambiente</th> <!-- Nuevo campo -->
            <th>Acciones</th>
          </tr>
          </thead>
          <tbody>
            <?php
             $servername = "localhost";
                  $username = "root";
                  $password = "";
                  $dbname = "base_chat";

                  $conn = new mysqli($servername, $username, $password, $dbname);

                  if ($conn->connect_error) {
                    die("Error de conexión: " . $conn->connect_error);
                  }
                  // Consultar los usuarios de la base de datos
                  $sql = "SELECT * FROM actividad where id_evento = $eventoID";
                  $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              // Mostrar las actividades
              while ($row = $result->fetch_assoc()) {
                // Obtener el nombre del expositor
                // Conectar a la base de datos
                
                // Obtener el nombre del ambiente
                
              
                // Puedes ajustar el formato de salida según tus necesidades
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row['nombre'] . "</td>";
                echo "<td>" . $row['tipo'] . "</td>";
                echo "<td>" . $row['descripcion'] . "</td>";
                echo "<td>" . $row['duracion'] . "</td>";
                echo "<td>" . $row['fecha'] . "</td>";
                echo "<td>" . $row['hora'] . "</td>";
                echo "<td><img src='../imgactividad/" . $row['imagen'] . "' class='img-thumbnail' style='max-width:100px;'></td>";

                //para el ombre del expositor
                echo "<td>" . $row['nomExpo'] . "</td>";
                echo "<td>" . $row['nomAmbiente'] . "</td>";
                
                
                // Obtener el nombre del expositor
        
                
                echo "<td>";
                echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#editarActividadModal' data-id='" . $row['id'] . "' data-nombre='" . $row['nombre'] . "' data-tipo='" . $row['tipo'] . "' data-descripcion='" . $row['descripcion'] . "' data-duracion='" . $row['duracion'] . "' data-fecha='" . $row['fecha'] . "' data-hora='" . $row['hora'] . "' data-imagen='" . $row['imagen'] . "' data-expositor='" . $row['expositor_id'] . "' data-ambiente='" . $row['ambiente_id'] . "'><i class='fa fa-edit'></i> Editar</button> <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#eliminarUsuarioModal' data-id='" . $row["id"] . "'><i class='fa fa-trash'></i> Eliminar</button></td>";
                echo "</tr>"; 
              }
            } else {
              echo "<tr><td colspan='9'>No se encontraron actividades.</td></tr>";
            }
            ?>
          </tbody>
      </table>
    </div>        
</div>
</div>

      
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
</div> 
</div><!-- para el crud-->
</div>
<!-- modal editar -->
<!-- Formulario modal para editar actividad -->
<div class="modal fade" id="editarActividadModal" tabindex="-1" role="dialog" aria-labelledby="editarActividadModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarActividadModalLabel">Editar Actividad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editarActividadForm" action="actualizar_actividad.php" method="POST" enctype="multipart/form-data">
          <!-- Aquí va el contenido del formulario -->
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
          </div>
          <div class="form-group">
            <label for="tipo">Tipo</label>
            <input type="text" class="form-control" id="tipo" name="tipo" required>
          </div>
          <div class="form-group">
            <label for="imagen">Imagen</label>
            <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*">
          </div>
          <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
          </div>
          <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
          </div>
          <div class="form-group">
            <label for="hora">Hora</label>
            <input type="time" class="form-control" id="hora" name="hora" required>
          </div>
          <div class="form-group">
            <label for="duracion">Duración</label>
            <input type="text" class="form-control" id="duracion" name="duracion" required>
          </div>
          <!-- Expositores -->
          <div class="form-group">
            <label for="expositor">Expositor</label>
            <select class="form-control" id="expositor" name="expositor" required>
              <option value="">Seleccione un expositor</option>
              <!-- Aquí debes generar las opciones con PHP -->
              <?php
              function obtenerExpositores()
              {
                $conexion = new mysqli("localhost", "root", "", "base_chat");
                $query = "SELECT id, nombre FROM usuario WHERE tipo_usuario = 'expositor'";
                $resultado = $conexion->query($query);

                $expositores = array();
                while ($fila = $resultado->fetch_assoc()) {
                  $expositores[] = $fila;
                }

                $conexion->close();

                return $expositores;
              }
              $expositores = obtenerExpositores();
              foreach ($expositores as $expositor) {
                echo '<option value="' . $expositor['id'] . '">' . $expositor['nombre'] . '</option>';
              }
              ?>

            </select>
          </div>
          <!-- Ambientes -->
          <div class="form-group">
            <label for="ambiente">Ambiente</label>
            <select class="form-control" id="ambiente" name="ambiente" required>
              <option value="">Seleccione un ambiente</option>
              <!-- Aquí debes generar las opciones con PHP -->
              <?php
              function obtenerAmbientes()
              {
                $conexion = new mysqli("localhost", "root", "", "base_chat");
                $query = "SELECT id, nombre FROM ambiente";
                $resultado = $conexion->query($query);

                $ambientes = array();
                while ($fila = $resultado->fetch_assoc()) {
                  $ambientes[] = $fila;
                }

                $conexion->close();

                return $ambientes;
              }
              $ambientes = obtenerAmbientes();
              foreach ($ambientes as $ambiente) {
                echo '<option value="' . $ambiente['id'] . '">' . $ambiente['nombre'] . '</option>';
              }
              ?>
            </select>
          </div>
          <input type="hidden" id="id_actividad" name="id_actividad">
          <!-- Fin del contenido del formulario -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



 <!-- Modal registrase-->
  <!-- Formulario modal para añadir actividad -->
<!-- Formulario modal para añadir actividad -->
<div class="modal fade" id="añadirActividadModal" tabindex="-1" role="dialog" aria-labelledby="añadirActividadModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="añadirActividadModalLabel">Añadir Actividad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="guardar_actividad1.php" method="POST" enctype="multipart/form-data">
          <!-- Aquí va el contenido del formulario -->
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
          </div>
          <div class="form-group">
            <label for="tipo">Tipo</label>
            <input type="text" class="form-control" id="tipo" name="tipo" required>
          </div>
          <div class="form-group">
            <label for="imagen">Imagen</label>
            <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*" required>
          </div>
          <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
          </div>
          <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
          </div>
          <div class="form-group">
            <label for="hora">Hora</label>
            <input type="time" class="form-control" id="hora" name="hora" required>
          </div>
          <div class="form-group">
            <label for="duracion">Duración</label>
            <input type="text" class="form-control" id="duracion" name="duracion" required>
          </div>
          <!-- Expositores -->
          <div class="form-group">
            <label for="expositor">Expositor</label>
            <select class="form-control" id="expositor" name="expositor">
              <option value="">Seleccione un expositor</option>
              <?php
                  
              
              $expositores = obtenerExpositores();
              foreach ($expositores as $expositor) {
                echo '<option value="' . $expositor['id'] . '">' . $expositor['nombre'] . '</option>';
              }

              ?>
            </select>
          </div>
          
          <!-- Ambientes -->
          <div class="form-group">
            <label for="ambiente">Ambiente</label>
            <select class="form-control" id="ambiente" name="ambiente">
              <option value="">Seleccione un ambiente</option>
              <?php
              
             
              
              $ambientes = obtenerAmbientes();
              foreach ($ambientes as $ambiente) {
                echo '<option value="' . $ambiente['id'] . '">' . $ambiente['nombre'] . '</option>';
              }
              ?>
            </select>
          </div>
          <input type="hidden" id="id_evento" name="id_evento" value="<?php echo $eventoID; ?>">
          <!-- Fin del contenido del formulario -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- modal eliminar -->
<div class="modal fade" id="eliminarUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="eliminarUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eliminarUsuarioModalLabel">Eliminar Actividad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Está seguro de que desea eliminar esta Actividad?
      </div>
      <div class="modal-footer">
        <form action="eliminar_actividad.php" method="post">
          <input type="hidden" name="id" id="eliminarUsuarioId" value="">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!--scrip para el eliminar-->
<script>
  $('#eliminarUsuarioModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Botón que abre el modal
    var id = button.data('id') // Extraer la información de los atributos data-id
    var modal = $(this)
    modal.find('#eliminarUsuarioId').val(id) // Asignar valor al campo id del formulario
  })
</script>
<!-- scrip editar usuario -->
<script>
  function fillEditForm(button) {
  // Obtener los valores de los atributos data del botón
  var id = button.getAttribute("data-id");
  var nombre = button.getAttribute("data-nombre");
  var tipo = button.getAttribute("data-tipo");
  var descripcion = button.getAttribute("data-descripcion");
  var duracion = button.getAttribute("data-duracion");
  var fecha = button.getAttribute("data-fecha");
  var hora = button.getAttribute("data-hora");
  var imagen = button.getAttribute("data-imagen");
  var expositor = button.getAttribute("data-expositor");
  var ambiente = button.getAttribute("data-ambiente");

  // Llenar los campos del formulario modal con los valores obtenidos
  document.getElementById("nombre").value = nombre;
  document.getElementById("tipo").value = tipo;
  document.getElementById("descripcion").value = descripcion;
  document.getElementById("duracion").value = duracion;
  document.getElementById("fecha").value = fecha;
  document.getElementById("hora").value = hora;
  document.getElementById("imagen").value = imagen;
  document.getElementById("expositor").value = expositor;
  document.getElementById("ambiente").value = ambiente;
  document.getElementById("id_actividad").value = id;
}

</script>

 <!-- jQuery  para el registro-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Custom JS -->

<!--para pagina de administrador jQuery -->
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
<script src="../dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../dist/js/pages/dashboard.js"></script>

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

<!-- Botón para abrir el modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#añadirActividadModal">
  Añadir Actividad
</button>

<!-- Formulario modal para añadir actividad -->
<div class="modal fade" id="añadirActividadModal" tabindex="-1" role="dialog" aria-labelledby="añadirActividadModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="añadirActividadModalLabel">Añadir Actividad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="guardar_actividad.php" method="POST" enctype="multipart/form-data">
          <!-- Aquí va el contenido del formulario -->
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
          </div>
          <div class="form-group">
            <label for="tipo">Tipo</label>
            <input type="text" class="form-control" id="tipo" name="tipo" required>
          </div>
          <div class="form-group">
            <label for="imagen">Imagen</label>
            <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*" required>
          </div>
          <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
          </div>
          <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
          </div>
          <div class="form-group">
            <label for="hora">Hora</label>
            <input type="time" class="form-control" id="hora" name="hora" required>
          </div>
          <div class="form-group">
            <label for="duracion">Duración</label>
            <input type="text" class="form-control" id="duracion" name="duracion" required>
          </div>
          <input type="hidden" id="id_evento" name="id_evento">
          <!-- Fin del contenido del formulario -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!--sccrip para las actividades-->
<script>
  $(document).ready(function() {
  // Capturar el evento clic del botón "Ver Actividades"
  $(document).on('click', '.btn-ver-actividades', function() {
    // Obtener el ID del evento desde el atributo data-id del botón
    var eventoID = $(this).data('id');
    
    // Realizar alguna acción con el ID del evento (por ejemplo, redirigir a una página de actividades)
    // Aquí puedes modificar este código según tus necesidades
    window.location.href = 'actividades.php?id=' + eventoID;
  });
});

//funciones para obtener ambientes y expositores-->

  


</script>

</body>
</html>