<?php
require_once '../class/functions.php';

if ($_POST['email']=="" || $_POST['password']=="" ) {
	header("Location:../../index?request=inserta texto");
}else{
	$GuruApi= new GuruApi();
	$StrMail=$GuruApi->TestInput($_POST['email']);
	$StrPass=$GuruApi->TestInput($_POST['password']);

	//seteamos el contenido de las variables que nos pasan por POST
	if (is_string($StrMail) && is_string($StrPass)) {
		//validamos que la contraseña sea correcta
		if ($GuruApi->TestPassword($StrPass,"../../index")) {
			//validamos que halla llegado un correo valido
			if ($GuruApi->TestMail($StrMail)) {
					$SqlCompare = $conexion->prepare("SELECT Vc_Correo FROM G_Usuario WHERE Vc_Correo= ? ");//preparamos la consulta
					$SqlCompare->bind_param("s", $StrMail);//asignamos el parametro
					if ($SqlCompare->execute()) {//ejecutamos la consulta
						$SqlCompare->store_result();//traemos el conjunto de resultados
						if ($NumRows = $SqlCompare->num_rows!=0) {//verificamos si el número de filas es diferente de 0
							header("Location:../../iniciar-sesion?request=Correo Existe, inicie sesión&email=".$StrMail);
						}else{
							$EncodePass=$GuruApi->HashPassword($StrPass);
							$nivel=1;
							$SqlInsert = $conexion->prepare("INSERT INTO G_Usuario (Vc_Correo,Vc_Password,Int_NivelUsuario) VALUES (?, ?, ?)");
						    $SqlInsert->bind_param("sss", $StrMail, $EncodePass, $nivel);
						    if ($SqlInsert->execute()) {
						    	header("Location:../../iniciar-sesion?requestok=Inicia Sesión&email=".$StrMail);
						    }else{
						    	header("Location:../../index?request=error");
						    }	
						}
					}else{
						echo $conexion->error;
					}
			}else{
				header("Location:../../index?request=Inserta un Correo Valido");
			}
		}
	}else{
		header("Location:../../index?request=Inserta texto valido");
	}
	
}
?>