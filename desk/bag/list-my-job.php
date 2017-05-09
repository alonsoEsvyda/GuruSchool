<?php
  include('../session/session_parameters.php');
  include ("../class/functions.php");
  include ("../class/function_data.php");
  //llamamos a la clase the bag
  $TheBag= new TheBag();
  //traemos el método que nos retorna las vacantes en lista
  $GetVacancyUser=$TheBag->GetVacancyUser($_SESSION['Data']['Id_Usuario']);

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
  <style type="text/css">
    p{
      margin:0 !important;
    }
  </style>
</head>
<body>
  <!--Menú-->
  <?php 
    include("includes/pop_up-dev.php");
    include ("includes/menu-dev.php"); 
  ?>
  <!--Titulo dela Sección-->
  <section id="sec-front" class="padding margin-top">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-front text-front-down">
                <center>
                  <h2>Empleos Postulados</h2>
                  <p>Aquí tienes una lista de los empleos que Publicaste en La Bolsa</p>
                  <a href="vacancy-published"><button type="button" class="waves-effect waves-light wow pulse animated btn btn-default">Publica una Vacante</button></a>
                </center>
            </div>
          </div>            
        </div>
      </div>
  </section>
  <!--Cursos Que Enseño-->
  <section class="jobs-grid">
    <div class="container">
      <div class="row">
        <div class="col-md-12 intermediate">
          <?php
            if ($GetVacancyUser==false) {
              echo '<center>
                    <div class="intermediate margin-bottom padding-lestc">
                      <br><br><br>
                        <h2><i class="fa fa-suitcase" aria-hidden="true"></i> Usted no Tiene ningúna Vacante Publicada. <a href="vacancy-published">Publique Aquí.</a></h2>
                    </div>
                  </center>' ;
            }else{
              foreach ($GetVacancyUser as $vacancy) {
                ?>
                  <div class="container-list-job">
                    <div class="company-job">
                      <a class="delete-vacancy" data-vacancy="<?php echo $GuruApi->StringEncode($vacancy[0]); ?>" onclick="Delete(this)"><h3>X</h3></a>
                      <h2><?php echo $vacancy[1]; ?></h2>
                    </div>
                    <div class="description-job">
                      <hr style="margin:0;">
                      <p><?php echo strip_tags(substr($vacancy[5],0,130))." [...]"; ?></p>
                    </div>
                    <div class="add-job">
                      <h4><?php echo $vacancy[4]." - ".$vacancy[2]."/".$vacancy[3]." (".$vacancy[6].")";?></h4>
                    </div>
                  </div>
                <?php
              }
            }
          ?>
        </div>
      </div>
    </div>
  </section>
  <!--Footer-->
    <?php include ("../../includes-front/footer.php"); ?>
    <!--Scripts-->
    <?php include ("includes/scripts-dev.html"); ?>
    <script type="text/javascript">
      function Delete(button){
        var Data=$(button).attr('data-vacancy');
          $.post('controll/delete_vacancy.php',{
              Data:Data,
          },function(info){
            if (info==true) {
              $(button).parent('div').parent('div').remove();
            }
          });
      }
    </script>
</body>
</html>