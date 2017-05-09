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
		$ArrDataCourse=$ModelHTMLTeach->GetDataRejectedCourse($GuruApi->TestInput($_GET['IdC']),$_SESSION['Data']['Id_Usuario'],"Aprobado");
		if ($ArrDataCourse==false) {
			header("Location:http://localhost/GuruSchool/desk/teach/teacher?request=Ups, Hubo un Error");
		}else{
			list($IntIdCourse,$StrNameTeachC,$StrImage,$StrStateCourse,$StrTypecourse,$Intprice,$StrResumen,$StrDescripcion,$StrCategorie,$StrSubcategorie,$StrVideo,$StrNota)=$ArrDataCourse;
		}
		//llamamos a la clase SQLGetSelInt
		$SQLGetSelInt= new SQLGetSelInt();
		//traemos el metodo que  nos retorna los vídeos
		$ArrDataVideo=$SQLGetSelInt->SQLDataVideos($GuruApi->TestInput($_GET['IdC']));
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
	<?php
      include("includes/pop_up-dev.php");
    ?>
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
									<input type="hidden" name="IdC" id="IdC" data-id="<?php echo $GuruApi->StringEncode($_GET['IdC']); ?>" >
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
												<a  data-id="<?php echo $GuruApi->StringEncode($DataVideo[1]); ?>" data-case="free" onclick="eliminar(this)">
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
										            	<button type="button" class="btn btn-primary" data-id="<?php echo $GuruApi->StringEncode($_GET['IdC']); ?>" value="si" onclick="send_review(this)">yes</button>
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
							  		<p class="margin-none">sube vídeos cortos de 5min máximo, no excedas el limite, procura resumir, sin perder ningun dato importante que tus estudiantes deban aprender.... Solo vídeos con formato Mp4 (Máximo Vídeos de 15MB)</p>
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
										<input type="hidden" id="IdC" name="IdC" value="<?php echo $GuruApi->StringEncode($_GET['IdC']); ?>" >
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
												<a data-id="<?php echo $GuruApi->StringEncode($DataVideo[1]); ?>" data-case="pay" onclick="eliminar(this)">
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
										            	<button type="button" class="btn btn-primary" data-id="<?php echo $GuruApi->StringEncode($_GET['IdC']); ?>" value="si" onclick="send_review(this)">yes</button>
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
	    						<img style="width:100%;" src="../img_user/Cursos_Usuarios/<?php echo $StrImage; ?>"><br><br>
	    					</div>
    					<?php		
    					}else{
    					?>
    						<div class="col-md-6">
	    						<img style="width:100%;" src="../img_user/Cursos_Usuarios/<?php echo $StrImage; ?>"><br><br>
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
	<!--Footer-->
    <?php include ("../../includes-front/footer.php"); ?>
    <!--Scripts-->
    <?php include ("includes/scripts-dev.html"); ?>

    <!--script para subir los vídeos por medio de Ajax-->
    <script type="text/javascript">
    //Script para subir los vídeos al Servidor
        function subirArchivosPago() {//Script para subir archivos de Pago
        	Name=$("#NameVideo").val(),
            $("#file").upload('controll/up_pay_videos.php',
            {
                NameVideo: Name,
                IdC: $("#IdC").val(),
            },
            function(respuesta) {
                //Una vez se suba el archivo entonces nos retorna una respuesta
                $("#barra_de_progreso").val(0);
                if (respuesta == false) {
                	$('#Progress').css('display','none');
                	mostrarRespuesta("<h3><i class='fa fa-exclamation-triangle' aria-hidden='true'></i>Error:</h3><br>-Revise que los Campos Esten Llenos<br><br>-Revise que sea un Vídeo Mp4<br><br>-No Exceda el Peso Limite del Archivo (30MB)",false);
                	HiddenInput(true);
                }else{
                	$('#Progress').css('display','none');
                    mostrarRespuesta('<i class="fa fa-check" aria-hidden="true"></i> El Video ha sido subido correctamente.', true);
                    HiddenInput(true);
                    $("#NameVideo, #file").val('');
                    $('#list-videos-pay').append('<li><td><p><i class="fa fa-play-circle-o" aria-hidden="true"></i>'+ Name +'<a data-id="'+respuesta[0]+'" data-case="pay" onclick="eliminar(this)"><i style="float:right;" class="fa fa-times" aria-hidden="true"></i></a><a data-idvideo="'+ respuesta[1] +'" data-case="pay" onclick="previewfree(this)"><i style="float:right;" class="fa fa-eye" aria-hidden="true"></i></a> </p></td></li>');
                }
            }, function(progreso, valor) {
                //Barra de progreso.
                $("#barra_de_progreso").val(valor);
            });
        }
        function subirArchivoFree(){//Script para subir archivos grátis
        	id=$('#IdC').attr('data-id'),
        	url=$('#UrlYoutube').val(),
        	name=$('#NameVideo').val(),
	       $.post('controll/up_free_videos.php',{
            	IdC:id,
            	UrlYoutube:url,
            	NameVideo:name,
            },function(info){
            	if (info==false) {
            		mostrarRespuesta("<h3><i class='fa fa-exclamation-triangle' aria-hidden='true'></i>Error:</h3><br>-Revise que los Campos Esten Llenos<br><br>-Revise que la Url del Vídeo sea Valida<br><br>-No Exceda el Limite de Caracteres",false)
            	}else{
            		mostrarRespuesta('<i class="fa fa-check" aria-hidden="true"></i> El Video ha sido subido correctamente.', true)
            		$('#UrlYoutube,#NameVideo').val('')
            		$('#list-videos-free').append('<li><td><p><i class="fa fa-play-circle-o" aria-hidden="true"></i>'+ name +'<a data-id="'+info+'" data-case="free"  onclick="eliminar(this)"><i style="float:right;" class="fa fa-times" aria-hidden="true"></i></a><a data-idvideo="'+ YouTubeGetID(url) +'" data-case="free" onclick="previewfree(this)"><i style="float:right;" class="fa fa-eye" aria-hidden="true"></i></a> </p></td></li>');
            	}
            });
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
        function HiddenInput(res){//esta función habilita y deshabilita el formulario
        	if (res) {
        		$("#file").removeAttr("disabled");
        		$("#NameVideo").removeAttr("disabled");
        		$('.send-pay').removeAttr("disabled");
        	}else{
        		$("#file").attr('disabled', 'disabled');
        		$("#NameVideo").attr('disabled', 'disabled');
        		$('.send-pay').attr('disabled', 'disabled');
        	}
        }
        function YouTubeGetID(url){//Script para Obtener el Id de youtube
		  var ID = '';
		  url = url.replace(/(>|<)/gi,'').split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
		  if(url[2] !== undefined) {
		    ID = url[2].split(/[^0-9a-z_\-]/i);
		    ID = ID[0];
		  }
		  else {
		    ID = url;
		  }
		    return ID;
		}
        $(document).ready(function() {//Empieza la función y llamamos los metodos creados
        	//videos de pago
            $(".send-pay").on('click', function() {
            	if ($('#file').val()=="" || $('#NameVideo').val()=="") {
            		mostrarRespuesta('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Tienes que Insertar un Vídeo', false);
            	}else{
            		$('#Progress').css('display','block');
            		HiddenInput(false);
               		subirArchivosPago();
            	}
            });
            //videos grátis
            $('.send-free').on('click', function(e){
            	e.preventDefault();
        		subirArchivoFree();
    		});
        });
    </script>
    <!--script para subir los vídeos por medio de Ajax-->


    <script type="text/javascript">
    	//enviamos el id para cambiar de estado
        function send_review(button){
			if(button.value=="si"){
            	$.post('controll/send_review.php',{
                	IdC:$(button).attr('data-id'),
                },function(info){
                    window.location="teacher?requestok="+info;
                });
            }
        }
        //script para elimiar vídeos
        function eliminar(button){
        	if ($(button).attr('data-case')=="free"){
        		$.post('controll/delete_video_free.php',{
	            	Id:$(button).attr('data-id'),
	            },function(info){
	               if (info==true) {
	               	$(button).parent('p').remove();
	               	mostrarRespuesta('<i class="fa fa-check" aria-hidden="true"></i> El Vídeo se Ha Eliminado.',true);
	               }else{
	               	mostrarRespuesta('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> El Vídeo no se Ha Borrado',false);
	               }
	            });
        	}else if($(button).attr('data-case')=="pay"){
        		$.post('controll/delete_video_pay.php',{
	            	Id:$(button).attr('data-id'),
	            },function(info){
	               if (info==true) {
	               	$(button).parent('p').remove();
	               	mostrarRespuesta('<i class="fa fa-check" aria-hidden="true"></i> El Vídeo se Ha Eliminado.',true);
	               }else{
	               	mostrarRespuesta('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> El Vídeo no se Ha Borrado',false);
	               }
	            });
        	}
        }
        //scripta para visulizar video
        function previewfree (button){
        	 if ($(button).attr('data-case')=="free") {
    	 		$('#msgMdal').html('<div class="modal-dialog"><div class="modal-content"><div class="modal-body" ><iframe class="video" width="100%" height="500px" src="http://www.youtube.com/embed/'+ $(button).attr('data-idvideo') +'?showinfo=0" frameborder="0"></iframe></div> </div></div>');
	        	 $('#msgMdal').modal();
        	 }else if($(button).attr('data-case')=="pay"){

        	 	$('#reproductor').html('<video id="video1" preload="auto" width="100%"  data-setup="{}"><source src="../videos_user/'+$(button).attr('data-idvideo')+'" type="video/mp4"><p class="vjsno-js"> To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/"</p></video>');
	        	 $('#msgMdal').modal();
        	 }
        }
    </script>
</body>
</html>