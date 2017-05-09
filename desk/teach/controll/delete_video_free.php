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
	$ValidateSession = $ValidateData->ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,"http://localhost/GuruSchool/iniciar-sesion?request=iniciar sesion");

	//Verificamos que venga algo en el IdC
	if (!isset($_POST['Id']) || $_POST['Id']=="") {
		echo false;
	}else{
		//DesEncriptamos el IdC y lo Sanamos
		$IdEncode=$_POST['Id'];
		$IdDecode=$GuruApi->StringDecode($IdEncode);
		$IdVideo=$GuruApi->TestInput($IdDecode);
	}
		//Eliminamos el Curso
		$SqlDeleteVideo=$conexion->prepare("DELETE FROM G_Videos_Curso WHERE Id_Pk_VideosCurso = ?");
		$SqlDeleteVideo->bind_param("i",$IdVideo);
		if ($SqlDeleteVideo->execute()) {
			echo true;
		}else{
			echo false;
		}
?>