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

	//Verificamos que venga algo en el IdC
	if (!isset($_POST['IdC']) || $_POST['IdC']=="" || $_POST['NameVideo']=="" || $_POST['UrlYoutube']=="") {
		echo false;
	}else{
		//Verificamos que no excedan el limite de caracteress
		if (strlen($_POST['NameVideo'])>100 || strlen($_POST['UrlYoutube'])>100) {
			echo false;
		}else{
			//DesEncriptamos el IdC
			$IdEncode=$_POST['IdC'];
			$IdDecode=$GuruApi->StringDecode($IdEncode);
				//Definimos las Variables y las Sanamos
				$IdSession=$_SESSION['Data']['Id_Usuario'];
				$IdCurso=$GuruApi->TestInput($IdDecode);
				$StrName=$GuruApi->TestInput($_POST['NameVideo']);
				$StrUrl=$GuruApi->TestInput($_POST['UrlYoutube']);
				$StrType="Gratis";
					//verificamos que el curso sea Grátis
					$SqlValidateFree=$conexion->prepare("SELECT * FROM G_Cursos WHERE Id_Pk_Curso= ? AND Vc_TipoCurso=? AND Int_Fk_IdUsuario= ? ");
					$SqlValidateFree->bind_param("isi", $IdCurso,$StrType,$IdSession);
					$SqlValidateFree->execute();
					$SqlValidateFree->store_result();
					if ($SqlValidateFree->num_rows==0) {
						echo false;
					}else{
						//Verificamos que la URL de Youtube sea Correcta y traemos el ID del vídeo
						$StrIdYoutube=$GuruApi->GetIdYoutube($StrUrl);
						if ($StrIdYoutube==false) {
							echo false;
						}else{
							//Insertamos el Vídeo
							$SqlInsertVideo=$conexion->prepare("INSERT INTO G_Videos_Curso (Int_Fk_IdCurso,Txt_NombreVideo,Vc_VideoArchivo) VALUES (?,?,?)");
							$SqlInsertVideo->bind_param("iss", $IdCurso,$StrName,$StrIdYoutube);
							if ($SqlInsertVideo->execute()) {
								//sacamos el último Id Insertado
								$SqlGetVideoId=$conexion->query("SELECT MAX(Id_Pk_VideosCurso) as IdVideo FROM G_Videos_Curso");
								if ($SqlGetVideoId){
									$Get=$SqlGetVideoId->fetch_array();
									echo $GuruApi->StringEncode($Get['IdVideo']);
								}else{
									echo false;
								}
							}
						}
					}
		}
	}

?>