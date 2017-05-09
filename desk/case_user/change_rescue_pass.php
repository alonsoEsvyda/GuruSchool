<?php
	include ("../class/functions.php");

	//Llamamos la clase GuruApi
	$GuruApi = new GuruApi();

	//definimos las variables y las sanamos
	$EmailDecode=$GuruApi->StringDecode($_POST['Key']);
	$StrEmail=$GuruApi->TestInput($EmailDecode);
	$NewPass=$GuruApi->TestInput($_POST['NewPass']);
	$RepeatPass=$GuruApi->TestInput($_POST['RepeatPass']);
	$NewVal=NULL;
		//validamos que la contraseña sea igual a la contraseña que se repite
		if ($RepeatPass==$NewPass) {
			if (strlen($NewPass) < 8) {
				echo false;
			}else if(!preg_match('/(?=\d)/', $NewPass)){
				echo false;
			}else if(!preg_match('/(?=[a-z])/', $NewPass)){
				echo false;
			}else if(!preg_match('/(?=[A-Z])/', $NewPass)){
				echo false;
			}else{
				//convertismo las contraseña nueva a un Hash
				$StrPassHash=$GuruApi->HashPassword($NewPass);
					//Actualizamos la contraseña 
					$SQLUpdate=$conexion->prepare("UPDATE G_Usuario SET Vc_Password = ?  WHERE Vc_Correo = ? ");
					$SQLUpdate->bind_param("ss",$StrPassHash,$StrEmail);
						//verificamos que se ejecute correctamente la consulta
						if ($SQLUpdate->execute()) {
							$SqlDeleteToken=$conexion->prepare("UPDATE G_Usuario SET Vc_Rescue_Token = ?  WHERE Vc_Correo = ? ");
							$SqlDeleteToken->bind_param("ss",$NewVal,$StrEmail);
								if ($SqlDeleteToken->execute()) {
									echo true;
								}else{
									echo false;
								}
						}else{
							echo false;
						}
			}
		}else{
			echo false;
		}
	
?>