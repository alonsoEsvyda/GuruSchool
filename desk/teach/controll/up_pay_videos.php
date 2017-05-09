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
	if (!isset($_POST['IdC']) || $_POST['IdC']=="" || $_POST['NameVideo']=="" || $_FILES['VideoArchivo']['name']=="") {
		echo false;
	}else{
		//Verificamos que no exceda el limite de caracteres
		if (strlen($_POST['NameVideo'])>100) {
			echo false;
		}else{
			//DesEncriptamos el IdC
			$IdEncode=$_POST['IdC'];
			$IdDecode=$GuruApi->StringDecode($IdEncode);
			//Definimos las Variables y las Sanamos
			$IdSession=$_SESSION['Data']['Id_Usuario'];
			$IdCurso=$GuruApi->TestInput($IdDecode);
			$StrName=$GuruApi->TestInput($_POST['NameVideo']);
			$StrVideo=$GuruApi->TestInput($_FILES['VideoArchivo']['name']);
			$StrType="De Pago";
				//verificamos que el curso sea De Pago
				$SqlValidateFree=$conexion->prepare("SELECT Vc_TipoCurso FROM G_Cursos WHERE Id_Pk_Curso= ? AND Vc_TipoCurso=? AND Int_Fk_IdUsuario= ? ");
				$SqlValidateFree->bind_param("isi", $IdCurso,$StrType,$IdSession);
				$SqlValidateFree->execute();
				$SqlValidateFree->store_result();
				if ($SqlValidateFree->num_rows==0) {
					echo false;
				}else{
					//verificamos que sea un archivo relacionado con estas extensiones
					$valid_exts = array('mp4', 'webm', 'ogv');
   					$extension = end(explode(".", $StrVideo));
					if ((($_FILES["VideoArchivo"]["type"] == "video/mp4") || ($_FILES["VideoArchivo"]["type"] == "video/webm") || ($_FILES["VideoArchivo"]["type"] == "video/ogv")) && in_array($extension, $valid_exts)){
						//Verificamos que el tamaño del archivo no exceleda el limite
						$SizeVideo=$GuruApi->SizeFile($_FILES['VideoArchivo']['size']);
						if ($SizeVideo==true) {
							//Creamos el Nombre del Vídeo
							$time = time();
							$NombreConEspacios = str_replace(' ','-',$StrName);
							//limpiamos el nombre de caracteres especiales
							$NombreLimpio = preg_replace('/[¿!¡;,:?#@()"]/','_',$NombreConEspacios);
    						$NameVideoFile = "{$NombreLimpio}_$time.$extension";
							//Insertamos el Vídeo
							$SqlInsertVideo=$conexion->prepare("INSERT INTO G_Videos_Curso (Int_Fk_IdCurso,Txt_NombreVideo,Vc_VideoArchivo) VALUES(?,?,?)");
							$SqlInsertVideo->bind_param("iss", $IdCurso,$StrName,$NameVideoFile);
								if ($SqlInsertVideo->execute()) {
									//Movemos el Archivo a la Carpeta Correspondiente
									move_uploaded_file($_FILES['VideoArchivo']['tmp_name'], "../../videos_user/$NameVideoFile");
									//sacamos el último Id Insertado
									$SqlGetVideoId=$conexion->query("SELECT MAX(Id_Pk_VideosCurso) as IdVideo FROM G_Videos_Curso");
									if ($SqlGetVideoId){
										$Get=$SqlGetVideoId->fetch_array();
										$IdVideo=$GuruApi->StringEncode($Get['IdVideo']);
										$Array=array($IdVideo,$NameVideoFile);
										//enviamos un objeto json
										echo json_encode($Array);
									}else{
										echo false;
									}
								}
						}else{
							echo false;
						}
					}else{
						echo false;
					}
				}
		}
	}
?>