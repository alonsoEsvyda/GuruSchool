<?php
	include('../../session/session_parameters.php');
	include ("../../class/functions.php");
	include ("../../class/function_data.php");

	//Llamamos la clase GuruApi
	$GuruApi = new GuruApi();
	//llamamos a la clase ValidateData
  	$ValidateData= new ValidateData();
  	//Validamos el tiempo de vida de la sesión
  	$TimeSession=$ValidateData->SessionTime($_SESSION['Data']['Tiempo'],"http://localhost/GuruSchool/desk/session/logout.php");
  	//Asignamos el tiempo actual a la variable de sesión
  	$_SESSION['Data']['Tiempo']=date("Y-n-j H:i:s");
  	//traemos la ip real del usuario
	$GetRealIp = $GuruApi->getRealIP();
	//validamos que exista la sesión y las credenciales sean correctas
	$ValidateSession = $ValidateData->ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,"../../../iniciar-sesion.php?request=iniciar sesion");

	//trverificamos que venga algo en las variables
	if (!isset($_POST['Data']) || empty($_POST['Data'])) {
		echo false;
	}else{
		//sanamos las variables
		$DataIdDecode=$GuruApi->StringDecode($_POST['Data']);
      	$DataIdSane=$GuruApi->TestInput($DataIdDecode);
      		//eliminamos la vacante
	        $SqlDeelete=$conexion->prepare("DELETE FROM G_Vacantes WHERE Id_Pk_Vacante= ?");
	        $SqlDeelete->bind_param("i",$DataIdSane);
	          if ($SqlDeelete->execute()) {
	            echo true;
	          }else{
	            echo false;
	          }
	}
?>