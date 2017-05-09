<?php
  include('../session/session_parameters.php');
  include ("../class/functions.php");
  include ("../class/function_data.php");

    //Llamamos la clase GuruApi
    $GuruApi = new GuruApi();

    if (!isset($_REQUEST['IdP']) || $_REQUEST['IdP']=="") {
      header("Location:http://localhost/GuruSchool/desk/user?request=Ups, Hubo un Error");
    }else{
      //llamamos a la clase Questions
      $Forum = new Forum();
      //llamamos el metodo que nos retorna los comentarios
      $GetDataAnswer=$Forum->GetDataAnswer($GuruApi->TestInput($_REQUEST['IdP']));
      //traemos los datos
      foreach ($GetDataAnswer as $DataQuestion) {
      }
      //este metodo valida que el id recibido esté en la tabla
      $ValidateAnswers=$Forum->ValidateAnswers($GuruApi->TestInput($_REQUEST['IdP']));
      if ($ValidateAnswers==false) {
        header("Location:http://localhost/GuruSchool/desk/user");
      }
      //validamos que exista el ID
      if (!isset($_REQUEST['IdP']) || $_REQUEST['IdP']=="") {
        header("Location:http://localhost/GuruSchool/desk/user");
      }
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
            <div class="questions row">
              <!--pregunta-->
              <div class="col-md-1">
                <!--imagen-->
                <div class="circle-image" style="background:url(http://localhost/GuruSchool/desk/img_user/Perfil_Usuarios/<?php echo $DataQuestion[2]; ?>);background-size:cover;background-position:center;width:50px;height:50px;margin:0 auto;"></div>
              </div>
              <div class="col-md-10 margin-lestc-top">
                <!--pregunta-->
                <h2><?php echo $DataQuestion[0]; ?></h2>
                <p><?php echo $DataQuestion[1]; ?></p>
              </div>
            </div>
            <hr>
            <div class="col-md-12">
              <div class="intermediate body-answers padding-bottom">
                  <div class="content-answer">
                    <?php
                      if ($DataQuestion[3]==false) {
                        ?>
                          <div class="answer row">
                             <div class="col-md-1">
                                <!--imagen-->
                                <div class="circle-image" style="background:url(http://localhost/GuruSchool/desk/img_user/Perfil_Usuarios/defecto_user.jpg);background-size:cover;background-position:center;width:50px;height:50px;margin:0 auto;"></div>
                              </div>
                              <div class="col-md-10 margin-lestc-top">
                                <!--pregunta-->
                                <h4>NO HAY RESPUESTAS</h4>
                              </div>
                          </div>
                        <?php
                      }else if($DataQuestion[3]==true){
                        foreach ($GetDataAnswer as $DataAnswer) {
                          ?>
                            <div class="answer row">
                               <div class="col-md-1">
                                  <!--imagen-->
                                  <div class="circle-image" style="background:url(http://localhost/GuruSchool/desk/img_user/Perfil_Usuarios/<?php echo $DataAnswer[5]; ?>);background-size:cover;background-position:center;width:50px;height:50px;margin:0 auto;"></div>
                                </div>
                                <div class="col-md-10 margin-lestc-top">
                                  <!--pregunta-->
                                  <h4><?php echo $DataAnswer[4]; ?></h4>
                                </div>
                            </div>
                          <?php
                        }
                      }
                    ?>
                  </div>
                <div class="row">
                  <div class="col-md-9">
                  </div>
                  <div class="col-md-3">
                    <a style="width:100%;" class="btn btn-default"  data-toggle="modal" data-target="#myModal">Responde a la pregunta</a>
                  </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-body">
                          <div style="display:none;" id="respuesta" class="alert"></div>
                          <textarea name="Answer" id="Answer"></textarea>
                          <input type="hidden" value="<?php echo $GuruApi->StringEncode($_REQUEST['IdP']); ?>" id="DataToken" name="Data">
                          <button style="width:100%;" id="sendAnswer" class=" margin-lestb-top btn btn-default" >Responder</button>
                      </div>
                    </div>
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
        $('#sendAnswer').on('click', function(e){
            $('#sendAnswer').css('display','none');
            e.preventDefault();
            RegisterAnswer();
        });
    });

    function RegisterAnswer(){
      var DataAnswer={Answer:$('#Answer').val(),DataToken:$('#DataToken').val()};
       $.ajax({
            type: "POST",
            url: "controll/register_answers.php",
            data:DataAnswer,
            dataType: "json"
        }).done (function(info){
          if (info==false) {
            mostrarRespuesta("-Llene los campos<br><br>-No exceda el limite de caracteres");
            $('#sendAnswer').css('display','block');
          }else{
            $('.content-answer').append('<div class="answer row"><div class="col-md-1"><!--imagen--><div class="circle-image" style="background:url(http://localhost/GuruSchool/desk/img_user/Perfil_Usuarios/'+info[1]+');background-size:cover;background-position:center;width:50px;height:50px;margin:0 auto;"></div> </div><div class="col-md-10 margin-lestc-top"><!--pregunta--><h4>'+info[2]+'</h4></div> </div>');
            $('#myModal').modal('toggle');
            $('#Answer').val('');
            $('#sendAnswer').css('display','block');
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
