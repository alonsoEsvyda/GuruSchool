<?= $headers; ?>
<?= $helper->PopUpBody(); ?>
<?= $menuFront; ?>
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
                    <h3 class="signup-tab"><a href="<?= BASE_DIR; ?>/home/">REGÍSTRATE</a></h3>
                    <h3 class="login-tab"><a class="active" href="<?= BASE_DIR; ?>/home/iniciar_session/">LOGIN</a></h3>
                  </div>
                  <div class="tabs-content">
                    <div id="login-tab-content">
                      <center>
                        <div class="fb">
                          <div class="fb-login-button" data-size="large"  data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false" onlogin="checkLoginState();"></div>
                        </div>
                      </center>
                    <div class="aditional-text">
                        <h1>ACCEDE CON TU EMAIL</h1>
                    </div>
                      <form class="login-form" action="<?= BASE_DIR; ?>/session/load_session/" method="post">
                        <input type="email" class="input" id="user_login" name="email" value="<?php if(isset($_GET['email'])){echo $_GET['email'];} ?>" autocomplete="off" placeholder="Email" required/>
                        <input type="password" class="input" id="user_pass" name="password" autocomplete="off" placeholder="Password" required/>
                        <input type="hidden" name="auth_token" value="<?= $helper->generateFormToken('send_message'); ?>" />
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
                    <h3 class="signup-tab"><a href="<?= BASE_DIR; ?>/home/">REGÍSTRATE</a></h3>
                    <h3 class="login-tab"><a class="active" href="<?= BASE_DIR; ?>/home/iniciar_session/">LOGIN</a></h3>
                  </div>
                  <div class="tabs-content">
                    <div id="res-login-tab-content">
                      <center>
                        <div class="fb">
                          <div class="fb-login-button" data-size="large"  data-button-type="login_with" data-show-faces="false" data-auto-logout-link="false" data-use-continue-as="false" onlogin="checkLoginState();"></div>
                        </div>
                      </center>
                    <div class="aditional-text">
                        <h1>ACCEDE CON TU EMAIL</h1>
                    </div>
                      <form class="login-form" action="<?= BASE_DIR; ?>/session/load_session/" method="post">
                        <input type="email" class="input" id="user_login" name="email" value="<?php if(isset($_GET['email'])){echo $_GET['email'];} ?>" autocomplete="off" placeholder="Email" required/>
                        <input type="password" class="input" id="user_pass" name="password" autocomplete="off" placeholder="Password" required/>
                        <input type="hidden" name="auth_token" value="<?= $helper->generateFormToken('send_message2'); ?>" />
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
</body>
<?= $footer; ?>
<?= $resource_script; ?>
<div id="fb-root"></div>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Home/session_facebook/facebook_callback.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Home/rescue_pass/rescue_callback.js"></script>