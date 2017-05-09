<?php
  include('../session/session_parameters.php');
  include ("../class/functions.php");
  include ("../class/function_data.php");

    //Llamamos la clase GuruApi
    $GuruApi = new GuruApi();

    if (!isset($_REQUEST['IdC']) || $_REQUEST['IdC']=="") {
      header("Location:http://localhost/GuruSchool/desk/user?request=Ups, Hubo un Error");
    }else{
      //llamamos a la clase Questions
      $Forum = new Forum();
      $ValidateQuestions=$Forum->ValidateQuestions($GuruApi->TestInput($_REQUEST['IdC']),$_SESSION['Data']['Id_Usuario']);
      //validamos que el curso sea mio
      if ($ValidateQuestions==false) {
        header("Location:http://localhost/GuruSchool/desk/user");
      }
      //lamamos al meotod que nos retorna las preguntas
      $GetDataQuestions=$Forum->GetDataQuestions($GuruApi->TestInput($_REQUEST['IdC']));
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
  
  <!--FORMULARIO, PREGUNTAS-->
    <section class="forum">
      <div class="container">
        <div class="row">
          <div class="content content-inside intermediate">
            <!--Titulos-->
            <div class="col-md-9 padding-lestb-bottom"> 
              <h1>Foro de Preguntas</h1>
            </div>
            <div class="col-md-3 padding-lestb-bottom">
                <a style="width:100%;" class="btn btn-default"  data-toggle="modal" data-target="#myModal">Haz una Pregunta</a>
            </div>
            <!--Preguntas-->
            <div class="col-md-12">
              <div class="intermediate body-questions padding-bottom">
                <hr>
                  <div class="content-questions">
                  <?php
                  if ($GetDataQuestions==false) {
                    ?>
                      <!--cuerpo de la pregunta-->
                      <div class="questions row">
                        <div class="col-md-1">
                          <!--imagen-->
                            <div class="circle-image" style="background:url(http://localhost/GuruSchool/desk/img_user/Perfil_Usuarios/defecto_user.jpg);background-size:cover;background-position:center;width:50px;height:50px;margin:0 auto;"></div>
                        </div>
                        <div style="margin-top:5px;" class="col-md-10">
                          <!--pregunta-->
                          <a><label>No hay preguntas</label><h4>No hay Preguntas</h4></a>
                        </div>
                        <div class="col-md-1 margin-lestc-top">
                          <!--número de preguntas-->
                          <div class="number-comments">
                          </div>
                        </div>
                      </div>
                    <?php
                  }else{
                    foreach ($GetDataQuestions as $DataQuestions) {
                      ?>
                        <!--cuerpo de la pregunta-->
                        <div class="questions row">
                          <div class="col-md-1">
                            <!--imagen-->
                            <div class="circle-image" style="background:url(http://localhost/GuruSchool/desk/img_user/Perfil_Usuarios/<?php echo $DataQuestions[3]; ?>);background-size:cover;background-position:center;width:50px;height:50px;margin:0 auto;"></div>
                          </div>
                          <div style="margin-top:5px;" class="col-md-10">
                            <!--pregunta-->
                            <a href="answers/<?php echo $DataQuestions[0]; ?>/"><label><?php echo $DataQuestions[2]; ?></label><h4><?php echo $DataQuestions[1]; ?></h4></a>
                          </div>
                          <div class="col-md-1 margin-lestc-top">
                            <!--número de preguntas-->
                            <div class="number-comments">
                               <?php echo $DataQuestions[4]; ?> <i class="fa fa-comment" aria-hidden="true"></i>
                            </div>
                          </div>
                        </div>
                      <?php
                    }
                  }
                  ?>
                  </div>
              </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-body">
                      <div style="display:none;" id="respuesta" class="alert"></div>
                      <input type="text" name="Tittle" id="TittleQuest" placeholder="Titlo de la pregunta" required/>
                      <input type="hidden" value="<?php echo $GuruApi->StringEncode($_REQUEST['IdC']); ?>" id="DataToken" name="Data">
                      <textarea name="Question"  id="QuestionText"></textarea>
                      <button style="width:100%;" id="sendQuest" class="margin-lestb-top btn btn-default" >Enviar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  <!--FORMULARIO, PREGUNTAS-->
  
  <!--Footer-->
  <?php include ("../../includes-front/footer.php"); ?>
  <!--Scripts-->
  <?php include ("includes/scripts-dev.html"); ?>
  <!--script para insertar preguntas-->
  <script type="text/javascript">
    $(document).ready(function(){
        $('#sendQuest').on('click', function(e){
            $('#sendQuest').css('display','none');
            e.preventDefault();
            RegisterQuestion();
        });
    });

    function RegisterQuestion(){
      var DataQuestion={Tittle:$('#TittleQuest').val(), Question:$('#QuestionText').val(), DataToken:$('#DataToken').val()};
       $.ajax({
            type: "POST",
            url: "controll/register_questions.php",
            data:DataQuestion,
            dataType: "json"
        }).done (function(info){
          if (info==false) {
            mostrarRespuesta("-Llene los campos<br><br>-No exceda el limite de caracteres");
            $('#sendQuest').css('display','block');
          }else{
            $('.content-questions').append('<div class="questions row"><div class="col-md-1"><!--imagen--><div class="circle-image" style="background:url(http://localhost/GuruSchool/desk/img_user/Perfil_Usuarios/'+info[2]+');background-size:cover;background-position:center;width:50px;height:50px;margin:0 auto;"></div></div><div style="margin-top:5px;" class="col-md-10"><!--pregunta--><a href="answers/'+info[0]+'/"><label>'+info[1]+'</label><h4>'+info[3]+'</h4></a></div> <div class="col-md-1 margin-lestc-top"><!--número de preguntas--><div class="number-comments">0 <i class="fa fa-comment" aria-hidden="true"></i> </div></div></div>');
            $('#myModal').modal('toggle');
            $('#TittleQuest,#QuestionText').val('');
            $('#sendQuest').css('display','block');
          }
        });
    }
    function mostrarRespuesta(mensaje){//Esta función añade la respuesta a un contenedor HTML
      $('#respuesta').css('display','block');
        $("#respuesta").removeClass('alert-success').removeClass('alert-danger').html(mensaje);
        $("#respuesta").addClass('alert-danger');
    }
  </script>
</body>
</html>
