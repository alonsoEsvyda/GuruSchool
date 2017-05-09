<?php
  include('../session/session_parameters.php');
  include ("../class/functions.php");
  include ("../class/function_data.php");
  	
  	//Llamamos la clase GuruApi
	$GuruApi = new GuruApi();
  	if (!isset($_GET['IdC']) || $_GET['IdC']=="") {
  		header("Location:http://localhost/GuruSchool/desk/user?request=Ups, Hubo un Error");
  	}else{
	  	//llamamos a la clase ModelHTMLTeach
		$ModelHTMLTeach=new ModelHTMLTeach();
		//traemos el metodo que nos retorna los datos del curso
		$ArrDataCourse=$ModelHTMLTeach->GetDataRejectedCourse($GuruApi->TestInput($_GET['IdC']),$_SESSION['Data']['Id_Usuario'],"Rechazado");
		if ($ArrDataCourse==false) {
			header("Location:http://localhost/GuruSchool/desk/teach/teacher?request=Ups, Hubo un Error");
		}else{
			list($IntIdCourse,$StrNameTeachC,$StrImage,$StrStateCourse,$StrTypecourse,$Intprice,$StrResumen,$StrDescripcion,$StrCategorie,$StrSubcategorie,$StrVideo,$StrNota)=$ArrDataCourse;
		}
		//traemos el metodo que nos retorna las categorías
		$ArrCategorias=$ModelHTMLTeach->GetCategoriesHtml();
  	}

  	//llamamos a la clase ValidateData
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
	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="padding margin-top intermediate">
						<h1>Curso: <?php echo $StrNameTeachC; ?> </h1>
			            <hr>
						  <?php
						  if ($StrNota==NULL) {
						  	?>
						  	<p class="margin-none p-bold">No hay Notas en este momento, reenviar curso o corregir errores <BR></p>
						  	<?php
						  }else{
						  	?>
						  	<div class="alert alert-dismissible alert-danger">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  <h3><i class="fa fa-pencil-square-o" aria-hidden="true"></i> NOTA:</h3><br>
						  	  <p class="margin-none"><?php echo $StrNota; ?></p>
						  	</div>
						  	<?php
						  }
						  ?>
						<hr>
			            <form class="green-word" action="controll/update_course.php" method="POST" enctype="multipart/form-data">
			            	<div class="form-group">
						        <div class="col-md-12">
						        <h4>Nombre y Resumen de tu Curso</h4>
						    	<hr>
						            <input type="text" name="NombreCurso" value="<?php echo $StrNameTeachC; ?>" data-toggle="tooltip" data-placement="top" title="Escribe un Nombre Sencillo, fácil de aprender.." placeholder="Nombre del Curso (Máximo: 120 Caracteres)" required/>
						        </div>
						    </div>
						    <div class="form-group">
						        <div class="col-md-12 margin-lestc-top">
						            <input type="text" name="Resumen" value="<?php echo $StrResumen; ?>" data-toggle="tooltip" data-placement="top" title="Cuentanos en breve de tu curso, trata de ser Preciso." placeholder="Escribe un Resumen Corto del Curso. (Máximo 260 Caracteres)" required/>
						        </div>
						    </div>
						    <div class="form-group">
						    	<div class="col-md-12 margin-lestc-top">
						    	<h4>Descripción Completa del Curso</h4>
						    	<hr>
						            <textarea name="Descripcion" placeholder="Escribe la descripción Completa de tu Curso, con puntos y señales...."><?php echo $StrDescripcion; ?></textarea>
						        </div>
						    </div>
						    <div class="form-group">
						    	<div class="col-md-6 margin-lestb-top">
						            <select class="categoria" name="categoria" onclick="GetSubCat(this)" required/>
						            	<option selected><?php echo $StrCategorie; ?></option>
						            	<?php
						            		foreach ($ArrCategorias as $DataCat) {
						            			?>
						            				<option value="<?php echo $DataCat[0]; ?>"><?php echo $DataCat[0]; ?></option>
						            			<?php
						            		}
						            	?>
						            </select>
						        </div>
						        <div class="col-md-6 margin-lestb-top">
						            <select class="sub_categoria" name="sub-categoria" required/>
						            	<option selected><?php echo $StrSubcategorie; ?></option>
						            </select>
						        </div>
						    </div>
						    <div class="form-group">
						        <div class="col-md-12 margin-lest-top">
						        <h4>Importa una Vídeo Promocional</h4>
						    	<hr>
						    		<?php 
						    			if ($StrVideo==NULL) {
						    				?>
						    				<input type="url" name="VideoYoutube" data-toggle="tooltip" data-placement="top" title="Importa el vídeo desde Youtube" placeholder="Sube el Vídeo Promocional, copia aquí la URL"/>
						    				<?php
						    			}else{
						    				?>
						    				<input type="url" name="VideoYoutube" value="<?php echo "https://www.youtube.com/watch?v=".$StrVideo; ?>" data-toggle="tooltip" data-placement="top" title="Importa el vídeo desde Youtube" placeholder="Sube el Vídeo Promocional, copia aquí la URL"/>
						    				<iframe class="video" width="100%" height="500px" src="http://www.youtube.com/embed/<?php echo $StrVideo; ?>?controls=0&showinfo=0" frameborder="0"></iframe>
						    				<?php
						    			}
						    		?>
						        </div>
						    </div>
						    <div class="form-group">
						    	<div class="col-md-12 margin-lest-top">
						    	<h4>Imagen Promocional (Recuerda: Solo Formato: JPG Y PNG y una Resolución de 1000px X 530px)</h4>
						    	<hr>
						           	<img style="width:100%;height:auto;" src="../img_user/Cursos_Usuarios/<?php echo $StrImage; ?>">
						           	<input type="file" name="foto" id="file" class="input-file"/>
									  <label for="file" class="btn btn-tertiary js-labelFile">
									    <i class="icon fa fa-check"></i>
									    <span class="js-fileName">Cambia la Foto Promocional</span>
									  </label>
						        </div>
						    </div>
						    <div class="form-group">
						    	<div class="col-xs-12 margin-lest-top margin-bottom">
						    		<!--<input type="radio" value="1" name="habilitarDeshabilitar" onchange="habilitar(this.value);" checked> Gratis-->
						    		<h4>Deseas que tu Curso sea Grátis?</h4>
						    		<hr>
						    		<?php
						    		$tipo=$StrTypecourse;
						    		$valor=$Intprice;
						    			if ($tipo=="Gratis") {
						    				?>
						    					<input type="radio" name="radio" id="yes" value="1" onchange="habilitar(this.value);" checked/>
												<input type="radio" name="radio" id="no" value="0" onchange="habilitar(this.value);"/>
						    				<?php
						    			}else if($tipo=="De Pago"){
						    				?>
						    					<input type="radio" name="radio" id="yes" value="1" onchange="habilitar(this.value);"/>
												<input type="radio" name="radio" id="no" value="0" onchange="habilitar(this.value);" checked/>
						    				<?php
						    			}
						    		?>
									  <div class="switch">
									    <label for="yes">SI</label>
									    <label for="no">NO</label>
									    <span></span>
									  </div>
						        </div>
						        
						    </div>
						    <div class="form-group">
						    	<div class="col-xs-6 margin-lestb-top">
						    		<input type="number" class="precio" name="precio" value="<?php echo $valor; ?>" data-toggle="tooltip" data-placement="top" title="Pon un Precio Justo a tu Curso, así lograrás vender más!!" placeholder="$ Precio" required/>
						    	</div>
						    </div>
						    <div class="form-group">
						    	<div class="col-xs-12 margin-lesta-top">
						    		<center>
						    			<input type="hidden" name="IdC" value="<?php echo $GuruApi->StringEncode($_GET['IdC']); ?>">
								    	<button type="submit" class="btn btn-default">Guardar</button>
								    </center>
								    <hr>
						    	</div>
						    </div>
						</form>
						    <div class="form-group">
						    	<div class="col-xs-12 margin-bottom">
						    		<center>
								    	<button type="submit"  data-toggle="modal" data-target="#myModal" data-toggle="tooltip" data-placement="left" title="Solo Pincha Aquí cuando estés Seguro y hallas subido tus vídeos.." class="btn btn-info">Reenviar para Revisión</button>
								    	<!--MODAL CONFIRMATION-->
										<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
										    <div class="modal-dialog" role="document">
										        <div class="modal-content">
										            <div class="modal-header">
										                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										                    <span aria-hidden="true">&times;</span>
										                </button>
										                <h3 class="modal-title" id="myModalLabel">Esta seguro que desea Envíar?</h3>
										            </div>
										            <div class="modal-footer">
										            	<center>
											            	<button type="button" class="btn btn-primary" data-id="<?php echo $GuruApi->StringEncode($_GET['IdC']); ?>" value="si" onclick="publicar(this)">yes</button>
											                <button type="button" class="btn btn-secondary" value="no" data-dismiss="modal">no</button>
										            	</center>
										            </div>
										   		 </div>
											</div>
										</div>
								    </center>
						    	</div>
						    </div>
					</div>
				</div>
			</div>
		</div>
	</section>	
	<!--Footer-->
    <?php include ("../../includes-front/footer.php"); ?>
    <!--Scripts-->
    <?php include ("includes/scripts-dev.html"); ?>
    <script type="text/javascript">	
    //script para traer sub-categorias
		 function GetSubCat (input){
		 	$(input).change(function(){
			    $.ajax({
			      url:"controll/get-sub-cat.php",
			      type: "POST",
			      data:"categoria="+$(input).val(),
			      success: function(info){
			        $('.sub_categoria').html(info);
			      }
			    })
			  });
		 }
	</script>
    <script>
    //Script para habilitar  y des-habilitar campo precio
    	$(document).ready(function(){
    		// deshabilitamos campo precio al cargar
			$(".precio").attr('disabled', 'disabled');
			if ($(".precio").val()==0 || $(".precio").val()=="" ) {
				$(".precio").css('display','none');
			}else{
				$(".precio").removeAttr("disabled");
				$(".precio").css('display','block');
			}
    	});
		function habilitar(value)
		{
			if(value=="1")
			{
				// deshabilitamos campo precio
				$(".precio").attr('disabled', 'disabled');
				$(".precio").css('display','none');
			}else if(value=="0"){
				// habilitamos campo precio
				$(".precio").removeAttr("disabled");
				$(".precio").css('display','block');
			}
		}
	</script>
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
    //Script confirmation para envíar a revisión
        function publicar(button){
			if(button.value=="si"){
            	$.post('controll/send_confirmation.php',{
                	Id:$(button).attr('data-id'),
                },function(info){
                    window.location="teacher?requestok="+info;
                });
            }else{
            	alert("error");
            }
        }
    </script>
</body>
</html>