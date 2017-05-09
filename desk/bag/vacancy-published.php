<?php
	include('../session/session_parameters.php');
	include ("../class/functions.php");
	include ("../class/function_data.php");
	//llamamos a la clase DataHTMLModel
	$ValidateData= new ValidateData();
	//Validamos que el usuario tenga sus datos Profesionales llenos
	$ValidateData->ValidateDataProfessional($_SESSION['Data']['Id_Usuario'],'../data_user.php?request=Debes de llenar tus Datos Profesionales.');
	//Validamos que el usuario tenga sus datos Bancarios llenos
	$ValidateData->ValidateDataAccount($_SESSION['Data']['Id_Usuario'],'../data_user.php?request=Debes de llenar tus Datos Bancarios.');
	//validamos que el usuario tenga sus datos personales completos
	$ValidateData->ValidateIssetDatUser($_SESSION['Data']['Id_Usuario'],'../data_user.php?request=Llena Primero tu Datos Personales.');
	
	//llamamos la clase SQLGetSelInt
	$SQLGetSelInt= new SQLGetSelInt();
	//llamamos a la clase ModelHTMLTeach
	$ModelHTMLTeach=new ModelHTMLTeach();
	//llamamos la clase para traer  los paises
	$GetCountry=$SQLGetSelInt->SQLGetDataCountry(); 
	//Traemos el meotod que nos retona la categorías
	$ArrCategorias=$ModelHTMLTeach->GetCategoriesHtml();

	//Llamamos la clase GuruApi
	$GuruApi = new GuruApi();
	//llamamos la clase ValidateData
	$ValidateData= new ValidateData();
	//Validamos el tiempo de vida de la sesión
	$TimeSession=$ValidateData->SessionTime($_SESSION['Data']['Tiempo'],"http://localhost/GuruSchool/desk/session/logout.php");
	//Asignamos el tiempo actual a la variable de sesión
	$_SESSION['Data']['Tiempo']=date("Y-n-j H:i:s");
	//traemos la ip real del usuario
	$GetRealIp = $GuruApi->getRealIP();
	//validamos que exista la sesión y las credenciales sean correctas
	$ValidateSession = $ValidateData->ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,"http://localhost/GuruSchool/iniciar-sesion?request=iniciar sesion");
?>
<!DOCTYPE html>
<html>
<head>
	<!--head-->
	<?php
    	$baseUrl = dirname($_SERVER['PHP_SELF']).'/';
  	?>
  	<base href="<?php echo $baseUrl; ?>" >
  	<?php include ("../../includes-front/head.php"); ?>
</head>
<body>
	<!--Menú-->
	<?php include ("includes/menu-dev.php"); ?>
	<?php
      include("includes/pop_up-dev.php");
    ?>
	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="padding margin-top intermediate">
						<h1>Publica una Vacante</h1>
			            <hr>
			            <form action="controll/create_vacancy.php" method="POST">
			            	<div class="form-group">
					        	<div class="col-md-6 margin-lestb-top">
					            	<input type="text" name="Company" maxlength="40" placeholder="Empresa" required/>
					        	</div>
					        	<div class="col-md-6 margin-lestb-top">
					            	<input type="text" name="Vacancy" maxlength="40" placeholder="Nombre Vacante" required/>
					        	</div>
						    </div>
						    <div class="form-group">
						        <div class="col-md-6">
						            <select  name="Country" required/>
				                      <option value="" disabled selected>Seleccione el País</option>
				                      <?php 
				                        sort($GetCountry);
				                        foreach ($GetCountry as $DataCountry) {
				                          ?>
				                          <option><?php echo $DataCountry[0]; ?></option>
				                          <?php
				                        }
				                      ?>
				                    </select>
						        </div>
						        <div class="col-md-6">
						        	<input type="text" name="City" maxlength="30" placeholder="Ciudad" required/>
						        </div>
						    </div>
						    <div class="form-group">
						        <div class="col-md-6">
						            <select class="categoria" name="Categorie" required/>
				                      <option value="" disabled selected>Seleccione Categoría</option>
				                      <?php
				                        sort($ArrCategorias);
				                        foreach ($ArrCategorias as $DataCat) {
				                          ?>
				                            <option value="<?php echo $DataCat[0]; ?>"><?php echo $DataCat[0]; ?></option>
				                          <?php
				                        }
				                      ?>
				                    </select>
						        </div>
						        <div class="col-md-6">
						        	<select class="categoria" name="TypeJob" required/>
				                        <option value="" disabled selected>Seleccione Tipo</option>
				                        <option>Presencial</option>
				                        <option>Freelance</option>
				                      </select>
						        </div>
						    </div>
						    <div class="form-group">
					        	<div class="col-md-4 margin-lestb-top">
					            	<input type="number" name="Salary"  placeholder="Salario" required/>
					        	</div>
					        	<div class="col-md-4 margin-lestb-top">
					            	<input type="number" name="NumVacancy" placeholder="Número Vacantes" required/>
					        	</div>
					        	<div class="col-md-4 margin-lestb-top">
					            	<input type="email" name="Email" maxlength="40" placeholder="Email" required/>
					        	</div>
						    </div>
						    <div class="form-group">
					        	<div class="col-md-12">
						             <textarea name="Description" required/>"Descripción de la Vacante"</textarea>
						        </div>
						    </div>
						    <div class="form-group">
						    	<div class="col-md-6 col-md-offset-3 margin-lesta-top margin-bottom">
						    		<center>
								    	<button type="submit" class="btn btn-default">Publicar</button>
								    </center>
						    	</div>
						    </div>
			            </form>
					</div>				
				</div>
			</div>
		</div>
	</section>	
	<!--Footer-->
    <?php include ("../../includes-front/footer.php"); ?>
    <!--Scripts-->
    <?php include ("includes/scripts-dev.html"); ?>
</body>
</html>