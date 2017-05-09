<?php
	include('session/session_parameters.php');
	include ("class/functions.php");
	include ("class/function_data.php");
	//Llamamos la clase GuruApi
	$GuruApi = new GuruApi();
	//llamamos la clase ValidateData
	$ValidateData= new ValidateData();
	//Validamos el tiempo de vida de la sesión
	$TimeSession=$ValidateData->SessionTime($_SESSION['Data']['Tiempo'],"session/logout.php");
	//Asignamos el tiempo actual a la variable de sesión
	$_SESSION['Data']['Tiempo']=date("Y-n-j H:i:s");
	//traemos la ip real del usuario
	$GetRealIp = $GuruApi->getRealIP();
	//validamos que exista la sesión y las credenciales sean correctas
	$ValidateSession = $ValidateData->ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,"../iniciar-sesion.php?request=iniciar sesion");
?>
<!DOCTYPE html>
<html>
<head>
	<!--head-->
	<?php
     $baseUrl = dirname($_SERVER['PHP_SELF']).'/';
  	?>
  	<base href="<?php echo $baseUrl; ?>" >
  	<?php include ("../includes-front/head.php"); ?>
</head>
<body>
	<!--Menú-->
	<?php include ("includes/menu-dev.php"); ?>
	<?php
      include("includes/pop_up-dev.php");
    ?>
	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="padding margin-top intermediate">
						<h1>Cambia tu Contraseña</h1>
			            <hr>
			            <form action="case_user/change_password.php" method="POST">
			            	<div class="form-group">
					        	<div class="col-md-6 col-md-offset-3 margin-top">
					            	<input type="password" name="ActualPass" placeholder="* Password Actual" required/>
					        	</div>
						    </div>
						    <div class="form-group">
						        <div class="col-md-6 col-md-offset-3">
						            <input type="password" name="NewPass" placeholder="* Nuevo Password, Ej:Ramonvaldez50" data-toggle="tooltip" data-placement="top" title="El password debe ser Mayor a 8 digitos, tener 1 letra Mayúscula minimo, 1 dígito y 1 letra Minúscula minimo." required/>
						        </div>
						    </div>
						    <div class="form-group">
						        <div class="col-md-6 col-md-offset-3">
						            <input type="password" name="RepeatPass" placeholder="* Repite el Password" required/>
						        </div>
						    </div>
						    <div class="form-group">
						    	<div class="col-md-6 col-md-offset-3 margin-lesta-top margin-bottom">
						    		<center>
								    	<button type="submit" class="btn btn-default">Guardar</button>
								    </center>
						    	</div>
						    </div>
			            </form>
					</div>				
				</div>
			</div>
		</div>
	</section>	
	<!--Footer-->
    <?php include ("../includes-front/footer.php"); ?>
    <!--Scripts-->
    <?php include ("includes/scripts-dev.html"); ?>
</body>
</html>