<?php  

session_start();

if(isset($_GET["session"]))
    {
      header('Location: ../destroy.php'); 
    }
    if(!isset($_SESSION["auth"]))
      header('Location: ../index.php');

?>


<?php  

$server="localhost";
$user="root";
$pass="";
$dbname="proyectofinal";
$conexion= mysqli_connect($server, $user, $pass, $dbname)
or die("Error de conexión: ".mysqli_connect_error());


mysqli_set_charset($conexion, "utf8");

$usuario_id=$_SESSION["auth"];

$consulta_usuario = mysqli_query ($conexion,"
  SELECT * 
  FROM usuarios 
  WHERE id='$usuario_id'") or die ("Error en la consulta:".mysql_error());

            $usuario = mysqli_fetch_array($consulta_usuario);


    if(isset($_GET['del']))
    {
      $Nombre=$_GET['del'];
      $sql = mysqli_query ($conexion,"DELETE FROM reservaciones WHERE Nombre='$Nombre'")
                        or die("Error en la consulta: ".mysql_error());
    }

    if(isset($_GET['del2']))
    {
      $Nombre=$_GET['del2'];
      $sql = mysqli_query ($conexion,"DELETE FROM usuarios WHERE Nombre='$Nombre'")
                        or die("Error en la consulta: ".mysql_error());
    }
    if(isset($_GET['del3']))
    {
      $Nombre=$_GET['del3'];
      $sql = mysqli_query ($conexion,"DELETE FROM usuarios WHERE Nombre='$Nombre'")
                        or die("Error en la consulta: ".mysql_error());
    }




$consulta = mysqli_query ($conexion,"
                SELECT * 
                FROM reservaciones
                WHERE Mesa!='NULL' and id_Usuario='$usuario_id' and Inactivo=0")
                or die("Error en la consulta: ".mysql_error());


@$table .= "<table class='table card-table table-responsive table-responsive-large' style='width:100%'>
                        <thead>
                          <tr>
                            <th class='d-none d-md-table-cell'>Nombre</th>
                            <th>Px.</th>
                            <th >Px. Ingresadas</th>
                            <th >Mesa</th>
                            <th >Dia</th>
                          </tr>
                        </thead>
                        <tbody>";

while($fila = mysqli_fetch_array($consulta)){
$table .= "<tr>
      
      <td class='text-dark d-none d-md-table-cell'>".$fila["Nombre"]."</td>
      <td>".$fila["Px"]."</td>
      <td>".$fila["Px_Ingresado"]."</td>
      <td>".$fila["Mesa"]."</td>
      <td>".$fila["Dia"]."</td>
   </tr>\n";
    }


$table .= "</table>\n"; 




$consulta2 = mysqli_query ($conexion,"
                SELECT * 
                FROM reservaciones
                WHERE Mesa IS NULL and id_Usuario='$usuario_id' and Inactivo=0")
                or die("Error en la consulta: ".mysql_error());

                //$nfilas = mysqli_num_rows ($consulta2);

@$table2 .= "<table class='table card-table table-responsive table-responsive-large' style='width:100%'>
                        <thead>
                          <tr>
                            <th>Nombre</th>
                            <th>Px.</th>
                            <th>Mesa</th>
                            <th>Dia</th>
                            <th>Eliminar Reservación</th>
                          </tr>
                        </thead>
                        <tbody>";

while($fila2 = mysqli_fetch_array($consulta2)){
$table2 .= "<tr>
      
      <td>".$fila2["Nombre"]."</td>
      <td>".$fila2["Px"]."</td>
      <td> SIN MESA </td>
      <td>".$fila2["Dia"]."</td>
      <td>
      <a href='index.php?del=".$fila2["Nombre"]."' ><button type='button' class='btn btn-danger'>Eliminar</button></a>
      </td>
   </tr>\n";
    }

    
$table2 .= "</table>\n";



    if ($_SERVER["REQUEST_METHOD"] == "POST") {
  

  if ($_POST['action'] == 'Agregar') {
   
$nombre=$_REQUEST['Nombre'];
  $telefono=$_REQUEST['Telefono'];
  $correo=$_REQUEST['Correo'];
  $contrasena=$_REQUEST['Contrasena'];
  $idCoordinador=$usuario['idCoordinador'];
  $verificar=$_REQUEST['verifContrasena'];

$nombresRps="
  SELECT Nombre
  FROM usuarios
  WHERE Nombre='$nombre' ";

  $cuentaRps= mysqli_query($conexion, $nombresRps) 
  or die("Error al validar correo.".mysql_error());

   $numRps=mysqli_num_rows($cuentaRps);

   if ($numRps>0)
   $errores["Nombre"]="El RP ya existe!"; 
    
else

  if (strcmp($contrasena, $verificar) !== 0)
  $errores["Contrasena"]= "El password debe ser el mismo!";


$correosrps="
  SELECT Correo
  FROM usuarios
  WHERE Correo='$correo' ";

  $correosrps2= mysqli_query($conexion, $correosrps) 
  or die("Error al validar correo.".mysql_error());

   $numRps2=mysqli_num_rows($correosrps2);

   if ($numRps2>0)
   $errores["Correo"]="El Correo ya existe ya existe!";

if (!isset($errores)){

  $hash=password_hash($contrasena, PASSWORD_DEFAULT);

  $ingresarRP="INSERT INTO usuarios (Nombre, Telefono, idCoordinador, Correo, Contrasena)
      VALUES ('$nombre', '$telefono', '$usuario_id', '$correo', '$hash') ";

  if (mysqli_query($conexion, $ingresarRP)) {  
    }else{
      echo "Error al registrar el usuario" . mysqli_error($conexion);
  }
header('Location: ./index.php');
}

} else if ($_POST['action'] == 'Reservar') {
     $nombre=$_REQUEST['Nombre'];
  $px=$_REQUEST['Px'];
  $comentario=$_REQUEST['comentarios'];
  $dia=$_REQUEST['Dia'];

  $sql="INSERT INTO reservaciones (id_Usuario, Nombre, Px, Comentarios, Dia)
      VALUES ('$usuario_id','$nombre', '$px', '$comentario', '$dia')";

  if (mysqli_query($conexion, $sql)) {  
    }else{
      echo "Error al registrar su reservación" . mysqli_error($conexion);
  }
header("location: index.php"); 
}
else if ($_POST['action'] == 'AgregarCordi') {
$nombre=$_REQUEST['Nombre'];
  $telefono=$_REQUEST['Telefono'];
  $correo=$_REQUEST['Correo'];
  $contrasena=$_REQUEST['Contrasena'];
  $idCapitan=$usuario['idCoordinador'];
  $verificar=$_REQUEST['verifContrasena'];

$nombresRps="
  SELECT Nombre
  FROM usuarios
  WHERE Nombre='$nombre' ";

  $cuentaRps= mysqli_query($conexion, $nombresRps) 
  or die("Error al validar correo.".mysql_error());

   $numRps=mysqli_num_rows($cuentaRps);

   if ($numRps>0)
   $errores["Nombre"]="El RP ya existe!"; 
    
else

  if (strcmp($contrasena, $verificar) !== 0)
  $errores["Contrasena"]= "El password debe ser el mismo!";


$correosrps="
  SELECT Correo
  FROM usuarios
  WHERE Correo='$correo' ";

  $correosrps2= mysqli_query($conexion, $correosrps) 
  or die("Error al validar correo.".mysql_error());

   $numRps2=mysqli_num_rows($correosrps2);

   if ($numRps2>0)
   $errores["Correo"]="El Correo ya existe ya existe!";

if (!isset($errores)){

  $hash=password_hash($contrasena, PASSWORD_DEFAULT);

  $ingresarRP="INSERT INTO usuarios (Nombre, Telefono, idCapitan, Correo, Contrasena)
      VALUES ('$nombre', '$telefono', '$usuario_id', '$correo', '$hash') ";

  if (mysqli_query($conexion, $ingresarRP)) {  
    }else{
      echo "Error al registrar el usuario" . mysqli_error($conexion);
  }
header('Location: ./index.php');
  }
}

}

$consulta_equipo = mysqli_query ($conexion,"
  SELECT * 
  FROM usuarios 
  WHERE idCoordinador='$usuario_id'") or die ("Error en la consulta:".mysql_error());


@$table3 .= "<table class='table card-table table-responsive table-responsive-large' style='width:100%'>
                        <thead>
                          <tr>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th >Correo</th>
                          </tr>
                        </thead>
                        <tbody>";



while($equipo2 = mysqli_fetch_array($consulta_equipo)){
$table3 .= "<tr>
      
      <td>".$equipo2["Nombre"]."</td>
      <td>".$equipo2["Telefono"]."</td>
      <td>".$equipo2["Correo"]."</td>
  <td class='text-right'>
                              <div class='dropdown show d-inline-block widget-dropdown'>
                              <a class='dropdown-toggle icon-burger-mini' href='' role='button' id='dropdown-recent-order1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' data-display='static'></a>
                                <ul class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdown-recent-order1'>
                                  
                                  <li class='dropdown-item'>
                                    <a href='index.php?del2=".$equipo2["Nombre"]."' ><button style='width:85px' type='button' class='btn btn-danger'>Eliminar</button></a>
                                  </li>
                                </ul>
                              </div>
                            </td>
   </tr>\n";
    }


@$table40 .= "</table>\n";

$consulta_equipo20 = mysqli_query ($conexion,"
  SELECT * 
  FROM usuarios 
  WHERE idCapitan='$usuario_id'") or die ("Error en la consulta:".mysql_error());


@$table40 .= "<table class='table card-table table-responsive table-responsive-large' style='width:100%'>
                        <thead>
                          <tr>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th >Correo</th>
                          </tr>
                        </thead>
                        <tbody>";



while($equipo30 = mysqli_fetch_array($consulta_equipo20)){
$table40 .= "<tr>
      
      <td>".$equipo30["Nombre"]."</td>
      <td>".$equipo30["Telefono"]."</td>
      <td>".$equipo30["Correo"]."</td>
  <td class='text-right'>
                              <div class='dropdown show d-inline-block widget-dropdown'>
                              <a class='dropdown-toggle icon-burger-mini' href='' role='button' id='dropdown-recent-order1' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' data-display='static'></a>
                                <ul class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdown-recent-order1'>
                                  
                                  <li class='dropdown-item'>
                                    <a href='index.php?del3=".$equipo30["Nombre"]."' ><button style='width:85px' type='button' class='btn btn-danger'>Eliminar</button></a>
                                  </li>
                                </ul>
                              </div>
                            </td>
   </tr>\n";
    }


$table40 .= "</table>\n";



?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Abolengo | Principal</title>

  <!-- GOOGLE FONTS -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500" rel="stylesheet"/>
  <link href="https://cdn.materialdesignicons.com/3.0.39/css/materialdesignicons.min.css" rel="stylesheet" />

  <!-- PLUGINS CSS STYLE -->
  <link href="assets/plugins/toaster/toastr.min.css" rel="stylesheet" />
  <link href="assets/plugins/nprogress/nprogress.css" rel="stylesheet" />
  <link href="assets/plugins/flag-icons/css/flag-icon.min.css" rel="stylesheet"/>
  <link href="assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" />
  <link href="assets/plugins/ladda/ladda.min.css" rel="stylesheet" />
  <link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
  <link href="assets/plugins/daterangepicker/daterangepicker.css" rel="stylesheet" />

  <!-- SLEEK CSS -->
  <link id="sleek-css" rel="stylesheet" href="assets/css/sleek.css" />

  

  <!-- FAVICON -->
  <link rel="icon" type="image/png" href="../images/icons/favicon.jpg"/>

  <!--
    HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
  -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script src="assets/plugins/nprogress/nprogress.js"></script>
</head>


  <body class="sidebar-fixed sidebar-dark header-light header-fixed" id="body">
    <script>
      NProgress.configure({ showSpinner: false });
      NProgress.start();
    </script>

    <div class="mobile-sticky-body-overlay"></div>

    <div class="wrapper">
      
              <!--
          ====================================
          ——— LEFT SIDEBAR WITH FOOTER
          =====================================
        -->
        <aside class="left-sidebar bg-sidebar">
          <div id="sidebar" class="sidebar sidebar-with-footer">
            <!-- Aplication Brand -->
            <div class="app-brand" style="background-color: #000000!important;">
              <a href="../index.php" style="padding-left: 0!important;">
                
                <img src="../images/Logo.jpg" style="max-width: 6em;     margin-left: -3%;">
                <span class="brand-name" style="color: #EAE3B7; font-weight: bolder;">ABOLENGO</span>
                
              </a>
            </div>
            <!-- begin sidebar scrollbar -->
            <div class="sidebar-scrollbar">

              <!-- sidebar menu -->
              <ul class="nav sidebar-inner" id="sidebar-menu">
                

                
   
                

      

                <li  class="has-sub" >
                    <a class="sidenav-item-link" href="index.php">
                      <i class="mdi mdi-home"></i>
                      <span class="nav-text">Principal</span>
                    </a>
                  </li>
<?php if(isset($usuario['idCapitan'])|| !isset($usuario['idCapitan'])&& !isset($usuario['idCoordinador'])) : ?>  
                
                  <li  class="has-sub" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#dashboard"
                      aria-expanded="false" aria-controls="dashboard">
                      <i class="mdi mdi-map"></i>
                      <span class="nav-text">Mapa</span> <b class="caret"></b>
                    </a>
                  <ul  class="collapse show"  id="dashboard"
                      data-parent="#sidebar-menu">
                      <div class="sub-menu">
                        
                      
                          
                         

                            <li >
                              <a class="sidenav-item-link" href="mapa3.php">
                                <span class="nav-text">Ver mapa</span>
                                
                              </a>
                            </li>
                          
                        <?php endif; ?>

                        <?php if (isset($usuario['idCapitan']) && isset($usuario['idCoordinador'])) : ?>
                        <li  class="active" >
                              <a class="sidenav-item-link" href="mapa.php">
                                <span class="nav-text">Agregar mesa</span>
                                
                              </a>
                            </li>

                            <li >
                              <a class="sidenav-item-link" href="mapa2.php">
                                <span class="nav-text">Eliminar mesa</span>
                                
                              </a>
                            </li>
      
                            

                          
                        

                        
                      </div>
                    </ul>
                  </li>
                <?php endif; ?>

                
              </ul>

            </div>

            <hr class="separator" />

         
          </div>
        </aside>

      

      <div class="page-wrapper">
                  <!-- Header -->
          <header class="main-header " id="header">
            <nav class="navbar navbar-static-top navbar-expand-lg">
              <!-- Sidebar toggle button -->
              <button id="sidebar-toggler" class="sidebar-toggle">
                <span class="sr-only">Toggle navigation</span>
              </button>
              <!-- search form -->
              <div class=" d-none d-lg-inline-block">
                <div class="input-group">
                <!-- <button type="button" class="btn btn-dark" style="margin-right: 26em; margin-left: 26em;">AGREGAR RESERVA</button> -->
                <button type="button" class="btn btn-info btn-pill btn-dark" data-toggle="modal" data-target="#exampleModalForm" style="margin-right: 28em; margin-left: 26em; margin-top: 1em;">
                AGREGAR RESERVA
                    </button>
                </div>
                <div id="search-results-container">
                  <ul id="search-results"></ul>
                </div>
              </div>





              <div class="navbar-right ">
                <ul class="nav navbar-nav">
                  
 

                  <!-- User Account -->
                  <li class="dropdown user-menu">
                    <button href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                      <!-- <img src="assets/img/user/user.png" class="user-image" alt="User Image" /> -->
                      <span class="d-none d-lg-inline-block">

                        <?php echo $usuario['Nombre']; ?>
                      
                      </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <!-- User image -->
                      <li class="dropdown-header">
                        <!-- <img src="assets/img/user/user.png" class="img-circle" alt="User Image" /> -->
                        <div class="d-inline-block">
                          <?php echo $usuario['Nombre']; ?><small class="pt-1"><?php echo $usuario['Correo']; ?></small>
                        </div>
                      </li>
                      <li class="dropdown-footer">
                        <a href="index.php?session=off"> <i class="mdi mdi-logout"></i> Log Out </a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </nav>


          </header>



<!-- Form Modal -->
            <div class="modal fade" id="exampleModalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalFormTitle" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalFormTitle">Información de Reserva</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form  method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Fecha de reservación</label>
                        <input type="date" class="form-control" name="Dia" placeholder="" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Nombre</label>
                        <input type="text" class="form-control" name="Nombre" placeholder="Juan Carlos" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Numero de personas</label>
                        <input type="text" class="form-control" name="Px" placeholder="Ejemplo: 4" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Observaciones</label>
                        <input type="text" cols="40" rows="5" name="comentarios" class="form-control" id="exampleInputPassword1" placeholder="Opcional">
                        <small id="emailHelp" class="form-text text-muted">Las observaciones son opcionales</small>
                      </div>
                      <input type="submit" class="btn btn-primary" name="action" value="Reservar">
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-pill" data-dismiss="modal">Cerrar</button>
                    <!-- <button type="button" class="btn btn-primary btn-pill">Guardar</button> -->
                  </div>
                </div>
              </div>
            </div>

        <div class="content-wrapper">
          <div class="content">						 

						<div class="row">
							<div class="col-12"> 
                  <!-- Recent Order Table -->
                  <div class="card card-table-border-none" id="recent-orders">
                    <div class="card-header justify-content-between">
                      <h2>Reservaciones con mesa</h2>
                      <div class="date-range-report ">
                        <span></span>
                      </div>
                    </div>
                    <div class="card-body pt-0 pb-5">
                      <?php 
                      echo $table;
                      ?>                   
                    </div>
                  </div>

                  <div class="card card-table-border-none" id="recent-orders">
                    <div class="card-header justify-content-between">
                      <h2>Reservaciones sin mesa</h2>
                      <div class="date-range-report ">
                        <span></span>
                      </div>
                    </div>
                    <div class="card-body pt-0 pb-5">
                      <?php 
                      echo $table2;
                      ?>                   
                    </div>
                  </div>
</div>
						</div>

<?php if(isset($usuario['idCapitan'])|| !isset($usuario['idCapitan'])&& !isset($usuario['idCoordinador'])) : ?>






            <div class="row">
              <div class="col-xl-6"> 
                  <!-- To Do list -->
                  <div class="card card-default todo-table" id="todo" data-scroll-height="550">
                    <div class="card-header justify-content-between">
                      <h2>Registro de nuevos RPS</h2>
                    </div>
                    <div class="card-body slim-scroll">

                      <div class="todo-list" id="todo-list">
                       
                      <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">
                      <p>Ingresar Nombre</p>
                      <input type="text" name="Nombre" style="width:200px;" required="true"><font color="red"> <?php  echo @$errores["Nombre"]?></font> <br><br>
                      <p>Ingresar Teléfono</p>
                      <input type="number" name="Telefono" style="width:200px;" required="true"><br><br>
                      <p>Ingresar Correo</p>
                      <input type="email" name="Correo" style="width:200px;" required="true"><font color="red"> <?php  echo @$errores["Correo"]?></font><br><br>
                      <p>Ingrese la contraseña</p>
                      <input type="password" name="Contrasena" style="width:200px;" required="true"><br><br>
                      <p>Ingrese nuevamente la contraseña</p>
                      <input type="password" name="verifContrasena" style="width:200px;" required="true"> <font color="red"> <?php  echo @$errores["Contrasena"]?></font><br><br>
                      <input class="btn btn-primary btn-pill" style="width:120px;" id="add-task" type="submit" name="action" value="Agregar">
                      </form>
                       

                       
                      </div>
                    </div>
                    <div class="mt-3"></div>
                  </div>
</div>

            </div>

                       




<div class="card card-table-border-none" id="recent-orders">
                    <div class="card-header justify-content-between">
                      <h2>Modificar información (RP)</h2>
                      <div class="date-range-report ">
                        <span></span>
                      </div>
                    </div>
                    <div class="card-body pt-0 pb-5">
                      
                      <?php  
                      echo $table3;

                      ?>
                         
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>




                  


<?php endif; ?>

<?php if ( !isset($usuario['idCapitan']) && !isset($usuario['idCoordinador'])) : ?>


<div class="row">
              <div class="col-xl-6"> 
                  <!-- To Do list -->
                  <div class="card card-default todo-table" id="todo" data-scroll-height="550">
                    <div class="card-header justify-content-between">
                      <h2>Registro de nuevos Cordis</h2>
                    </div>
                    <div class="card-body slim-scroll">

                      <div class="todo-list" id="todo-list">
                       
                      <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">
                      <p>Ingresar Nombre</p>
                      <input type="text" name="Nombre" style="width:200px;" required="true"><font color="red"> <?php  echo @$errores["Nombre"]?></font> <br><br>
                      <p>Ingresar Teléfono</p>
                      <input type="number" name="Telefono" style="width:200px;" required="true"><br><br>
                      <p>Ingresar Correo</p>
                      <input type="email" name="Correo" style="width:200px;" required="true"><font color="red"> <?php  echo @$errores["Correo"]?></font><br><br>
                      <p>Ingrese la contraseña</p>
                      <input type="password" name="Contrasena" style="width:200px;" required="true"><br><br>
                      <p>Ingrese nuevamente la contraseña</p>
                      <input type="password" name="verifContrasena" style="width:200px;" required="true"> <font color="red"> <?php  echo @$errores["Contrasena"]?></font><br><br>
                      <input class="btn btn-primary btn-pill" style="width:120px;" id="add-task" type="submit" name="action" name="action" value="AgregarCordi">
                      </form>
                       

                       
                      </div>
                    </div>
                    <div class="mt-3"></div>
                  </div>
</div>

            </div>


<div class="card card-table-border-none" id="recent-orders">
                    <div class="card-header justify-content-between">
                      <h2>Modificar información (Coordinador)</h2>
                      <div class="date-range-report ">
                        <span></span>
                      </div>
                    </div>
                    <div class="card-body pt-0 pb-5">
                      
                      <?php  
                      echo $table40;

                      ?>
                         
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>

           
          
<?php endif; ?>

          


        </div>

                  <footer class="footer mt-auto">
<!--             <div class="copyright bg-white">
              <p>
                &copy; <span id="copy-year">2019</span> Copyright Sleek Dashboard Bootstrap Template by
                <a
                  class="text-primary"
                  href="http://www.iamabdus.com/"
                  target="_blank"
                  >Abdus</a
                >.
              </p>
            </div> -->
            <script>
                var d = new Date();
                var year = d.getFullYear();
                document.getElementById("copy-year").innerHTML = year;
            </script>
          </footer>

      </div>
    </div>

    
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCn8TFXGg17HAUcNpkwtxxyT9Io9B_NcM" defer></script>
<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/plugins/toaster/toastr.min.js"></script>
<script src="assets/plugins/slimscrollbar/jquery.slimscroll.min.js"></script>
<script src="assets/plugins/charts/Chart.min.js"></script>
<script src="assets/plugins/ladda/spin.min.js"></script>
<script src="assets/plugins/ladda/ladda.min.js"></script>
<script src="assets/plugins/jquery-mask-input/jquery.mask.min.js"></script>
<script src="assets/plugins/select2/js/select2.min.js"></script>
<script src="assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>
<script src="assets/plugins/jvectormap/jquery-jvectormap-world-mill.js"></script>
<script src="assets/plugins/daterangepicker/moment.min.js"></script>
<script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="assets/plugins/jekyll-search.min.js"></script>
<script src="assets/js/sleek.js"></script>
<script src="assets/js/chart.js"></script>
<script src="assets/js/date-range.js"></script>
<script src="assets/js/map.js"></script>
<script src="assets/js/custom.js"></script>




  </body>
</html>
