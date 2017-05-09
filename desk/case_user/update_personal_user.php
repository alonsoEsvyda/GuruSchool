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

	//definimos las variables y las sanamos
	$ImgPhoto=$GuruApi->TestInput($_FILES['foto']['name']);
	$StrName=$GuruApi->TestInput($_POST['Nombre']);
	$IntDni=$GuruApi->TestInput($_POST['Dni']);
	$StrAge=$GuruApi->TestInput($_POST['Edad']);
	$StrCountry=$GuruApi->TestInput($_POST['Pais']);
	$StrCity=$GuruApi->TestInput($_POST['Ciudad']);
	$IntTelf=$GuruApi->TestInput($_POST['Telefono']);

	//verificamos que los campos no excedan su limite o tengan contenido indebido
	if (strlen($StrName)>100 || is_numeric($StrName) || empty($StrName)) {
		header("Location:../data_user?request=No es un Nombre Valido");
	}else if(strlen($IntDni)>15 || !is_numeric($IntDni) || empty($IntDni)){
		header("Location:../data_user?request=Escribe un Dni Valido");
	}else if (strlen($StrAge)>3 || !is_numeric($StrAge) || empty($StrAge)) {
		header("Location:../data_user?request=Escribe una edad Valida");
	}else if (strlen($IntTelf)>10 || !is_numeric($IntTelf) || empty($IntTelf)) {
		header("Location:../data_user?request=Escribe una Telefono Válido");
	}else if (strlen($StrCountry)>150 || is_numeric($StrCountry) || empty($StrCountry)) {
		header("Location:../data_user?request=Escribe un Pais Valido");
	}else if (strlen($StrCity)>100 || is_numeric($StrCity) || empty($StrCity)) {
		header("Location:../data_user?request=Escribe una Ciudad Valida");
	}else{
		$SessionId=$_SESSION['Data']['Id_Usuario'];
		$SqlValidate=$conexion->query("SELECT Vc_NombreUsuario,Int_Cedula,Int_Edad,Vc_Pais,Vc_Ciudad,Txt_ImagenUsuario,Txt_ImagenMin FROM G_Datos_Usuario WHERE Int_Fk_IdUsuario=$SessionId");
		//verificamos que el usuario no tenga datos guardados
		if ($SqlValidate->num_rows==0) {
			if($ImgPhoto==""){
				header("Location:../data_user?request=Inserte una Imagen");
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
		            $extension = end(explode('.', $_FILES['foto']['name']));
		        	//limpiamos la imagen y la nombramos
		        	$FotoOriginal=$GuruApi->TestInput($_FILES['foto']['name']);
		        	$CleanFoto=str_replace(' ', '_',$FotoOriginal);
		        	$CleanSigns=preg_replace('/[¿!¡;,:?#@()"]/','_',$CleanFoto);
		        	$time = time();
		            $foto = $time."_".$CleanSigns;
		            $directorio = "../img_user/Perfil_Usuarios/"; // directorio de tu elección
		            
		            // almacenar imagen en el servidor
		            $minFoto = 'min_'.$foto;
		            $resFoto = 'res_'.$foto;
		            if (file_exists($directorio.$minFoto)) {
		                header("Location:../data_user?request=Ya existe esta Imagen MIN");
		            }else if(file_exists($directorio.$resFoto)){
		            	header("Location:../data_user?request=Ya existe esta Imagen RES");
		            }else{
		            	//Insertamos los datos del usuario
		            	$SqlUpdateData=$conexion->prepare("INSERT INTO G_Datos_Usuario (Vc_NombreUsuario,Int_Cedula,Int_Edad,Vc_Pais,Vc_Ciudad,Txt_ImagenUsuario,Txt_ImagenMin,Int_Fk_IdUsuario,Vc_Telefono) VALUES (?,?,?,?,?,?,?,?,?) ");
		            	$SqlUpdateData->bind_param("siissssii",$StrName,$IntDni,$StrAge,$StrCountry,$StrCity,$resFoto,$minFoto,$SessionId,$IntTelf);
		            	if ($SqlUpdateData->execute()) {
		            		//movemos la imagen al directorio
		            		move_uploaded_file($_FILES['foto']['tmp_name'], $directorio.$foto);
		            		//redimensionamos la imagen
			                $GuruApi->resizeImagen($directorio, $foto, 160, 172,$minFoto,$extension);
	                		$GuruApi->resizeImagen($directorio, $foto, 377, 291,$resFoto,$extension);
	                		//borramos la imagen del directorio
			                unlink($directorio.$foto);
			                //redireccionamos al usuario
			                header("Location:../data_user?requestok=Datos Actualizados Correctamente");
		            	}else{
		            		header("Location:../data_user?request=Intente Más Tarde");
		            	}
		            }
		        } else { // El archivo no es JPG/GIF/PNG
		            $malformato = $_FILES["foto"]["type"];
		            header("Location: ../data_user?request=imagen: ".$malformato." con Formato Incorrecto");
		            exit;
	          	}
			}
		//si ya tiene datos, actualizamos	
		}else{
			if($ImgPhoto==""){
				$SqlUpdateData=$conexion->prepare("UPDATE G_Datos_Usuario SET Vc_NombreUsuario=?,Int_Cedula=?,Int_Edad=?,Vc_Pais=?,Vc_Ciudad=?,Vc_Telefono=? WHERE Int_Fk_IdUsuario = ?");
            	$SqlUpdateData->bind_param("siissii",$StrName,$IntDni,$StrAge,$StrCountry,$StrCity,$IntTelf,$SessionId);
            	if ($SqlUpdateData->execute()) {
	                header("Location:../data_user?requestok=Datos Actualizados Correctamente");
            	}else{
            		header("Location:../data_user?request=Intente Más Tarde");
            	}
			}else{
				//traemos los datos de las imagenes actuales de la consulta
				$DataImage=$SqlValidate->fetch_array();
				// Primero, hay que validar que se trata de un JPG/GIF/PNG
		        $allowedExts = array("jpg", "jpeg", "gif", "png", "JPG", "GIF", "PNG");
		        $extension = end(explode(".", $_FILES["foto"]["name"]));
		        if ((($_FILES["foto"]["type"] == "image/gif")
		                || ($_FILES["foto"]["type"] == "image/jpeg")
		                || ($_FILES["foto"]["type"] == "image/png")
		                || ($_FILES["foto"]["type"] == "image/pjpeg"))
		                && in_array($extension, $allowedExts)) {
		            //limpiamos la imagen y la nombramos
		        	$FotoOriginal=$GuruApi->TestInput($_FILES['foto']['name']);
		        	$CleanFoto=str_replace(' ', '_',$FotoOriginal);
		        	$CleanSigns=preg_replace('/[¿!¡;,:?#@()"]/','_',$CleanFoto);
		        	$time = time();
		            $foto = $time."_".$CleanSigns;
		            $directorio = "../img_user/Perfil_Usuarios/"; // directorio de tu elección
		            
		            // almacenar imagen en el servidor
		            $minFoto = 'min_'.$foto;
		            $resFoto = 'res_'.$foto;
		            if (file_exists($directorio.$minFoto)) {
		                header("Location:../data_user?request=Ya existe esta Imagen MIN");
		            }else if(file_exists($directorio.$resFoto)){
		            	header("Location:../data_user?request=Ya existe esta Imagen RES");
		            }else{
	            		if (unlink($directorio.$DataImage['Txt_ImagenUsuario']) && unlink($directorio.$DataImage['Txt_ImagenMin'])) {
			            	//Actualizamos los datos
			            	$SqlUpdateData=$conexion->prepare("UPDATE G_Datos_Usuario SET Vc_NombreUsuario=?,Int_Cedula=?,Int_Edad=?,Vc_Pais=?,Vc_Ciudad=?,Txt_ImagenUsuario=?,Txt_ImagenMin=?,Vc_Telefono=? WHERE Int_Fk_IdUsuario = ? ");
			            	$SqlUpdateData->bind_param("siissssii",$StrName,$IntDni,$StrAge,$StrCountry,$StrCity,$resFoto,$minFoto,$IntTelf,$SessionId);
			            	//ejecutamos la consulta
			            	if ($SqlUpdateData->execute()) {
			            		//guardamos la imagen en la carpeta
			            		move_uploaded_file($_FILES['foto']['tmp_name'], $directorio.$foto);
			            		//redimensionamos las imagenes
				                $GuruApi->resizeImagen($directorio, $foto, 160, 172,$minFoto,$extension);
		                		$GuruApi->resizeImagen($directorio, $foto, 377, 291,$resFoto,$extension);
		                		//borramos la imagen del directorio
				                unlink($directorio.$foto);
				                //redireccionamos al usuario
				                header("Location:../data_user?requestok=Datos Actualizados Correctamente");
			            	}else{
			            		header("Location:../data_user?request=Intente Más Tarde");
			            	}
			            }else{
			            	header("Location:../data_user?request=Hubo un Error, Intente Más Tarde");
			            }
		            }
		        } else { // El archivo no es JPG/GIF/PNG
		            $malformato = $_FILES["foto"]["type"];
		            header("Location: ../data_user?request=imagen: ".$malformato." con Formato Incorrecto");
		            exit;
	          	}
			}
		}
	}

?>