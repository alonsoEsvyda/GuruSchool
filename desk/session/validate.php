<?php
include('session_parameters.php');
require_once '../class/functions.php';
$GuruApi= new GuruApi();
$token=$_POST['auth_token'];
$NameSession="";
	//aquí validamos de donde proviene el token, para que no se confundan las variables de sesión que se crean
	if (isset($_POST['button-lg'])) {//validamos que se presionó el botón de la versión escritorio
		$NameSession="send_message";
	}else if(isset($_POST['button-res'])){//validamos que se presionó el botón de la versión móvil
		$NameSession="send_message2";
	}
	$ValidToken=$GuruApi->verifyFormToken($NameSession, $token, 300);
	if (!$ValidToken) {
	   session_destroy();//destruimos la sesión
	   $parametros_cookies = session_get_cookie_params();// traemos lo que contenga la cookie
	   setcookie(session_name(),0,1,$parametros_cookies["path"],null, null, true);// destruimos la cookie
	   session_start();
	   session_regenerate_id(true);
	   header("Location:../../iniciar-sesion?request=Tu token no es valido. Intenta de nuevo.&email=".$StrMail);
	   exit();
	}else{
		if ($_POST['email']=="" || $_POST['password']=="" ) {
			header("Location:../../iniciar-sesion?request=inserta texto");
		}else{
			$StrMail=$GuruApi->TestInput($_POST['email']);
			$StrPass=$GuruApi->TestInput($_POST['password']);

			if (is_string($StrMail) && is_string($StrPass)) {
				if ($GuruApi->TestMail($StrMail)) {
					$SqlGetDate = $conexion->prepare("SELECT Id_Pk_Usuario,Vc_Correo,Vc_Password,Int_NivelUsuario FROM G_Usuario WHERE Vc_Correo= ? ");//preparamos la consulta
					$SqlGetDate->bind_param("s", $StrMail);//asignamos el parametro
					$SqlGetDate->execute();//ejecutamos la consulta
					$SqlGetDate->store_result();//traemos el conjunto de resultados
					if ($NumRows = $SqlGetDate->num_rows==0) {//validamos si la consulta no trajo ningún registro
						header("Location:../../iniciar-sesion?request=Usuario Invalido");
					}else{
						$SqlGetDate->bind_result($idBd,$MailBd,$PassBd,$NivelBd);//Asignamos variables a la consulta parametrizada
						while ($SqlGetDate->fetch()) {
							if (password_verify($StrPass,$PassBd)) {
								if ($NivelBd==1) {
									//Traemos la Ip Real del Usuario
									$Ip=$GuruApi->getRealIP();
									//Creamos la sesión
									$_SESSION['Data']=array('Id_Usuario' => $idBd, 'Ipuser' => $Ip, 'navUser' => $_SERVER["HTTP_USER_AGENT"], 'hostUser' => gethostbyaddr($Ip), 'Tiempo'=>date("Y-n-j H:i:s"));
				                    header("Location:../user");
								}else if ($NivelBd==0) {
									header("Location:../../iniciar-sesion?request=Error");	
								}
							}else{
								header("Location:../../iniciar-sesion?request=Contraseña no coincide&email=".$StrMail);
							}
						}
					}
				}else{
					header("Location:../../iniciar-sesion?request=Inserta un Correo Valido");
				}
			}else{
				header("Location:../../iniciar-sesion?request=Inserta texto valido");
			}
		}
	}
/**/
?>