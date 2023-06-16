<?php
session_start();

// Verificar si el usuario ha iniciado sesión como participante
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'administrador') {
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
						<h2><b>Usuarios Participantes</b></h2>
					</div>
					<div class="col-sm-6">
						<a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Añadir un nuevo Usuario</span></a>
												
					</div>
          <a href="crearpdfParticipante.php" class="btn btn-primary"><i class="bi bi-printer"></i> Imprimir</a>
				</div>

			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						
						<th>ID</th>
			            <th>Nombre</th>
			            <th>Apellido</th>
			            <th>Teléfono</th>
			            <th>Email</th>
			            <th>Imagen</th>
			            <th>Tipo Usuario</th>
			            <th>Estado</th>
			            <th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<tr>
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
			            $sql = "SELECT * FROM usuario where tipo_usuario = 'participante'";
			            $result = $conn->query($sql);

			            if ($result->num_rows > 0) {
			              // Mostrar los usuarios en la tabla
			              while($row = $result->fetch_assoc()) {
			                echo "<tr>";
			                echo "<td>" . $row["id"] . "</td>";
			                echo "<td>" . $row["nombre"] . "</td>";
			                echo "<td>" . $row["apellido"] . "</td>";
			                echo "<td>" . $row["telefono"] . "</td>";
			                echo "<td>" . $row["email"] . "</td>";
			                echo "<td><img src='../imgusuarios/" . $row["imagen"] . "' class='img-thumbnail' style='max-width:100px;'></td>";
			                echo "<td>" . $row["tipo_usuario"] . "</td>";
			                echo "<td>" . $row["estado"] . "</td>";
			                
			                echo "<td><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#editarUsuarioModal' data-id='" . $row["id"] . "' data-nombre='" . $row["nombre"] . "' data-apellido='" . $row["apellido"] . "' data-telefono='" . $row["telefono"] . "' data-email='" . $row["email"] . "' data-imagen='" . $row["imagen"] . "' data-tipo='" . $row["tipo_usuario"] . "' data-estado='" . $row["estado"] . "'><i class='fa fa-edit'></i> Editar</button> <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#eliminarUsuarioModal' data-id='" . $row["id"] . "'><i class='fa fa-trash'></i> Eliminar</button></td>";
                echo "</tr>";
			              }
			            } else {
			              echo "<tr><td colspan='9'>No se encontraron usuarios.</td></tr>";
			            }
			          ?>
						
						
					</tr>
					
										
					
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
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarUsuarioModalLabel">Editar usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="editar_usuario_participante.php" method="POST">
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="">
          </div>
          <div class="form-group">
            <label for="apellido">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" value="">
          </div>
          <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="">
          </div>
        <div class="form-group">
          <label for="imagen">Imagen:</label>
          <input type="file" class="form-control-file" id="imagen" name="imagen"> 
      </div>


          <div class="form-group">
            <label for="tipo_usuario">Tipo de usuario</label>
            <select class="form-control" id="tipo_usuario" name="tipo_usuario">
              <option value="participante">PARTICIPANTE</option>
              <option value="administrador">ADMINISTRADOR</option>
              <option value="control">CONTROL</option>
              <option value="expositor">EXPOSITOR</option>
              
            </select>
          </div>
          <div class="form-group">
            <label for="estado">Estado</label>
            <select class="form-control" id="estado" name="estado">
              <option value="activo">Activo</option>
              <option value="inactivo">Inactivo</option>
            </select>
          </div>
          <input type="hidden" id="id" name="id" value="">
          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
      </div>
    </div>
  </div>
</div>


 <!-- Modal registrase-->
  <div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="registroModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registroModalLabel">Formulario de registro</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="registroForm" action="guardar_registro_participante_crudAdmi.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
          <label for="apellido">Apellido</label>
          <input type="text" class="form-control" id="apellido" name="apellido" required>
        </div>
        <div class="form-group">
          <label for="telefono">Teléfono</label>
          <input type="tel" class="form-control" id="telefono" name="telefono" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="contrasena">Contraseña</label>
          <div class="input-group">
            <input type="password" class="form-control" id="contrasena" name="contrasena" required>
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="button" id="verContrasenaBtn">
                <i class="fa fa-eye"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="imagen">Imagen de perfil</label>
          <input type="file" class="form-control-file" id="imagen" name="imagen" accept="image/*" required>
        </div>
      </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: red">Cancelar</button>
          <button type="submit" form="registroForm" class="btn btn-primary" style="background-color: green" >Registrar</button>

        </div>
      </div>
    </div>
  </div>



<!-- modal eliminar -->
<div class="modal fade" id="eliminarUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="eliminarUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eliminarUsuarioModalLabel">Eliminar Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Está seguro de que desea eliminar este usuario?
      </div>
      <div class="modal-footer">
        <form action="eliminarUsuario_participante.php" method="post">
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
  // Capturar el evento de apertura del modal de edición
  $('#editarUsuarioModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Botón que activó el modal
    var id = button.data('id'); // Obtener el ID del usuario a editar
    var nombre = button.data('nombre'); // Obtener el nombre del usuario a editar
    var apellido = button.data('apellido'); // Obtener el apellido del usuario a editar
    var telefono = button.data('telefono'); // Obtener el teléfono del usuario a editar
    var email = button.data('email'); // Obtener el email del usuario a editar
    var imagen = button.data('imagen'); // Obtener la imagen del usuario a editar
    var tipo = button.data('tipo'); // Obtener el tipo de usuario a editar
    var estado = button.data('estado'); // Obtener el estado del usuario a editar

    // Actualizar los valores de los campos del formulario en el modal con los datos del usuario
    var modal = $(this);
    modal.find('#id').val(id);
    modal.find('#nombre').val(nombre);
    modal.find('#apellido').val(apellido);
    modal.find('#telefono').val(telefono);
    modal.find('#email').val(email);
    modal.find('#tipo_usuario').val(tipo);
    modal.find('#estado').val(estado);
  });
</script>

 <!-- jQuery  para el registro-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Custom JS -->
<script>
  $(document).ready(function() {
    // Función para mostrar u ocultar la contraseña
    $('#verContrasenaBtn').click(function() {
      var tipo = $('#contrasena').attr('type');
      if (tipo == 'password') {
        $('#contrasena').attr('type', 'text');
        $('#verContrasenaBtn i').removeClass('fa-eye');
        $('#verContrasenaBtn i').addClass('fa-eye-slash');
      } else {
        $('#contrasena').attr('type', 'password');
        $('#verContrasenaBtn i').removeClass('fa-eye-slash');
        $('#verContrasenaBtn i').addClass('fa-eye');
      }
    });
  });
</script>
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
</body>
</html>