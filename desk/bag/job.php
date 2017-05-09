<?php
  include('../session/session_parameters.php');
	include ("../class/functions.php");
  include ("../class/function_data.php");

  //Llamamos la clase GuruApi
  $GuruApi = new GuruApi();
  //llamamos a la clase TheBag
  $TheBag=new TheBag();
  //llamamos al metodo que nos retorna los datos de la vacante
  $GetDataVacancy=$TheBag->GetDataVacancy($GuruApi->TestInput($_REQUEST['IdJ']),"Public");
  if ($GetDataVacancy==false) {
    header("Location:http://localhost/GuruSchool/la-bolsa?request=Lo siento, no lo encontramos :(");
  }else{
    foreach ($GetDataVacancy as $Data) {
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
  <!--Nombre-->
	<section id="sec-front" class="padding margin-top">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
           <!--Nombre y profesión-->
            <div class="text-front text-front-down">
                <h2>
                  <?php echo $Data[0]; ?>
                </h2>
                <p>
                  <?php echo $Data[1]; ?>
                </p>
            </div>
          </div>            
        </div>
      </div>
  </section>
  <!--Biografía-->
  <section class="grid-left-profile">
      <div class="container">
        <div class="row">
        <!--Imagen de perfil-->
          <div class="intermediate col-md-3">
            <img class="img_user_profile" src="../img_user/Perfil_Usuarios/<?php echo $Data[11]; ?>">
            <hr style="margin: 8px;">
            <center>
              <h4 style="font-size:20px; font-weight:600;color:rgba(52, 152, 219,1.0);"><?php echo $Data[10]; ?></h4>
            </center>
          </div>
          <div class="col-md-9">
            <div style="margin-bottom: 10px;" class="intermediate">
              <h3>Pais: <?php echo $Data[2]; ?> - Ciudad: <?php echo $Data[3]; ?> (<?php echo $Data[12]; ?>)</h3>
              <hr>
              <h3><?php echo $Data[4]; ?> - <?php echo $Data[5]; ?></h3>
              <hr>
              <h4>Salario: $<?php echo $Data[6]; ?> - Vacantes: <?php echo $Data[7]; ?> - <label class="label label-warning">Enviar CV: <?php echo $Data[8]; ?></label></h4>
              <hr>
              <h3>Descripción:</h3>
            </div>
            <p><?php echo $Data[9]; ?></p>
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