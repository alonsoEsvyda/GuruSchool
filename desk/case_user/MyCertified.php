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

	//validamos que la variable exista y tenga contenido
	if (!isset($_GET['Data']) || $_GET['Data']=="") {
		header("Location:../user?request=Hubo un Error, Lo sentimos.");
	}else{
		//definimos las variable y las sanamos
		$IdDecode=$GuruApi->StringDecode($_GET['Data']);
		$IdCourse=$GuruApi->TestInput($IdDecode);
		$IdUser=$_SESSION['Data']['Id_Usuario'];
			//validamos que el curso pertenezca al usuario
			$SqlValidate=$conexion->prepare("SELECT Int_IdCurso FROM Certificados_Usuarios WHERE Int_IdCurso = ? AND Int_Fk_IdUsuario = ?");
			$SqlValidate->bind_param("ii", $IdCourse,$IdUser);
			$SqlValidate->execute();
			$SqlValidate->store_result();
				//verificamos si el curso existe en los datos del usuario
				if ($SqlValidate->num_rows==0) {
					header("Location:../user?request=Hubo un Error, Lo sentimos.");
				}else{
					//traemos los datos del usuario en caso de que si existan en la tabla
					$SqlGetData=$conexion->prepare("SELECT a.Vc_NombreCurso,b.Vc_NombreUsuario,b.Int_Cedula,c.Vc_NumberCertified FROM Certificados_Usuarios AS c INNER JOIN G_Cursos AS a ON c.Int_IdCurso=a.Id_Pk_Curso INNER JOIN G_Datos_Usuario AS b ON c.Int_Fk_IdUsuario=b.Int_Fk_IdUsuario WHERE c.Int_IdCurso = ? AND c.Int_Fk_IdUsuario = ?");
					$SqlGetData->bind_param("ii",$IdCourse,$IdUser);
					$SqlGetData->execute();
					$SqlGetData->store_result();
					$SqlGetData->bind_result($StrNameCourse,$StrNameUser,$IntDniUser,$IntCertified);
					$SqlGetData->fetch();

					include('../library/fpdf/fpdf.php');

					$pdf=new FPDF('L','mm','A4');
					$pdf->AddPage();
					$pdf->SetFont('Arial','',10);
					$pdf->Cell(1,10,'',0,0);
					$pdf->Image('../../css/imagenes/Plantilla2.png' ,10,8,278,'PNG');
					$pdf->SetFont('Arial','I',22);
					$pdf->SetXY(140.2,100); 
					$pdf->Cell(20,20,$StrNameUser,0,0,'C');
					$pdf->SetFont('Helvetica','I',12);
					$pdf->SetXY(140.2,107); 
					$pdf->Cell(20,20,'DNI:'.$IntDniUser,0,0,'C');
					$pdf->SetFont('Arial','I',15);
					$pdf->SetXY(140.2,133); 
					$pdf->Cell(20,20,utf8_decode($StrNameCourse),0,0,'C');
					$pdf->SetFont('Arial','I',10);
					$pdf->SetXY(247.2,179); 
					$pdf->Cell(10,10,utf8_decode($IntCertified),0,0,'C');
					$pdf->Output();
				}
	}
?>