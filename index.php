<?php
  include('desk/session/session_parameters.php');
  
  header( 'X-Content-Type-Options: nosniff' );
  // evitar ataques clickjacking
  header( 'X-Frame-Options: SAMEORIGIN' );
  // Filtro anti-xss
  header( 'X-XSS-Protection: 1;mode=block' );

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
	<?php include ("includes-front/head.php"); ?>
</head>
<body>
	<!--Navigation-->
    <?php include("includes-front/menu.php"); ?>   
    <!--Front-->
    <section id="sec-front" class="padding-top">
    	<div class="container">
    		<div class="row">
    			<div  class="col-xs-6 hidden-xs">
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
            <div  class="col-xs-6 hidden-xs">
                <div class="form-wrap">
                  <div class="tabs">
                    <h3 class="signup-tab"><a class="active" href="">REGÍSTRATE</a></h3>
                    <h3 class="login-tab"><a href="iniciar-sesion">LOGIN</a></h3>
                  </div>
                  <div class="tabs-content">
                    <div id="signup-tab-content" class="active">
                      <div class="fb">
                          <?php
                            echo '<a href="' . $loginUrl . '"><i class="fa fa-facebook fa-lg"></i>Conectate con Facebook</a>';
                          ?>
                      </div>
                    <div class="aditional-text">
                        <h1>REGISTRATE CON TU EMAIL</h1>
                        <?php
                          include("includes-front/pop_up.php");
                        ?>
                    </div>
                      <form class="signup-form" action="desk/session/register.php" method="post">
                        <input type="email" class="input" id="user_email" name="email" value="<?php if(isset($_GET['email'])){echo $_GET['email'];} ?>" autocomplete="off" placeholder="Email" required/>
                        <input type="password" autocomplete="off" class="input" id="user_pass" name="password" autocomplete="off" placeholder="Password" data-toggle="tooltip" data-placement="left" title="El password debe ser Mayor a 8 digitos, tener 1 letra Mayúscula minimo, 1 dígito y 1 letra Minúscula minimo." required/>
                        <hr>
                        <input type="submit" class="button" value="Registrarme">
                      </form>
                    </div>
                  </div>
                </div>
            </div>
            <!--*RESPONSIVE-->
            <div class="col-xs-12 visible-xs">
                <div class="form-wrap">
                  <div class="tabs">
                    <h3 class="signup-tab"><a class="active" href="">REGÍSTRATE</a></h3>
                    <h3 class="login-tab"><a href="iniciar-sesion.php">LOGIN</a></h3>
                  </div>
                  <div class="tabs-content">
                    <div id="res-signup-tab-content" class="active">
                      <div class="fb">
                        <?php
                            echo '<a href="' . $loginUrl . '"><i class="fa fa-facebook fa-lg"></i>Conectate con Facebook</a>';
                          ?>
                      </div>
                    <div class="aditional-text">
                        <h1>REGISTRATE CON TU EMAIL</h1>
                        <?php
                          include("includes-front/pop_up.php");
                        ?>
                    </div>
                      <form class="signup-form" action="desk/session/register.php" method="post">
                        <input type="email" class="input" id="user_email" name="email" value="<?php if(isset($_GET['email'])){echo $_GET['email'];} ?>"  autocomplete="off" placeholder="Email" required/>
                        <input type="password" autocomplete="off" class="input" id="user_pass" name="password" autocomplete="off" placeholder="Password" data-toggle="tooltip" data-placement="top" title="El password debe ser Mayor a 8 digitos, tener 1 letra Mayúscula minimo, 1 dígito y 1 letra Minúscula minimo." required/>
                        <hr>
                        <input type="submit" class="button" value="Registrarme">
                      </form>
                    </div>
                  </div>
                </div>
            </div>
            <!--/LOGIN-->
    		</div>
    	</div>
    </section>
    <!--Como funciona?-->
    <section class="aditional-tittle aditional-tittle-top">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <center>
              <h1>¿Como funciona Gurú School?</h1>
              <hr>
              <p>En tres sencillos pasos lo podrás ver, baja un poco más </p>
              <i class="fa fa-angle-down" aria-hidden="true"></i>
            </center>
          </div>
        </div>
      </div>
    </section>
    <!--Pasos1-->
    <section class="intermediate steps1">
      <div class="container">
        <div class="row hidden-xs">
          <div class="col-md-6">
            <h1>1. Aprende algo Nuevo!</h1>
            <p>Aquí tienes la posibilidad de aprender casi cualquier curso de nuestras diversas categorías, en el tiempo que tu quieras, sin presión. Es una forma muy divertida en la que aprenderás muy fácil y rápido.</p>
            <img class="earpods imgstep2 wow bounceInLeft" data-wow-duration="1s" data-wow-delay="0.5s" src="css/imagenes/earpods.png">
          </div>
          <div class="col-md-6">
            <img class="imgstep1 wow bounceInRight" data-wow-duration="1s" data-wow-delay="0.5s"  src="css/imagenes/imac.png">
          </div>
        </div>
        <!--*RESPONSIVE-->
        <div class="row visible-xs">
          <div class="col-xs-12">
            <center>
              <h1>1. Aprende algo Nuevo!</h1>
              <p>Aquí tienes la posibilidad de aprender casi cualquier curso de nuestras diversas categorías,
              en el tiempo que tu quieras, sin presión. Es una forma muy divertida en la que aprenderás muy fácil y rápido.</p>
              <img class="imgstep1-res wow bounceInRight" data-wow-duration="1s" data-wow-delay="0.5s"  src="css/imagenes/imac.png">
            </center>
          </div>
        </div>
      </div>
    </section>
    <!--Pasos2-->
    <section class="intermediate steps2">
      <div class="container">
        <div class="row hidden-xs">
        <hr>
        <div class="col-md-6">
            <img class="imgstep3 wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" src="css/imagenes/hombre.png">
          </div>
          <div class="col-md-6">
            <h1>2. Enseña lo que te Gusta!</h1>
            <p>En nuestra plataforma te podrás destacar como profesor si eso es lo que te apasiona, podrás enseñar casi cualquier cosa, podrás subir tus vídeos, inter-actuar con tus estudiantes, una experiencia Genial y Única.</p>
            <img class="porta imgstep4 wow bounceInRight" data-wow-duration="1s" data-wow-delay="0.5s"  src="css/imagenes/portalapiz.png">
          </div>
        </div>
        <!--*RESPONSIVE-->
        <div class="row visible-xs">
        <hr>
          <div class="col-xs-12">
            <center>
              <h1>2. Enseña lo que te Gusta!</h1>
              <p>En nuestra plataforma te podrás destacar como profesor si eso es lo que te apasiona, 
              podrás enseñar casi cualquier cosa, podrás subir tus vídeos, inter-actuar con tus estudiantes, una experiencia Genial y Única.</p>
              <img class="imgstep3 wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" src="css/imagenes/hombre.png">
            </center>
          </div>
        </div>
      </div>
    </section>
    <!--Pasos3-->
    <section class="intermediate steps3">
      <div class="container">
        <div class="row hidden-xs">
        <hr>
        <div class="col-md-4">
            <img class="wow bounceInLeft"  data-wow-duration="2s" data-wow-delay="0.5s" src="css/imagenes/Certificado.png">
          </div>
          <div class="col-md-4">
            <h1>3. Gana Dinero ó Obten tu Certificado!</h1>
            <p>Si terminaste uno de nuestros cursos, obtendrás al final un Certificado de Participación Ò si lo que hiciste fue crear un curso en nuestra plataforma, podrás reclamar siempre el 70% de las ganancias del mismo.</p>
          </div>
          <div class="col-md-4">
            <img class="wow bounceInRight" data-wow-duration="1s" data-wow-delay="0.5s" src="css/imagenes/dinero.png">
          </div>
        </div>
        <!--*RESPONSIVE-->
        <div class="row visible-xs">
        <hr>
          <div class="col-xs-12">
            <h1>3. Gana Dinero ó Obten tu Certificado!</h1>
            <p>Si terminaste uno de nuestros cursos, obtendrás al final un Certificado de Participación Ò si lo que hiciste fue crear un curso en nuestra plataforma, podrás reclamar siempre el 70% de las ganancias del mismo.</p>
          </div>
          <div class="col-xs-12">
            <img class="wow bounceInRight" data-wow-duration="1s" data-wow-delay="0.5s" src="css/imagenes/dinero.png">
          </div>
        </div>
      </div>
    </section>
    <!--REGISTER-->
    <center>
      <img class="img-intermediate" src="css/imagenes/mujer.png">
    </center>
    <section id="grid">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1>¿Que esperas? Registrate Ya, no tienes<br> que pagar ni un centavo</h1><br>
            <center>
              <button type="button" id="Btn-Registrar" class="waves-effect waves-light wow pulse animated btn btn-default">Registrate Ya!</button>
            </center>
          </div>
        </div>
      </div>
    </section>
    <!--Footer-->
    <?php include ("includes-front/footer.php"); ?>
    <!--Scripts-->
   	<?php include ("includes-front/scripts.html"); ?>
</body>
</html>