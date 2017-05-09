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

	//antes de realizar cualquier acción, validamos si el usuario pertenece a Colombia
	$SessionId=$_SESSION['Data']['Id_Usuario'];
	$SqlValidateCountry=$conexion->query("SELECT Vc_Pais,Int_Cedula FROM G_Datos_Usuario WHERE Int_Fk_IdUsuario = $SessionId");
	$NumberRegist=$SqlValidateCountry->num_rows;
	if ($NumberRegist==0) {
		header("Location:../data_user?request=Usted no tiene un pais de procedencia");
	}else{
		$Country=$SqlValidateCountry->fetch_array();
		if ($Country['Vc_Pais']=="Colombia") {
			//Definimos las Variables
			if ($_POST['Banco']=="Efecty") {
				$IntAccount=$Country['Int_Cedula'];
				$StrBank="Quiero Recibir Pagos por Efecty";
			}else{
				$IntAccount=$GuruApi->TestInput($_POST['Cuenta']);
				$StrBank=$GuruApi->TestInput($_POST['Banco']);
			}

			if (empty($StrBank) || empty($IntAccount)) {
				header("Location:../data_user?request=Llene todos los Campos de su Cuenta");
			}else{
				if (strlen($IntAccount)>12) {
					header("Location:../data_user?request=Cuenta demasiado Larga");
				}else if (strlen($StrBank)>50){
					header("Location:../data_user?request=Nombre del Banco muy Largo");
				}else{
					//Ciframos la cuenta para guardarla en la base de datos
					$CryptAccount=$GuruApi->StringEncode($IntAccount);
					//Creamos una consulta para extraer los datos que hallan en la tabla
					$SqlValidate=$conexion->query("SELECT Vc_Cuenta,Vc_Banco FROM G_Cuenta_Usuario WHERE Int_Fk_DatosUsuario=$SessionId");
						//Verificamos que el usuario no tenga datos guardados en la tabla
						if ($SqlValidate->num_rows==0) {
							$SqlInsertData=$conexion->prepare("INSERT INTO G_Cuenta_Usuario (Int_Fk_DatosUsuario,Vc_Cuenta,Vc_Banco) VALUES (?,?,?) ");
							$SqlInsertData->bind_param("iss", $SessionId,$CryptAccount,$StrBank);
								if ($SqlInsertData->execute()) {
									header("Location:../data_user?requestok=Datos Insertados Correctamente");
								}else{
									header("Location:../data_user?request=Hubo un Error Insertando, Intente más Tarde");
								}
						}else{
							$SqlInsertData=$conexion->prepare("UPDATE G_Cuenta_Usuario SET Vc_Cuenta=?, Vc_Banco=? WHERE  Int_Fk_DatosUsuario = ?");
							$SqlInsertData->bind_param("ssi", $CryptAccount,$StrBank,$SessionId);
								if ($SqlInsertData->execute()) {
									header("Location:../data_user?requestok=Datos Actualizados Correctamente");
								}else{
									header("Location:../data_user?request=Hubo un Error Actualizando, Intente más Tarde");
								}
						}
				}
			}
		}else{
			header("Location:../data_user?request=Usted no es de Colombia");
		}
	}
?>