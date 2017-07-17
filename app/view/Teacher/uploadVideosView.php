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
    			<!--FOMULARIO PARA SUBIR VIDEOS EN CURSOS GRÁTIS-->
    			<?php
    			if ($StrTypecourse=="Gratis") {
    			?>
	    			<div class="col-xs-12 padding margin-top  intermediate">
						<h1>Sube Los vídeos de tu Curso</h1>
						<hr>
						  <?php
						  if ($StrNota!=NULL || $StrNota!="") {
						  ?>
						  	<div class="alert alert-dismissible alert-success">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  <h3><i class="fa fa-pencil-square-o" aria-hidden="true"></i> NOTA:</h3><br>
						  	  <p class="margin-none"><?php echo $StrNota; ?></p>
						  	</div>
						  	<?php
						  }
						  ?>
						  <div class="alert alert-dismissible alert-info">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  <h3><i class="fa fa-lightbulb-o" aria-hidden="true"></i> Recuerda:</h3><br>
						  		<p class="margin-none">sube vídeos cortos de (5min), no excedas el limite y procura resumir sin perder ningun dato importante que tus estudiantes deban aprender....</p>
						  </div>
						  <hr>
						<div style="display:none;" id="respuesta" class="alert"></div>
						<form action="javascript:void(0);"><!--action="controll/up_free_videos.php" method="POST"-->
							<div class="form-group">
								<div class="col-xs-12">
									<input type="text" maxlength="100" name="NameVideo" id="NameVideo" placeholder="Escribe el Nombre del Tema" required/>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<input type="url" maxlength="100" name="UrlYoutube" id="UrlYoutube" data-toggle="tooltip" data-placement="top" title="Copia la Url de tu vídeo, desde Youtube"  placeholder="Copia Aquí la URL desde Youtube" required/>
									<input type="hidden" name="IdC" id="IdC" data-id="<?php echo $helper->StringEncode($_GET['parametro']); ?>" >
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12 margin-bottom">
									<center>
										<button class="send-free btn btn-default">Guardar Vídeo</button>
									</center>
								</div>
							</div>
						</form>
						<div class="list-of-theme">
							<h1>Lista de Vídeos Por Tema</h1>
							<hr>
							<ul id="list-videos-free">
							<?php
							if ($ArrDataVideo==false) {
								?>
									<li>
										<td>
											<p>
												<i class="fa fa-play-circle-o" aria-hidden="true"></i>
												No Hay Vídeos
											</p>
										</td>
									</li>
								<?php
							}else{
								foreach ($ArrDataVideo as $DataVideo){
								?>
									<li>
										<td>
											<p>
												<i class="fa fa-play-circle-o" aria-hidden="true"></i>
													<?php echo $DataVideo[0]; ?>
												<a  data-id="<?php echo $helper->StringEncode($DataVideo[1]); ?>" data-case="free" onclick="eliminar(this)">
													<i style="float:right;" class="fa fa-times" aria-hidden="true"></i>
												</a>
												<a data-idvideo="<?php echo $DataVideo[2]; ?>" data-case="free" onclick="previewfree(this)">
													<i style="float:right;" class="fa fa-eye" aria-hidden="true"></i>
												</a>
											</p>
										</td>
									</li>
								<?php
								}
							}
							?>
							</ul>
						</div>
						<!-- Modal -->
					    <div class="modal fade" id="msgMdal">

					    </div>

						<div class="form-group">
							<div class="col-xs-12 margin-lestb-top">
								<center>
									<button type="submit"  data-toggle="modal" data-target="#myModal" class="btn btn-info">Enviar a Revisión</button>

									<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									    <div class="modal-dialog" role="document">
									        <div class="modal-content">
									            <div class="modal-header">
									                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									                    <span aria-hidden="true">&times;</span>
									                </button>
									                <h3 class="modal-title" id="myModalLabel">Esta seguro que desea Enviar?</h3>
									            </div>
									            <div class="modal-footer">
									            	<center>
										            	<button type="button" class="btn btn-primary" data-id="<?php echo $helper->StringEncode($_GET['parametro']); ?>" value="si" onclick="send_review(this)">yes</button>
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
    			<?php
	    		}else if($StrTypecourse=="De Pago"){
    			?>
	    			<!--FOMULARIO PARA SUBIR VIDEOS EN CURSOS DE PAGO-->
	    			<div class="col-xs-12 padding margin-top  intermediate">
						<h1>Sube Los vídeos de tu Curso</h1>
						<hr>
						  <div>
							  <?php
							  if ($StrNota!=NULL || $StrNota!="") {
							  ?>
							  	<div class="alert alert-dismissible alert-success">
								  <button type="button" class="close" data-dismiss="alert">×</button>
								  <h3><i class="fa fa-pencil-square-o" aria-hidden="true"></i> NOTA:</h3><br>
							  	  <p class="margin-none"><?php echo $StrNota; ?></p>
							  	</div>
							  <?php
							  }
							  ?>
							  <div class="alert alert-dismissible alert-info">
								  <button type="button" class="close" data-dismiss="alert">×</button>
								  <h3><i class="fa fa-lightbulb-o" aria-hidden="true"></i> Recuerda:</h3><br>
							  		<p class="margin-none">sube vídeos cortos de 5min máximo, no excedas el limite, procura resumir, sin perder ningun dato importante que tus estudiantes deban aprender.... Solo vídeos con formato Mp4 (Máximo Vídeos de 40MB)</p>
							  </div>
						  </div>
						<hr>
						<div id="Progress" style="display:none; padding:5px; border-radius:5px;" class="alert-info">
							<center>
								<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><br><br>
								<label style="color:rgba(0,0,0,0.6);">Estamos Subiendo tu vídeo...</label>
							<progress id="barra_de_progreso" value="0" max="100" style="width:90%;"></progress>
							</center>
						</div>
						<div style="display:none;" id="respuesta" class="alert"></div>
						<form action="javascript:void(0);">
							<div class="form-group">
								<div class="col-md-2">
									<div class="wrapper">
									  <div class="file-upload">
									    <input type="file" name="VideoArchivo" id="file" required/>
									    <i class="fa fa-folder-open-o" aria-hidden="true"></i>
									  </div>
									</div>
								</div>
								<div class="col-md-10">
									<input type="text" maxlength="100" name="NameVideo" id="NameVideo" placeholder="Escribe el Nombre del Tema" required/>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12 margin-lestc-top margin-bottom">
									<center>
										<button type="submit" class="send-pay btn btn-default">Subir Vídeo</button>
										<input type="hidden" id="IdC" name="IdC" value="<?php echo $helper->StringEncode($_GET['parametro']); ?>" >
									</center>
								</div>
							</div>
						</form>
						<div class="list-of-theme">
							<h1>Lista de Vídeos Por Tema</h1>
							<hr>
							<ul id="list-videos-pay">
							<?php
							if ($ArrDataVideo==false) {
								?>
									<li>
										<td>
											<p>
												<i class="fa fa-play-circle-o" aria-hidden="true"></i>
												No Hay Vídeos
											</p>
										</td>
									</li>
								<?php
							}else{
								foreach ($ArrDataVideo as $DataVideo){
								?>
									<li>
										<td>
											<p>
												<i class="fa fa-play-circle-o" aria-hidden="true"></i>
													<?php echo $DataVideo[0]; ?>
												<a data-id="<?php echo $helper->StringEncode($DataVideo[1]); ?>" data-case="pay" onclick="eliminar(this)">
													<i style="float:right;" class="fa fa-times" aria-hidden="true"></i>
												</a>
												<a data-idvideo="<?php echo $DataVideo[2]; ?>" data-case="pay" onclick="previewfree(this)">
													<i style="float:right;" class="fa fa-eye" aria-hidden="true"></i>
												</a>
											</p>
										</td>
									</li>
								<?php
								}
							}
							?>
							</ul>
						</div>
						<!-- Modal -->
					    <div class="modal fade" id="msgMdal">
				            <div class="modal-dialog" role="document">
							    <div class="modal-content">
						            <div id="reproductor" class="modal-body">

						            </div>
						            <div id="control-media" class="modal-footer">
			                			<div id="play-btn" class="video-controls"><i class="fa fa-play" aria-hidden="true"></i></div>
			                			<div id="pause-btn" class="video-controls"><i class="fa fa-pause" aria-hidden="true"></i></i></div>
			                			<div id="stop-btn" class="video-controls"><i class="fa fa-stop" aria-hidden="true"></i></div>
			                			<div id="mute-btn" class="video-controls"><i class="fa fa-volume-off" aria-hidden="true"></i></div>
			                			<div id="unmute-btn" class="video-controls"><i class="fa fa-volume-up" aria-hidden="true"></i></div>
						            </div>
							    </div>
				            </div>
					    </div>
						<div class="form-group">
							<div class="col-xs-12 margin-lestb-top">
								<center>
									<button type="submit"  data-toggle="modal" data-target="#myModal" class="btn btn-info">Enviar a Revisión</button>

									<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									    <div class="modal-dialog" role="document">
									        <div class="modal-content">
									            <div class="modal-header">
									                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									                    <span aria-hidden="true">&times;</span>
									                </button>
									                <h3 class="modal-title" id="myModalLabel">Esta seguro que desea Publicar?</h3>
									            </div>
									            <div class="modal-footer">
									            	<center>
										            	<button type="button" class="btn btn-primary" data-id="<?php echo $helper->StringEncode($_GET['parametro']); ?>" value="si" onclick="send_review(this)">yes</button>
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
    			<?php
	    		}
    			?>
    			<!--DATOS DEL CURSO-->
    			<div class="col-xs-12 padding-left padding-right padding-bottom intermediate">
    			<h1>Detalles De tu Curso</h1>
    			<hr>
    				<div class="form-group">
    					<?php
    					if ($StrVideo==NULL) {
    					?>
    						<div class="col-md-12">
	    						<img style="width:100%;" src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/<?php echo $StrImage; ?>"><br><br>
	    					</div>
    					<?php		
    					}else{
    					?>
    						<div class="col-md-6">
	    						<img style="width:100%;" src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/<?php echo $StrImage; ?>"><br><br>
	    					</div>
	    					<div class="col-md-6">
	    						<iframe class="video" width="100%" height="330px" src="http://www.youtube.com/embed/<?php echo $StrVideo; ?>?controls=0&showinfo=0" frameborder="0"></iframe>
	    					</div>
    					<?php
    					}
    					?>
    				</div>
    				<div class="green-word2 form-group">
				        <div class="col-md-12">
				        <h3>Nombre:</h3><br>
				        <h4><?php echo $StrNameTeachC; ?></h4>
				    	<hr>
				    	<h3>Resumen:</h3><br>
				    	<h4><?php echo $StrResumen; ?></h4>
				    	<hr>
				    	<h3>Descripción:</h3>
				    	<h4><?php echo $StrDescripcion; ?></h4>
				    	<hr>
				    	<h3>Este Curso es :</h3><br>
				    	<?php
				    	if ($StrTypecourse=="Gratis") {
				    	?>
				    		<h2><span class="label label-success">Gratis</span></h2>
				    	<?php
				    	}else{
				    	?>
				    		<h2><span class="label label-danger">De Pago: $<?php echo $Intprice; ?> COP</span></h2>
				    	<?php	
				    	}
				    	?>
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
<!--subir vídeos-->
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/ajax/upload.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/jquery/config_notify.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/jquery/config_tinymice.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/jquery/config_data_img.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/jquery/config_video.js"></script>
<!--script para subir los vídeos por medio de Ajax-->
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/jquery/config_and_upload_videos.js"></script>
