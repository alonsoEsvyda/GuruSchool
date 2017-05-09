<?php
  include('../session/session_parameters.php');
  include ("../class/functions.php");
  include ("../class/function_data.php");

  //Llamamos la clase GuruApi
  $GuruApi = new GuruApi();

  //validamos que exista el id del curso
  if (!isset($_REQUEST['IdC']) || $_REQUEST['IdC']=="") {
    header("Location:http://localhost/GuruSchool/desk//user?request=Hubo un Error, intente más tarde.");
  }else{
    //llamamos a la clase DataPlayer
    $DataPlayer= new DataPlayer();
    //llammamos al metodo que nos retorna los datos del curso
    $GetDataVideo=$DataPlayer->GetDataVideo($_SESSION['Data']['Id_Usuario'],$GuruApi->TestInput($_REQUEST['IdC']));
    //validamos que Retorne datos
    if ($GetDataVideo==false) {
      header("Location:http://localhost/GuruSchool/desk/user?request=Hubo un Error, intente más tarde.");
    }else{
      foreach ($GetDataVideo as $DataPlay ){
      }
    }
    //valiamos que el usuario halla completado el curso
    $ValidateCertifiedCourse=$DataPlayer->ValidateCertifiedCourse($_SESSION['Data']['Id_Usuario'],$GuruApi->TestInput($_REQUEST['IdC']));
    //llamamos a la clase SQLGetSelInt
    $SQLGetSelInt= new SQLGetSelInt();
    //llamamos al metodo que nos retorna los datos del creador del curso
    $SQLDataUser=$SQLGetSelInt->SQLDataUser($DataPlay[4]);
      if ($SQLDataUser==false) {
        header("Location:http://localhost/GuruSchool/desk//user?request=Hubo un Error, intente más tarde.");
      }else{
        list($IntIdUser,$StrName,$StrImagenUser,$StrImageMin,$StrBiogra,$StrProfession,$StrFace,$StrGoogle,$StrLinked,$StrTwitt)=$SQLDataUser;
      }
    //llamamos a la clase ModelHTMLUser
    $ModelHTMLUser= new ModelHTMLUser();
    //traemos el metodo que nos retorna el correo de un usuario
    $GetEmailTutor=$ModelHTMLUser->GetEmailUser($IntIdUser);
    }

    //Llamamos la clase GuruApi
    $GuruApi = new GuruApi();
    //llamamos a la clase ValidateData
    $ValidateData= new ValidateData();
    //Validamos el tiempo de vida de la sesión
    $TimeSession=$ValidateData->SessionTime($_SESSION['Data']['Tiempo'],"http://localhost/GuruSchool/desk/session/logout.php");
    //Asignamos el tiempo actual a la variable de sesión
    $_SESSION['Data']['Tiempo']=date("Y-n-j H:i:s");
    //traemos la ip real del usuario
    $GetRealIp = $GuruApi->getRealIP();
    //validamos que exista la sesión y las credenciales sean correctas
    $ValidateSession = $ValidateData->ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,"http://localhost/GuruSchool/iniciar-sesion.php?request=iniciar sesion");
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
  <?php 
    include("includes/pop_up-dev.php");
    include ("includes/menu-dev.php"); 
  ?>
  <!--Reproductor-->
  <section class="player-content">
    <div class="container">
      <div class="row">
        <div class="col-md-12 tittle-player content-inside margin-lestc-bottom intermediate">
          <!--Nombre del Curso-->
          <h2><?php echo ucwords($DataPlay[1]); ?></h2>
          <hr>
          <div style="overflow: hidden;"  class="subtittle-video">
            <div class="content-subtittle">
              <h3 style="float: left; color:white !important;"><?php echo $DataPlay[6]; ?></h3>
            </div>
            <div>
              <a data-toggle="modal" data-target="#myModalmsg"><i style="float: right;" data-toggle="tooltip" data-placement="top" title="Darme de Baja del curso" class="h1-hover white-letter fa fa-bars fa-lg" aria-hidden="true"></i></a>
              <a href="javascript:void(0);" onclick="javascript:introJs().setOption('showProgress', true).start();"><i style="float: right;" class="h1-hover white-letter margin-lestc-right fa fa-question fa-lg" aria-hidden="true"></i></a>
            </div>
          </div>
        </div>
        <div class="col-md-8">
          <!--Reproductor del Curso-->
          <div class="player-video intermediate">
            <?php
              if ($DataPlay[0]=="Gratis") { 
                ?>
                  <div style="width:100%; height:500px;" data-id="<?php echo $DataPlay[8]; ?>" data-theme="<?php echo $DataPlay[6]; ?>" data-course="<?php echo $GuruApi->StringEncode($_REQUEST['IdC']); ?>" id="video-placeholder" class="video_code"></div>
                <?php
              }else if($DataPlay[0]=="De Pago"){
                ?>
                  <video id="my-video" class="video-js" style="width:100%;" data-id="<?php echo $DataPlay[8]; ?>" data-theme="<?php echo $DataPlay[6]; ?>" data-course="<?php echo $GuruApi->StringEncode($_REQUEST['IdC']); ?>" controls preload="auto" height="500px"
                   data-setup="{}">
                    <source id="source-video" src="../videos_user/<?php echo $DataPlay[8]; ?>" type='video/mp4'>
                    <p class="vjs-no-js">
                      To view this video please enable JavaScript, and consider upgrading to a web browser that
                      <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                    </p>
                  </video>
                <?php
              }
            ?>
          </div>
        </div>
        <div class="col-md-4">
          <div class="player-list intermediate">
            <div class="list-global">
              <!--lista de los vídeos-->
              <div data-step="1" data-intro="<h1 class='h1-black'>Hola!!</h1><br> Este es el Play-List de tu curso. Una vez termines cada vídeo, la sección quedará en verde." class="list">
                <?php
                  sort($GetDataVideo,SORT_NUMERIC);
                  foreach ($GetDataVideo as $DataPlay ){
                    if ($DataPlay[7]=="Completo") {
                      ?>
                        <a data-name="<?php echo $DataPlay[8]; ?>" data-theme="<?php echo $DataPlay[6]; ?>" data-course="<?php echo $GuruApi->StringEncode($_REQUEST['IdC']); ?>" data-token="<?php echo $GuruApi->StringEncode($DataPlay[0]); ?>" class="video_name">
                          <div class="tiitle-list">
                            <i style="color:rgba(46, 204, 113,1.0);" class="fa fa-check-circle" aria-hidden="true"></i> <label style="color: white;" ><?php echo $DataPlay[6]; ?></label>
                          </div>
                        </a>
                      <?php
                    }else{
                      ?>
                        <a data-name="<?php echo $DataPlay[8]; ?>" data-theme="<?php echo $DataPlay[6]; ?>" data-course="<?php echo $GuruApi->StringEncode($_REQUEST['IdC']); ?>" data-token="<?php echo $GuruApi->StringEncode($DataPlay[0]); ?>" class="video_name">
                          <div class="tiitle-list">
                            <i class="fa fa-play-circle" aria-hidden="true"></i> <label style="color: white;"><?php echo $DataPlay[6]; ?></label>
                          </div>
                        </a>
                      <?php
                    }
                  }
                ?>
              </div>
            </div>
            <div data-step="2" data-intro="Pregunta lo que quieras en el Foro, es dedicado completamente a las dudas que surjan respecto al Curso, soluciona las preguntas de tus compañeros, etc.." class="click-forum margin-lestc-top margin-lestc-bottom">
              <a href="../forum/questions/<?php echo $_REQUEST['IdC']; ?>/" target="_blank"><i class="fa fa-arrow-right" aria-hidden="true"></i> Visita el Foro del Curso</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--información del curso-->
  <section class="info-content">
    <div class="container">
      <div class="row">
        <div data-step="5" data-intro="Aquí puedes encontrar la Biografía del tutor y la Descripción Completa y Explícita del Curso.<br><br>Mucha Suerte y Éxitos" class="col-md-9">
          <!--informacion del curso-->
          <div class="info-course padding-lest-top padding-lest-left padding-lest-right padding-lest-bottom intermediate">
            <h1 class="h1-bold h1-black">A Cerca de Este Curso</h1>
            <hr>
            <?php echo $DataPlay[2]; ?>
          </div>
          <!--informacion del tutor-->
          <div class="info-teacher padding-lest-top padding-lest-left padding-lest-right padding-lest-bottom intermediate">
          <h1 class="h1-bold h1-black">A Cerca del Tutor</h1>
          <hr>
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-4">
                  <div id="content-person" class="card">
                      <center>
                          <div class="img-fluid-preview">
                              <img class="img-fluid" src="../img_user/Perfil_Usuarios/<?php echo $StrImageMin; ?>" alt="Card image cap">
                          </div>
                      </center>
                      <div class="card-block">
                          <h4 class="card-title"><?php echo $StrName; ?></h4>
                          <a class="btn btn-primary margin-lest-top margin-lestc-bottom" href="../public-profile/<?php echo $GetEmailTutor; ?>" target="_blank">Ver Más</a>
                      </div>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="intermediate margin-lestc-top ">
                    <h2>Biografía</h2>
                    <p>
                      <?php echo $StrBiogra; ?>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--estado del certificado y bolsa-->
        <div class="col-md-3">
          <div class="info-target">
            <!--estado el certificado-->
            <?php
              if ($ValidateCertifiedCourse==true) {
                ?>
                  <div data-step="3" data-intro="Terminaste todos los vídeos? Genial eso quiere decir que puedes dar Click aquí y descarga tu Certificado." id="card" class="card get-certified">
                    <center>
                        <div class="img-fluid-preview">
                            <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                        </div>
                    </center>
                    <div class="card-block">
                        <h4 class="card-title">Felicidades,Reclama tu Certificado!</h4>
                        <a href="../my-certificate" class="btn btn-primary margin-lestb-top"><i class="fa fa-check" aria-hidden="true"></i> Reclamar</a>
                    </div>
                </div>
                <?php
              }else{
                ?>
                  <div data-step="3" data-intro="Termina todos los vídeos del curso y podrás descargar el Certificado (Todos los vídeos deben quedar en verde :) )" id="card" class="card no-certified">
                    <center>
                        <div class="img-fluid-preview">
                            <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                        </div>
                    </center>
                    <div class="card-block">
                        <h4 class="card-title">No Tienes Certificado Disponible</h4>
                        <p class="btn btn-primary margin-lestb-top"><i class="fa fa-times" aria-hidden="true"></i> Reclamar</p>
                    </div>
                  </div>
                <?php
              }
            ?>
            <!--targeta para ir a la bolsa de empleo-->
            <div data-step="4" data-intro="Aprovecha y busca una vacante en LA BOLSA, pon a prueba los conocimientos que adquiriste y Crea un Futuro." id="card" class="card employment">
                <center>
                    <div class="img-fluid-preview">
                        <i class="fa fa-suitcase" aria-hidden="true"></i>
                    </div>
                </center>
                <div class="card-block">
                    <h4 class="card-title">Conoce la Bolsa de Empleo!</h4>
                    <a href="../../la-bolsa?accept=yes" class="btn btn-primary margin-lestb-top"><i class="fa fa-arrow-right" aria-hidden="true"></i> Visitar</a>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--Modal-->
  <div class="modal fade" id="myModalmsg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="intermediate modal-header">
              <div id="ModalReq" class="intermediate modal-body">
                <center>
                  <i style="font-weight:100; font-size:130px; color:#C9DAE1;" class="fa fa-exclamation-triangle" aria-hidden="true"></i><br><br>
                      <h2 class="h1-light black-gray">!Piensalo Bien¡</h2><br>
                      <h4 class="semi-gray">Perderás el progreso que llevas.</h4><br>
                      <button type="button" class="btn btn-default" value="no" data-dismiss="modal">Cancelar</button>
                      <button type="button" class="buttongray btn btn-secondary" id="baja" data-course="<?php echo $GuruApi->TestInput($GuruApi->StringEncode($_REQUEST['IdC'])); ?>">ELIMINAR</button>  
                  </center>
              </div>
              </div>
          </div>
      </div>
  </div>
  <!--Reproductor-->

  <!--Footer-->
  <?php include ("../../includes-front/footer.php"); ?>
  <!--Scripts-->
  <?php include ("includes/scripts-dev.html"); ?>
  <script type="text/javascript">
    $(document).ready(function(){
        $('.video_name').click(function(){
           $(".tiitle-list").css({'background-color':'rgba(52, 73, 94,1.0)' ,'color':'rgba(255,255,255,0.8)'});
           $(".tiitle-list label").css('color', 'rgba(255,255,255,0.8)');
           $("div", this).css({'background-color':'white','color':'rgba(52, 73, 94,1.0)'});
           $("label", this).css('color', 'rgba(52, 73, 94,1.0)');
            var dataVideo={Token:$(this).attr('data-token'), NameVideo:$(this).attr('data-name'), NameTheme:$(this).attr('data-theme'), DataCourse:$(this).attr('data-course')};
             $.ajax({
                  type: "POST",
                  url: "controll/put_videos.php",
                  data:dataVideo,
                  dataType: "json"
              }).done (function(info){
                if (info[3]==true) {
                  $(".player-video").html('<div style="width:100%; height:500px;" data-id="'+info[0]+'" data-theme="'+info[1]+'" data-course="'+info[2]+'" id="video-placeholder" class="video_code"></div>'); 
                  $(".content-subtittle h3").html(info[1]);
                  onYouTubeIframeAPIReady(info[0]);
                }else{
                  $("video").find("#source-video").attr("src",info[0]);
                  $("video").attr("src","../videos_user/"+info[0]);
                  $("video").attr("data-theme",info[1]);
                  $("video").attr("data-course",info[2]);
                  $("video").attr("data-id",info[0]);
                  $(".content-subtittle h3").html(info[1]);
                }
              });
        });
    });
  </script>
  <script type="text/javascript">
    $(document).ready(function(){
      $('#baja').click(function(){
          $.post('controll/unsubscribe.php',{
              Course:$('#baja').attr('data-course'),
          },function(info){
              if (info==true) {
                  window.location="../user.php?requestok=Haz eliminado el curso de tu lista Correctamente";
              }else if(info==false){
                  window.location="../user.php?request=Hubo un problema, intente más tarde.";
              }else{
                  window.location="../user.php?request=Hubo un problema, intente más tarde.";
              }
          });
      })
    })
  </script>
</body>
</html>
