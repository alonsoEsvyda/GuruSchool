<?php
  include('session/session_parameters.php');
	include ("class/functions.php");
  include ("class/function_data.php");

  //llamamos a la clase DataCertified
  $DataCertified= new DataCertified();
  //llamamos al metodo que nos retorna los datos del certificado
  $GetDataCertified=$DataCertified->GetDataCertified($_SESSION['Data']['Id_Usuario']);
  if ($GetDataCertified==true) {
    foreach ($GetDataCertified as $Certified) {
    }
  }

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
                	<h2>Mis Certificados</h2>
                	<p>Sección del Alumno.</p>
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
                  <h1>!Descarga tu Certificado¡</h1>
                  <hr>
                </div>
              </div>
            </div>
          </section>
          <?php
            if ($GetDataCertified==false) {
              ?>
                <div class="intermediate">
                  <center>
                    <h2 class="margin-lestb-bottom margin-lestb-top"> NO TIENES CERTIFICADOS DISPONIBLES</h2><a href="../Cursos?accept=yes"><button class="margin-lestb-bottom btn btn-default">Busca un Curso y Gana</button></a>
                  </center>
                </div>
              <?php
            }else{
              foreach ($GetDataCertified as $Certified) {
                ?>
                  <div class="contenible-card ">
                    <div class="card hoverable">
                        <div class="card-image hidden-xs">
                            <div class="view overlay hm-white-slight z-depth-1">
                                <img src="img_user/Cursos_Usuarios/<?php echo $Certified[2]; ?>" class="img-responsive" alt="">
                                <a href="case_user/MyCertified?Data=<?php echo $GuruApi->StringEncode($Certified[0]); ?>">
                                    <div class="mask waves-effect"></div>
                                </a>
                            </div>
                        </div>
                        <div class="card-image-res visible-xs">
                            <div class="view overlay hm-white-slight z-depth-1">
                                <img src="img_user/Cursos_Usuarios/<?php echo $Certified[2]; ?>" class="img-responsive" alt="">
                                <a href="case_user/MyCertified?Data=<?php echo $GuruApi->StringEncode($Certified[0]); ?>">
                                    <div class="mask waves-effect"></div>
                                </a>
                            </div>
                        </div>
                        <div class="card-content">
                            <h5><?php echo $Certified[1]; ?></h5>
                            <p><i class="fa fa-certificate" aria-hidden="true"></i> Certificado Listo</p>
                        </div>
                        <div class="card-btn text-left">
                          <h2>Clickeame</h2>
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