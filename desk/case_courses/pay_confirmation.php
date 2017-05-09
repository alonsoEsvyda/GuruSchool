<?php
  include ("../class/functions.php");
  include ("../class/function_data.php");

  $GuruApi= new GuruApi();
  //verificamos si nos envían datos por POST
  if ($_SERVER['REQUEST_METHOD']=='POST') {
  	//Token de Seguridad
  	$ApiKey = "rpfLb9n4HOXWxn0Z7RHGs1bt6v";
  	//previo, definimos las variables curadas que se insertarán en la BD...
  	$State_Pol=$GuruApi->TestInput($_POST['state_pol']);
  	$Response_Code_Pol=$GuruApi->TestInput($_POST['response_code_pol']);
  	$Response_Message_Pol=$GuruApi->TestInput($_POST['response_message_pol']);
  	$Payment_Method_Type=$GuruApi->TestInput($_POST['payment_method_type']);
  	$Transacction_Date=$GuruApi->TestInput($_POST['transaction_date']);
  	$Reference_Pol=$GuruApi->TestInput($_POST['reference_pol']);
  	//Traigo las variables que crean la firma
  	$MerchantId=$_POST['merchant_id'];
  	$ReferenceSale=$GuruApi->TestInput($_POST['reference_sale']);
  	$NewValue=number_format($_POST['value'], 1, '.', '');
  	$Currency=$_POST['currency'];
  	$Sign_Received=$_POST['sign'];
    $Day=date("d");
    $Month=date("m");
    $Year=date("Y");
  	//creamos la firma
  	$Sign_Created=md5($ApiKey."~".$MerchantId."~".$ReferenceSale."~".$NewValue."~".$Currency."~".$State_Pol);
  		//Validamos la firma
  		if (strtoupper($Sign_Received)==strtoupper($Sign_Created)) {
  			//validamos cual es el estado que nos retorna el State_Pol y el Response_Code_Pol
  			if ($State_Pol==4 && $Response_Code_Pol==1) {
  				//si es Aprobada, actualizamos los datos de la tabla
  				$SqlUpdateData=$conexion->prepare("UPDATE Historial_Pagos SET Vc_StatePol=?, Vc_Response_Code_Pol=?, Vc_Response_Message_Pol=?, Vc_Payment_Method_Type=?, Vc_Transaction_Date=?, Int_Reference_Pol=? WHERE Vc_Reference_Sale = ? ");
  				$SqlUpdateData->bind_param("sssssis", $State_Pol,$Response_Code_Pol,$Response_Message_Pol,$Payment_Method_Type,$Transacction_Date,$Reference_Pol,$ReferenceSale);
  				if ($SqlUpdateData->execute()) {
  					//traemos el id del comprador y el vendedor, como del curso comprado
  					$SqlGetDataUsers=$conexion->prepare("SELECT Int_Id_UsuarioVende,Int_Id_UsuarioCompro,Int_Id_CursoComprado,Int_MontoCurso,Vc_Nickname_Buyer FROM Historial_Pagos WHERE Vc_Reference_Sale = ? ");
  					$SqlGetDataUsers->bind_param("i",$ReferenceSale);
  						//verificamos que la consulta se ejecute correctamente
  						if ($SqlGetDataUsers->execute()) {
  							$SqlGetDataUsers->store_result();
  							$SqlGetDataUsers->bind_result($IdUserSale,$IdUserBuy,$IdCourse,$IntValueCourse,$StrNicknameBuyer);
  							$SqlGetDataUsers->fetch();
  							//definimos los pagos para cada uno
  							$PageGuru=$GuruApi->Percentage($IntValueCourse,30);
							  $PageUser=$GuruApi->Percentage($IntValueCourse,70);
									//Verificamos si el curso existe en la tabla de pagos_usuarios
	  							$SqlVerifyCourseUser=$conexion->prepare("SELECT Int_Id_Curso FROM Pagos_Usuarios WHERE Int_Id_Curso = ? AND Int_Fk_GUsuario = ?");
	  							$SqlVerifyCourseUser->bind_param("ii",$IdCourse,$IdUserSale);
	  								//validamos que se ejecute la consulta
	  								if ($SqlVerifyCourseUser->execute()) {
	  									$SqlVerifyCourseUser->store_result();
	  									//verificamos si viene algún dato, caso contrario insertamos para mantener el historial
	  									if ($SqlVerifyCourseUser->num_rows!=0) {
	  										$SqlProcessDataUser=$conexion->prepare("UPDATE Pagos_Usuarios SET Int_MontoCurso =?+Int_MontoCurso, Int_MontoGuru =?+Int_MontoGuru WHERE Int_Id_Curso = ? AND Int_Fk_GUsuario= ? ");
	  										$SqlProcessDataUser->bind_param("iiii",$PageUser,$PageGuru,$IdCourse,$IdUserSale);
	  									}else{
	  										$StateCobro="AddingUp";
	  										$SqlProcessDataUser=$conexion->prepare("INSERT INTO Pagos_Usuarios (Int_Fk_GUsuario,Int_Id_Curso,Int_MontoCurso,Int_MontoGuru,Vc_EstadoCobro) VALUES (?,?,?,?,?)");
	  										$SqlProcessDataUser->bind_param("iiiis",$IdUserSale,$IdCourse,$PageUser,$PageGuru,$StateCobro);
	  									}
	  										//validamos si se ejecuta algúna de estás consultas
	  										if ($SqlProcessDataUser->execute()) {
                          //insertamos el pago en la tabla de pagos admin
                          $SqlInsertAdmin=$conexion->prepare("INSERT INTO Pagos_Admin (Int_Ammount,Int_Day,Int_Month,Int_Year,Vc_NameBuyer) VALUES (?,?,?,?,?) ");
                          $SqlInsertAdmin->bind_param("iiiis",$PageGuru,$Day,$Month,$Year,$StrNicknameBuyer);
                            if ($SqlInsertAdmin->execute()) {
                              //insertamos en la tabla  de cursos del usuario que compró el curso
                              $GetDataCourse=$conexion->prepare("SELECT Txt_NombreVideo FROM G_Videos_Curso WHERE Int_Fk_IdCurso= ? ");
                              $GetDataCourse->bind_param("i", $IdCourse);
                              $GetDataCourse->execute();
                              $GetDataCourse->store_result();
                              $GetDataCourse->bind_result($StrNameVideo);
                              $StateVideo="Incompleto";
                                while ($GetDataCourse->fetch()) {
                                  $InsertCourse=$conexion->prepare("INSERT INTO G_Usuarios_Cursos (Int_Fk_IdCurso,Int_Fk_IdUsuario,Vc_NombreVideo,Vc_EstadoVideo) 
                                                    VALUES (?,?,?,?)");
                                  $InsertCourse->bind_param("ssss", $IdCourse,$IdUserBuy,$StrNameVideo,$StateVideo);
                                  $InsertCourse->execute();
                                }
                            }else{
                              echo "error procesando datos Gurú";
                            }
	  										}else{
	  											echo "error procesando datos usuario";
	  										}
	  								}
  						}
  				}else{
  					echo "Error Updapeando aprobación";
  				}
  			}else{
  				//si es rechazada, actualizamos los datos de la tabla
  				$SqlUpdateData=$conexion->prepare("UPDATE Historial_Pagos SET Vc_StatePol=?, Vc_Response_Code_Pol=?, Vc_Response_Message_Pol=?, Vc_Payment_Method_Type=?, Vc_Transaction_Date=?, Int_Reference_Pol=? WHERE Vc_Reference_Sale = ? ");
  				$SqlUpdateData->bind_param("sssssis", $State_Pol,$Response_Code_Pol,$Response_Message_Pol,$Payment_Method_Type,$Transacction_Date,$Reference_Pol,$ReferenceSale);
  				if ($SqlUpdateData->execute()) {
  					echo "actualizado";
  				}else{
  					echo "Error Updapeando fallo";
  				}
  			}
  		}else{
  			echo "Error Validando Firma";
  		}
  }else{
  	echo "error";
  }

?>