<?php
	include ("../class/functions.php");
	//Llamamos la clase GuruApi
	$GuruApi = new GuruApi();
	//definimos las variables
	$StrToken = md5(uniqid(microtime(), true));
	$StrEmail = $GuruApi->TestInput($_POST['Email']);
		//seteamos las variables yverificamos que sean del tipo string
		if (is_string($StrEmail)) {
			//Validmos que sea un Correo Valido
			if ($GuruApi->TestMail($StrEmail)) {
				//validamos que el correo esté registrado
				$SqlCompare = $conexion->prepare("SELECT Vc_Correo FROM G_Usuario WHERE Vc_Correo= ? ");
				$SqlCompare->bind_param("s", $StrEmail);
				if ($SqlCompare->execute()) {
					$SqlCompare->store_result();
					if ($NumRows = $SqlCompare->num_rows!=0) {
						//insertamos el Token en la Base de Datos
						$SqlInsert=$conexion->prepare("UPDATE G_Usuario SET Vc_Rescue_Token = ? WHERE Vc_Correo = ?");
						$SqlInsert->bind_param("ss", $StrToken,$StrEmail);
						if ($SqlInsert->execute()) {
							//construimos nuestro correo
							Require ("../library/phpmailer/class.phpmailer.php");
							//cuerpo del mensaje
							$body='
							<html>
							<head>
							</head>
							<body>
							<div>
								<div style="width:100%; height:auto; padding:10px; background-color:rgba(189, 195, 199,0.4);font-family: sans-serif;">
								<strong style="color:rgba(52, 73, 94,1.0);"><h2>¡Hola '.$StrEmail.'!</h2></strong>
								<h3 style="font-weight:100;">Alguien solicitó cambiar tu password. Puedes hacerlo:</h3>
								<a  href=http://localhost/GuruSchool/rescue_pass?token_password='.$StrToken.'> DANDO CLIK EN ESTE ENLACE</a>
								<h3 style="font-weight:100;">Si tú no solicitaste este cambio, por favor ignora este mail, tu contraseña no se modificará si no hasta que accedas al link de arriba.</h3>
								<hr>
								<p class="dis" style="font-size:12px;">La información contenida en este correo electrónico está dirigida únicamente a su destinatario, es estrictamente confidencial y por lo tanto legalmente protegida. Cualquier comentario o declaración hecha no es necesariamente de GURÚ SCHOOL. GURÚ SCHOOL no es responsable de ninguna recomendación, solicitud, oferta y convenio. El envio de este correo se realizó por medio de una aplicación de GURÚ SCHOOL, por favor no contestar este mensaje, si desea comunicarse con nosotros, hagalo por medio de <a href="mailto:baja@guruschool.co" title="Sugerencia-reclamo-pregunta">baja@guruschool.co</a></p>
								</div>
							 </div> 
							</body>
							</html>
							';
							$body .= "";

							$mail=new PHPMailer(true);
							$mail->IsSMTP();
							$mail->Host = "smtp.gmail.com";		
							$mail->Port = 465;  
							$mail->SMTPAuth = true;
							$mail->SMTPSecure = "ssl"; 
							$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only

							$mail->From     = "avmsolucion@gmail.com";
							$mail->FromName = "GURU SCHOOL";
							$mail->Subject  = "Cambio de Contraseña";
							$mail->AltBody  = "Leer"; 
							$mail->MsgHTML($body);
							// Activo condificacción utf-8
							$mail->CharSet = 'UTF-8';

							$mail->AddAddress($StrEmail);
							$mail->SMTPAuth = true;
							
							$mail->Username="avmsolucion@gmail.com";
							$mail->Password="yousolicit1200";
							//enviamos el email
							if ($mail->Send()) {
								echo true;
							}else{
								echo false;
								die();
							}
						}else{
							echo false;
						}
					}else{
						echo false;
					}
				}else{
					echo false;
				}
			}else{
				echo false;
			}
		}else{
			echo false;
		}
?>