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
	if (!isset($_POST['Course']) || $_POST['Course']=="" ) {
		echo false;
	}else{
		//definimos las variables y las sanamos (también desciframos valores cifrados)
		$IdCourseDecode=$GuruApi->TestInput($GuruApi->StringDecode($_POST['Course']));
		$IdUser=$_SESSION['Data']['Id_Usuario'];
		//verificamos que el curso si pertenezca al usuario en cuestión
		$SqlValidateCourse=$conexion->prepare("SELECT Id_Pk_CursosApuntados FROM G_Usuarios_Cursos WHERE Int_Fk_IdCurso=? AND Int_Fk_IdUsuario=?");
		$SqlValidateCourse->bind_param("ii",$IdCourseDecode,$IdUser);
		$SqlValidateCourse->execute();
		$SqlValidateCourse->store_result();
		if ($SqlValidateCourse->num_rows==0) {
			echo false;
		}else{
			//Creamos la consulta que elimina el curso de la tabla
			$SqlDeleteVideo=$conexion->prepare("DELETE FROM G_Usuarios_Cursos WHERE Int_Fk_IdCurso=? AND Int_Fk_IdUsuario=?");
			$SqlDeleteVideo->bind_param("ii",$IdCourseDecode,$IdUser);
			if ($SqlDeleteVideo->execute()) {
				echo true;
			}else{
				echo false;
			}
		}
	}

?>