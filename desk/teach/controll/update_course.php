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

	//Definimos las Variables
	$IdSession=$_SESSION['Data']['Id_Usuario'];
	$StrNombreCurso=$GuruApi->TestInput($_POST['NombreCurso']);
	$StrResumen=$GuruApi->TestInput($_POST['Resumen']);
	$StrDescripcion=$GuruApi->TestInput($_POST['Descripcion']);
	$StrCategoria=$GuruApi->TestInput($_POST['categoria']);
	$StrSubCategoria=$GuruApi->TestInput($_POST['sub-categoria']);
	$UrlVideoYoutube=$GuruApi->TestInput($_POST['VideoYoutube']);
	$StrImagen=$GuruApi->TestInput($_FILES['foto']['name']);
	$StrRadio=$GuruApi->TestInput($_POST['radio']);

	if (empty($StrNombreCurso) || empty($StrResumen) || empty($StrDescripcion) || empty($StrCategoria) || empty($StrSubCategoria) || empty($UrlVideoYoutube)) {
			header("Location:../teacher?request=Llena bien los datos, no juegues con migo :@");
	}else{
		//Saneamos el ID del curso y lo des-encriptamos
		if (!isset($_POST['IdC']) || $_POST['IdC']=="") {
			header("Location:../teacher?request=No Alteres los Datos, te Tenemos Vigilado...");
		}else{
			$IdEncodeCurso=$GuruApi->TestInput($_POST['IdC']);
			$IdCurso=$GuruApi->StringDecode($IdEncodeCurso);
		}
		//estado del curso
		$State="Rechazado";

			//Validamos que el Nombre y el resumen no supere los 100 y 260 caracteres
			if (strlen($StrNombreCurso)>100 || strlen($StrResumen)>260) {
				header("Location:../teacher?request=Número de Caracteres Superado, revise Nombre o Descripción");
			}
				//Validamos que valor trae el radio, para definir el precio y tipo de curso
				if ($StrRadio==1){
					//Si es igual a 1, el precio es 0 y el curso es Gratis
					$IntPrecio=0;
					$StrTipoCurso="Gratis";
				}else if ($StrRadio==0){
					//Si es igual a 0, el precio es el de el Input y el Curso es de Pago
					$IntPrecio=$GuruApi->TestInput($_POST['precio']);
					$StrTipoCurso="De Pago";
				}else{
					//Si trae un valor diferente, redireccionamos
					header("Location:../teacher?request=No Modifique los Campos");
				}
					//Validamos si se insertó una URL de Youtube
					if ($UrlVideoYoutube!="") {
						$StrIdYoutube=$GuruApi->GetIdYoutube($UrlVideoYoutube);
						if ($StrIdYoutube==false) {
							header("Location:../teacher?request=Video No Valido");
						}
					}else{
						$StrIdYoutube=NULL;
					}
						//Traemos el ID de la categoría
		            	$SqlGetCategorie=$conexion->prepare("SELECT Id_Pk_Categorias FROM G_Categorias WHERE Vc_NombreCat= ?");
		            	$SqlGetCategorie->bind_param("s", $StrCategoria);
						//Validamos Que se halla subido una Imagen 
						if ($StrImagen=="") {
			            	if ($SqlGetCategorie->execute()) {
			            		$SqlGetCategorie->store_result();
			            		$SqlGetCategorie->bind_result($IdCategorie);
			            		$SqlGetCategorie->fetch();
			            		//Traemos la imagen actual del Curso
			            		$SqlImage=$conexion->query("SELECT Vc_Imagen_Promocional FROM G_Cursos WHERE Id_Pk_Curso=$IdCurso");
			            		$DataImage=$SqlImage->fetch_array();
				            		//Actualizamos los datos del Curso
					            	$SqlUpdateData=$conexion->prepare("UPDATE G_Cursos SET Int_Fk_IdCat=?,Vc_NombreCurso=?,Vc_ResumenCurso=?,Txt_DescripcionCompleta=?,Vc_Categoria=?,Vc_SubCategoria=?,Vc_VideoPromocional=?,Vc_TipoCurso=?,Int_PrecioCurso=? WHERE Id_Pk_Curso= ? AND Int_Fk_IdUsuario= ? AND Vc_EstadoCurso= ?");
					            	$SqlUpdateData->bind_param("isssssssiiis", $IdCategorie,$StrNombreCurso,$StrResumen,$StrDescripcion,$StrCategoria,$StrSubCategoria,$StrIdYoutube,$StrTipoCurso,$IntPrecio,$IdCurso,$IdSession,$State);
					            	if ($SqlUpdateData->execute()) {
						                header("Location:../update_course/".$IdCurso);
					            	}else{
					            		header("Location:../teacher?request=Hubo un Error, Intente Más Tarde");
					            	}
			            	}else{
			            		header("Location:../teacher?request=Hubo un Error, Intente Un Poco Más Tarde");
			            	}
						}else{
							// Primero, hay que validar que se trata de un JPG/GIF/PNG
					        $allowedExts = array("jpg", "jpeg", "gif", "png", "JPG", "GIF", "PNG");
					        $extension = end(explode(".", $_FILES["foto"]["name"]));
					        if ((($_FILES["foto"]["type"] == "image/gif")
					                || ($_FILES["foto"]["type"] == "image/jpeg")
					                || ($_FILES["foto"]["type"] == "image/png")
					                || ($_FILES["foto"]["type"] == "image/pjpeg"))
					                && in_array($extension, $allowedExts)) {
					            // el archivo es un JPG/GIF/PNG, entonces...
					            //limpiamos la imagen y la nombramos
					        	$FotoOriginal=$GuruApi->TestInput($_FILES['foto']['name']);
					        	$CleanFoto=str_replace(' ', '_',$FotoOriginal);
					        	$CleanSigns=preg_replace('/[¿!¡;,:?#@()"]/','_',$CleanFoto);
					        	$time = time();
					            $foto = $time."_".$CleanSigns;
					            $directorio = "../../img_user/Cursos_Usuarios/"; // directorio de tu elección
					            
					            // almacenar imagen en el servidor
					            $ResFoto = 'Res_Curso_'.$foto;
					            if(file_exists($directorio.$ResFoto)){
					            	header("Location:../teacher?request=Ya existe esta Imagen en el Servidor");
					            }else{
					            	//Traemos el ID de la categoría
					            	if ($SqlGetCategorie->execute()) {
					            		$SqlGetCategorie->store_result();
					            		$SqlGetCategorie->bind_result($IdCategorie);
					            		$SqlGetCategorie->fetch();
					            		//Traemos la imagen actual del Curso
					            		$SqlImage=$conexion->query("SELECT Vc_Imagen_Promocional FROM G_Cursos WHERE Id_Pk_Curso=$IdCurso");
					            		$DataImage=$SqlImage->fetch_array();
					            		//la borramos del directorio actual
					            		if (unlink($directorio.$DataImage['Vc_Imagen_Promocional'])) {
						            		//Actualizamos los datos del Curso
							            	$SqlUpdateData=$conexion->prepare("UPDATE G_Cursos SET Int_Fk_IdCat=?,Vc_NombreCurso=?,Vc_ResumenCurso=?,Txt_DescripcionCompleta=?,Vc_Categoria=?,Vc_SubCategoria=?,Vc_VideoPromocional=?,Vc_Imagen_Promocional=?,Vc_TipoCurso=?,Int_PrecioCurso=? WHERE Id_Pk_Curso= ? AND Int_Fk_IdUsuario= ? AND Vc_EstadoCurso= ?");
							            	$SqlUpdateData->bind_param("issssssssiiis", $IdCategorie,$StrNombreCurso,$StrResumen,$StrDescripcion,$StrCategoria,$StrSubCategoria,$StrIdYoutube,$ResFoto,$StrTipoCurso,$IntPrecio,$IdCurso,$IdSession,$State);
							            	if ($SqlUpdateData->execute()) {
							            		//movemos la imagen al directorio
							            		move_uploaded_file($_FILES['foto']['tmp_name'], $directorio.$foto);
							            		//redimensionamos la imagen
						                		$GuruApi->resizeImagen($directorio, $foto, 530, 999,$ResFoto,$extension);
						                		//borramos la imagen del directorio
								                unlink($directorio.$foto);
								                //redireccionamos al usuario
								                header("Location:../update_course/".$IdCurso);
							            	}else{
							            		header("Location:../teacher?request=Hubo un Error, Intente Más Tarde");
							            	}
						            	}else{
						            		header("Location:../teacher?request=Hubo un Error, Intente Más Tarde, lo Siento.");
						            	}
					            	}else{
					            		header("Location:../teacher?request=Hubo un Error, Intente Un Poco Más Tarde");
					            	}
					            }
					        } else { // El archivo no es JPG/GIF/PNG
					            $malformato = $_FILES["foto"]["type"];
					            header("Location:../teacher?request=imagen: ".$malformato." con Formato Incorrecto");
					            exit;
				          	}
						}
	}
?>