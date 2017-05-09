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


	//verificamos que existan las variables
	if (!isset($_POST['DataCourse']) || !isset($_POST['NameVideo']) || $_POST['NameVideo']=="" || $_POST['DataCourse']=="" ) {
		echo false;
	}else{
		//definimos las variables y las sanamos (también desciframos valores cifrados)
		$IdCourseDecode=$GuruApi->StringDecode($_POST['DataCourse']);
		$IdCourseClean=$GuruApi->TestInput($IdCourseDecode);
		$IdUser=$_SESSION['Data']['Id_Usuario'];
		$StrNameTheme=$GuruApi->TestInput($_POST['NameVideo']);
		$StateVideo="Completo";

			//creamos la consulta parametrizada para marcar el vídeo
			$SqlMakeVideo=$conexion->prepare("UPDATE G_Usuarios_Cursos SET Vc_EstadoVideo = ? WHERE Int_Fk_IdCurso = ? AND Int_Fk_IdUsuario= ? AND Vc_NombreVideo = ? ");
			$SqlMakeVideo->bind_param("siis", $StateVideo,$IdCourseClean,$IdUser,$StrNameTheme);
				if ($SqlMakeVideo->execute()) {
					echo true;
				}else{
					echo false;
				}
	}

?>