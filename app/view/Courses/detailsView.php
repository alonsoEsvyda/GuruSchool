<?= $headers; ?>
<?= $helper->PopUpBody(); ?>
<!-- Content -->
<?php 
	//Detalles Curso
	list($IdPkCurso,$IdFkUser,$StrNameCurso,$StrResumen,$StrResComplete,$ImagenCurso,$VideoCurso,$Intprecio,$StrTipoCurso,$StrSubCategoria,$StrCategoria)=$GetDataCourse;
	//Detalles Usuario
    list($IntIdUser,$StrName,$StrImagenUser,$StrImageMin,$StrBiogra,$StrProfession,$StrFace,$StrGoogle,$StrLinked,$StrTwitt)=$GetDataUser;
?> 
  <meta name=" title" content="<?php echo $StrNameCurso; ?>">
  <meta property="og:title" content="<?php echo $StrNameCurso; ?>" />
  <meta property="og:description" content="<?php echo $StrResumen; ?>" />
  <meta property="og:image" content="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/<?php echo $ImagenCurso; ?>" />
<body>
  	<!--Navigation-->
    <?= $menuFront; ?>
    <!--Details Curso-->
    <section class="main">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-9">
                    <!--DATOS DEL CURSO: video principal y programa -->
    				<div class="content-inside content-font intermediate table-responsive">
                        <h1 class="h1-alternative-size"><?= $StrNameCurso; ?></h1>
                        <p class="p-bold"><?= $StrResumen; ?></p>
                        <hr>
                        <!--arbol-->
                        <div class="padding-lesta-bottom">
                            <ol class="ol-list">
                                <li><a> <?= $StrCategoria; ?> &nbsp;&nbsp; <i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp;&nbsp; </a></li>
                                <li><a> <?= $StrSubCategoria; ?> &nbsp;&nbsp; <i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp;&nbsp; </a></li>
                                <li><a> <?= $StrNameCurso; ?></a></li>
                            </ol>
                            <label class="black-letter p-bold">&nbsp;&nbsp;  •  &nbsp;&nbsp;<i class="fa fa-user" aria-hidden="true">&nbsp;</i><?= $SQLStudentsIn; ?> Alumnos Inscritos</label>
                        </div>
                        <!--imagen o vídeo del curso-->
                        <?php if ($VideoCurso==NULL) { ?>
                            <img width="100%" height="auto" src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/<?= $ImagenCurso; ?>"></img>
                        <?php }else{ ?>
                            <iframe class="video" width="100%" height="500px" src="http://www.youtube.com/embed/<?= $VideoCurso; ?>?controls=0&showinfo=0" frameborder="0"></iframe>
                        <?php } ?>
                        <hr>
                        <div class="content-description margin-lestc-top">
                            <h2>Descripción del Curso</h2>
                            <hr>
                            <p><?= $StrResComplete; ?></p>
                            <table class="table table-hover">
                              <thead>
                                  <tr>
                                    <th>Programa</th>
                                  </tr>
                              </thead>
                                <tbody>
                                  <?php foreach ($GetDataVideos as $DataVideo) { ?>
                                       <tr>
                                            <td><p><i class="fa fa-play-circle-o" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= $DataVideo[0]; ?></p></td>
                                          </tr>
                                   <?php } ?>
                                </tbody>
                            </table>
                        </div>
    				</div>
    			</div>
    			<div class="col-md-3">
    				<div class="content-right intermediate">
                    <!--DATOS ADICIONALES DEL CURSO, COMO PRECIO Y QUE INCLUYE-->
                        <?php $IntIdEncode = $helper->StringEncode($IntIdCourse);//Encriptamo el Id para enviarlo por Ajax ?>
                        <a class="Apuntar"  data-id="<?= $IntIdEncode; ?>" >
                            <button type="button"  data-toggle="tooltip" data-placement="top" title="Genial!" class="margin-top waves-effect waves-light btn btn-default">Apuntate</button>
                        </a>
                        <?php if (utf8_encode($StrTipoCurso)=="Gratis") {?>
                            <div class="margin-lestc-top">
                                <h1 class="black-letter">Este Curso Es Grátis</h1>
                            </div>
                            <hr>
                            <h2>Este Curso Incluye:</h2>
                            <p>
                                <i class="fa fa-graduation-cap" style="color:#16a085;" aria-hidden="true"></i>&nbsp; Certificado<br>
                                <i class="fa fa-thumbs-o-up" style="color:#2980b9;" aria-hidden="true"></i>&nbsp; Una Experiencia Inolvidable<br>
                                <i class="fa fa-heart-o" style="color:#c0392b;" aria-hidden="true"></i>&nbsp; Acceso de por Vida<br>
                                <i class="fa fa-commenting-o" style="color:#f39c12;" aria-hidden="true"></i>&nbsp; Asitencia del Tutor<br>
                            </p>
                            
                        <?php }else if(utf8_encode($StrTipoCurso)=="De Pago"){ ?>
                            <div class="margin-lestc-top">
                                <h1 class="black-letter">$ <?= number_format($Intprecio); ?> COP</h1>
                            </div>
                            <hr>
                            <h2>Este Curso Incluye:</h2>
                            <p>
                                <i class="fa fa-graduation-cap" style="color:#16a085;" aria-hidden="true"></i>&nbsp; Certificado<br>
                                <i class="fa fa-thumbs-o-up" style="color:#2980b9;" aria-hidden="true"></i>&nbsp; Una Experiencia Inolvidable<br>
                                <i class="fa fa-heart-o" style="color:#c0392b;" aria-hidden="true"></i>&nbsp; Acceso de por Vida<br>
                                <i class="fa fa-commenting-o" style="color:#f39c12;" aria-hidden="true"></i>&nbsp; Asitencia del Tutor<br>
                            </p>
                        <?php } ?>
                        <hr>
                    <!--DATOS DEL TUTOR DEL CURSO-->    
                        <h2>Este Curso es dictado por:</h2>
                        <div id="content-person" class="card">
                            <?php if ($StrImagenUser==NULL) {?>
                                <center>
                                    <div class="img-fluid-preview">
                                        <img class="img-fluid" src="<?= BASE_DIR; ?>/design/img/Perfil_Usuarios/defecto_user.jpg" alt="Card image cap">
                                    </div>
                                </center>
                            <?php }else{ ?>
                                <center>
                                    <div class="img-fluid-preview">
                                        <img class="img-fluid" src="<?= BASE_DIR; ?>/design/img/Perfil_Usuarios/<?= $StrImageMin; ?>" alt="Card image cap">
                                    </div>
                                </center>
                            <?php } ?>  
                            <div class="card-block">
                                <h4 style="font-weight: bold; color:black;" class="card-title"><?= $StrName; ?></h4>
                                <p class="card-text darkgray"><?= strip_tags(substr($StrBiogra,0,150)); ?>....</p>
                                <a class="btn btn-primary" data-toggle="modal" data-target="#myModal">Ver Más</a>
                            </div>
                        </div>
                        <!-- Media Share -->
                        <div class="margin-lestc-top">
                            <h3>Comparte</h3>
                            <ul>
                                <li class="margin-lestc-top"><a class="facebook-detail share-width margin-lestc-left" href="https://www.facebook.com/sharer/sharer.php?u=https://" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
                                <li class="margin-lestc-top"><a class="google-detail share-width margin-lestc-left" href="https://plus.google.com/share?url=https://" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a></li>
                                <li class="margin-lestc-top"><a class="twitter-detail share-width margin-lestc-left" href="https://twitter.com/share?url=https://www.pagina.com&original_referer=https://www.pagina.com&text=texto&via=guru school" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                        <!-- Modal Tutor -->
                        <div  class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div  class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div  class="no-margin modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <!--<h1 class="modal-title" id="myModalLabel"><i class="fa fa-bookmark" aria-hidden="true"></i> Biografía</h1>-->
                                    </div>
                                    <div class="modal-body">
                                        <center>
                                            <img style="width:24%;border-radius: 100%;" class="img-fluid" src="<?= BASE_DIR; ?>/design/img/Perfil_Usuarios/<?= $StrImageMin; ?>" alt="Card image cap">
                                            <h1 style="font-weight: bolder; color:black;" class="card-title"><?= $StrName; ?></h1>
                                            <p class="darkgray"><?= $StrProfession; ?></p>
                                        </center>
                                        <hr>
                                        <p><?= $StrBiogra; ?></p>
                                    </div>
                                    <div class="no-margin modal-footer" id="footer">
                                        <a style="width: 100%;" class="btn btn-info buttonblue" href="public-profile/<?= $ArrEmailData; ?>" target="_blank">VISÍTA EL PERFIL DEL TUTOR</a>
                                    </div>
                                </div>
                            </div>
                        </div>
    				</div>
    			</div>
                <!--CURSOS QUE NOS PUEDEN INTERESAR-->
                <div class="container">
                    <div class="row">
                        <div style="padding:20px;" class="col-md-12">
                        <div class="intermediate">
                            <h2>Cursos que te pueden interesar</h2>
                            <hr>
                        </div>
                            <?php
                                 foreach ($GetDataViewCategorie as $Data) {
                                    ?>
                                    <div class="contenible-card ">
                                        <div class="card hoverable">
                                            <div class="card-image hidden-xs">
                                                <div class="view overlay hm-white-slight z-depth-1">
                                                    <img src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/<?= $Data[3]; ?>" class="img-responsive" alt="">
                                                    <a href="details/<?= $Data[0]; ?>/<?= str_replace(" ","-",$Data[2]); ?>/">
                                                        <div class="mask waves-effect"></div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-image-res visible-xs">
                                                <div class="view overlay hm-white-slight z-depth-1">
                                                    <img src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/<?= $Data[3]; ?>" class="img-responsive" alt="">
                                                    <a href="details/<?= $Data[0]; ?>/<?= str_replace(" ","-",$Data[2]); ?>/">
                                                        <div class="mask waves-effect"></div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-content">
                                                <span class=" span-card black-gray"><?= ucwords(substr($Data[2],0,70)); ?>..</span>
                                                <p><?= $Data[6]; ?></p>
                                            </div>
                                            <div class="card-btn text-left">
                                            <?php 
                                                if (utf8_encode($Data[5])=="Gratis") 
                                            {?>
                                                <h2 class="h1-bold-second">Grátis</h2>
                                            <?php
                                                }else if($Data[5] =="De Pago")
                                            {?>
                                                <h2 class="h1-bold-second">$ <?= $Data[4]; ?> COP</h2>
                                            <?php
                                                }
                                            ?>
                                           </div>
                                        </div>
                                    </div>
                                    <?php
                                 }
                                ?> 
                        </div>
                    </div>
                </div>
    		</div>
    	</div>
    </section>
    <!-- Modal Pop Up -->
    <div class="modal fade" id="myModalmsg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="intermediate modal-header">
                <div id="ModalReq" class="intermediate modal-body">

                </div>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- /Content -->
<?= $footer; ?>
<?= $resource_script; ?>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Home/hostname.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.Apuntar').click(function(){
            $('.Apuntar').css('display','none');
            $.post(Hostname()+'/GuruSchool/cursos/pointCourse/',{
                Id:$(this).attr('data-id'),
            },function(info){
                if (info==true) {
                    window.location=Hostname()+"/GuruSchool/home/iniciar_session/&request=Debes Inciar Sesión";
                }else if(info==false){
                    console.log("datos");
                    // window.location=Hostname()+"/GuruSchool/data_user.php?request=Completar Datos Personales";
                }else if(info==1){
                    window.location=Hostname()+"/GuruSchool/session/logout/";
                }else if(info==0){
                    window.location=Hostname()+"/GuruSchool/home/";
                }else{
                    $('.Apuntar').css('display','block');
                    $('#ModalReq').html(info);
                    $('#myModalmsg').modal();
                }
            });

        });
    });
</script>