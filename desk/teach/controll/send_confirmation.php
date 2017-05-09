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

	//validamos que exista en ID del curso
	if (!isset($_POST['Id']) || empty($_POST['Id'])) {
		header("Location:../teacher?request=Ups, Hubo un Error, lo Sentimos.");
	}
	//DesEncriptamos Id del Curso
	$IdEncondeCourse=$GuruApi->StringDecode($_POST['Id']);
	//Definimos variables y  las sanamos
	$IdSession=$_SESSION['Data']['Id_Usuario'];
	$IdCourse=$GuruApi->TestInput($IdEncondeCourse);
	$State="En Revision";

		//Actualizamos el Estado
		$SqlUpdateState=$conexion->prepare("UPDATE G_Cursos SET Vc_EstadoCurso= ? WHERE Id_Pk_Curso= ? AND Int_Fk_IdUsuario= ?");
		$SqlUpdateState->bind_param("sii", $State,$IdCourse,$IdSession);
		if ($SqlUpdateState->execute()) {
			echo "Curso en Revisión: Espere Mientras lo Aprobamos";
		}else{
			echo "Hubo un Error, Intente Más Tarde";
		}
?>