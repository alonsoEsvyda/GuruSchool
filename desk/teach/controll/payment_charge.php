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

	//recibimos las variables y las sanamos
	$DataDecode=$GuruApi->StringDecode($_POST['Data']);
	$IdCourseSane=$GuruApi->TestInput($DataDecode);
	$IdUser=$_SESSION['Data']['Id_Usuario'];
	$Date=date("Y-m-d");
	$StateCharge="Pending";
			//verificamos que el id exista en la tabla de pagos usuarios
			$SqlValidateUser=$conexion->prepare("SELECT Int_Id_Curso FROM Pagos_Usuarios WHERE Int_Id_Curso= ?");
			$SqlValidateUser->bind_param("i",$IdCourseSane);
			$SqlValidateUser->execute();
			$SqlValidateUser->store_result();
				if ($SqlValidateUser->num_rows==0) {
					echo false;
				}else{
					//sacamos el monto a cobrar de la tabla
					$SqlGetAmount=$conexion->prepare("SELECT Int_MontoCurso FROM Pagos_Usuarios WHERE Int_Fk_GUsuario=? AND Int_Id_Curso= ? ");
					$SqlGetAmount->bind_param("ii",$IdUser,$IdCourseSane);
					$SqlGetAmount->execute();
					$SqlGetAmount->store_result();
					$SqlGetAmount->bind_result($IntAmmount);
					$SqlGetAmount->fetch();
						//validamos que el monto sea mayor a 400 mil
						if ($IntAmmount>=400000) {
							$IntNumberPay=time().rand(1,9999);
							//Insertamos el monto en las tablas de cobros
							$SqlInsertData=$conexion->prepare("INSERT INTO Cobros_Usuarios (Int_Fk_GUsuario,Int_Id_Curso,Int_MontoCobrado,Vc_EstadoCobro,Da_FechaCobro,Int_NumerPay) VALUES (?,?,?,?,?,?)");
							$SqlInsertData->bind_param("iiissi",$IdUser,$IdCourseSane,$IntAmmount,$StateCharge,$Date,$IntNumberPay);
							if ($SqlInsertData->execute()) {
								//borramos los datos de las tablas de pagos
								$SqlDeleteDataUser=$conexion->prepare("DELETE FROM Pagos_Usuarios WHERE Int_Id_Curso=? AND Int_Fk_GUsuario=?");
								$SqlDeleteDataUser->bind_param("ii",$IdCourseSane,$IdUser);
								if ($SqlDeleteDataUser->execute()) {
									echo true;
								}else{
									echo false;
								}
							}else{
								echo false;
							}
						}else{
							echo false;
						}
				}	
?>