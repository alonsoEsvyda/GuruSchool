<?= $headers; ?>
<?= $helper->PopUpBody(); ?>
<?= $menuFront; ?>
<!--Front-->
    <section style="background-image: url('<?= BASE_DIR ?>/design/css/imagenes/fondo-certificado.png');background-size: 100% 100%; no-repeat center center fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;" id="sec-front" class="padding margin-top">
    	<div class="container">
    		<div class="row">
    			<div class="col-md-12">
    				<div class="text-front text-front-down">
		                <center>
		                	<h1>Obten tu Certificado</h1><br>
			                <h1>De Participación.</h1><br>
			                <p>Mejora tu Curriculum certificando tus Conocimientos.</p>
             				  <a href="Cursos.php?accept=yes"><button type="button" class="waves-effect waves-light wow pulse animated btn btn-default">Ver Cursos</button></a>
		                </center>
		            </div>
    			</div>            
    		</div>
    	</div>
    </section>
    <!--steps-->
    <section class="intermediate steps1">
      <div class="container">
        <div class="row hidden-xs">
          <div class="col-md-6">
            <h1>Tu certificado es así!</h1>
            <p>Este es el certificado de participación disponible en casi la mayoría de nuestros cursos, simplemente termina el 100% del curso y Boalá, automáticamente lo tienes.</p>
          </div>
          <div class="col-md-6">
            <a data-toggle="modal" data-target="#myModal"><img class="imgstep1 wow bounceInRight" data-wow-duration="1s" data-wow-delay="0.5s"  src="<?= BASE_DIR ?>/design/css/imagenes/Certificado.png"></a>
            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
              <div class="modal-dialog">
                <center><img style="width:130%; margin-left:-80px;" src="<?= BASE_DIR ?>/design/css/imagenes/Certificado.png"></center>
              </div>
            </div>
          </div>
        </div>
        <!--RESPONSIVE-->
        <div class="row visible-xs">
          <div class="col-xs-12">
            <center>
              <h1>Tu certificado es así!</h1>
              <p>Este es el certificado de participación disponible en casi la mayoría de nuestros cursos, simplemente termina el 100% del curso y Boalá, automáticamente lo tienes.</p>
              <img  class="imgstep1-res wow bounceInRight" data-wow-duration="1s" data-wow-delay="0.5s"  src="<?= BASE_DIR ?>/design/css/imagenes/Certificado.png">
            </center>
          </div>
        </div>
      </div>
    </section>
    <section class="intermediate steps2">
      <div class="container">
        <div class="row hidden-xs">
        <hr>
        <div class="col-md-6">
            <img class="imgstep3 wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" src="<?= BASE_DIR ?>/design/css/imagenes/ipad.png">
          </div>
          <div class="col-md-6">
            <h1>Añadelo a tu Hoja de Vida!</h1>
            <p>Este Certificado te servirá para que lo agregues en tu Hoja de vida, lo podrás descargar de nuestra plataforma siempre que desees en formato PDF, compartelo donde quieras y con quien quieras.</p>
          </div>
        </div>
        <!--RESPONSIVE-->
        <div class="row visible-xs">
        <hr>
          <div class="col-xs-12">
            <center>
              <h1>Añadelo a tu Hoja de Vida!</h1>
              <p>Este Certificado te servirá para que lo agregues en tu Hoja de vida, lo podrás descargar de nuestra plataforma siempre que desees en formato PDF, compartelo donde quieras y con quien quieras.</p>
              <img class="imgstep3 wow bounceInLeft" data-wow-duration="2s" data-wow-delay="0.5s" src="<?= BASE_DIR ?>/design/css/imagenes/ipad.png">
            </center>
          </div>
        </div>
      </div>
    </section>
    <hr class="hr-class">
    <section class="aditional-tittle aditional-tittle-top">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <center>
              <h1>!Logra tu Objetivo¡</h1>
              <hr>
              <p>Confía tu Futuro en las manos de nuestros Expertos, Anímate. </p>
              <a href="Cursos.php?accept=yes"><button type="button" class="waves-effect waves-light wow pulse animated btn btn-default">Buscar Cursos</button></a>
            </center>
          </div>
        </div>
      </div>
    </section>
    <center>
      <img class="img-class wow bounceInUp hidden-xs" data-wow-duration="1s" src="<?= BASE_DIR ?>/design/css/imagenes/hand.jpg">
      <img style="width:100%;" class="img-class wow bounceInUp visible-xs" data-wow-duration="1s" src="<?= BASE_DIR ?>/design/css/imagenes/hand.jpg">
    </center>
<?= $footer; ?>
<?= $resource_script; ?>