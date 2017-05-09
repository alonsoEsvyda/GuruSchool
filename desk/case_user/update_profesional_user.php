<?php
	include('../session/session_parameters.php');
	include ("../class/functions.php");
	include ("../class/function_data.php");
	//Llamamos la clase GuruApi
	$GuruApi = new GuruApi();
	//llamamos la clase ValidateData
	$ValidateData= new ValidateData();
	//Validamos el tiempo de vida de la sesión
	$TimeSession=$ValidateData->SessionTime($_SESSION['Data']['Tiempo'],"../session/logout.php");
	//Asignamos el tiempo actual a la variable de sesión
	$_SESSION['Data']['Tiempo']=date("Y-n-j H:i:s");
	//traemos la ip real del usuario
	$GetRealIp = $GuruApi->getRealIP();
	//validamos que exista la sesión y las credenciales sean correctas
	$ValidateSession = $ValidateData->ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,"../../iniciar-sesion.php?request=iniciar sesion");

	//Definimos las variables
	$IdSession=$_SESSION['Data']['Id_Usuario'];
	$StrProfession=$GuruApi->TestInput($_POST['profesion']);
	$StrBiografia=$GuruApi->TestInput($_POST['biografia']);
	$UrlFacebook=$GuruApi->TestInput($_POST['Facebook']);
	$UrlTwitter=$GuruApi->TestInput($_POST['Twitter']);
	$UrlGoogle=$GuruApi->TestInput($_POST['Google']);
	$UrlLinkedIn=$GuruApi->TestInput($_POST['LinkedIn']);

	//Verificamos que sean URL validas
	if ($UrlFacebook!="") {
		if ($GuruApi->TestFacebook($UrlFacebook)==false) {
			header("Location:../data_user?request=Url Facebook No Valida");
		}
	}
	if($UrlTwitter!=""){
		if($GuruApi->TestTwitter($UrlTwitter)==false){
			header("Location:../data_user?request=Url Twitter No Valida");
		}
	}
	if($UrlGoogle!=""){
		if($GuruApi->TestUrl($UrlGoogle)==false){
			header("Location:../data_user?request=Url Google No Valida");
		}
	}
	if ($UrlLinkedIn!="") {
		if($GuruApi->TestUrl($UrlLinkedIn)==false){
			header("Location:../data_user?request=Url LinkedIn No Valida");
		}
	}

	//validamos que los campos obligatorios no estén vacíos
	if (empty($StrProfession) || empty($StrBiografia)) {
		header("Location:../data_user?request=Llene los Campos Obliatorios");
	}else{
		if (strlen($StrProfession)>150) {
			header("Location:../data_user?request=No exceda el limite de caracteres en su Profesión");
		}else{
			//verificamos que el usuario no tenga datos en la tabla
			$SqlValidate=$conexion->query("SELECT Vc_Profesion,Txt_Biografia,Txt_Facebook,Txt_Twitter,Txt_Google,Txt_LinkedIn FROM G_Profesion_Usuario WHERE Int_Fk_DatosUsuario=$IdSession");
				if ($SqlValidate->num_rows==0) {
					$SqlInsertData=$conexion->prepare("INSERT INTO G_Profesion_Usuario (Int_Fk_DatosUsuario,Vc_Profesion,Txt_Biografia,Txt_Facebook,Txt_Twitter,Txt_Google,Txt_LinkedIn) VALUES (?,?,?,?,?,?,?) ");
					$SqlInsertData->bind_param("issssss",$IdSession,$StrProfession,$StrBiografia,$UrlFacebook,$UrlTwitter,$UrlGoogle,$UrlLinkedIn);
						if ($SqlInsertData->execute()) {
							header("Location:../data_user?requestok=Datos Insertados Correctamente");
						}else{
							header("Location:../data_user?request=Hubo un Error, Intente más Tarde");
						}
				}else{
					$SqlInsertData=$conexion->prepare("UPDATE G_Profesion_Usuario SET Vc_Profesion=?,Txt_Biografia=?,Txt_Facebook=?,Txt_Twitter=?,Txt_Google=?,Txt_LinkedIn=? WHERE  Int_Fk_DatosUsuario = ?");
					$SqlInsertData->bind_param("ssssssi",$StrProfession,$StrBiografia,$UrlFacebook,$UrlTwitter,$UrlGoogle,$UrlLinkedIn,$IdSession);
						if ($SqlInsertData->execute()) {
							header("Location:../data_user?requestok=Datos Actualizados Correctamente");
						}else{
							header("Location:../data_user?request=Hubo un Error, Intente más Tarde");
						}
				}
		}
	}
?>