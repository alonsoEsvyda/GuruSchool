<?php
include('../session/session_parameters.php');
include ("../class/functions.php");
	//validamos el tiempo de vida de la sesión
	if (!isset($_SESSION['Data']['Tiempo'])) {
	    echo true;
	}else{
		$InicioSesion=$_SESSION['Data']['Tiempo'];
	    $TiempoActual = date("Y-n-j H:i:s"); 
	    $TiempoTotal=(strtotime($TiempoActual)-strtotime($InicioSesion)); 
	    if ($TiempoTotal>=900) {
	      echo 1;
	    }else{
	    	//Validamos que se hallan enviado datos por Post
			if (!isset($_POST['Id'])|| $_POST['Id']=="") {
				echo 0;
			}else{
				//validamos que exista la sesión primeramente
				if (isset($_SESSION['Data']['Id_Usuario'])) {
					//Traemos la IP verdadera del Usuario y Verificamos que las variables de sesión concuerden con la ip, servidor y navegador actual del usuario.
					$GuruApi= new GuruApi();
					$Ip=$GuruApi->getRealIP();
					//Decodificamos el Id del Curso y definimos la variable del Id del Usuario
					$IdDecode=$GuruApi->StringDecode($_POST['Id']);
					$IdCourse=$GuruApi->TestInput($IdDecode);
					$IdUser=$_SESSION['Data']['Id_Usuario'];
					//Validamos que las credenciales sean correctas
					if ($_SESSION['Data']['navUser'] != $_SERVER['HTTP_USER_AGENT'] or 
						$_SESSION['Data']['Ipuser'] != $Ip or 
						$_SESSION['Data']['hostUser'] != gethostbyaddr($Ip)) 
					{
					   //Si no son iguales, se destruye la sesión
					   session_destroy();//destruimos la sesión
					   $parametros_cookies = session_get_cookie_params();// traemos lo que contenga la cookie
					   setcookie(session_name(),0,1,$parametros_cookies["path"]);// destruimos la cookie
					   session_start();
					   session_regenerate_id(true);
					   echo true;
					}else{
						//validamos que el usuario halla llenado sus datos personales principales
						$SqlGetData=$conexion->prepare("SELECT a.Vc_NombreUsuario,a.Int_Cedula,a.Int_Edad,a.Vc_Pais,a.Vc_Ciudad,b.Vc_Correo FROM G_Datos_Usuario AS a INNER JOIN G_Usuario AS b ON a.Int_Fk_IdUsuario=b.Id_Pk_Usuario WHERE a.Int_Fk_IdUsuario = ?");
						$SqlGetData->bind_param("i", $IdUser);
						$SqlGetData->execute();
						$SqlGetData->store_result();
						$SqlGetData->bind_result($Name,$Dni,$Age,$Country,$City,$MailUser);
						$SqlGetData->fetch();
						if ($Name == NULL or $Dni == NULL or $Age == NULL or $Country == NULL or $City == NULL ){
							echo false;
						}else{
							//Validamos si el usuario ya está inscrito en ese curso
							$ValidCouserUser=$conexion->prepare("SELECT Int_Fk_IdCurso,Int_Fk_IdUsuario FROM G_Usuarios_Cursos WHERE Int_Fk_IdCurso= ? AND Int_Fk_IdUsuario = ? ");
							$ValidCouserUser->bind_param("ii", $IdCourse,$IdUser);
							$ValidCouserUser->execute();
							$ValidCouserUser->store_result();
							if ($ValidCouserUser->num_rows > 0) {
								echo '<center>
										<i style="font-weight:100; font-size:130px; color:#C9DAE1;" class="fa fa-thumbs-o-up" aria-hidden="true"></i><br><br>
				                        <h2 class="h1-light black-gray">!Usted Ya está en este Curso¡</h2><br>
				                        <h4 class="semi-gray">Vamos, continuemos</h4><br>
				                        <button type="button" class="buttongray btn btn-secondary" value="no" data-dismiss="modal">cancelar</button>	
				                        <a class="btn btn-default" href="classroom/player/'.$IdCourse.'/">Click Aquí</a>
				                    </center>';
							}else{
								//caso contrario verificamos si el curso es grátis o de pago y traemos los datos
								$GetTypeCourse=$conexion->prepare("SELECT Vc_TipoCurso,Int_PrecioCurso,Vc_NombreCurso,Int_Fk_IdUsuario FROM G_Cursos WHERE Id_Pk_Curso = ? ");
								$GetTypeCourse->bind_param("i", $IdCourse);
								$GetTypeCourse->execute();
								$GetTypeCourse->store_result();
								$GetTypeCourse->bind_result($StrTypeCourse,$IntPrecio,$NameCourse,$IdUserSeller);
								$GetTypeCourse->fetch();
								if ($StrTypeCourse=="Gratis") {
									//insertamos en la tabla de de cursos del usuario
									$GetDataCourse=$conexion->prepare("SELECT Txt_NombreVideo FROM G_Videos_Curso WHERE Int_Fk_IdCurso= ? ");
									$GetDataCourse->bind_param("i", $IdCourse);
									$GetDataCourse->execute();
									$GetDataCourse->store_result();
									$GetDataCourse->bind_result($StrNameVideo);
									$StateVideo="Incompleto";
										while ($GetDataCourse->fetch()) {
											$InsertCourse=$conexion->prepare("INSERT INTO G_Usuarios_Cursos (Int_Fk_IdCurso,Int_Fk_IdUsuario,Vc_NombreVideo,Vc_EstadoVideo) 
																				VALUES (?,?,?,?)");
											$InsertCourse->bind_param("ssss", $IdCourse,$IdUser,$StrNameVideo,$StateVideo);
											$InsertCourse->execute();
										}
				                    	echo '
				                    		<center>
												<i style="font-weight:100; font-size:130px; color:#C9DAE1;" class="fa fa-smile-o" aria-hidden="true"></i><br><br>
												<h2 class="h1-light black-gray">!Te Haz Apuntado Correctamente¡</h2><br>
												<h4 class="semi-gray">Empecemos!!!</h4><br>
												<button type="button" class="buttongray btn btn-secondary" value="no" data-dismiss="modal">cancelar</button>	
						                        <a class="btn btn-default" href="classroom/player/'.$IdCourse.'/">Click Aquí.</a><br>
						                    </center>';
										
								}else if($StrTypeCourse=="De Pago"){
								  $merchant=546832;
								  $apikey="rpfLb9n4HOXWxn0Z7RHGs1bt6v";
								  $referencecode=time().rand(1,9999);
								  $amount=$IntPrecio;
								  $description=$NameCourse;
								  $currency="COP";
								  $cifrado=md5($apikey."~".$merchant."~".$referencecode."~".$amount."~".$currency);
								  //insertamos los datos relevantes en la BD, en la tabla Cursos_PorPagar
								  $InsertPurchase=$conexion->prepare("INSERT INTO Historial_Pagos (Vc_Reference_Sale,Txt_NameCourse,Int_MontoCurso,Vc_Nickname_Buyer,Vc_Email_Buyer,	Int_Id_UsuarioVende,Int_Id_CursoComprado,Int_Id_UsuarioCompro) VALUES ('".$referencecode."','".$description."','".$amount."','".$Name."','".$MailUser."','".$IdUserSeller."','".$IdCourse."','".$IdUser."')");
									  	//validamos que se haga la insercción
									  	if ($InsertPurchase->execute()) {
									  		echo '
												<center>
												<i style="font-weight:100; font-size:120px; color:#C9DAE1;" class="fa fa-usd" aria-hidden="true"></i><br><br>
												<h3>Tienes que Completar el Pago</h3><br>
													<form method="post" action="https://gateway.payulatam.com/ppp-web-gateway">
													  <input name="merchantId"    type="hidden"  value="'.$merchant.'"   >
													  <input name="accountId"     type="hidden"  value="549050" >
													  <input name="description"   type="hidden"  value="'.$description.'"  >
													  <input name="referenceCode" type="hidden"  value="'.$referencecode.'" >
													  <input name="amount"        type="hidden"  value="'.$amount.'"   >
													  <input name="tax"           type="hidden"  value="0" >
													  <input name="taxReturnBase" type="hidden"  value="0" >
													  <input name="currency"      type="hidden"  value="'.$currency.'" >
													  <input name="signature"     type="hidden"  value="'.$cifrado.'"  >
													  <input name="test"          type="hidden"  value="0" >
													  <input name="buyerEmail"    type="hidden"  value="'.$MailUser.'" >
													  <input name="buyerFullName"    type="hidden"  value="'.$Name.'" >
													  <input name="responseUrl"    type="hidden"  value="http://avmsolucionweb.com/PHP/respuesta.php" >
													  <input name="confirmationUrl"    type="hidden"  value="http://avmsolucionweb.com/PHP/confirmacion.php" >
													  <input name="Submit" class="btn btn-default"  type="submit"  value="Dando Click Aquí" >
													</form>
												</center>
											';
									  	}else{
									  		echo 0;
									  	}
								}else{
									echo "error ejecutando el proceso";
								}
							}
						}
					}
				}else{
					echo true;
				}
			}
	    }
	}
?>