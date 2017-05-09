<?php
	include('session_parameters.php');
	include("../class/functions.php");
	//llamamos la clase GuruApi
	$GuruApi= new GuruApi();
	//Traemos la Ip Real del Usuario
	$Ip=$GuruApi->getRealIP();
	//DEFINO VARIABLES
	$StrMail=$_SESSION['Data_Facebook']['email'];
	$Nivel=1;
	//DEFINO VARIABLES
	$SqlGetDate=$conexion->prepare("SELECT Id_Pk_Usuario,Vc_Correo,Vc_Password,Int_NivelUsuario FROM G_Usuario WHERE Vc_Correo= ?");
	$SqlGetDate->bind_param("s", $StrMail);
	$SqlGetDate->execute();
	$SqlGetDate->store_result();
	if ($NumRows = $SqlGetDate->num_rows!=0) {
		$SqlGetDate->bind_result($idBd,$MailBd,$PassBd,$NivelBd);//Asignamos variables a la consulta parametrizada
			if ($PassBd!="" || $PassBd!=NULL) {
				header("Location:../../iniciar-sesion.php?request=Inicie con la contraseña de su usuario");
			}else{
				while ($SqlGetDate->fetch()) {
					if ($NivelBd==1) {
						//Creamos la sesión
						$_SESSION['Data']=array('Id_Usuario' => $idBd, 'Ipuser' => $Ip, 'navUser' => $_SERVER["HTTP_USER_AGENT"], 'hostUser' => gethostbyaddr($Ip),'Tiempo'=>time());
	                    header("Location:../user.php?request=lo lograste");
					}else if ($NivelBd==0) {
						echo "Continuará";
					}
				}
			}
	}else{
		$SqlInsert = $conexion->prepare("INSERT INTO G_Usuario (Vc_Correo,Int_NivelUsuario) VALUES (?,?)");
	    $SqlInsert->bind_param("ss", $StrMail, $Nivel);
	    if ($SqlInsert->execute()) {
			//Creamos las sesión
			$_SESSION['Data']=array('Id_Usuario' => $idBd, 'Ipuser' => $Ip, 'navUser' => $_SERVER["HTTP_USER_AGENT"], 'hostUser' => gethostbyaddr($Ip) );
            header("Location:../user.php");
	    }else{
	    	header("Location:../../index.php?request=error usuario");
	    }	
	}

?>