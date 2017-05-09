<?php
  include('../session/session_parameters.php');
  include ("../class/functions.php");
  include ("../class/function_data.php");

  //llamamos a la clase ModelHTMLTeach
  $ModelHTMLTeach= new ModelHTMLTeach();
  //llamamos al metodo que nos retorna los cobros
  $PaymentsCourse=$ModelHTMLTeach->PaymentsCourse($_SESSION['Data']['Id_Usuario']);

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
  <?php
    include("includes/pop_up-dev.php");
  ?>
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
          <div style="margin-left:11px;" class="list-global content-description intermediate margin-top table-responsive">
            <table class="table table-hover">
              <thead>
                  <tr>
                    <th><h1><i class="fa fa-usd" aria-hidden="true"></i> Cobros Efectuados y Pendientes.</h1></th>
                  </tr>
              </thead>
                <tbody>
                  <tr>
                    <td><h3>Curso Cobrado</h3></td>
                    <td><h3>Monto</h3></td>
                    <td><h3>Estado del Cobro</h3></td>
                    <td><h3>Fecha</h3></td>
                    <td><h3># Pago</h3></td>
                  </tr>
                  <?php
                    if ($PaymentsCourse==false) {
                      ?>
                        <tr>
                          <td><h4>No tienes Cobros</h4></td>
                          <td>$ 0 COP</td>
                          <td><span class="label label-success">Efectuado</span></td>
                          <td>0</td>
                        </tr>
                      <?php
                    }else{
                      foreach ($PaymentsCourse as $Payment) {
                        ?>
                          <tr>
                            <td><h4><?php echo $Payment[3]; ?></h4></td>
                            <td>$ <?php echo number_format($Payment[0]); ?> COP</td>
                            <td>
                              <?php
                                if ($Payment[1]=="Pending") {
                                  ?>
                                    <span class="label label-warning"><?php echo $Payment[1]; ?></span>
                                  <?php
                                }else if($Payment[1]=="Execute"){
                                  ?>
                                    <span class="label label-success"><?php echo $Payment[1]; ?></span>
                                  <?php
                                }else if($Payment[1]=="Resting"){
                                  ?>
                                    <span class="label label-info"><?php echo $Payment[1]; ?></span>
                                  <?php
                                }
                              ?>
                            </td>
                            <td><?php echo $Payment[2]; ?></td>
                            <td><?php echo $Payment[4]; ?></td>
                          </tr>
                        <?php
                      }
                    }
                  ?>
                </tbody>
            </table>
          </div>
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