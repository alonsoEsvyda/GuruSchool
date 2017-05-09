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
	
	//Llamamos la clase GuruApi
	$GuruApi = new GuruApi();
  	//Validamos el tiempo de vida de la sesión
  	$TimeSession=$ValidateData->SessionTime($_SESSION['Data']['Tiempo'],"http://localhost/GuruSchool/desk/session/logout.php");
  	//Asignamos el tiempo actual a la variable de sesión
  	$_SESSION['Data']['Tiempo']=date("Y-n-j H:i:s");
	//traemos la ip real del usuario
	$GetRealIp = $GuruApi->getRealIP();
	//validamos que exista la sesión y las credenciales sean correctas
	$ValidateSession = $ValidateData->ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,"http://localhost/GuruSchool/iniciar-sesion?request=iniciar sesion");
	//llamamos a la clase ModelHTMLTeach
	$ModelHTMLTeach=new ModelHTMLTeach();
	//Traemos el meotod que nos retona la categorías
	$ArrCategorias=$ModelHTMLTeach->GetCategoriesHtml();

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
<?php
  include("includes/pop_up-dev.php");
?>
	<!--Menú-->
	<?php include ("includes/menu-dev.php"); ?>
	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="padding margin-top intermediate">
						<h1>Información del Curso</h1>
			            <hr>
						<div class="alert alert-dismissible alert-success">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  <h3><i class="fa fa-lightbulb-o" aria-hidden="true"></i> Recuerda:</h3><br>
						  		<p class="margin-none">De la información que escribas en este formulario dependerá el éxito de tu curso, trata de ser sencillo, utiliza palabras que cualquiera pueda entender, pero también contenido inteligente que refleje la calidad de lo que ofreces..</p>
						</div>
						<hr>
			            <form class="green-word" action="controll/up_course" method="POST" enctype="multipart/form-data">
			            	<div class="form-group">
						        <div class="col-md-12">
						        <h4>Escribe el Nombre y Resumen de tu Curso</h4>
						    	<hr>
						            <input type="text" name="NombreCurso"  maxlength="100" data-toggle="tooltip" data-placement="top" title="Escribe un Nombre Sencillo, fácil de aprender.." placeholder="Nombre del Curso (Máximo: 100 Caracteres)" required/>
						        </div>
						    </div>
						    <div class="form-group">
						        <div class="col-md-12 margin-lestc-top">
						            <input type="text" data-toggle="tooltip" data-placement="top" title="Cuentanos en breve de tu curso, trata de ser Preciso." name="Resumen" placeholder="Escribe un Resumen Corto del Curso. (Máximo 260 Caracteres)" required/>
						        </div>
						    </div>
						    <div class="form-group">
						    	<div class="col-md-12 margin-lestc-top">
						    	<h4>Descripción Completa del Curso</h4>
						    	<hr>
						            <textarea name="Descripcion" placeholder="Escribe la descripción Completa de tu Curso, con puntos y señales...."></textarea>
						        </div>
						    </div>
						    <div class="form-group">
						    	<div class="col-md-6 margin-lestb-top">
						            <select class="categoria" name="categoria" onclick="GetSubCat(this)" required/>
						            	<option value="" disabled selected>Seleccione Categoría</option>
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
						            	<option value="" disabled selected>Sub-Categoría</option>
						            </select>
						        </div>
						    </div>
						    <div class="form-group">
						        <div class="col-md-12 margin-lesta-top">
						        <h4>Importa una Vídeo Promocional</h4>
						    	<hr>
						            <input type="url" data-toggle="tooltip" data-placement="top" title="Importa el vídeo desde Youtube" name="VideoYoutube" placeholder="Sube el Vídeo Promocional, copia aquí la URL"/>
						        </div>
						    </div>
						    <div class="form-group">
						    	<div class="col-md-12 margin-top">
						    	<h4>Imagen Promocional (Recuerda: Solo Formato: JPG Y PNG y una Resolución de 1000px X 530px)</h4>
						    	<hr>
						           	<div class="content-image">
										<label class="input-file-img" for="files"><i class="fa fa-upload" aria-hidden="true"></i> Upload Image</label>
											<input type='file' name="archivo" id="files" class="imgInp">
								    	<br/>
									    <img id="blah" class="thumb" src="../../css/imagenes/imagen_unavaible.png" alt="your image" />
						           	</div>
						        </div>
						    </div>
						    <div class="form-group">
						    	<div class="col-xs-12 margin-lestb-top margin-bottom">
						    		<h4>Deseas que tu Curso sea Grátis?</h4>
						    		<hr>
									<input type="radio" name="radio" id="yes" value="1" onchange="habilitar(this.value);" checked/>
									<input type="radio" name="radio" id="no" value="0" onchange="habilitar(this.value);" />
									  <div class="switch">
									    <label for="yes">SI</label>
									    <label for="no">NO</label>
									    <span></span>
									  </div>
						        </div>
						        
						    </div>
						    <div class="form-group">
						    	<div class="col-xs-6 margin-lestb-top">
						    		<input type="number" class="precio" name="precio" data-toggle="tooltip" data-placement="top" title="Pon un Precio Justo a tu Curso, así lograrás vender más!!" placeholder="$ Precio" required/>
						    	</div>
						    </div>
						    <div class="form-group">
						    	<div class="col-xs-12 margin-lesta-top margin-bottom">
						    		<center>
								    	<button type="submit" class="btn btn-default">Guardar</button>
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
			$(".precio").css('display','none');
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
    //Script para visualizar la miniatura de la imagen de perfil
        function readURL(input) {
	        if (input.files && input.files[0]) {
	            var reader = new FileReader();
	            reader.onload = function (e) {
	                $('#blah').attr('src', e.target.result);
	            }
	            reader.readAsDataURL(input.files[0]);
	        }
	    }
	    $(".imgInp").change(function(){
	        readURL(this);
	    });       
    </script>
</body>
</html>