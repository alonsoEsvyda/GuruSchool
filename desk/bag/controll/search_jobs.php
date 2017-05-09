<?php
	include('../../session/session_parameters.php');
	include ("../../class/functions.php");
	include ("../../class/function_data.php");

	//Llamamos la clase GuruApi
	$GuruApi = new GuruApi();

	//traemos las variables y las sanamos
	$Country=$GuruApi->TestInput($_POST['Country']);
	$Categorie=$GuruApi->TestInput($_POST['Categorie']);
	$Type=$GuruApi->TestInput($_POST['Type']);
	$State="Public";

	//validamos si ciudad tiene algún dato o no
	if (!empty($_POST['City'])) {
		$City=$GuruApi->TestInput($_POST['City']);
			//creamos la consulta que nos retorna los datos
			$SqlGetData=$conexion->prepare("SELECT Id_Pk_Vacante,Vc_Empresa,Vc_NombreVacante,Txt_DescripcionVacante,Vc_Categoria,Vc_Pais,Vc_Ciudad,Da_Fecha FROM G_Vacantes WHERE Vc_Pais= ? AND Vc_Ciudad=? AND Vc_Categoria= ? AND Vc_TipoVacante= ? AND Vc_EstadoVacante=? ");
			$SqlGetData->bind_param("sssss", $Country,$City,$Categorie,$Type,$State);
	}else{
		//creamos la consulta que nos retorna los datos
		$SqlGetData=$conexion->prepare("SELECT Id_Pk_Vacante,Vc_Empresa,Vc_NombreVacante,Txt_DescripcionVacante,Vc_Categoria,Vc_Pais,Vc_Ciudad,Da_Fecha FROM G_Vacantes WHERE Vc_Pais= ? AND Vc_Categoria= ? AND Vc_TipoVacante= ? AND Vc_EstadoVacante=? ");
		$SqlGetData->bind_param("ssss", $Country,$Categorie,$Type,$State);
	}	
		//terminados de preparar la consulta
		$SqlGetData->execute();
		$SqlGetData->store_result();
		//verificamos que venga algo en la consulta
		if ($SqlGetData->num_rows==0) {
			echo "<div class='padding intermediate'>
                      <center><h3>NO HAY VACANTES PUBLICADAS</h3></center>
                    </div>";
		}else{
			$SqlGetData->bind_result($IdVacancy,$NameCompany,$NameVacancy,$Description,$Categorie,$Country,$City,$Date);
			while ($SqlGetData->fetch()) {
				?>
					<!--vacantes-->
	                  <div class="container-job">
	                    <div class="company-job">
	                      <h4><?php echo $NameCompany; ?></h4>
	                      <a href="desk/bag/job/<?php echo $IdVacancy; ?>/"><h2><?php echo $NameVacancy; ?></h2></a>
	                    </div>
	                    <div class="description-job">
	                      <hr style="margin:0;">
	                      <p style="margin:0;"><?php echo strip_tags(substr($Description,0,130))." [...]"; ?></p>
	                    </div>
	                    <div class="add-job">
	                      <h4><?php echo $Categorie."-".$Country."/".$City." (".$Date.")"; ?></h4>
	                    </div>
	                  </div>
				<?php
			}
		}
?>