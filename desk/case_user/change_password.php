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

	//definimos las variables y las sanamos
	$StrActualPass=$GuruApi->TestInput($_POST['ActualPass']);
	$NewPass=$GuruApi->TestInput($_POST['NewPass']);
	$RepeatPass=$GuruApi->TestInput($_POST['RepeatPass']);
	if (empty($StrActualPass) || empty($NewPass) || empty($RepeatPass)) {
		header("Location:../security?request=Llene todos los Datos");
	}else{
		//validamos que el password actual sea correcto
		$SQLValidatePass=$conexion->prepare("SELECT Vc_Password FROM G_Usuario WHERE Id_Pk_Usuario = ?");
		$SQLValidatePass->bind_param("i", $_SESSION['Data']['Id_Usuario']);
		$SQLValidatePass->execute();
		$SQLValidatePass->store_result();
		$SQLValidatePass->bind_result($HashPassword);
		$SQLValidatePass->fetch();
		//validamos que la contraseña coincida al hash guardado en la BD
		if (password_verify($StrActualPass,$HashPassword)) {
			//validamos que la contraseña sea igual a la contraseña que se repite
			if ($RepeatPass==$NewPass) {
				//validamos que la contraseña sea seguray cumpla con lo que exige el sistema
				if ($GuruApi->TestPassword($NewPass,"../security")) {
					//convertismo las contraseña nueva a un Hash
					$StrPassHash=$GuruApi->HashPassword($NewPass);
					//Actualizamos la contraseña 
					$SQLUpdate=$conexion->prepare("UPDATE G_Usuario SET Vc_Password = ?  WHERE Id_Pk_Usuario = ? ");
					$SQLUpdate->bind_param("si",$StrPassHash,$_SESSION['Data']['Id_Usuario']);
					//verificamos que se ejecute correctamente la consulta
					if ($SQLUpdate->execute()) {
						header("Location:../security?requestok=Contraseña Actualizada Correctamente");
					}else{
						header("Location:../security?request=Hubo un Error, Intente más Tarde..");
					}
				}
			}else{
				header("Location:../security?request=Campos no Coinciden, Escriba bien la Contraseña");
			}
		}else{
			header("Location:../security?request=Password Actual Incorrecto");
		}
	}
?>