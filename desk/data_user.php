<?php
	include('session/session_parameters.php');
	include ("class/functions.php");
	include ("class/function_data.php");
	//llamamos la clase ModelHTMLUser
	$ModelHTMLUser = new ModelHTMLUser();
	//llamamos al metodo que nos retorna los datos especificos del usuario
	$DataUserPersonal = $ModelHTMLUser->DataUserPersonal($_SESSION['Data']['Id_Usuario']);
	//lamamos al metodo que nos retorna los datos profesionales del usuario
	$DataUserProfesional=$ModelHTMLUser->DataUserProfesional($_SESSION['Data']['Id_Usuario']);
	//llamamos al metodo que nos retorna las redes sociales
	$GetSocialMediaUser=$ModelHTMLUser->GetSocialMediaUser($_SESSION['Data']['Id_Usuario']);
	//llamamos al metodo que nos retorna la cuenta del usuario
	$GetAccountUser=$ModelHTMLUser->GetAccountUser($_SESSION['Data']['Id_Usuario']);
	//llamamos la clase SQLGetSelInt
	$SQLGetSelInt= new SQLGetSelInt();
	//llamamos la clase para traer  los paises
  	$GetCountry=$SQLGetSelInt->SQLGetDataCountry(); 


	//Llamamos la clase GuruApi
	$GuruApi = new GuruApi();
	//llamamos la clase ValidateData
	$ValidateData = new ValidateData();
	//Validamos el tiempo de vida de la sesión
  	$TimeSession=$ValidateData->SessionTime($_SESSION['Data']['Tiempo'],"session/logout.php");
  	//Asignamos el tiempo actual a la variable de sesión
  	$_SESSION['Data']['Tiempo']=date("Y-n-j H:i:s");
	//traemos la ip real del usuario
	$GetRealIp = $GuruApi->getRealIP();
	//validamos que exista la sesión y las credenciales sean correctas
	$ValidateSession = $ValidateData->ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,"../iniciar-sesion.php?request=iniciar sesion");
?>
<!DOCTYPE html>
<html>
<head>
	<!--head-->
	<?php
   	 $baseUrl = dirname($_SERVER['PHP_SELF']).'/';
  	?>
  	<base href="<?php echo $baseUrl; ?>" >
  	<?php include ("../includes-front/head.php"); ?>
</head>
<body>
	<!--Menú-->
	<?php 
	  include ("includes/menu-dev.php"); 
      include("includes/pop_up-dev.php");
    ?>
	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="padding margin-top intermediate">
						<h1>Mis Datos Personales y Profesionales</h1>
			            <hr>
			            <div class="col-md-12 visible-xs">
			    			<h1>Datos Personales</h1>
			    			<hr>
				    	</div>
			            <!--DATOS PERSONALES-->
			            <?php
			            	if ($DataUserPersonal==0) {//Si no retorna ningún valor, llenamos el formulario
			            ?>
			            	<!--CAMBIAR IMAGEN DE PERFÍL-->
			            	<form action="case_user/update_personal_user.php" method="POST" enctype="multipart/form-data">
			            		<div class="form-group">
							    	<div class="col-md-3">
							    		<div style="width:100%;height:150px; border:1px solid rgba(0,0,0,0.1);">
							    			<center>
							    				<img style="width:auto;height:150px;" src="img_user/Perfil_Usuarios/defecto_user.jpg">
							    			</center>
							    		</div>
							    		<input type="file" name="foto" id="file" class="input-file" required/>
										  <label for="file" class="btn btn-tertiary js-labelFile">
										    <i class="icon fa fa-check"></i>
										    <span class="js-fileName">Cambia tu Foto</span>
										  </label>
							    	</div>
							    	<div class="col-md-1 hidden-xs"></div>
							    	<div class="col-md-8 padding hidden-xs">
						    			<h1>Datos Personales</h1>
							    	</div>
							    </div>
				            	<div class="form-group">
							        <div class="col-md-12 margin-top">
							            <input type="text" maxlength="100" name="Nombre" placeholder="Escribe tu Nombre Completo" required/>
							        </div>
							    </div>
							    <div class="form-group">
							        <div class="col-md-4">
							            <input type="number" max="100000000000" name="Dni" placeholder="DNI o Cedula" required/>
							        </div>
							        <div class="col-md-4">
							            <input type="number" min="0" max="150" name="Edad" placeholder="Escribe tu Edad" required/>
							        </div>
							        <div class="col-md-4">
							            <input type="number" min="0" max="5000000000" name="Telefono" placeholder="Telefono" required/>
							        </div>
							    </div>
							    <div class="form-group">
							        <div class="col-md-6">
							            <select name="Pais" required/>
								          <option value="" disabled selected>Seleccione su País</option>
								          <?php 
								          	foreach ($GetCountry as $DataCountry) {
								          		?>
								          		<option><?php echo $DataCountry[0]; ?></option>
								          		<?php
								          	}
								          ?>
								        </select>
							        </div>
							        <div class="col-md-6">
							            <input type="text" maxlength="50" name="Ciudad" placeholder="Ciudad" required/>
							        </div>
							    </div>
							    <div class="form-group">
							    	<div class="col-md-12 margin-lesta-top margin-bottom">
							    		<center>
									    	<button type="submit" class="btn btn-default">Guardar</button>
									    </center>
							    	</div>
							    </div>
						    </form>
			            <?php
			            	}else{// en caso de que nos retorne algun valor, llenamos los campos
			            		foreach ($DataUserPersonal as $DataUser) {
		            	?>
								<!--CAMBIAR DATOS PERSONALES-->
		            			<form action="case_user/update_personal_user.php" method="POST" enctype="multipart/form-data">
		            				<div class="form-group">
								    	<div class="col-md-3">
								    		<div style="width:100%;height:auto; border:1px solid rgba(0,0,0,0.1);">
								    			<center>
								    				<img style="width:100%;height:auto;" src="img_user/Perfil_Usuarios/<?php echo $DataUser[5]; ?>">
								    			</center>
								    		</div>
								    		<input type="file" name="foto" id="file" class="input-file"/>
											  <label for="file" class="btn btn-tertiary js-labelFile">
											    <i class="icon fa fa-check"></i>
											    <span class="js-fileName">Cambia tu Foto</span>
											  </label>
								    	</div>
								    	<div class="col-md-1 hidden-xs"></div>
								    	<div class="col-md-8 padding hidden-xs">
							    			<h1>Datos Personales</h1>
								    	</div>
								    </div>
					            	<div class="form-group">
								        <div class="col-md-12 margin-top">
								            <input type="text" maxlength="100" name="Nombre" value="<?php echo $DataUser[0]; ?>" placeholder="Escribe tu Nombre Completo" required/>
								        </div>
								    </div>
								    <div class="form-group">
								        <div class="col-md-4">
								            <input type="number" max="100000000000" value="<?php echo $DataUser[1]; ?>" name="Dni" placeholder="DNI o Cedula" required/>
								        </div>
								        <div class="col-md-4">
								            <input type="number" min="0" max="150" name="Edad" value="<?php echo $DataUser[2]; ?>" placeholder="Esribe tu Edad" required/>
								        </div>
								        <div class="col-md-4">
								            <input type="number" min="0" max="5000000000" name="Telefono" value="<?php echo $DataUser[7]; ?>" placeholder="Telefono" required/>
								        </div>
								    </div>
								    <div class="form-group">
								        <div class="col-md-6">
								            <select name="Pais" required/>
								              <option><?php echo $DataUser[3]; ?></option>
									          <?php 
									          	foreach ($GetCountry as $DataCountry) {
									          		?>
									          		<option><?php echo $DataCountry[0]; ?></option>
									          		<?php
									          	}
									          ?>
									        </select>
								        </div>
								        <div class="col-md-6">
								            <input type="text" maxlength="50" name="Ciudad" value="<?php echo $DataUser[4]; ?>" placeholder="Ciudad" required/>
								        </div>
								    </div>
								    <div class="form-group">
								    	<div class="col-md-12 margin-lesta-top margin-bottom">
								    		<center>
										    	<button type="submit" class="btn btn-default">Guardar</button>
										    </center>
								    	</div>
								    </div>
								</form>
						    <?php
						    	}
						    }
						    ?>
			            <!--DATOS PROFESIONALES-->
			            <div class="form-group">
					    	<div class="col-md-12">
				    			<h1>Datos Profesionales</h1>
				    			<hr>
					    	</div>
					    </div>
					    	<form action="case_user/update_profesional_user.php" method="POST">
					    		<?php
							   	 if ($DataUserProfesional==0) {
							    ?>
					            	<div class="form-group">
								        <div class="col-md-6 margin-latestc-top">
								            <input type="text" maxlength="150" name="profesion" placeholder="Escribe tu Profesión" required/>
								        </div>
								    </div>
								    <div class="form-group">
								        <div class="col-md-12">
								             <textarea name="biografia" placeholder="Escribe tu Biografía"></textarea>
								        </div>
								    </div>
							    <?php
								 }else{
								 	foreach ($DataUserProfesional as $DataProf) {
									?>
						            	<div class="form-group">
									        <div class="col-md-6 margin-latestc-top">
									            <input type="text" maxlength="150" name="profesion" value="<?php echo $DataProf[0]; ?>" placeholder="Escribe tu Profesión" required/>
									        </div>
									    </div>
									    <div class="form-group">
									        <div class="col-md-12">
									        	<textarea name="biografia" placeholder="Escribe tu Biografía"><?php echo $DataProf[1]; ?></textarea>
									        </div>
									    </div>
								    <?php	
							    	}
								 }
							    ?>
							    <div class="form-group">
							    <?php
							    	if ($GetSocialMediaUser==0) {
							    		?>
							    			<label class="col-xs-1"><a class="btn btn-fb"><i class="fa fa-facebook"></i></a></label>
									        <div class="col-md-2">
									             <input type="url" placeholder="Facebook" name="Facebook">
									        </div>
									        <label class="col-xs-1"><a class="btn btn-fb"><i class="fa fa-twitter"></i></a></label>
									        <div class="col-md-2">
									             <input type="url" placeholder="Twitter" name="Twitter">
									        </div>
									        <label class="col-md-1"><a class="btn btn-fb"><i class="fa fa-google-plus"></i></a></label>
									        <div class="col-md-2">
									             <input type="url" placeholder="Google+" name="Google">
									        </div>
									        <label class="col-md-1"><a class="btn btn-fb"><i class="fa fa-linkedin"></i></a></label>
									        <div class="col-md-2">
									             <input type="url" placeholder="LinkedIn" name="LinkedIn">
									        </div>
							    		<?php
							    	}else{
							    		foreach ($GetSocialMediaUser as $DataSocial) {
							    			?>
							    				<label class="col-xs-1"><a class="btn btn-fb"><i class="fa fa-facebook"></i></a></label>
										        <div class="col-md-2">
										             <input type="url" value="<?php echo $DataSocial[0]; ?>" placeholder="Facebook" name="Facebook">
										        </div>
										        <label class="col-xs-1"><a class="btn btn-fb"><i class="fa fa-twitter"></i></a></label>
										        <div class="col-md-2">
										             <input type="url" value="<?php echo $DataSocial[3]; ?>" placeholder="Twitter" name="Twitter">
										        </div>
										        <label class="col-md-1"><a class="btn btn-fb"><i class="fa fa-google-plus"></i></a></label>
										        <div class="col-md-2">
										             <input type="url" value="<?php echo $DataSocial[1]; ?>" placeholder="Google+" name="Google">
										        </div>
										        <label class="col-md-1"><a class="btn btn-fb"><i class="fa fa-linkedin"></i></a></label>
										        <div class="col-md-2">
										             <input type="url" value="<?php echo $DataSocial[2]; ?>" placeholder="LinkedIn" name="LinkedIn">
										        </div>
							    			<?php
							    		}
							    	}
							    ?>
							    </div>
							    <div class="form-group">
							    	<div class="col-md-12 margin-lesta-top margin-bottom">
							    		<center>
									    	<button type="submit" class="btn btn-default">Guardar</button>
									    </center>
							    	</div>
							    </div>
				            </form>
			            <!--DATOS BANCARIOS-->
			            <div class="form-group">
					    	<div class="col-md-12">
				    			<h1>Datos Bancarios</h1>
				    			<p>Llenar este espacio para pagarte, solo si eres Profesor (Valido solo Para Colombia)</p>
				    			 <div style="display:none;" id="respuesta" class="alert"></div>
				    			<hr>
					    	</div>
					    </div>
			            <form action="case_user/update_account_user.php" method="POST">
			            	<?php
			            		if ($GetAccountUser==0) {
			            			?>
			            				<div class="form-group">
			            					<div class="col-md-6 margin-latestc-top">
									            <select name="Banco" class="banco" onchange="Change(this.value)" required/>
										          <option value="" disabled selected>Seleccione un Banco</option>
										          <option value="Bancolombia">Bancolombia</option>
										          <option value="Banco Agrario">Banco Agrario</option>
										          <option value="Banco Caja Social">Banco Caja Social</option>
										          <option value="Davivienda">Davivienda</option>
										          <option value="Efecty">Quiero Recibir Pagos por Efecty</option>
										        </select>
									        </div>
									        <div class="col-md-6 margin-latestc-top">
									            <input type="number" min="0" max="100000000000" name="Cuenta" class="cuenta" placeholder="Nº Cuenta de Ahorros (Ej: 11100088899)" required/>
									        </div>
									    </div>
			            			<?php
			            		}else{
			            			foreach ($GetAccountUser as $DataAccount) {
			            				?>
			            					<div class="form-group">
			            						<div class="col-md-6">
									            	<select name="Banco" class="banco" onchange="Change(this.value)" required/>
											          <option value="<?php echo $DataAccount[1]; ?>"><?php echo $DataAccount[1]; ?></option>
											          <option value="" disabled>Seleccione un Banco</option>
											          <option value="Bancolombia">Bancolombia</option>
											          <option value="Banco Agrario">Banco Agrario</option>
											          <option value="Banco Caja Social">Banco Caja Social</option>
											          <option value="Davivienda">Davivienda</option>
											          <option value="Efecty">Quiero Recibir Pagos por Efecty</option>
											        </select>
									        	</div>
										        <div class="col-md-6">
										            <input type="number" min="0" max="10000000000000000000" name="Cuenta" class="cuenta" value="<?php echo $GuruApi->StringDecode($DataAccount[0]); ?>" placeholder="Nº Cuenta de Ahorros (Ej: 11100088899)" required/>
										        </div>
										    </div>
			            				<?php
			            			}
			            		}
			            	?>
						    <div class="form-group">
						    	<div class="col-md-12 margin-lesta-top margin-bottom">
						    		<center>
								    	<button type="submit" id="verify"  class="btn btn-default">Guardar</button>
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
    <?php include ("../includes-front/footer.php"); ?>
    <!--Scripts-->
    <?php include ("includes/scripts-dev.html"); ?>
    <script type="text/javascript">
    //script para subir imagen
    	(function() {
		  'use strict';
		  $('.input-file').each(function() {
		    var $input = $(this),
		      $label = $input.next('.js-labelFile'),
		      labelVal = $label.html();

		    $input.on('change', function(element) {
		      var fileName = '';
		      if (element.target.value) fileName = element.target.value.split('\\').pop();
		      fileName ? $label.addClass('has-file').find('.js-fileName').html(fileName) : $label.removeClass('has-file').html(labelVal);
		    });
		  });

		})();
    </script>
    <script type="text/javascript">
    	function Change(button){
    		$(".cuenta").val('');
    		if (button=="Efecty") {
    			mostrarRespuesta("Llena el Valor de la cuenta con unos y ceros",false)
    		}else if(button=="Bancolombia"){
    			mostrarRespuesta(button+": Esta cuenta consta de 11 Dígitos",false)
    		}else if(button=="Banco Agrario"){
    			mostrarRespuesta(button+": Esta cuenta consta de 12 Dígitos",false)
    		}else if(button=="Banco Caja Social"){
    			mostrarRespuesta(button+": Esta cuenta consta de 11 Dígitos",false)
    		}else if(button=="Davivienda"){
    			mostrarRespuesta(button+": Esta cuenta consta de 12 Dígitos",false)
    		}
    	}
    	function mostrarRespuesta(mensaje, ok){//Esta función añade la respuesta a un contenedor HTML
        	$('#respuesta').css('display','block');
            $("#respuesta").removeClass('alert-success').removeClass('alert-danger').html(mensaje);
            if(ok){
                $("#respuesta").addClass('alert-success');
            }else{
                $("#respuesta").addClass('alert-danger');
            }
        }
    </script>
</body>
</html>