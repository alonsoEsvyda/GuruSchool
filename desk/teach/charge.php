h2<?php
  include('../session/session_parameters.php');
  include ("../class/functions.php");
  include ("../class/function_data.php");

  //llamamos a la clase ModelHTMLTeach
  $ModelHTMLTeach= new ModelHTMLTeach();
  //llamamos al metodo que nos retorna los cursos pagados
  $ChargeCourse=$ModelHTMLTeach->ChargeCourse($_SESSION['Data']['Id_Usuario']);

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
	<?php include ("includes/menu-dev.php"); ?>
	<!--Titulo dela Sección-->
	<section id="sec-front" class="padding margin-top">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-front text-front-down">
                <center>
                	<h2>Plataforma del Maestro</h2>
                	<p>En esta Sección puedes Enseñar, Cobrar y Editar tus Cursos</p>
                  <a href="up_course"><button type="button" data-step="1" data-intro="Si tienes un talento que mostrár, enseñalo aquí en un Video-Curso" class="waves-effect waves-light wow pulse animated btn btn-default">Enseña Un Curso</button></a>
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
            if ($ChargeCourse==false) {
              echo '<center>
                    <div class="intermediate margin-bottom padding">
                      <br><br><br>
                        <h2><i class="fa fa-paper-plane-o" aria-hidden="true"></i> Usted no tiene cobros.</h2>
                    </div>
                  </center>' ;
            }else{
              foreach ($ChargeCourse as $Charge) {
                ?>
                  <div class="contenible-card">
                      <div style="height:auto;" class="card hoverable margin-lestb-top">
                          <div class="card-image hidden-xs">
                              <div class="view overlay hm-white-slight z-depth-1">
                                  <img src="../img_user/Cursos_Usuarios/<?php echo $Charge[4]; ?>" class="img-responsive" alt="">
                                    <div class="mask waves-effect"></div>
                              </div>
                          </div>
                          <div class="card-image-res visible-xs">
                              <div class="view overlay hm-white-slight z-depth-1">
                                  <img src="../img_user/Cursos_Usuarios/<?php echo $Charge[4]; ?>" class="img-responsive" alt="">
                                    <div class="mask waves-effect"></div>
                              </div>
                          </div>
                          <div class="card-content">
                              <h5><?php echo $Charge[3]; ?></h5>
                              <?php
                                if ($Charge[1]>=400000) {
                                  ?>
                                    <p>Total:$ <?php echo number_format($Charge[1]); ?> COP | <a data-course="<?php echo $GuruApi->StringEncode($Charge[0]); ?>" data-toggle="modal" data-target="#myModal" onclick="SendData(this)"><span class="label label-success"><i class="fa fa-unlock-alt" aria-hidden="true"></i> COBRAR</span></a></p>
                                  <?php
                                }else{
                                  ?>
                                    <p>Total:$ <?php echo number_format($Charge[1]); ?> COP | <span class="label label-danger"><i class="fa fa-lock" aria-hidden="true"></i> NO CREDIT</span></p>
                                  <?php
                                }
                              ?>
                          </div>
                      </div>
                  </div>
                <?php
              }
          ?>
          <?php
            }
          ?>
        </div>
        <!--modal-->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header intermediate">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <center>
                          <h3 class="modal-title" id="myModalLabel">¿Desea confirmar el Cobro?</h3>
                        <label>Una vez se notifique el cobro no hay marcha atras, de click si está seguro.</label>
                        </center>
                    </div>
                    <div class="modal-footer" id="modal-message">
                      <center>
                          <button type="button" class="btn btn-primary" value="si" onclick="SendCharge(this)">yes</button>
                          <button type="button" class="btn btn-secondary" value="no" data-dismiss="modal">no</button>
                      </center>
                    </div>
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
    <script type="text/javascript">
      function SendData(button){
        var DataCourse=$(button).attr('data-course');
        $('#modal-message').find('.btn-primary').attr('data-course',DataCourse);
      }
      function SendCharge(button){
        var DataCourse=$(button).attr('data-course');
          $.post('controll/payment_charge.php',{
            Data:DataCourse,
          },function(info){
            if (info==true) {
              window.location="payments?requestok=Le notificaremos el Pago por Email o Telefono, tan pronto esté listo.";
            }
          });
      }
    </script>
</body>
</html>