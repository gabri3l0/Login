<?php  

session_start();

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{

	$server = "localhost";
	$user = "root";
	$pass = "";
	$dbname = "proyectofinal";
	$conexion = mysqli_connect ($server,$user,$pass,$dbname) or die ("Error de conexion:".mysqli_connect_error());

	mysqli_set_charset($conexion, "utf8");

	$correo=$_POST["mail"];//Obtener valores de Correo
	$pass=$_POST["pass"];//Obtener valores de pass

	$sqlSelectUser = mysqli_query ($conexion,"SELECT Correo FROM usuarios WHERE Correo='$correo'") or die ("Error en la consulta:".mysql_error());//Busca el correo en la BD
	

	$sqlnum=mysqli_num_rows($sqlSelectUser);// Numero de tuplas, si es 0 el correo no se encuentra si es 1 si existe en la BD

	if($sqlnum==0)
			$errores["mail"] = "El correo no existe";
		else
		{
		
		$sqlPass = mysqli_query ($conexion,"SELECT Contrasena FROM usuarios WHERE Correo='$correo'") or die ("Error en la consulta:".mysql_error());//Busca el correo y trae la contrasena encriptada

		$passwhash = mysqli_fetch_array ($sqlPass);//Trae el arreglo de informacion

			if(password_verify($pass, $passwhash[0])) //Verifica la contrasena que sea la misma que la encriptada
			{
					if(!isset($errores)) //No hay errores
						{


						$consulta_id= mysqli_query ($conexion,"SELECT id FROM usuarios WHERE Correo='$correo'") or die ("Error en la consulta:".mysql_error());

						$id_usuario = mysqli_fetch_array($consulta_id);

						$_SESSION["auth"]=$id_usuario['id']; //Crea variable de sesion

						header('Location: dashboard/index.php'); //Redirige a Login

						return;

						}
			}
			else
			$errores["password"] = "La contraseña esta incorrecta";
		}

}
   	 else
   	{
   		if(isset($_SESSION["auth"]))
		{
			header('Location: dashboard/index.php'); //Redirige a Login
		}
		// else
		// 	header('Location: index.php'); //Redirige a Login
   	}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Abolengo</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.jpg"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/AbolengoWallpaper.jpg');">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
					<span class="login100-form-logo">
						<!-- <i class="zmdi zmdi-landscape"></i> -->
						<img src="images/logo.jpg" style="    width: 189%;">
					</span>

					<span class="login100-form-title p-b-34 p-t-27">
						Iniciar Sesión
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Ingresa un Usuario">
						<input class="input100" type="text" name="mail" placeholder="Correo">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Verifica la Contraseña">
						<input class="input100" type="password" name="pass" placeholder="Contraseña">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>


	<font color="red"> <?php echo @$errores["mail"]?></font>
	<font color="red"> <?php echo @$errores["password"]?></font>

<!-- 					<div class="contact100-form-checkbox">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
						<label class="label-checkbox100" for="ckb1">
							Recuerdame
						</label>
					</div> -->

					<div class="container-login100-form-btn">
						<input type="submit" name="enviar" class="login100-form-btn" value="Entrar">
						</input>
					</div>

					<div class="text-center p-t-90">
						<a class="txt1" href="#">
							¿Olvidaste tu contraseña?
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>