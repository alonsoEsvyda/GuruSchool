<?php
    include('session/session_parameters.php');
    include ("class/functions.php");
    include ("class/function_data.php");

    if (!isset($_GET['IdC']) || $_GET['IdC']=="") {
        header("Location:http://localhost/GuruSchool/index?request=Ups, Hubo un Error");
    }else{
        //DesEncriptamos el Id del Curso
        $GuruApi = new GuruApi();
        $IntIdDecode = $_GET['IdC'];
        $IdCurso=$GuruApi->TestInput($IntIdDecode);

        //Traemos los datos relevantes del curso
        $SQLGetSelInt= new SQLGetSelInt();
        $GetDataCourse=$SQLGetSelInt->SQLDataCourse($IdCurso);
        if ($GetDataCourse==false) {
            header("Location:http://localhost/GuruSchool/Cursos?accept=yes&requestinfo=Ese Curso no Existe");
        }else{
            list($IdPkCurso,$IdFkUser,$StrNameCurso,$StrResumen,$StrResComplete,$ImagenCurso,$VideoCurso,$Intprecio,$StrTipoCurso,$StrSubCategoria,$StrCategoria)=$GetDataCourse;
        }
        //Traemos los datos del creador del curso
        $GetDataUser=$SQLGetSelInt->SQLDataUser($IdFkUser);
        list($IntIdUser,$StrName,$StrImagenUser,$StrImageMin,$StrBiogra,$StrProfession,$StrFace,$StrGoogle,$StrLinked,$StrTwitt)=$GetDataUser;
        //Traemos los nombres de los vídeos del curso
        $GetDataVideos=$SQLGetSelInt->SQLDataVideos($IdPkCurso);

        //llamamos a la clase ModelHTMLUser
        $ModelHTMLUser= new ModelHTMLUser();
        //traemos el email del profesor
        $ArrEmailData= $ModelHTMLUser->GetEmailUser($IntIdUser);
        //lamamos a la clase ViewsSQL();
        $ViewsSQL= new ViewsSQL();
        //Traemos los cursos aleatorios en una vista de la clase ViewsSQL
        $GetDataView=$ViewsSQL->GetViewCourseSubCategorie($StrSubCategoria); 
        //Traemos los cursos aleatorios en una vista de la clase ViewsSQL
        $SQLStudentsIn=$SQLGetSelInt->SQLStudentsIn($IdCurso); 
    }
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo $StrNameCurso; ?></title>
  <meta name=" title" content="<?php echo $StrNameCurso; ?>">
  <meta property="og:title" content="<?php echo $StrNameCurso; ?>" />
  <meta property="og:description" content="<?php echo $StrResumen; ?>" />
  <meta property="og:image" content="img_user/Cursos_Usuarios/<?php echo $ImagenCurso; ?>" />
  <?php
     $baseUrl = dirname($_SERVER['PHP_SELF']).'/';
  ?>
  <base href="<?php echo $baseUrl; ?>" >
  <?php include ("../includes-front/head.php"); ?>
</head>
<body>
  	<!--Navigation-->
    <?php 
        include("includes/menu-dev.php"); 
    ?>    
    <!--Details Curso-->
    <section class="main">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-9">
                    <!--DATOS DEL CURSO: video principal y programa -->
    				<div class="content-inside content-font intermediate table-responsive">
                        <h1 class="h1-alternative-size"><?php echo $StrNameCurso; ?></h1>
                        <p class="p-bold"><?php echo $StrResumen; ?></p>
                        <hr>
                        <!--arbol-->
                        <div class="padding-lesta-bottom">
                            <ol class="ol-list">
                                <li><a> <?php echo $StrCategoria; ?> &nbsp;&nbsp; <i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp;&nbsp; </a></li>
                                <li><a> <?php echo $StrSubCategoria; ?> &nbsp;&nbsp; <i class="fa fa-caret-right" aria-hidden="true"></i> &nbsp;&nbsp; </a></li>
                                <li><a> <?php echo $StrNameCurso; ?></a></li>
                            </ol>
                            <label class="black-letter p-bold">&nbsp;&nbsp;  •  &nbsp;&nbsp;<i class="fa fa-user" aria-hidden="true">&nbsp;</i><?php echo $SQLStudentsIn; ?> Alumnos Inscritos</label>
                        </div>
                        <!--imagen o vídeo del curso-->
                        <?php if ($VideoCurso==NULL) { ?>
                            <img width="100%" height="auto" src="img_user/Cursos_Usuarios/<?php echo $ImagenCurso; ?>"></img>
                        <?php }else{ ?>
                            <iframe class="video" width="100%" height="500px" src="http://www.youtube.com/embed/<?php echo $VideoCurso; ?>?controls=0&showinfo=0" frameborder="0"></iframe>
                        <?php } ?>
                        <hr>
                        <div class="content-description margin-lestc-top">
                            <h2>Descripción del Curso</h2>
                            <hr>
                            <p><?php echo $StrResComplete; ?></p>
                            <table class="table table-hover">
                              <thead>
                                  <tr>
                                    <th>Programa</th>
                                  </tr>
                              </thead>
                                <tbody>
                                  <?php
                                   foreach ($GetDataVideos as $DataVideo) {
                                       ?>
                                       <tr>
                                            <td><p><i class="fa fa-play-circle-o" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $DataVideo[0]; ?></p></td>
                                          </tr>
                                       <?php
                                    } 
                                  ?>
                                </tbody>
                            </table>
                        </div>
    				</div>
    			</div>
    			<div class="col-md-3">
    				<div class="content-right intermediate">
                    <!--DATOS ADICIONALES DEL CURSO, COMO PRECIO Y QUE INCLUYE-->
                        <?php
                        $IntIdEncode = $GuruApi->StringEncode($IntIdDecode);//Encriptamo el Id para enviarlo por Ajax
                        ?>
                        <a class="Apuntar"  data-id="<?php echo $IntIdEncode; ?>" >
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
                                <h1 class="black-letter">$ <?php echo number_format($Intprecio); ?> COP</h1>
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
                                        <img class="img-fluid" src="img_user/Perfil_Usuarios/defecto_user.jpg" alt="Card image cap">
                                    </div>
                                </center>
                            <?php }else{ ?>
                                <center>
                                    <div class="img-fluid-preview">
                                        <img class="img-fluid" src="img_user/Perfil_Usuarios/<?php echo $StrImageMin; ?>" alt="Card image cap">
                                    </div>
                                </center>
                            <?php } ?>  
                            <div class="card-block">
                                <h4 style="font-weight: bold; color:black;" class="card-title"><?php echo $StrName; ?></h4>
                                <p class="card-text darkgray"><?php echo strip_tags(substr($StrBiogra,0,150)); ?>....</p>
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
                                            <img style="width:24%;border-radius: 100%;" class="img-fluid" src="img_user/Perfil_Usuarios/<?php echo $StrImageMin; ?>" alt="Card image cap">
                                            <h1 style="font-weight: bolder; color:black;" class="card-title"><?php echo $StrName; ?></h1>
                                            <p class="darkgray"><?php echo $StrProfession; ?></p>
                                        </center>
                                        <hr>
                                        <p><?php echo $StrBiogra; ?></p>
                                    </div>
                                    <div class="no-margin modal-footer" id="footer">
                                        <a style="width: 100%;" class="btn btn-info buttonblue" href="public-profile/<?php echo $ArrEmailData; ?>" target="_blank">VISÍTA EL PERFIL DEL TUTOR</a>
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
                                 foreach ($GetDataView as $Data) {
                                    ?>
                                    <div class="contenible-card ">
                                        <div class="card hoverable">
                                            <div class="card-image hidden-xs">
                                                <div class="view overlay hm-white-slight z-depth-1">
                                                    <img src="../desk/img_user/Cursos_Usuarios/<?php echo $Data[3]; ?>" class="img-responsive" alt="">
                                                    <a href="details/<?php echo $Data[0]; ?>/<?php echo str_replace(" ","-",$Data[2]); ?>/">
                                                        <div class="mask waves-effect"></div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-image-res visible-xs">
                                                <div class="view overlay hm-white-slight z-depth-1">
                                                    <img src="../desk/img_user/Cursos_Usuarios/<?php echo $Data[3]; ?>" class="img-responsive" alt="">
                                                    <a href="details/<?php echo $Data[0]; ?>/<?php echo str_replace(" ","-",$Data[2]); ?>/">
                                                        <div class="mask waves-effect"></div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-content">
                                                <span class=" span-card black-gray"><?php echo ucwords(substr($Data[2],0,70)); ?>..</span>
                                                <p><?php echo $Data[6]; ?></p>
                                            </div>
                                            <div class="card-btn text-left">
                                            <?php 
                                                if (utf8_encode($Data[5])=="Gratis") 
                                            {?>
                                                <h2 class="h1-bold-second">Grátis</h2>
                                            <?php
                                                }else if($Data[5] =="De Pago")
                                            {?>
                                                <h2 class="h1-bold-second">$ <?php echo $Data[4]; ?> COP</h2>
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
    <!--Footer-->
    <?php include ("../includes-front/footer.php"); ?>
    <!--Scripts-->
    <?php include ("includes/scripts-dev.html"); ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.Apuntar').click(function(){
                $('.Apuntar').css('display','none');
                $.post('case_courses/apuntar_curso.php',{
                    Id:$(this).attr('data-id'),
                },function(info){
                    if (info==true) {
                        window.location="../iniciar-sesion.php?request=Debes Inciar Sesión";
                    }else if(info==false){
                        window.location="data_user.php?request=Completar Datos Personales";
                    }else if(info==1){
                        window.location="session/logout";
                    }else if(info==0){
                        window.location="../index";
                    }else{
                        $('.Apuntar').css('display','block');
                        $('#ModalReq').html(info);
                        $('#myModalmsg').modal();
                    }
                });

            });
        });
    </script>
</body>
</html>