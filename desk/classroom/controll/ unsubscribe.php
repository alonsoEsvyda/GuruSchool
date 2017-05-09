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

	//recibimos las variables y las sanamos
	$IdCourse=$GuruApi->TestInput($GuruApi->StringDecode($_POST['Course']));
		echo $IdCourse;
	/*if (!isset($_POST['Course']) || $_POST['Course']=="") {
		echo false;
	}else{
		$IdCourse=$GuruApi->TestInput($GuruApi->StringDecode($_POST['Course']));
		echo $IdCourse;
	}*/

?>