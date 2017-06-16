<?php
$headers = '
	<!DOCTYPE html>
	<html>
	<head>
		<title>Aprende, Enseña en linea | Gurú School</title>

		<!-- Meta Tags Headers -->
		<meta content="text/html; charset=UTF-8; X-Content-Type-Options=nosniff" http-equiv="Content-Type" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="description" content="Somos una plataforma colaborativa donde puedes aprender y enseñar cursos o tutoriales de una forma agradable y fácil"> 
		<meta http-equiv="Content-Language" content="es">
		<meta name="distribution" content="global"/>
		<meta name=”robots” content="Index, Follow">
		<meta name="revisit-after" content="1 day">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		
		<!-- Links -->
		<LINK HREF="'.BASE_DIR.'/design/css/imagenes/favicon.ico" REL="SHORTCUT ICON">
		<!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">-->
		<link href="'.BASE_DIR.'/design/css/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="'.BASE_DIR.'/design/css/material_bootstrap/mdb.min.css" rel="stylesheet" type="text/css">
		<link href="'.BASE_DIR.'/design/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<link href="'.BASE_DIR.'/design/css/style.v1.css" rel="stylesheet" type="text/css">
		<link href="'.BASE_DIR.'/design/css/animate/animate.min.css" rel="stylesheet">
		<link href="'.BASE_DIR.'/design/css/notify/pnotify.custom.min.css" media="all" rel="stylesheet" type="text/css" />
		<link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
		<!-- Add IntroJs styles -->
	    <link href="'.BASE_DIR.'/design/intro/introjs.css" rel="stylesheet">
	</head>';



// Process for render the menú 
if (isset($_GET['accept'])) {
    if (isset($_SESSION['Data']['Id_Usuario'])) {
    	$section = '<li><a href="desk/user" class="waves-effect waves-light"><strong>Inicio</strong></a></li>
        <li><a href="'.BASE_DIR.'/cursos/lista/&accept=yes" class="waves-effect waves-light">Cursos</a></li>
        <li><a href="'.BASE_DIR.'/home/certificados/&accept=yes" class="waves-effect waves-light">Certificados</a></li>
        <li><a href="'.BASE_DIR.'/la_bolsa/trabajos/&accept=yes" class="waves-effect waves-light">La Bolsa</a></li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mi Cuenta <i class="fa fa-angle-down" aria-hidden="true"></i></a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <a href="desk/profile"><li class="active dropdown-item"><img style="width:16px; margin-top:5px; margin-right:5px; float:left;" src="css/imagenes/favicon.ico"> Mi Perfil Gurú</li></a>
                <a href="desk/my-certificate"><li class="dropdown-item"><i class="blue-sun fa fa-certificate" aria-hidden="true"></i> Mis Certificados</li></a>
                <a href="desk/teach/teacher"><li class="dropdown-item"><i class="green-lanter fa fa-graduation-cap" aria-hidden="true"></i> Enseño</li></a>
                <a href="desk/learn"><li class="dropdown-item"><i class="red-black fa fa-book" aria-hidden="true"></i> Aprendo</li></a>
                <a href="desk/bag/list-my-job"><li class="dropdown-item"><i class="purple-black fa fa-suitcase" aria-hidden="true"></i> Empleos</li></a>
                <a href="desk/data_user"><li class="dropdown-item"><i class="blue-dark fa fa-database" aria-hidden="true"></i> Mis Datos</li></a>
                <a href="desk/security"><li class="dropdown-item"><i class="orange-sun fa fa-lock" aria-hidden="true"></i> Seguridad</li></a>
                <a href="desk/session/logout"><li class="dropdown-item"><i class="red-orange fa fa-times" aria-hidden="true"></i> Salir</li></a>
            </ul>
        </li>';
    }else{
    	$section = '<li><a href="'.BASE_DIR.'/home/" class="waves-effect waves-light"><strong>Inicio</strong></a></li>
        <li><a href="'.BASE_DIR.'/cursos/lista/&accept=yes" class="waves-effect waves-light">Cursos</a></li>
        <li><a href="'.BASE_DIR.'/home/certificados/&accept=yes" class="waves-effect waves-light">Certificados</a></li>
        <li><a href="'.BASE_DIR.'/la_bolsa/trabajos/&accept=yes" class="waves-effect waves-light">La Bolsa</a></li>
        <li><a href="'.BASE_DIR.'/home/iniciar_session/" class="waves-effect waves-light">Iniciar Sesión</a></li>
        <li><a style="background-color:#2BBBAD; color:white; border-radius:2px; padding:13px; margin-top:15px; font-size:15px;" href="'.BASE_DIR.'/home/" class="btn-register-menu waves-effect waves-light">REGISTRATE</a></li>';
    }
}else{
	$section ='<li><a href="'.BASE_DIR.'/home/" class="waves-effect waves-light"><strong>Inicio</strong></a></li>
    <li><a href="'.BASE_DIR.'/cursos/lista/&accept=yes" class="waves-effect waves-light">Cursos</a></li>
    <li><a href="'.BASE_DIR.'/home/certificados/&accept=yes" class="waves-effect waves-light">Certificados</a></li>
    <li><a href="'.BASE_DIR.'/la_bolsa/trabajos/&accept=yes" class="waves-effect waves-light">La Bolsa</a></li>';
}	

$menuFront = '
<nav id="navegacion" class="navbar navbar-fixed-top  white" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" id="responsive" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <img class="logo" src="'.BASE_DIR.'/design/css/imagenes/logo.png">
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul id="UlBar" class="nav navbar-nav">
            '.$section.'
            </ul>
        </div>
    </div>
</nav>
';
// Process for render the menú 



$menu2 = "";

$container = "";

$footer ='
<!---FOOTER-->
<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
          <div class="footer-horizontal">
              <div class="form-group hidden-xs">
                  <div class="col-xs-3">
                      <h1>Secciones</h1>
                      <ul>
                        <li><a href="'.BASE_DIR.'/index.php">Inicio</a></li>
                        <li><a href="'.BASE_DIR.'/Cursos.php?accept=yes">Cursos</a></li>
                        <li><a href="'.BASE_DIR.'/Certificados.php?accept=yes">Certificados</a></li>
                      </ul>
                  </div>
                  <div class="col-xs-3">
                      <h1>Terminos</h1>
                      <ul>
                        <li><a>Politicas de Privacidad</a></li>
                        <li><a>Terminos y Condiciones</a></li>
                      </ul>
                  </div>
                  <div class="col-xs-3">
                      <h1>Información</h1>
                      
                      <ul>
                        <li><a>Preguntas Frecuentes</a></li>
                        <li><a>Facebook</a></li>
                        <li><a>Nosotros</a></li>
                      </ul>
                  </div>
              </div>
              <div class="form-group hidden-xs ">
                  <div class="col-xs-3">
                      <h1>Contacto</h1>
                      <ul>
                        <a href="mailto:hola@guruschool.co"><li><p><i class="fa fa-envelope" aria-hidden="true"></i> hola@guruschool.co</p></li></a>
                        <a href="tel:+573204880761"><li><p><i class="fa fa-phone" aria-hidden="true"></i> +57-3204880761</p></li></a>
                        <li><p><i class="fa fa-map-marker" aria-hidden="true"></i> Cll 19 # 9-37/Moniquira</p></li>
                      </ul>
                  </div>
              </div>
              <!--RESPONSIVE-->
              <div class="form-group visible-xs">
                  <div class="col-xs-12">
                      <center>
                        <h1>Secciones</h1>
                        <ul>
                          <li><a href="'.BASE_DIR.'/index.php">Inicio</a></li>
                          <li><a href="'.BASE_DIR.'/Cursos.php?accept=yes">Cursos</a></li>
                          <li><a href="'.BASE_DIR.'/Certificados.php?accept=yes">Certificados</a></li>
                        </ul><br><br>
                      </center>
                  </div>
                  <div class="col-xs-12">
                      <center>
                        <h1>Terminos</h1>
                        <ul>
                          <li><a>Politicas de Privacidad</a></li>
                          <li><a>Terminos y Condiciones</a></li>
                        </ul><br><br>
                      </center>
                  </div>
                  <div class="col-xs-12">
                      <center>
                        <h1>Información</h1>
                        <ul>
                          <li><a>Preguntas Frecuentes</a></li>
                          <li><a>Facebook</a></li>
                          <li><a>Nosotros</a></li>
                        </ul><br><br>
                      </center>
                  </div>
              </div>
              <div class="form-group visible-xs">
                  <div class="col-xs-12">
                      <center>
                        <h1>Contacto</h1>
                        <ul>
                          <a href="mailto:hola@guruschool.co"><li><p><i class="fa fa-envelope" aria-hidden="true"></i> hola@guruschool.co</p></li></a>
                          <a href="tel:+573204880761"><li><p><i class="fa fa-phone" aria-hidden="true"></i> +57-3204880761</p></li></a>
                          <li><p><i class="fa fa-map-marker" aria-hidden="true"></i> Cll 19 # 9-37/Moniquira</p></li>
                        </ul>
                      </center>
                  </div>
              </div>
          </div>
      </div>
    </div>
    <hr>
      <p class="copy hidden-xs ">2016 Gurú School ®. Todos los derechos reservados - Términos y condiciones, Políticas de Privacidad.</p>
      <ul class="social hidden-xs">
        <li><a href="https://plus.google.com/u/0/102820082564546543759" target="_blank"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a></li>
        <li><a href="https://twitter.com/Guru_School" target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
        <li><a href="https://www.facebook.com/GuruLearn/" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
      </ul>
    <!--RESPONSIVE-->
      <center>
        <p class="copy-res visible-xs">2016 Gurú School ®. Todos los derechos reservados - Términos y condiciones, Políticas de Privacidad.</p>
        <ul class="social-res visible-xs">
          <li><a href="https://plus.google.com/u/0/102820082564546543759" target="_blank"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a></li>
          <li><a href="https://twitter.com/Guru_School" target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
          <li><a href="https://www.facebook.com/GuruLearn/" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
        </ul>
      </center>
  </div>
</footer>
';

$resource_script = '
	<script type="text/javascript" src="'.BASE_DIR.'/design/js/jquery/jquery.js"></script>
	<script type="text/javascript" src="'.BASE_DIR.'/design/js/bootstrap/bootstrap.min.js"></script>
	<script src="'.BASE_DIR.'/design/js/material_bootstrap/mdb.min.js" type="text/javascript"></script>
	<script src="'.BASE_DIR.'/design/js/main/main.js" type="text/javascript"></script>
	<!--sistema de notificacion-->
	<script src="'.BASE_DIR.'/design/js/notify/pnotify.custom.min.js" type="text/javascript"></script>
	<!--efectos-->
	<script src="'.BASE_DIR.'/design/js/wow/wow.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.4/angular.min.js"></script>
	<script>
		new WOW().init();
	</script>
	<script type="text/javascript" src="'.BASE_DIR.'/design/js/tooltip.js"></script>
	<!--BTN UP HEADER-->
	<script type="text/javascript">
		$(document).ready(function() {
		  $("#user_email").focus();
		  $("#user_login").focus();
	      $("#Btn-Registrar").click(function () {
	        $("body,html").animate({scrollTop: 0 }, 800);
	        $("#user_email").focus();
	        return false;
	      });
		});
	</script> 
	<script type="text/javascript">
		function notify(tit,not,type,style)
		{
			new PNotify({
			    title: tit,
		        text: not,
			    type: type,
			    styling: style
		    });
		}
	</script>
	</html>';
?>