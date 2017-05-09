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
	$ValidateSession = $ValidateData->ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,"http://localhost/GuruSchool/iniciar-sesion");

	//llamamos a la clase Questions
    $Forum= new Forum();
    $IdEncode=$GuruApi->StringDecode($_POST['DataToken']);
    $ValidateQuestions=$Forum->ValidateQuestions($IdEncode,$_SESSION['Data']['Id_Usuario']);
    //validamos que el curso sea mio yq ue exista el id
    if ($ValidateQuestions==false) {
      echo json_encode(false);
    }else{
    	if (!isset($_POST['Tittle']) || $_POST['Tittle']=="" || !isset($_POST['Question']) || $_POST['Question']=="" ) {
			echo json_encode(false);
		}else{
			//definimos las variables y las sanamos
			$IdCourse=$GuruApi->TestInput($IdEncode);
			$Tittle=$GuruApi->TestInput($_POST['Tittle']);
			$Question=$GuruApi->TestInput($_POST['Question']);
			$IdUser=$_SESSION['Data']['Id_Usuario'];
				//validamos que los input no sobrepasen el limite de caracteres
				if (strlen($Tittle)>100 || strlen($Question)>400) {
					echo json_encode(false);
				}else{
					//insertamos la pregunta en la tabla
					$InsertQuest=$conexion->prepare("INSERT INTO G_Foro_Curso (Int_Fk_IdCurso,Int_Usuario,Vc_Pregunta,Txt_DescripcionPregunta) VALUES(?,?,?,?) ");
					$InsertQuest->bind_param("iiss", $IdCourse,$IdUser,$Tittle,$Question);
					if ($InsertQuest->execute()) {
						//traemos el Id de la pregunta
						$SqlGetLastId=$conexion->prepare("SELECT MAX(Id_Pk_ForoCurso) AS IdQuestion FROM G_Foro_Curso WHERE Int_Fk_IdCurso = ?");
						$SqlGetLastId->bind_param("i",$IdCourse);
						$SqlGetLastId->execute();
						$SqlGetLastId->store_result();
						$SqlGetLastId->bind_result($IdQuestion);
						$SqlGetLastId->fetch();
						//Traemos el nombre del usuario que pública y los datos del mismo
						$SqlGetUser=$conexion->prepare("SELECT Vc_NombreUsuario, Txt_ImagenMin FROM G_Datos_Usuario WHERE Int_Fk_IdUsuario = ?");
						$SqlGetUser->bind_param("i", $IdUser);
						$SqlGetUser->execute();
						$SqlGetUser->store_result();
						$SqlGetUser->bind_result($NameUser,$ImageUser);
						$SqlGetUser->fetch();
						//creamos el array para convertirlo a formato json
						$Array=array($IdQuestion,$NameUser,$ImageUser,$Tittle);
						//enviamos un objeto json
						echo json_encode($Array);
					}else{
						echo json_encode(false);
					}
				}
		}
    }
?>