<?= $headers; ?>
<?= $helper->PopUpBody(); ?>
<body>
	<!--Navigation-->
	<?= $menuFront; ?>
	<!--Front-->
  	<section>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="padding margin-top intermediate">
						<h1>Publica una Vacante</h1>
			            <hr>
			            <form action="<?= BASE_DIR; ?>/la_bolsa/insertar_vacante/" method="POST">
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
</body>
<!-- /Content -->
<?= $footer; ?>
<?= $resource_script; ?>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Home/hostname.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=s2wi0xpte6v7aabzfpepgp6f37mq2btp9p1m7ybe7tzaxoy1"></script>
<script>
 	tinymce.init({
		selector: 'textarea',
		height: 150,
		menubar: false,
		toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify',
		content_css: [
			'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
			'//www.tinymce.com/css/codepen.min.css'
		]
	});
</script>