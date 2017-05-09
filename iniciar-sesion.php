<?php
  include('desk/session/session_parameters.php');
  if (isset($_SESSION['Data']['Id_Usuario'])) {
    header("Location:desk/user");
  }
  require_once __DIR__ . '/desk/library/api-facebook/src/Facebook/autoload.php';
  $fb = new Facebook\Facebook([
    'app_id' => '981554355256359',
    'app_secret' => '2d2e0414e108688b045fd8f44f6e3ffb',
    'default_graph_version' => 'v2.4',
    ]);
  $helper = $fb->getRedirectLoginHelper();
  $permissions = ['email']; // optional
  $loginUrl = $helper->getLoginUrl('http://guruschool.avmsolucionweb.com/desk/session/api-facebook.php', $permissions);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Aprende, Enseña en linea | Gurú School</title>
  <meta name=" title" content="Aprende, Enseña en linea | Gurú School">
	<?php 
    include ("desk/class/functions.php");
    include ("includes-front/head.php");
   ?>
</head>
<body>
	<!--Navigation-->
    <?php include("includes-front/menu.php"); ?>   
    <!--Front-->
    <section id="sec-front" class="padding-top" >
    	<div class="container">
    		<div class="row">
    			<div class="col-xs-6 hidden-xs">
    				<div class="text-front text-front-margin">
                <h1>Optimiza tus estudios.</h1><br>
                <h1>Actualiza tu Mente.</h1><br>
                <p>Aprende Más con Gurú School, Cursos Online <i class="fa fa-graduation-cap" aria-hidden="true"></i></p>
            </div>
    			</div>
          <!--*RESPONSIVE-->
          <div class="col-xs-12 visible-xs">
            <div class="text-front text-front-margin">
              <center>
                  <h1>Optimiza tus estudios.</h1><br>
                  <h1>Actualiza tu Mente.</h1><br>
                  <p>Aprende Más con Gurú School, Cursos Online <i class="fa fa-graduation-cap" aria-hidden="true"></i></p>
              </center>
            </div>
          </div>
          <!--LOGIN-->
            <div class="col-xs-6 hidden-xs">
                <div class="form-wrap">
                  <div class="tabs">
                    <h3 class="signup-tab"><a href="index">REGÍSTRATE</a></h3>
                    <h3 class="login-tab"><a class="active" href="">LOGIN</a></h3>
                  </div>
                  <div class="tabs-content">
                    <div id="login-tab-content">
                      <div class="fb">
                          <?php
                            echo '<a href="' . $loginUrl . '"><i class="fa fa-facebook fa-lg"></i>Conectate con Facebook</a>';
                          ?>
                      </div>
                    <div class="aditional-text">
                        <h1>ACCEDE CON TU EMAIL</h1>
                        <?php
                          include("includes-front/pop_up.php");
                        ?>
                    </div>
                      <form class="login-form" action="desk/session/validate.php" method="post">
                        <input type="email" class="input" id="user_login" name="email" value="<?php if(isset($_GET['email'])){echo $_GET['email'];} ?>" autocomplete="off" placeholder="Email" required/>
                        <input type="password" class="input" id="user_pass" name="password" autocomplete="off" placeholder="Password" required/>
                        <input type="hidden" name="auth_token" value="<?php $GuruApi= new GuruApi(); echo $GuruApi->generateFormToken('send_message');?>" />
                        <hr>
                        <input type="submit" name="button-lg" class="button" value="Login">
                      </form>
                      <div class="help-text">
                        <p><a data-toggle="modal" data-target="#myModal">Olvidé mi Contraseña!</a></p>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <!--*RESPONSIVE-->
            <div class="col-xs-12 visible-xs">
                <div class="form-wrap">
                  <div class="tabs">
                    <h3 class="signup-tab"><a href="index.php">REGÍSTRATE</a></h3>
                    <h3 class="login-tab"><a class="active" href="">LOGIN</a></h3>
                  </div>
                  <div class="tabs-content">
                    <div id="res-login-tab-content">
                      <div class="fb">
                        <?php
                            echo '<a href="' . $loginUrl . '"><i class="fa fa-facebook fa-lg"></i>Conectate con Facebook</a>';
                          ?>
                      </div>
                    <div class="aditional-text">
                        <h1>ACCEDE CON TU EMAIL</h1>
                        <?php
                          include("includes-front/pop_up.php");
                        ?>
                    </div>
                      <form class="login-form" action="desk/session/validate.php" method="post">
                        <input type="email" class="input" id="user_login" name="email" value="<?php if(isset($_GET['email'])){echo $_GET['email'];} ?>" autocomplete="off" placeholder="Email" required/>
                        <input type="password" class="input" id="user_pass" name="password" autocomplete="off" placeholder="Password" required/>
                        <input type="hidden" name="auth_token" value="<?php $GuruApi= new GuruApi(); echo $GuruApi->generateFormToken('send_message2');?>" />
                        <hr>
                        <input type="submit" name="button-res" class="button" value="Login">
                      </form>
                      <div class="help-text">
                        <p><a data-toggle="modal" data-target="#myModal">Olvidé mi Contraseña!</a></p>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <!--/LOGIN-->

            <!-- MODAL -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div style="padding:40px;" class="modal-body intermediate">
                          <center>
                            <h2>Recupera tu Contraseña</h2>
                            <p>Escribe tu email y te enviaremos una contraseña.</p>
                          </center>
                            <form>
                            <div class="request margin-lestc-top margin-lestc-bottom"></div>
                              <input type="email" placeholder="Escribe tu Correo" class="Email-Rescue" name="email" required/>
                              <input type="submit" style="width:100%;" name="button-res" class="Btn-Rescue btn btn-default" value="Enviar Correo">
                            </form>
                        </div>
                    </div>
                    <!--/.Content-->
                </div>
            </div>
    		</div>
    	</div>
    </section>
    <!--Footer-->
    <?php include ("includes-front/footer.php"); ?>
    <!--Scripts-->
   	<?php include ("includes-front/scripts.html"); ?>
    <script type="text/javascript">
      function RescuePass(){
        Email=$('.Email-Rescue').val();
        $.post('desk/case_user/rescue_pass.php',{
          Email:Email,
        },function(info){
          if (info==true) {
            $('.request').html("<span style='color:rgba(46, 204, 113,1.0);'>Se Envío Correctamente. Revise su bandeja de entrada o el Correo no deseado</span>");
            $('.Btn-Rescue').removeAttr("disabled");
          }else if(info==false){
            $('.request').html("<span style='color:rgba(192, 57, 43,1.0);'>Hubo un error al enviar, revise que el correo sea valido o llene el campo correspondiente.</span>");
            $('.Btn-Rescue').removeAttr("disabled");
          }
        });
      }
      $(document).ready(function(){
        $('.Btn-Rescue').on('click', function(e){
          if ($('.Email-Rescue').val()=="") {
            $('.request').html("<span style='color:rgba(192, 57, 43,1.0);'>Llene este Campo Primero.</span>");
          }else{
            e.preventDefault();
            $(".Btn-Rescue").attr('disabled', 'disabled');
            RescuePass();
          }
        });
      });
    </script>
</body>
</html>