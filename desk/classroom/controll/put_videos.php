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
	if (!isset($_POST['Token']) || !isset($_POST['NameVideo']) || !isset($_POST['NameTheme']) || !isset($_POST['DataCourse']) || $_POST['Token']=="" || $_POST['NameVideo']=="" || $_POST['NameTheme']=="" || $_POST['DataCourse']=="") {
		?>
			<iframe class="video" width="100%" height="500px" src="http://www.youtube.com/embed/?showinfo=0" frameborder="0"></iframe>
		<?php
	}else{
		$StrType=$GuruApi->StringDecode($_POST['Token']);
		$StrTypeClean=$GuruApi->TestInput($StrType);
		$UrlCourse=$GuruApi->TestInput($_POST['NameVideo']);
		$ThemeCourse=$GuruApi->TestInput($_POST['NameTheme']);
		$IdCourse=$GuruApi->TestInput($_POST['DataCourse']);

		if ($StrTypeClean=="Gratis") {
			$bool=true;
		}else if($StrTypeClean=="De Pago"){
			$bool=false;
		}
			//creamos el array
			$Array=array($UrlCourse,$ThemeCourse,$IdCourse,$bool);
			//enviamos un objeto json
			echo json_encode($Array);
	}

?>