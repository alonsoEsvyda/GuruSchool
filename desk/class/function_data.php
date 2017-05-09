<?php
/*********************************************************************************************
* Creado por Alonso Velez  16/08/2016. *******************************************************
* Version: 1.0 *******************************************************************************
* App: Gurú School ***************************************************************************  
* Descripcion: Este conjunto de clases se encarga de realizar las consultas a la base de datos   
**********************************************************************************************/

require ("config_db.php");

//esta clase validará los datos de un usuario
class ValidateData extends Model
{
	//methods
    public function __construct() 
    { 
        parent::__construct(); 
    } 
    public function ValidateSession($session,$ip,$nav,$host,$IpReal,$route)//Función para validar las sesiones
	{
		if (isset($session)) {
			if ($nav != $_SERVER['HTTP_USER_AGENT'] or 
				$ip != $IpReal or 
				$host != gethostbyaddr($IpReal)) 
			{
			   session_destroy();//destruimos la sesión
			   $parametros_cookies = session_get_cookie_params();// traemos lo que contenga la cookie
			   setcookie(session_name(),0,1,$parametros_cookies["path"]);// destruimos la cookie
			   session_start();
			   session_regenerate_id(true);
			   header("Location:$route");
			}else{

			}
		}else{
			header("Location:$route");
		}
	}
	public function SessionTime($Session,$route)//validamos el estado de vida, de la sesión
	{
		if (isset($Session)) {
		    $InicioSesion=$Session;
		    $TiempoActual = date("Y-n-j H:i:s"); 
		    $TiempoTotal=(strtotime($TiempoActual)-strtotime($InicioSesion)); 
		    if ($TiempoTotal>=1500) {
		      header("Location:$route");
		    }
		}
	}
    public function ValidateIssetDatUser($IdUser,$route)//validamos que el usuario tenga llenos sus datos principales
	{
		$SqlGetData=$this->_db->prepare("SELECT Vc_NombreUsuario,Int_Cedula,Int_Edad,Vc_Pais,Vc_Ciudad FROM G_Datos_Usuario WHERE Int_Fk_IdUsuario = ?");
		$SqlGetData->bind_param("i", $IdUser);
		$SqlGetData->execute();
		$SqlGetData->store_result();
		if ($SqlGetData->num_rows==0){
			header("Location:$route");
		}else{
			
		}
	}
	public function ValidateDataProfessional($IdUser,$route)//validamos que el usuario tenga llenos sus datos PROFESIONALES
	{
		$SqlGetData=$this->_db->prepare("SELECT Vc_Profesion,Txt_Biografia FROM G_Profesion_Usuario WHERE Int_Fk_DatosUsuario = ?");
		$SqlGetData->bind_param("i", $IdUser);
		$SqlGetData->execute();
		$SqlGetData->store_result();
		if ($SqlGetData->num_rows==0){
			header("Location:$route");
		}else{
			
		}
	}
	public function ValidateDataAccount($IdUser,$route)//validamos que el usuario halla llenado los datos bancarios
	{
		$SqlGetData=$this->_db->prepare("SELECT Vc_Cuenta FROM G_Cuenta_Usuario WHERE Int_Fk_DatosUsuario = ?");
		$SqlGetData->bind_param("i", $IdUser);
		$SqlGetData->execute();
		$SqlGetData->store_result();
		if ($SqlGetData->num_rows==0){
			header("Location:$route");
		}else{
			
		}
	}
}


// esta clase trae las vistas que hallan en la base de datos
class ViewsSQL extends Model
{
	//methods
    public function __construct() 
    { 
        parent::__construct(); 
    } 
	public function GetViewCourseSubCategorie($SubCategoria)//En esta vista traemos el resultado de los cursos aleatorios definidiendo una categoría, HOJA CURSOS.PHP
    {
    	$SqlGetView=$this->_db->prepare("SELECT Id_Pk_Curso,Int_Fk_IdUsuario,Vc_NombreCurso,Vc_Imagen_Promocional,Int_PrecioCurso,Vc_TipoCurso,Vc_NombreUsuario,Vc_EstadoCurso FROM vw_seleccioncursos WHERE Vc_SubCategoria = ? ORDER BY RAND() DESC LIMIT  4 ");
    	$SqlGetView->bind_param("s", $SubCategoria);
		$SqlGetView->execute();
		$SqlGetView->store_result();
		$SqlGetView->bind_result($IdPkCurso,$IdFkUser,$StrNameCurso,$Imagen,$Intprecio,$StrTipoCurso,$NameUser,$StateCourse);
		while ($SqlGetView->fetch()) {
			$ArrayData[]=array($IdPkCurso,$IdFkUser,$StrNameCurso,$Imagen,$Intprecio,$StrTipoCurso,$NameUser,$StateCourse);
		}
		$SqlGetView->close();
		return $ArrayData;
    }
    public function GetViewCourses()//En esta vista traemos el resultado de los cursos aleatorios sin definir una categoría, HOJA CURSOS.PHP
    {
		$SqlGetView=$this->_db->prepare("SELECT Id_Pk_Curso,Int_Fk_IdUsuario,Vc_NombreCurso,Vc_Imagen_Promocional,Int_PrecioCurso,Vc_TipoCurso,Vc_NombreUsuario,Vc_EstadoCurso FROM vw_seleccioncursos ORDER BY RAND() DESC LIMIT 30");
		$SqlGetView->execute();
		$SqlGetView->store_result();
		$SqlGetView->bind_result($IdPkCurso,$IdFkUser,$StrNameCurso,$Imagen,$Intprecio,$StrTipoCurso,$NameUser,$StateCourse);
		while ($SqlGetView->fetch()) {
			$ArrayData[]=array($IdPkCurso,$IdFkUser,$StrNameCurso,$Imagen,$Intprecio,$StrTipoCurso,$NameUser,$StateCourse);
		}
		$SqlGetView->close();
		return $ArrayData;
    }
}


//esta clase trae datos del usuario, curso, videos, paises, etc..
class SQLGetSelInt extends Model
{
	//methods
    public function __construct() 
    { 
        parent::__construct(); 
    } 
	public function SQLDataCourse($IdCurso)
	{//Aquí traemos los detalles del curso, de la HOJA DETAILS.PHP
    	//Traemos los datos relevantes del curso
    	$State="Publicado";
	    $SqlGetDataCourse=$this->_db->prepare("SELECT Id_Pk_Curso,Int_Fk_IdUsuario,Vc_NombreCurso,Vc_ResumenCurso,Txt_DescripcionCompleta,Vc_Imagen_Promocional,Vc_VideoPromocional,Int_PrecioCurso,Vc_TipoCurso,Vc_SubCategoria,Vc_Categoria FROM G_Cursos WHERE Id_Pk_Curso = ? AND Vc_EstadoCurso= ?  ");
	    $SqlGetDataCourse->bind_param("is",$IdCurso,$State);
	    $SqlGetDataCourse->execute();
	    $SqlGetDataCourse->store_result();
	    if ($SqlGetDataCourse->num_rows==0) {
	    	return false;
	    }else{
	    	$SqlGetDataCourse->bind_result($IdPkCurso,$IdFkUser,$StrNameCurso,$StrResumen,$StrResComplete,$ImagenCurso,$VideoCurso,$Intprecio,$StrTipoCurso,$StrSubCategoria,$StrCategoria);
		    $SqlGetDataCourse->fetch();
		    return array($IdPkCurso,$IdFkUser,$StrNameCurso,$StrResumen,$StrResComplete,$ImagenCurso,$VideoCurso,$Intprecio,$StrTipoCurso,$StrSubCategoria,$StrCategoria);
		    $SqlGetDataCourse->close();
	    }
    }

    public function SQLStudentsIn($IdCurso){
    	//Cuantos estudiantes están apuntados
	    $SqlGetDataCourse=$this->_db->prepare("SELECT COUNT(DISTINCT(Int_Fk_IdUsuario)) AS numero FROM G_Usuarios_Cursos WHERE Int_Fk_IdCurso= ? ");
	    $SqlGetDataCourse->bind_param("i",$IdCurso);
	    $SqlGetDataCourse->execute();
	    $SqlGetDataCourse->store_result();
	    $SqlGetDataCourse->bind_result($NumberStudents);
	    $SqlGetDataCourse->fetch();
	    if ($NumberStudents==0) {
	    	return 0;
	    }else{
		    return $NumberStudents;
		    $SqlGetDataCourse->close();
	    }
    }

    public function SQLDataUser($IdFkUser)
    {//Aquí traemos los datos del usuario, creador del curso, en la HOJA DETAILS.PHP
    	$SqlGetDataUser=$this->_db->prepare("SELECT a.Int_Fk_IdUsuario,a.Vc_NombreUsuario,a.Txt_ImagenUsuario,a.Txt_ImagenMin,b.Txt_Biografia,b.Vc_Profesion,b.Txt_Facebook,b.Txt_Google,b.Txt_LinkedIn,b.Txt_Twitter FROM G_Datos_Usuario AS a INNER JOIN G_Profesion_Usuario AS b ON a.Int_Fk_IdUsuario=b.Int_Fk_DatosUsuario WHERE a.Int_Fk_IdUsuario = ? ");
	    $SqlGetDataUser->bind_param("s", $IdFkUser);
	    $SqlGetDataUser->execute();
	    $SqlGetDataUser->store_result();
	    if ($SqlGetDataUser->num_rows==0) {
	    	return false;
	    }else{
	    	$SqlGetDataUser->bind_result($IntIdUser,$StrName,$StrImagenUser,$StrImageMin,$StrBiogra,$StrProfession,$StrFace,$StrGoogle,$StrLinked,$StrTwitt);
		    $SqlGetDataUser->fetch();
		    return array($IntIdUser,$StrName,$StrImagenUser,$StrImageMin,$StrBiogra,$StrProfession,$StrFace,$StrGoogle,$StrLinked,$StrTwitt);
		    $SqlGetDataUser->close();
	    }
    }

    public function SQLDataVideos($IdPkCurso)
    {//Aquí traemos los detalles de los videos, del curso, de la HOJA DETAILS.PHP
    	$SqlGetNameVideos=$this->_db->prepare("SELECT Txt_NombreVideo,Id_Pk_VideosCurso,Vc_VideoArchivo FROM G_Videos_Curso WHERE Int_Fk_IdCurso = ?");
	    $SqlGetNameVideos->bind_param("s",$IdPkCurso);
	    $SqlGetNameVideos->execute();
	    $SqlGetNameVideos->store_result();
	    if ($SqlGetNameVideos->num_rows==0) {
	    	return false;
	    }else{
	    	$SqlGetNameVideos->bind_result($NameVideo,$IntIdVideo,$Srcvideo);
		    while($SqlGetNameVideos->fetch()){
		        $ArrayNameVideo[]=array($NameVideo,$IntIdVideo,$Srcvideo);
		    }
			$SqlGetNameVideos->close();
			return $ArrayNameVideo;
	    }
    }

    public function SQLGetDataCountry()
    {// taremos una lista de paises para insertarlos en un select
    	$SqlGetDataCoun=$this->_db->prepare("SELECT Pais FROM Paises");
    	$SqlGetDataCoun->execute();
    	$SqlGetDataCoun->store_result();
    	$SqlGetDataCoun->bind_result($Country);
    	while ($SqlGetDataCoun->fetch()) {
    		$ArrayCountry[]=array($Country);
    	}
    	$SqlGetDataCoun->close();
    	return $ArrayCountry;
    }
}


//esta clase se encarga de traer las categorías 
class DataHTMLModel extends Model
{

    public function Accordeon($type)//definimos un acordeon
    {
    	$id="";
    	//si el dato booleano es 1 o 0, entonces el accordion saldrá solo en pantallas móviles(1) o solo en pantallas grandes(0)
    	if ($type==0) {
    		//definimos el tipo de accordion que saldrá
    		$id="accordion";
    		$res="";
    	}else if($type==1){
    		$id="accordion-res";
    		$res="visible-xs";
    	}
    	//Traemos las categorías
			$SqlGetCategorie=$this->_db->prepare("SELECT Id_Pk_Categorias,Vc_NombreCat FROM G_Categorias");
			$SqlGetCategorie->execute();
			$SqlGetCategorie->store_result();
			$SqlGetCategorie->bind_result($idCat,$NameCat);
		  	echo "<div class='panel-group $res' id='$id'>
		  			<h2 class='margin-lestc-left'>CATÁLOGO</h2>";
		  	// En un bucle las asignamos por defecto al panel-default
		    while ($SqlGetCategorie->fetch()) {
			    echo "<div class='panel panel-default'>
				      <div style='margin-top:5px;' class='panel-heading'>
				        <h4 class='h1-bold-four panel-title'>
				          <a data-toggle='collapse' href='.$NameCat '>$NameCat <i class='fa fa-angle-down' aria-hidden='true'></i></a>
				        </h4>
				      </div>
				      <div class='panel-collapse collapse $NameCat'>";
		      			//Traemos las sub-categorías
				      	$SqlGetSubCat=$this->_db->prepare("SELECT Vc_SubCat FROM G_Sub_Categoria WHERE Int_Fk_IdCat=$idCat");
				      	$SqlGetSubCat->execute();
				      	$SqlGetSubCat->store_result();
				      	$SqlGetSubCat->bind_result($NameSubCat);
				      	//Asignamos por defecto cada sub-categoría a la lista de cada categoría y en 
				      	//un data-name ponemos el nombre la categoría para traer los cursos de esa sub-categoría con AJAX
				      	while ($SqlGetSubCat->fetch()) {
				        echo "<ul class='list-group'>
				          <li class='list-group-item'><a style='cursor:pointer;' class='Encontrar' data-name='$NameSubCat'>$NameSubCat</a></li>
				        </ul>";

						}
		      echo "</div>
		    </div>";
	    	}
    }
   
}

//esta clase se encarga de modelar el HTML del usuario con los datos obtenidos mediante consultas SQL
class ModelHTMLUser extends Model
{
	//methods
    public function __construct() 
    { 
        parent::__construct(); 
    }

    public function SQLGetCoursesUser($IdUser)//esta función nos retorna los datos de los cursos que estamos aprendiendo
    {
    	$SqlGetId=$this->_db->prepare("SELECT DISTINCT(Int_Fk_IdCurso) FROM G_Usuarios_Cursos WHERE Int_Fk_IdUsuario = ? ");
    	$SqlGetId->bind_param("i", $IdUser);
    	$SqlGetId->execute();
    	$SqlGetId->store_result();
    	if ($SqlGetId->num_rows==0) {
    		$ArrayData=false;
    	}else{
    		$SqlGetId->bind_result($IntIdCurso);
	    	while ($SqlGetId->fetch()) {
	    		$SqlCourses=$this->_db->prepare("SELECT a.Id_Pk_Curso,a.Vc_NombreCurso,a.Vc_Imagen_Promocional,a.Int_PrecioCurso,a.Vc_TipoCurso,b.Vc_NombreUsuario  FROM G_Cursos AS a INNER JOIN G_Datos_Usuario AS b ON a.Int_Fk_IdUsuario=b.Int_Fk_IdUsuario WHERE a.Id_Pk_Curso = ? ");
	    		$SqlCourses->bind_param("i",$IntIdCurso);
	    		$SqlCourses->execute();
	    		$SqlCourses->store_result();
	    		$SqlCourses->bind_result($IntIdCourse,$StrNameCourse,$StrImageCourse,$IntPrecioCourse,$StrTipoCourse,$StrNameUser);
	    		while ($SqlCourses->fetch()) {
	    			$ArrayData[] = array($IntIdCourse,$StrNameCourse,$StrImageCourse,$IntPrecioCourse,$StrTipoCourse,$StrNameUser);	
	    		}
	    	}
	    	$SqlCourses->close();
    	}
    	$SqlGetId->close();
	    return $ArrayData;
    }

    public function SQLProgressCourse($IdUser,$IdCourse,$StateVideo)//esta función nos retorna el progreso del alumno
    {
    	$SqlGetProgress=$this->_db->prepare("SELECT ROUND((SELECT COUNT(a.Vc_EstadoVideo) as videos FROM G_Usuarios_Cursos AS a WHERE a.Vc_EstadoVideo=? AND a.Int_Fk_IdCurso=$IdCourse AND a.Int_Fk_IdUsuario=$IdUser)*100/(SELECT COUNT(b.Int_Fk_IdCurso) AS Id FROM G_Usuarios_Cursos AS b WHERE b.Int_Fk_IdCurso=? AND b.Int_Fk_IdUsuario=$IdUser)) AS Porcentaje FROM G_Usuarios_Cursos WHERE Int_Fk_IdUsuario=? ");
    	$SqlGetProgress->bind_param("sii",$StateVideo,$IdCourse,$IdUser);
    	$SqlGetProgress->execute();
    	$SqlGetProgress->store_result();
    	$SqlGetProgress->bind_result($Porcentaje);
    	$SqlGetProgress->fetch();
    	if ($Porcentaje==0) {
    		return 0;
    	}else{
    		return $Porcentaje;
    	}
    	$SqlGetProgress->close();
    }

    public function DataUserPersonal($IdUser)//Traemos datos principales del usuario
	{
		$SqlGetData=$this->_db->prepare("SELECT Vc_NombreUsuario,Int_Cedula,Int_Edad,Vc_Pais,Vc_Ciudad,Txt_ImagenUsuario,Txt_ImagenMin,Vc_Telefono FROM G_Datos_Usuario WHERE Int_Fk_IdUsuario = ?");
		$SqlGetData->bind_param("i", $IdUser);
		$SqlGetData->execute();
		$SqlGetData->store_result();
		if ($SqlGetData->num_rows==0) {
			 $ArrayData=0;
		}else{
			$SqlGetData->bind_result($StrName,$IntDni,$IntAge,$StrCountry,$StrCity,$StrImage,$StrImagenMin,$IntTelf);
			$SqlGetData->fetch();
			$ArrayData[]=array($StrName,$IntDni,$IntAge,$StrCountry,$StrCity,$StrImage,$StrImagenMin,$IntTelf);
		}
		$SqlGetData->close();
		return $ArrayData;
	}
	public function DataUserProfesional($IdUser)//Traemos datos profesionales del usuario
	{
		$SqlGetData=$this->_db->prepare("SELECT Vc_Profesion,Txt_Biografia FROM G_Profesion_Usuario WHERE Int_Fk_DatosUsuario = ?");
		$SqlGetData->bind_param("i", $IdUser);
		$SqlGetData->execute();
		$SqlGetData->store_result();
		if ($SqlGetData->num_rows==0) {
			$ArrayData=0;
		}else{
			$SqlGetData->bind_result($StrProfession,$StrBiografy);
			$SqlGetData->fetch();
			$ArrayData[]=array($StrProfession,$StrBiografy);
		}
		$SqlGetData->close();
		return $ArrayData;
	}
	public function GetSocialMediaUser($IdUser)
	{
		$SqlGetData=$this->_db->prepare("SELECT Txt_Facebook,Txt_Google,Txt_LinkedIn,Txt_Twitter FROM G_Profesion_Usuario WHERE Int_Fk_DatosUsuario= ?");
		$SqlGetData->bind_param("i", $IdUser);
		$SqlGetData->execute();
		$SqlGetData->store_result();
		if ($SqlGetData->num_rows==0) {
			$ArrayData=false;
		}else{
			$SqlGetData->bind_result($Face,$Google,$Linked,$Twitt);
			$SqlGetData->fetch();
			$ArrayData[]=array($Face,$Google,$Linked,$Twitt);
		}
		$SqlGetData->close();
		return $ArrayData;
	}
	public function GetAccountUser($IdUser)
	{
		$SqlGetData=$this->_db->prepare("SELECT Vc_Cuenta,Vc_Banco FROM G_Cuenta_Usuario WHERE Int_Fk_DatosUsuario= ?");
		$SqlGetData->bind_param("i", $IdUser);
		$SqlGetData->execute();
		$SqlGetData->store_result();
		if ($SqlGetData->num_rows==0) {
			$ArrayData=0;
		}else{
			$SqlGetData->bind_result($Account,$Bank);
			$SqlGetData->fetch();
			$ArrayData[]=array($Account,$Bank);
		}
		$SqlGetData->close();
		return $ArrayData;
	}
	public function GetEmailUser($IdUser)
	{
		$SqlGetData=$this->_db->prepare("SELECT Vc_Correo FROM G_Usuario WHERE Id_Pk_Usuario = ?");
		$SqlGetData->bind_param("i", $IdUser);
		$SqlGetData->execute();
		$SqlGetData->store_result();
		$SqlGetData->bind_result($StrMail);
		$SqlGetData->fetch();
		$ArrayData=$StrMail;
		$SqlGetData->close();
		return $ArrayData;
	}
	public function ReturnIdEmail($Email){
		$SqlGetData=$this->_db->prepare("SELECT Id_Pk_Usuario FROM G_Usuario WHERE Vc_Correo = ?");
		$SqlGetData->bind_param("s", $Email);
		$SqlGetData->execute();
		$SqlGetData->store_result();
		$SqlGetData->bind_result($StrId);
		$SqlGetData->fetch();
		$ArrayData=$StrId;
		$SqlGetData->close();
		return $ArrayData;
	}
	

}

//esta clase se encarga de modelar el HTML del Teacher con los datos obtenidos mediante consultas SQL
class ModelHTMLTeach extends Model
 {
    //methods
    public function __construct() 
    { 
        parent::__construct(); 
    }
    public function GetMyPublicCourses($IdUser,$State)//Aquí traemos los cursos que enseña el usuario en sesión PUBLICADOS para su perfíl público
    {
    	$SqlGetDataTeach=$this->_db->prepare("SELECT Id_Pk_Curso,Vc_NombreCurso,Vc_Imagen_Promocional,Vc_EstadoCurso,Vc_TipoCurso,Int_PrecioCurso FROM G_Cursos WHERE Int_Fk_IdUsuario = ? AND Vc_EstadoCurso= ?");
    	$SqlGetDataTeach->bind_param("is", $IdUser,$State);
    	$SqlGetDataTeach->execute();
    	$SqlGetDataTeach->store_result();
    	if ($SqlGetDataTeach->num_rows==0) {
    		$ArrayData=false;
    	}else{
    		$SqlGetDataTeach->bind_result($IntIdCourse,$StrNameTeachC,$StrImage,$StrStateCourse,$StrTypecourse,$Intprice);
	    	while ($SqlGetDataTeach->fetch()) {
	    		$ArrayData[]= array($IntIdCourse,$StrNameTeachC,$StrImage,$StrStateCourse,$StrTypecourse,$Intprice);
	    	}
    	}
    	$SqlGetDataTeach->close();
	    return $ArrayData;
    } 
    public function GetMyTeachCourses($IdUser)//Aquí traemos los cursos que enseña el usuario en sesión
    {
    	$SqlGetDataTeach=$this->_db->prepare("SELECT Id_Pk_Curso,Vc_NombreCurso,Vc_Imagen_Promocional,Vc_EstadoCurso,Vc_TipoCurso,Int_PrecioCurso FROM G_Cursos WHERE Int_Fk_IdUsuario = ?");
    	$SqlGetDataTeach->bind_param("i", $IdUser);
    	$SqlGetDataTeach->execute();
    	$SqlGetDataTeach->store_result();
    	if ($SqlGetDataTeach->num_rows==0) {
    		$ArrayData=false;
    	}else{
    		$SqlGetDataTeach->bind_result($IntIdCourse,$StrNameTeachC,$StrImage,$StrStateCourse,$StrTypecourse,$Intprice);
	    	while ($SqlGetDataTeach->fetch()) {
	    		$ArrayData[]= array($IntIdCourse,$StrNameTeachC,$StrImage,$StrStateCourse,$StrTypecourse,$Intprice);
	    	}
    	}
    	$SqlGetDataTeach->close();
	    return $ArrayData;
    }
    public function GetDataRejectedCourse($IdCurso,$IdUser,$State)//Aquí traemos los detalles del curso 
	{
    	//Traemos los datos relevantes del curso
	    $SqlGetDataCourse=$this->_db->prepare("SELECT Id_Pk_Curso,Vc_NombreCurso,Vc_Imagen_Promocional,Vc_EstadoCurso,Vc_TipoCurso,Int_PrecioCurso,Vc_ResumenCurso,Txt_DescripcionCompleta,Vc_Categoria,Vc_SubCategoria,Vc_VideoPromocional,Txt_Nota FROM G_Cursos WHERE Id_Pk_Curso = ? AND Int_Fk_IdUsuario= ? AND Vc_EstadoCurso= ?  ");
	    $SqlGetDataCourse->bind_param("iis",$IdCurso,$IdUser,$State);
	    $SqlGetDataCourse->execute();
	    $SqlGetDataCourse->store_result();
	    if ($SqlGetDataCourse->num_rows==0) {
	    	return false;
	    }else{
	    	$SqlGetDataCourse->bind_result($IntIdCourse,$StrNameTeachC,$StrImage,$StrStateCourse,$StrTypecourse,$Intprice,$StrResumen,$StrDescripcion,$StrCategorie,$StrSubcategorie,$StrVideo,$StrNota);
		    $SqlGetDataCourse->fetch();
		    return array($IntIdCourse,$StrNameTeachC,$StrImage,$StrStateCourse,$StrTypecourse,$Intprice,$StrResumen,$StrDescripcion,$StrCategorie,$StrSubcategorie,$StrVideo,$StrNota);
		    $SqlGetDataCourse->close();
	    }
    }
    //Methos Sección Teacher, payments, charge, etc...
    public function GetCategoriesHtml()// en este metodo tareamos las categorías de la base de datos para insertarlos en un select
    {
        $SqlGetCategorie=$this->_db->prepare("SELECT Vc_NombreCat FROM G_Categorias");
        $SqlGetCategorie->execute();
        $SqlGetCategorie->store_result();
        $SqlGetCategorie->bind_result($NameCat);
        while ($SqlGetCategorie->fetch()) {
            $ArrayCat[]=array($NameCat);
        }
        $SqlGetCategorie->close();
        return $ArrayCat;
    }
    public function ChargeCourse($IdUser){//metodo para traer os pagos del usuario
    	$SqlGetCharge=$this->_db->prepare("SELECT a.Int_Id_Curso,a.Int_MontoCurso,a.Vc_EstadoCobro,b.Vc_NombreCurso,b.Vc_Imagen_Promocional FROM Pagos_Usuarios AS a INNER JOIN 
    		G_Cursos AS b ON a.Int_Id_Curso=b.Id_Pk_Curso  WHERE a.Int_Fk_GUsuario=?");
    	$SqlGetCharge->bind_param("i",$IdUser);
    	$SqlGetCharge->execute();
    	$SqlGetCharge->store_result();
    	if ($SqlGetCharge->num_rows==0) {
    		$ArrayData=false;
    	}else{
    		$SqlGetCharge->bind_result($IntIdCourse,$IntMonto,$StrEstado,$StrNameCourse,$StrImage);
    		while ($SqlGetCharge->fetch()) {
    			$ArrayData[]= array($IntIdCourse,$IntMonto,$StrEstado,$StrNameCourse,$StrImage);
    		}
    	}
    	$SqlGetCharge->close();
    	return $ArrayData;
    }
    public function PaymentsCourse($IdUser){
    	$SqlGetPayment=$this->_db->prepare("SELECT a.Int_MontoCobrado,a.Vc_EstadoCobro,a.Da_FechaCobro,b.Vc_NombreCurso,a.Int_NumerPay FROM Cobros_Usuarios AS a INNER JOIN G_Cursos AS b ON a.Int_Id_Curso=b.Id_Pk_Curso WHERE a.Int_Fk_GUsuario = ? ");
    	$SqlGetPayment->bind_param("i",$IdUser);
    	$SqlGetPayment->execute();
    	$SqlGetPayment->store_result();
    	if ($SqlGetPayment->num_rows==0) {
    		$ArrayData=false;
    	}else{
    		$SqlGetPayment->bind_result($IntAmmount,$StrState,$StrDate,$StrNameCourse,$IntNumberPay);
    		while ($SqlGetPayment->fetch()) {
    			$ArrayData[]= array($IntAmmount,$StrState,$StrDate,$StrNameCourse,$IntNumberPay);
    		}
    	}
    	$SqlGetPayment->close();
    	return $ArrayData;
    }
 }

 //Clase para validar que los cursos sean de los usuarios
 class DataPlayer extends Model
 {
 	
 	//methods
    public function __construct() 
    { 
        parent::__construct(); 
    }
    
    public function GetDataVideo($IdUser,$IdCourse)//este metodo nos retorna los videos de un video curso
    {
    	$SqlGetDataPlayer=$this->_db->prepare("SELECT a.Vc_TipoCurso, a.Vc_NombreCurso, a.Txt_DescripcionCompleta, a.Id_Pk_Curso, a.Int_Fk_IdUsuario, a.Vc_VideoPromocional, b.Vc_NombreVideo,b.Vc_EstadoVideo FROM G_Cursos AS a INNER JOIN G_Usuarios_Cursos AS b ON a.Id_Pk_Curso=b.Int_Fk_IdCurso WHERE b.Int_Fk_IdUsuario = ? AND b.Int_Fk_IdCurso = ? ORDER BY b.Id_Pk_CursosApuntados DESC ");

    	$SqlGetDataPlayer->bind_param("ii",$IdUser,$IdCourse);
	    $SqlGetDataPlayer->execute();
	    $SqlGetDataPlayer->store_result();
	    if ($SqlGetDataPlayer->num_rows==0) {
    		$ArrayData=false;
    	}else{
    		$SqlGetDataPlayer->bind_result($StrTypeCourse,$StrNameCourse,$StrDescription,$IntIdCourse,$IntIdUser,$VideoPromo,$StrNameVideo,$StrVcState);
			$SqlGetDataVideos=$this->_db->prepare("SELECT Vc_VideoArchivo FROM G_Videos_Curso WHERE Int_Fk_IdCurso= ? ORDER BY Id_Pk_VideosCurso DESC ");
    		$SqlGetDataVideos->bind_param("i",$IdCourse);
    		$SqlGetDataVideos->execute();
    		$SqlGetDataVideos->store_result();
    		$SqlGetDataVideos->bind_result($Videos);
	    	while ($SqlGetDataPlayer->fetch()) {
	    		$SqlGetDataVideos->fetch();
	    		$ArrayData[]= array($StrTypeCourse,$StrNameCourse,$StrDescription,$IntIdCourse,$IntIdUser,$VideoPromo,$StrNameVideo,$StrVcState,$Videos);
	    	}
    	}
    	$SqlGetDataPlayer->close();
	    return $ArrayData;
    }

    public function ValidateCertifiedCourse($IdUser,$IdCourse)//este metodo valida que el usuario halla completado todos los video cursos y agrega el certificado
    {
    	$GetDataVideos=$this->_db->prepare("SELECT COUNT(Txt_NombreVideo) AS OneTotal FROM G_Videos_Curso WHERE Int_Fk_IdCurso = ? ");
    	$GetDataVideos->bind_param("i", $IdCourse);
    	$GetDataVideos->execute();
    	$GetDataVideos->store_result();
    	$GetDataVideos->bind_result($PrimerTotal);
    	$GetDataVideos->fetch();

    	$State="Completo";
    	$NumCetified=time().rand(1,9999);
    	$GetDataMyVideos=$this->_db->prepare("SELECT COUNT(Vc_NombreVideo) AS TwoTotal FROM G_Usuarios_Cursos WHERE Int_Fk_IdUsuario= ? AND Int_Fk_IdCurso= ? AND Vc_EstadoVideo= ?");
    	$GetDataMyVideos->bind_param("iis", $IdUser,$IdCourse,$State);
    	$GetDataMyVideos->execute();
    	$GetDataMyVideos->store_result();
    	$GetDataMyVideos->bind_result($SegundoTotal);
    	$GetDataMyVideos->fetch();

    	if ($PrimerTotal==$SegundoTotal) {
    		if ($PrimerTotal==0 || $SegundoTotal==0) {
    			return false;
    		}else{
    			$ValidateIssetCertified=$this->_db->prepare("SELECT Int_IdCurso FROM Certificados_Usuarios WHERE Int_Fk_IdUsuario= ? AND Int_IdCurso = ?");
	    		$ValidateIssetCertified->bind_param("ii",$IdUser,$IdCourse);
	    		$ValidateIssetCertified->execute();
	    		$ValidateIssetCertified->store_result();
	    			if ($ValidateIssetCertified->num_rows == 0 ) {
	    				$InsertCertified=$this->_db->prepare("INSERT INTO Certificados_Usuarios (Int_Fk_IdUsuario,Int_IdCurso,Vc_NumberCertified) VALUES (?,?,?) ");
	    				$InsertCertified->bind_param("iis",$IdUser,$IdCourse,$NumCetified);
	    					if ($InsertCertified->execute()) {
	    						return true;
	    					}
	    			}else{
	    				return true;
	    			}
    		}
    	}else{
    		return false;
    	}
    }
 }

 class DataCertified extends Model 
 {

 	//methods
    public function __construct() 
    { 
        parent::__construct(); 
    }

 	public function GetDataCertified($IdUser)
 	{
 		$SqlGetIdCourse=$this->_db->prepare("SELECT Int_IdCurso FROM Certificados_Usuarios WHERE  Int_Fk_IdUsuario = ?");
 		$SqlGetIdCourse->bind_param("i",$IdUser);
 		$SqlGetIdCourse->execute();
 		$SqlGetIdCourse->store_result();
 			if ($SqlGetIdCourse->num_rows==0) {
 				$ArrayData=false;
 			}else{
 				$SqlGetIdCourse->bind_result($IdCourse);
				while ($SqlGetIdCourse->fetch()) {
					$SqlGetCourse=$this->_db->prepare("SELECT Id_Pk_Curso,Vc_NombreCurso,Vc_Imagen_Promocional,Int_Fk_IdUsuario FROM G_Cursos WHERE  Id_Pk_Curso = ?");
					$SqlGetCourse->bind_param("i",$IdCourse);
					$SqlGetCourse->execute();
					$SqlGetCourse->store_result();
					$SqlGetCourse->bind_result($IntIdCourse,$StrNameCourse,$StrImage,$IntIdUser);
					$SqlGetCourse->fetch();
					$ArrayData[]=array($IntIdCourse,$StrNameCourse,$StrImage,$IntIdUser);
				}
 			}
 		$SqlGetIdCourse->close();
 		return $ArrayData;
 	}
 }

 class Forum extends Model
 {
 	//methods
    public function __construct() 
    { 
        parent::__construct(); 
    }

    public function ValidateQuestions($IdCourse,$IdUser){
    	$SqlValidate=$this->_db->prepare("SELECT Int_Fk_IdCurso FROM G_Usuarios_Cursos WHERE  Int_Fk_IdCurso = ? AND Int_Fk_IdUsuario = ? ");
    	$SqlValidate->bind_param("ii",$IdCourse,$IdUser);
    	$SqlValidate->execute();
    	$SqlValidate->store_result();
    		if ($SqlValidate->num_rows!=0) {
    			return true;
    		}else{
    			return false;
    		}
    }
    public function GetDataQuestions($IdCourse){
    	$SqlGetQuestions=$this->_db->prepare("SELECT Id_Pk_ForoCurso,Int_Usuario,Vc_Pregunta FROM G_Foro_Curso WHERE Int_Fk_IdCurso= ? ");
    	$SqlGetQuestions->bind_param("i",$IdCourse);
    	$SqlGetQuestions->execute();
    	$SqlGetQuestions->store_result();
		if ($SqlGetQuestions->num_rows==0) {
			$ArrayData=false;
		}else{
			$SqlGetQuestions->bind_result($IdQuestion,$IdUser,$StrQuestion);
    		while ($SqlGetQuestions->fetch()) {
    			//traemos los datos del usuario
    			$SqlGetDataUser=$this->_db->prepare("SELECT Vc_NombreUsuario,Txt_ImagenMin FROM G_Datos_Usuario WHERE Int_Fk_IdUsuario = ?");
    			$SqlGetDataUser->bind_param("i",$IdUser);
    			$SqlGetDataUser->execute();
    			$SqlGetDataUser->store_result();
    			$SqlGetDataUser->bind_result($StrNameUser,$StrImage);
    			$SqlGetDataUser->fetch();
    			//traemos el número de comentarios que tiene la pregunta
    			$SqlGetNumberComment=$this->_db->prepare("SELECT COUNT(Txt_Comment) AS NumComment FROM G_Comments_Foro WHERE Int_Fk_IdPreguntaForo = ? ");
    			$SqlGetNumberComment->bind_param("i",$IdQuestion);
    			$SqlGetNumberComment->execute();
    			$SqlGetNumberComment->store_result();
    			$SqlGetNumberComment->bind_result($NumComment);
    			$SqlGetNumberComment->fetch();
    			if ($NumComment==0) {
    				$NumComment=0;
    			}
    			//retornamos un array
    			$ArrayData[]=array($IdQuestion,$StrQuestion,$StrNameUser,$StrImage,$NumComment);
    		}
		$SqlGetDataUser->close();
 		return $ArrayData;
		}
    }
    public function ValidateAnswers($IdQuestion){
    	$SqlValidate=$this->_db->prepare("SELECT Id_Pk_ForoCurso FROM G_Foro_Curso WHERE Id_Pk_ForoCurso = ?");
    	$SqlValidate->bind_param("i",$IdQuestion);
    	$SqlValidate->execute();
    	$SqlValidate->store_result();
    		if ($SqlValidate->num_rows!=0) {
    			return true;
    		}else{
    			return false;
    		}
    }
    public function GetQuestionOnly($IdQuestion){

    }
    public function GetDataAnswer($IdQuestion){
    	//traemos los datos de la pregunta
    	$SqlGetQuestion=$this->_db->prepare("SELECT a.Vc_Pregunta,a.Txt_DescripcionPregunta,b.Txt_ImagenMin FROM G_Foro_Curso AS a INNER JOIN G_Datos_Usuario AS b ON a.Int_Usuario=b.Int_Fk_IdUsuario WHERE  a.Id_Pk_ForoCurso = ? ");
    	$SqlGetQuestion->bind_param("i",$IdQuestion);
    	$SqlGetQuestion->execute();
    	$SqlGetQuestion->store_result();
    	$SqlGetQuestion->bind_result($StrQuestion,$StrDescQuest,$ImgUserQuestion);
    	$SqlGetQuestion->fetch();
    	//tramos las respuestas
    	$SqlGetAnswers=$this->_db->prepare("SELECT a.Txt_Comment,b.Txt_ImagenMin FROM G_Comments_Foro AS a INNER JOIN G_Datos_Usuario as b ON a.Int_Usuario=b.Int_Fk_IdUsuario WHERE Int_Fk_IdPreguntaForo= ? ORDER BY a.Id_Pk_CommentsForo ASC ");
    	$SqlGetAnswers->bind_param("i",$IdQuestion);
    	$SqlGetAnswers->execute();
    	$SqlGetAnswers->store_result();
    		if ($SqlGetAnswers->num_rows==0) {
    			//retornamos un array
    			$bool=false;
    			$ArrayData[]=array($StrQuestion,$StrDescQuest,$ImgUserQuestion,$bool);
    		}else{
    			$SqlGetAnswers->bind_result($StrComment,$ImguserAnswer);
    			$bool=true;
	    		while ($SqlGetAnswers->fetch()) {
	    			//retornamos un array
	    			$ArrayData[]=array($StrQuestion,$StrDescQuest,$ImgUserQuestion,$bool,$StrComment,$ImguserAnswer);
	    		}
    		}
    	$SqlGetQuestion->close();
    	$SqlGetAnswers->close();
    	return $ArrayData;
    }
 }
  /**
  * Clase que nos genera las consultas para procesar las vacantes
  */
  class TheBag extends Model
  {
  	//methods
    public function __construct() 
    { 
        parent::__construct(); 
    }

    public function GetVacancyUser($IdUser){
    	$SqlGetDataVacancy=$this->_db->prepare("SELECT Id_Pk_Vacante,Vc_NombreVacante,Vc_Pais,Vc_Ciudad,Vc_Categoria,Txt_DescripcionVacante,Da_Fecha FROM G_Vacantes WHERE Int_Fk_IdUsuario=? ");
    	$SqlGetDataVacancy->bind_param("i",$IdUser);
    	$SqlGetDataVacancy->execute();
    	$SqlGetDataVacancy->store_result();
	    	if ($SqlGetDataVacancy->num_rows==0) {
	    		$ArrayData=false;
	    	}else{
	    		$SqlGetDataVacancy->bind_result($IdVacancy,$Vacancy,$Country,$City,$Categorie,$Description,$Date);
	    		while ($SqlGetDataVacancy->fetch()) {
					$ArrayData[]=array($IdVacancy,$Vacancy,$Country,$City,$Categorie,$Description,$Date);
	    		}
	    	}
	    $SqlGetDataVacancy->close();
    	return $ArrayData;
    }
    public function GetDataVacancy($IdVacancy,$State){
    	$SqlGetDataVacancy=$this->_db->prepare("SELECT a.Vc_Empresa,a.Vc_NombreVacante,a.Vc_Pais,a.Vc_Ciudad,a.Vc_Categoria,a.Vc_TipoVacante,a.Int_Salario,a.Int_NumVacantes,a.Vc_Correo,a.Txt_DescripcionVacante,b.Vc_NombreUsuario,b.Txt_ImagenUsuario,a.Da_Fecha FROM G_Vacantes AS a INNER JOIN G_Datos_Usuario AS b ON a.Int_Fk_IdUsuario=b.Int_Fk_IdUsuario WHERE a.Id_Pk_Vacante=? AND a.Vc_EstadoVacante=?");
    	$SqlGetDataVacancy->bind_param("is",$IdVacancy,$State);
    	$SqlGetDataVacancy->execute();
    	$SqlGetDataVacancy->store_result();
	    	if ($SqlGetDataVacancy->num_rows==0) {
	    		$ArrayData=false;
	    	}else{
	    		$SqlGetDataVacancy->bind_result($Company,$NameVacancy,$Country,$City,$Cat,$Type,$Salary,$NumVacancy,$Email,$Description,$NameUser,$ImageUser,$Date);
	    		$SqlGetDataVacancy->fetch();
				$ArrayData[]=array($Company,$NameVacancy,$Country,$City,$Cat,$Type,$Salary,$NumVacancy,$Email,$Description,$NameUser,$ImageUser,$Date);
	    	}
	    $SqlGetDataVacancy->close();
    	return $ArrayData;
    } 
    public function GetViewAllVacancy($State){
		$SqlGetData=$this->_db->prepare("SELECT Id_Pk_Vacante,Vc_Empresa,Vc_NombreVacante,Txt_DescripcionVacante,Vc_Categoria,Vc_Pais,Vc_Ciudad,Da_Fecha FROM vw_vacantes WHERE  Vc_EstadoVacante=? ORDER BY RAND() LIMIT 50 ");
		$SqlGetData->bind_param("s",$State);
		$SqlGetData->execute();
		$SqlGetData->store_result();
			if ($SqlGetData->num_rows==0) {
				$ArrayData=false;
			}else{
				$SqlGetData->bind_result($IdVacancy,$NameCompany,$NameVacancy,$Description,$Categorie,$Country,$City,$Date);
				while ($SqlGetData->fetch()) {
					$ArrayData[]=array($IdVacancy,$NameCompany,$NameVacancy,$Description,$Categorie,$Country,$City,$Date);
				}
			}
		$SqlGetData->close();
		return $ArrayData;
    }
  }
?>