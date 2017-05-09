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

	if (isset($_POST['categoria'])) {
		//taremos el id de la categoría
		$categoria=$GuruApi->TestInput($_POST['categoria']);
		$SQLGetIdCat=$conexion->prepare("SELECT Id_Pk_Categorias FROM G_Categorias WHERE Vc_NombreCat= ? ");
		$SQLGetIdCat->bind_param("s", $categoria);
		$SQLGetIdCat->execute();
		$SQLGetIdCat->store_result();	
		$SQLGetIdCat->bind_result($IdCat);
		$SQLGetIdCat->fetch();
			//traemos las sub-categoría
			$SQLGetSubCat=$conexion->prepare("SELECT Vc_SubCat FROM G_Sub_Categoria WHERE Int_Fk_IdCat= ? ");
			$SQLGetSubCat->bind_param("s", $IdCat);
			$SQLGetSubCat->execute();
			$SQLGetSubCat->store_result();
			$SQLGetSubCat->bind_result($NameSubCat);

			//$option="<option value='' disabled selected>Seleccione Sub-Categoría</option>";
				while ($SQLGetSubCat->fetch()) {
					echo '<option>'.$NameSubCat.'</option>';
				}
			//echo $option;

	}

?>