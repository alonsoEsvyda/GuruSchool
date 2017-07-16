<?= $headers; ?>
<?= $helper->PopUpBody(); ?>
<body ng-app="AppTeachers">
  <!--Navigation-->
  <?= $menuFront; ?>
  <!--Front-->
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
			            <form class="green-word" action="<?= BASE_DIR; ?>/maestros/UpNewCourse/" method="POST" enctype="multipart/form-data">
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
									    <img id="blah" class="thumb" src="<?= BASE_DIR; ?>/design/css/imagenes/imagen_unavaible.png" alt="your image" />
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
</body>
<!-- /Content -->
<?= $footer; ?>
<?= $resource_script; ?>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=s2wi0xpte6v7aabzfpepgp6f37mq2btp9p1m7ybe7tzaxoy1"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Home/hostname.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/app.js"></script>
<!--subir vídeos-->
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/ajax/upload.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/jquery/config_tooltip.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/jquery/config_notify.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/jquery/config_tinymice.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/jquery/getSubcat.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/jquery/config_input.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/jquery/config_data_img.js"></script>

