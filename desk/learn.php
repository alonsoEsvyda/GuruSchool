<?php
  include('session/session_parameters.php');
	include ("class/functions.php");
  include ("class/function_data.php");
  //Llamamos las clase ModelHTMLUser
  $DataHTMLUser = new ModelHTMLUser();
  //traemos los cursos en aprendisaje del usuario en sesión
  $DataMyCourse=$DataHTMLUser->SQLGetCoursesUser($_SESSION['Data']['Id_Usuario']);

  //Llamamos la clase GuruApi
  $GuruApi = new GuruApi();
  //llamamos la clase ValidateData
  $ValidateData= new ValidateData();
  //Validamos el tiempo de vida de la sesión
  $TimeSession=$ValidateData->SessionTime($_SESSION['Data']['Tiempo'],"session/logout.php");
  //Asignamos el tiempo actual a la variable de sesión
  $_SESSION['Data']['Tiempo']=date("Y-n-j H:i:s");
  //traemos la ip real del usuario
  $GetRealIp = $GuruApi->getRealIP();
  //validamos que exista la sesión y las credenciales sean correctas
  $ValidateSession = $ValidateData->ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,"../iniciar-sesion.php?request=iniciar sesion");
?>
<!DOCTYPE html>
<html>
<head>
	<!--head-->
	<?php
     $baseUrl = dirname($_SERVER['PHP_SELF']).'/';
  ?>
  <base href="<?php echo $baseUrl; ?>" >
  <?php include ("../includes-front/head.php"); ?>
</head>
<body>
	<!--Menú-->
	<?php include ("includes/menu-dev.php"); ?>
	<!--Titulo de la sección-->
	<section id="sec-front" class="padding margin-top">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-front text-front-down">
                <center>
                	<h2>Cursos Que Aprendo</h2>
                	<p>Sección del Alumno</p>
                </center>
            </div>
          </div>            
        </div>
      </div>
  </section>
  <!--Cursos que Aprendo-->
  <section class="courses-grid">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <section>
            <div class="container">
              <div class="row">
                <div class="intermediate col-md-12">
                  <h1>!Cursos en Progreso¡</h1>
                  <hr>
                </div>
              </div>
            </div>
          </section>
          <?php
            if ($DataMyCourse==false) {
              echo "<center>
                    <div class='intermediate margin-bottom padding-lestb'>
                      <br><br><br>
                        <h2><i class='fa fa-pencil' aria-hidden='true'></i> Usted no Está apuntadoa ningún Curso. Busque un Curso <a href='../Cursos?accept=yes'>Aquí</a></h2>
                    </div>
                  </center>" ;
            }else{
              foreach ($DataMyCourse as $DataCourse) {
              //traemos el promedio de los cursos realizados
              $SQLProgressCourse=$DataHTMLUser->SQLProgressCourse($_SESSION['Data']['Id_Usuario'],$DataCourse[0],"Completo");
              ?>
                <div class="contenible-card ">
                  <div class="card hoverable">
                      <div class="card-image hidden-xs">
                          <div class="view overlay hm-white-slight z-depth-1">
                              <img src="img_user/Cursos_Usuarios/<?php echo $DataCourse[2]; ?>" class="img-responsive" alt="">
                              <a href="classroom/player/<?php echo $DataCourse[0]; ?>/">
                                  <div class="mask waves-effect"></div>
                              </a>
                          </div>
                      </div>
                      <div class="card-image-res visible-xs">
                          <div class="view overlay hm-white-slight z-depth-1">
                              <img src="img_user/Cursos_Usuarios/<?php echo $DataCourse[2]; ?>" class="img-responsive" alt="">
                              <a href="classroom/player/<?php echo $DataCourse[0]; ?>/">
                                  <div class="mask waves-effect"></div>
                              </a>
                          </div>
                      </div>
                      <div class="card-content">
                          <h5><?php echo $DataCourse[1]; ?></h5>
                          <p>By: <?php echo $DataCourse[5]; ?></p>
                      </div>
                      <div class="card-btn text-left">
                        <p style="float: right; margin-top: 5px;" class="green-letter margin-lestc-right"><?php echo $SQLProgressCourse ?> %</p>
                        <div style="height: 3px; float: right; width: 60%;" class="margin-lestb-top margin-lestb-right progress">
                          <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $SQLProgressCourse; ?>"
                          aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $SQLProgressCourse; ?>%">
                          </div>
                        </div>
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
  </section>
	<!--Footer-->
    <?php include ("../includes-front/footer.php"); ?>
    <!--Scripts-->
    <?php include ("includes/scripts-dev.html"); ?>
</body>
</html>