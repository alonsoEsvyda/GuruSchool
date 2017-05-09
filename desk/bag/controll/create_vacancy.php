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

	//Recibimos los datos y los sanamos
	$Company=$GuruApi->TestInput($_POST['Company']);
	$Vacancy=$GuruApi->TestInput($_POST['Vacancy']);
	$Country=$GuruApi->TestInput($_POST['Country']);
	$City=$GuruApi->TestInput($_POST['City']);
	$Categorie=$GuruApi->TestInput($_POST['Categorie']);
	$TypeJob=$GuruApi->TestInput($_POST['TypeJob']);
	$Salary=$GuruApi->TestInput($_POST['Salary']);
	$NumVacancy=$GuruApi->TestInput($_POST['NumVacancy']);
	$Email=$GuruApi->TestInput($_POST['Email']);
	$Description=$GuruApi->TestInput($_POST['Description']);
	$State="Pending";
	$IdUser=$_SESSION['Data']['Id_Usuario'];
	$Fecha=date("Y-m-d");

	//validamos que no vengan vacíos
	if (empty($Company) || empty($Vacancy) || empty($Country) || empty($City) || empty($Categorie) || empty($TypeJob) || empty($Salary) || empty($NumVacancy) || empty($Email) || empty($Description)) {
		header("Location:../vacancy-published?request=Llena los datos, no jueges :@");
	}else{
		//verificamos que no superen los caracteres
		if (strlen($Company)>40 || strlen($Vacancy)>50 || strlen($Country)>70 || strlen($City)>30 || strlen($Categorie)>25 || strlen($TypeJob)>20 || strlen($Email)>45 ) {
			header("Location:../vacancy-published?request=No superes los datos, te tengo en la mira 0.0");
		}else{
			//validamos el email
			if ($GuruApi->TestMail($Email)) {
				//insertamos en la BD
				$SqlInsert=$conexion->prepare("INSERT INTO G_Vacantes (Int_Fk_IdUsuario,Vc_Empresa,Vc_NombreVacante,Vc_Pais,Vc_Ciudad,Vc_Categoria,Vc_TipoVacante,Int_Salario,Int_NumVacantes,Vc_Correo,Txt_DescripcionVacante,Vc_EstadoVacante,Da_Fecha) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
				$SqlInsert->bind_param("issssssiissss",$IdUser,$Company,$Vacancy,$Country,$City,$Categorie,$TypeJob,$Salary,$NumVacancy,$Email,$Description,$State,$Fecha);
				if ($SqlInsert->execute()) {
					header("Location:../list-my-job?requestok=Vacante Enviada, si cumple con los requisitos será Publicada, de lo contario será Eliminada.");
				}
			}else{
				header("Location:../vacancy-published?request=Debes escribir un Correo Valido");
			}
		}
	}
?>