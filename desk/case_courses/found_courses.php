<?php

include ("../class/functions.php");
include ("../class/function_data.php");
//validamos que se hallan enviado datos por POST
if (!isset($_POST['NameSubCat'])) {
	header("Location:http://localhost/GuruSchool/index");
}else{
	//Llamamos la clase GuruApi
	$GuruApi=new GuruApi();
	//lamamos a la clase SQLGetSelInt();
  	$SQLGetSelInt= new SQLGetSelInt();
	$NameSubcat=$GuruApi->TestInput($_POST['NameSubCat']);
	$State="Publicado";
	$SqlGetCourses=$conexion->prepare("SELECT Id_Pk_Curso,Int_Fk_IdUsuario,Vc_NombreCurso,Vc_Imagen_Promocional,Int_PrecioCurso,Vc_TipoCurso FROM G_Cursos WHERE Vc_SubCategoria = ? AND Vc_EstadoCurso = ? ORDER BY RAND() DESC LIMIT 12 ");
	$SqlGetCourses->bind_param("ss", $NameSubcat,$State);
	$SqlGetCourses->execute();
	$SqlGetCourses->store_result();

		if ($NumRows = $SqlGetCourses->num_rows!=0) {
			$SqlGetCourses->bind_result($IdPkCurso,$IdFkUser,$StrNameCurso,$Imagen,$Intprecio,$StrTipoCurso);
			//plasmamos en una estructura HTML los datos del curso seleccionado
			echo '<div class="intermediate text-left">
					<h1>'.$NameSubcat.'</h1>
	                <hr>	
				</div>';
			while ($SqlGetCourses->fetch()) {
				$SQLStudentsIn=$SQLGetSelInt->SQLStudentsIn($IdPkCurso); 
				//traemos el usuario
				$SqlGetUser=$conexion->prepare("SELECT Vc_NombreUsuario FROM G_Datos_Usuario WHERE Int_Fk_IdUsuario = ? ");
				$SqlGetUser->bind_param("s", $IdFkUser);
				$SqlGetUser->execute();
				$SqlGetUser->store_result();
				$SqlGetUser->bind_result($NameUser);
				$SqlGetUser->fetch();
				echo '
					<div class="contenible-card ">
		                <div class="card hoverable">
		                    <div class="card-image hidden-xs">
		                        <div class="view overlay hm-white-slight z-depth-1">
		                            <img src="desk/img_user/Cursos_Usuarios/'.$Imagen.'" class="img-responsive" alt="">
		                            <a href="desk/details/'.$IdPkCurso.'/'.str_replace(" ","-",$StrNameCurso).'">
		                                <div class="mask waves-effect"></div>
		                            </a>
		                        </div>
		                    </div>
		                    <div class="card-image-res visible-xs">
		                        <div class="view overlay hm-white-slight z-depth-1">
		                            <img src="desk/img_user/Cursos_Usuarios/'.$Imagen.'" class="img-responsive" alt="">
		                            <a href="desk/details/'.$IdPkCurso.'/'.str_replace(" ","-",$StrNameCurso).'">
		                                <div class="mask waves-effect"></div>
		                            </a>
		                        </div>
		                    </div>
		                    <div class="card-content">
		                        <span class=" span-card black-gray">'.ucwords(substr($StrNameCurso,0,70)).'..</span>
		                        <p>'.$NameUser.'</p>
		                    </div>
		                    <div style="overflow: hidden;" class="card-btn text-left">';
			         		if (utf8_encode($StrTipoCurso)=="Gratis") 
			                {
			                   	echo '<h2 style="float: left;" class="h1-bold-second">Grátis</h2>';
		                    }else if($StrTipoCurso=="De Pago"){
		                    	echo '<h2 style="float: left;" class="h1-bold-second">$ '.$Intprecio.' COP</h2>';
		                    }
		                   echo'<label style="float: right;" class="semi-gray margin-lestc-right"><i class="fa fa-user" aria-hidden="true"></i>&nbsp; '.$SQLStudentsIn.'</label>
		                   </div>
		                </div>
	    			</div>	
				';
			}
		}else{
			echo '<div class="intermediate text-left">
	    				<h1>'.$NameSubcat.'</h1>
		                <hr>	
	    			</div>';
			echo '<div class="intermediate padding">
					<center>
						<i style="font-weight:100; font-size:130px; color:#C9DAE1;" class="fa fa-frown-o" aria-hidden="true"></i><br><br>
	                    <h2 class="h1-light black-gray">!Lo Sentimos¡</h2><br>
	                    <h4 class="semi-gray">No hay Cursos en esta Sub-Categoría</h4><br>
                	</center>
                </div>';
		}
}
?>
