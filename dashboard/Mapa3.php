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

$server = "localhost";
  $user = "root";
  $pass = "";
  $dbname = "proyectofinal";
  $conexion = mysqli_connect ($server,$user,$pass,$dbname) or die ("Error de conexion:".mysqli_connect_error());

  mysqli_set_charset($conexion, "utf8");

$usuario_id=$_SESSION["auth"];

$consulta_usuario = mysqli_query ($conexion,"
  SELECT * 
  FROM usuarios 
  WHERE id='$usuario_id'") or die ("Error en la consulta:".mysql_error());

            $usuario = mysqli_fetch_array($consulta_usuario);


$consulta2 = mysqli_query ($conexion,"
                SELECT Nombre 
                FROM reservaciones
                WHERE Mesa IS NULL")
                or die("Error en la consulta: ".mysql_error());
@$table2 .= "<select name='Nombre' class='custom-select my-1 mr-sm-2' id='inlineFormCustomSelectPref' style='margin-left: 0; required'>
";
while($fila2 = mysqli_fetch_array($consulta2)){
$table2 .= "      
      <option value=".$fila2["Nombre"].">".$fila2["Nombre"]."</option>\n";
    }
$table2 .= "</select>\n";


$consulta3 = mysqli_query ($conexion,"SELECT * FROM mesas WHERE reservada=false;")
                or die("Error en la consulta: ".mysql_error());
@$table3 .= "<select name='Mesa' class='custom-select my-1 mr-sm-2' id='inlineFormCustomSelectPref' style='margin-left: 0; required'>
";
while($fila3 = mysqli_fetch_array($consulta3)){
$table3 .= "      
      <option value=".$fila3["id"].">".$fila3["id"]."</option>\n";
    }
$table3 .= "</select>\n";



//VACIAR MESA
 if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
$Nombre=$_REQUEST['Nombre'];
$consulta4 = mysqli_query ($conexion,"SELECT id_usuario FROM reservaciones WHERE Nombre='$Nombre'")
                or die("Error en la consulta: ".mysql_error());

while($fila4 = mysqli_fetch_array($consulta4)){
$id_usuario = $fila4["id_usuario"];
}

$consulta5 = mysqli_query ($conexion,"SELECT nombre FROM usuarios WHERE id='$id_usuario'")
                or die("Error en la consulta: ".mysql_error());

while($fila5 = mysqli_fetch_array($consulta5)){
$Reservo = $fila5["nombre"];
}

$Mesa=$_REQUEST['Mesa'];
// $Reservo = $consulta4;
$Nombre=$_REQUEST['Nombre'];
$PxI=$_REQUEST['PxI'];

// $Mesa="40";
// $Reservo = "NA";
// $Nombre="NA";
// $PxI=0;

  $sql="UPDATE mesas SET  reservada=1 WHERE id='$Mesa'";
// SET ContactName = 'Alfred Schmidt', City= 'Frankfurt' WHERE CustomerID = 1;
  if (mysqli_query($conexion, $sql)) {  
    }else{
      echo "Error al registrar su reservación" . mysqli_error($conexion);
  }

  $sql="UPDATE reservaciones SET px_ingresado='$PxI', mesa='$Mesa' WHERE nombre='$Nombre'";

  if (mysqli_query($conexion, $sql)) {  
    }else{
      echo "Error al registrar su reservación" . mysqli_error($conexion);
  }

header("location: index.php"); 


$archivo = file_get_contents("imap5customusermap_44104518.js"); //lees el js del mapa aqui esta las ubicaciones y nombres de mesas

$archivo = html_entity_decode($archivo);//decodificas el archivo  

$pos1 = strpos($archivo,"\/".$Mesa."i");//obtienes donde empeiza la mesa a modificar VARIA

$pos2 = strpos($archivo,"\/".$Mesa."f");//obtiones donde se temrmina la mesa a modificar VARIA

$fin = strlen($archivo);//sacas el tamano total de tu archivo

$inicioHastaPos = substr($archivo, 0, $pos1);//cortas del inicio hasta el principio de la mesa

$posHastaFinal = substr($archivo, $pos2, $fin);//cortas del final de la mesa al final del archivo

$inyeccion = "\/".$Mesa."i>\.r\.n<div>\.r\.n<p><b>RP: ".$Reservo." <\/b><\/p>\.r\.n<p><b> ".$Nombre."<\/b><\/p>\.r\.n<p><b>Px Ing: ".$PxI." <\/b><\/p>\.r\.n<\/div>\.r\.n<";//inyectas los nuevos datos a agregar VARIA

$inicioHastaPos .= $inyeccion;//juntas el inicio con la nueva mesa

$inicioHastaPos .= $posHastaFinal;//juntas todo el archivo

$archivo = str_replace("\.r\.n",'\r\n',$inicioHastaPos);//remplazas los valores criticos para que se lea bien el archivo

$myfile = fopen("imap5customusermap_44104518.js", "w") or die("No se puede abrir este archivo!");//abres el archivo a leer y la w es para sobre escribir la informacion

fwrite($myfile, $archivo);//sobreescribes el archivo con la nueva informaicion

fclose($myfile);//cierras el archivo y se guarda la info

header("location: Mapa.php"); 
    }



?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Abolengo | Mapa</title>

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


  <body class="header-fixed sidebar-fixed sidebar-dark header-light" id="body">
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

                        <?php if ( isset($usuario['idCapitan']) && isset($usuario['idCoordinador'])) : ?>
                        
                          
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
                <div style="margin-right: 40em; margin-left: 26em; margin-top: 1em;"></div>
            <!--     <button type="button" class="btn btn-info btn-pill btn-dark" data-toggle="modal" data-target="#exampleModalForm" style="margin-right: 26em; margin-left: 26em; margin-top: 1em;">
                AGREGAR RESERVA
                    </button> -->
                <!--   <input type="text" name="query" id="search-input" class="form-control" placeholder="'button', 'chart' etc."
                    autofocus autocomplete="off" /> -->
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



        <div class="content-wrapper">
          <div class="content"> 


<div class="row">
              
      



                        


          
<script src="imap5customcore.js" type="application/javascript"></script><script type="application/javascript">imap5custom.init({usermap:44104518,local:true,base:"",responsivemap:false});</script>
      </div>
    </div>



          


        </div>

                  <footer class="footer mt-auto">
            <div class="copyright bg-white">
 <!--              <p>
                &copy; <span id="copy-year">2019</span> Copyright Sleek Dashboard Bootstrap Template by
                <a
                  class="text-primary"
                  href="http://www.iamabdus.com/"
                  target="_blank"
                  >Abdus</a
                >.
              </p> -->
            </div>
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
