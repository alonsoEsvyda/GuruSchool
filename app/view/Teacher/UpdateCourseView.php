<?= $headers; ?>
<?= $helper->PopUpBody(); ?>
<body>
  <!--Navigation-->
  <?= $menuFront; ?>
  <?php
  	list($IntIdCourse,$StrNameTeachC,$StrImage,$StrStateCourse,$StrTypecourse,$Intprice,$StrResumen,$StrDescripcion,$StrCategorie,$StrSubcategorie,$StrVideo,$StrNota)=$ArrDataCourse;
  ?>
  <!--Front-->
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
		            <form class="green-word" action="<?= BASE_DIR; ?>/maestros/UpdateCourse/" method="POST" enctype="multipart/form-data">
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
					           	<img style="width:100%;height:auto;" src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/<?php echo $StrImage; ?>">
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
					    			<input type="hidden" name="IdC" value="<?php echo $helper->StringEncode($_GET['parametro']); ?>">
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
										            	<button type="button" class="btn btn-primary" data-id="<?php echo $helper->StringEncode($_GET['parametro']); ?>" value="si" onclick="publicar(this)">yes</button>
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
</body>
<!-- /Content -->
<?= $footer; ?>
<?= $resource_script; ?>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=s2wi0xpte6v7aabzfpepgp6f37mq2btp9p1m7ybe7tzaxoy1"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Home/hostname.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/app.js"></script>
<!--subir vídeos-->
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/ajax/upload.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/jquery/config_notify.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/jquery/config_tinymice.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/jquery/getSubcat.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/jquery/config_data_img.js"></script>
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
	function publicar(button){
		if(button.value == "si"){
	    	$.post(Hostname()+'/GuruSchool/maestros/sendConfirmationCourse/',{
	        	Id:$(button).attr('data-id'),
	        },function(info){
	        	if (info == true) {
	        		window.location=Hostname()+"/GuruSchool/maestros/dashboard&requestok=Curso en Revisión: Espere Mientras lo Aprobamos";
	        	}else{
	        		window.location=Hostname()+"/GuruSchool/maestros/dashboard&requestok=Hubo un error en el envío, intente más tarde.";
	        	}
	        });
	    }else{
	    	alert("error");
	    }
	}
</script>
<script type="text/javascript">
//script para  btn file
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


