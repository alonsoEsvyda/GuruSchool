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
	if (!isset($_POST['IdC']) || $_POST['IdC']=="") {
		header("Location:../teacher?request=No Alteres los Datos, te Tenemos Vigilado...");
	}else{
		//DesEncriptamos el IdC y lo Sanamos
		$IdEncode=$_POST['IdC'];
		$IdDecode=$GuruApi->StringDecode($IdEncode);
		$IdCurso=$GuruApi->TestInput($IdDecode);
		$IdSession=$_SESSION['Data']['Id_Usuario'];
		$State="En Revision Video";
	}

		//Enviamos el Curso a Revisión
		$SqlSendData=$conexion->prepare("UPDATE G_Cursos SET Vc_EstadoCurso= ? WHERE Id_Pk_Curso= ? AND Int_Fk_IdUsuario= ?");
		$SqlSendData->bind_param("sii", $State,$IdCurso,$IdSession);
			if ($SqlSendData->execute()) {
				echo "Ok, ya falta poco para que tu Curso esté en Linea.";
			}else{
				echo "Hubo un Error, Intente más Tarde";
			}
?>