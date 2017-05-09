<?php
  include('session/session_parameters.php');
	include ("class/functions.php");
  include ("class/function_data.php");
  $ModelHTMLUser= new ModelHTMLUser();
  //traemos los datos personales del usuario en sesión
  $ArrDataUser=$ModelHTMLUser->DataUserPersonal($_SESSION['Data']['Id_Usuario']);
  if ($ArrDataUser!=0) {
    foreach ($ArrDataUser as $DataUser){
    }
  }
  //traemos los datos profesionales del usuario en sesión
  $ArrDataProfUser=$ModelHTMLUser->DataUserProfesional($_SESSION['Data']['Id_Usuario']);
  if ($ArrDataProfUser!=0) {
    foreach ($ArrDataProfUser as $DataProfessional) {
    }
  }
  //traemos las redes sociales que halla insertado el usuario
  $ArrSocialMedia=$ModelHTMLUser->GetSocialMediaUser($_SESSION['Data']['Id_Usuario']);
  //traemos el correo del usuario para enviarlo a su perfil público
  $ArrEmailData=$ModelHTMLUser->GetEmailUser($_SESSION['Data']['Id_Usuario']);
  
  //Llamamos la clase GuruApi para validar credenciales
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
  <!--Nombre-->
	<section id="sec-front" class="padding margin-top">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
          <!--Nombre y profesión-->
            <div class="text-front text-front-down">
                <h2>
                  <?php 
                  if ($ArrDataUser==0) {
                    echo "No haz llenado tu Nombre";
                  }else{
                      echo $DataUser[0];
                    }
                 ?>
                </h2>
                <p>
                  <?php
                    if ($ArrDataProfUser==0) {
                      echo "No Haz Puesto Profesión";
                    }else{
                      echo $DataProfessional[0];
                    }
                  ?>
                </p>
                <a href="public-profile/<?php echo $ArrEmailData; ?>"><button type="button" class="btn btn-default">Ver Perfil Público</button></a>
            </div>
          </div>            
        </div>
      </div>
  </section>
  <!--Biografía-->
  <section class="intermediate grid-left-profile">
      <div class="container">
        <div class="row">
        <!--Imagen de perfil-->
          <div class="col-md-3">
            <?php
              if ($ArrDataUser==0) {
                ?>
                  <img class="img_user_profile" src="img_user/Perfil_Usuarios/defecto_user.jpg">
                <?php
              }else{
                ?>
                  <img class="img_user_profile" src="img_user/Perfil_Usuarios/<?php echo $DataUser[5]; ?>">
                <?php
              }
            ?>
          </div>
          <div class="col-md-9">
            <h1>Biografía</h1>
            <p>
              <?php
                if ($ArrDataProfUser==0) {
                  echo "No haz llenado tu biografía, Llenala <a href='data_user'> Aquí</a>";
                }else{
                  echo $DataProfessional[1];
                }          
              ?>
            </p>
            <hr>
            <!--Redes sociales-->
            <h1>Redes Sociales</h1>
            <div class="margin-lestc-top">
            <?php
              if ($ArrSocialMedia==0) {
                echo "<p>No haz agregado Redes sociales, Agrega tus Redes <a href='data_user'>Aquí</a></p>";
              }else{
                foreach ($ArrSocialMedia as $DataSocial) {
                  if($DataSocial[0]!=NULL) {
                    ?>
                      <a href="<?php echo $DataSocial[0];?>" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
                    <?php
                  }
                  if($DataSocial[1]!=NULL){
                    ?>
                      <a href="<?php echo $DataSocial[1]; ?>" target="_blank"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a> 
                    <?php
                  }
                  if($DataSocial[2]!=NULL){
                    ?>
                      <a href="<?php echo $DataSocial[2]; ?>" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
                    <?php
                  }
                  if($DataSocial[3]!=NULL){
                    ?>
                      <a href="<?php echo $DataSocial[3]; ?>" target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
                    <?php
                  }
                } 
              }
            ?>
            </div>
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