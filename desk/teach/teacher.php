<?php
  include('../session/session_parameters.php');
  include ("../class/functions.php");
  include ("../class/function_data.php");

  //llamos a la clase ModelHTMLTeach
  $ModelHTMLTeach= new ModelHTMLTeach();
  //traemos el metodo que nos retorna los cursos que enseñamos
  $MyCourses=$ModelHTMLTeach->GetMyTeachCourses($_SESSION['Data']['Id_Usuario']);
  //lamamos a la clase SQLGetSelInt();
  $SQLGetSelInt= new SQLGetSelInt();

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
                  <h2>Plataforma del Maestro</h2>
                  <p>En esta Sección puedes Enseñar, Cobrar y Editar tus Cursos</p>
                  <a href="up_course"><button data-step="1" data-intro="Si tienes un talento que mostrár, enseñalo aquí en un Video-Curso" type="button" class="waves-effect waves-light wow pulse animated btn btn-default">Enseña Un Curso</button></a>
                </center>
            </div>
          </div>            
        </div>
      </div>
  </section>
  <!--Cursos Que Enseño-->
  <section class="courses-grid">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <!--Navegación-->
          <div class="container-nav-teacher">
            <?php include("includes/menu-sub-nav.php"); ?>
          </div>
          <!--Cursos-->
          <?php
          if ($MyCourses==false) {
            echo '<center>
                    <div class="intermediate margin-bottom padding">
                      <br><br><br>
                        <h2><i class="fa fa-smile-o" aria-hidden="true"></i> Usted no ha Creado Ningún Curso. <a href="up_course">Empieza Aquí</a></h2>
                    </div>
                  </center>' ;
          }else{
            foreach ($MyCourses as $Courses) {
              //Traemos los cursos aleatorios en una vista de la clase ViewsSQL
              $SQLStudentsIn=$SQLGetSelInt->SQLStudentsIn($Courses[0]); 
              ?>
                <div class="contenible-card ">
                  <div class="card hoverable">
                      <div class="card-image hidden-xs">
                          <div class="view overlay hm-white-slight z-depth-1">
                              <img src="../img_user/Cursos_Usuarios/<?php echo $Courses[2]; ?>" class="img-responsive" alt="">
                              <?php
                                switch ($Courses[3]) {
                                  case 'Publicado':
                                    ?>
                                      <a href="../details/<?php echo $Courses[0]; ?>/<?php echo str_replace(" ","-",$Courses[1]); ?>/">
                                        <div class="mask waves-effect"></div>
                                      </a>
                                    <?php
                                    break;
                                  
                                  case 'Rechazado':
                                    ?>
                                      <a href="update_course/<?php echo $Courses[0]; ?>">
                                          <div class="mask waves-effect"></div>
                                      </a>
                                    <?php
                                    break;

                                  case 'Aprobado':
                                    ?>
                                      <a href="up_video_course/<?php echo $Courses[0]; ?>">
                                          <div class="mask waves-effect"></div>
                                      </a>
                                    <?php
                                    break;

                                  case 'En Revision':
                                    ?>
                                      <div class="mask waves-effect"></div>
                                    <?php
                                    break;
                                    
                                  case 'En Revision Video':
                                    ?>
                                      <div class="mask waves-effect"></div>
                                    <?php
                                    break;
                                }
                              ?>
                          </div>
                      </div>
                      <div class="card-image-res visible-xs">
                          <div class="view overlay hm-white-slight z-depth-1">
                              <img src="../img_user/Cursos_Usuarios/<?php echo $Courses[2]; ?>" class="img-responsive" alt="">
                              <?php
                                switch ($Courses[3]) {
                                  case 'Publicado':
                                    ?>
                                      <a href="../details/<?php echo $Courses[0]; ?>/<?php echo str_replace(" ","-",$Courses[1]); ?>/">
                                        <div class="mask waves-effect"></div>
                                      </a>
                                    <?php
                                    break;
                                  
                                  case 'Rechazado':
                                    ?>
                                      <a href="update_course/<?php echo $Courses[0]; ?>">
                                          <div class="mask waves-effect"></div>
                                      </a>
                                    <?php
                                    break;

                                  case 'Aprobado':
                                    ?>
                                      <a href="up_video_course/<?php echo $Courses[0]; ?>">
                                          <div class="mask waves-effect"></div>
                                      </a>
                                    <?php
                                    break;

                                  case 'En Revision':
                                    ?>
                                      <div class="mask waves-effect"></div>
                                    <?php
                                    break;

                                  case 'En Revision Video':
                                    ?>
                                      <div class="mask waves-effect"></div>
                                    <?php
                                    break;

                                }
                              ?>
                          </div>
                      </div>
                      <div class="card-content">
                          <h5><?php echo $Courses[1]; ?></h5>
                      </div>
                      <div class="card-btn text-left">
                      <?php
                        switch ($Courses[3]) {
                          case 'Publicado':
                            ?>
                              <span class="label label-success">Publicado&nbsp; • &nbsp;
                              <i class="fa fa-user" aria-hidden="true"></i>&nbsp; <?php echo $SQLStudentsIn; ?></span>
                            <?php
                            break;
                          
                          case 'Rechazado':
                            ?>
                              <span class="label label-danger">Rechazado</span>
                            <?php
                            break;

                          case 'Aprobado':
                            ?>
                              <span class="label label-info">Aprobado</span>
                            <?php
                            break;

                          case 'En Revision':
                            ?>
                              <span class="label label-warning">En Revisión</span>
                            <?php
                            break;

                          case 'En Revision Video':
                            ?>
                              <span class="label label-warning">En Revisión Video</span>
                            <?php
                            break;
                        }
                      ?>
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
    <?php include ("../../includes-front/footer.php"); ?>
    <!--Scripts-->
    <?php include ("includes/scripts-dev.html"); ?>
</body>
</html>