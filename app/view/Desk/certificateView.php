<?= $headers; ?>
<?= $helper->PopUpBody(); ?>
<body>
	<!--Navigation-->
	<?= $menuFront; ?>
	<!--Front-->
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
                    <h2 class="margin-lestb-bottom margin-lestb-top"> NO TIENES CERTIFICADOS DISPONIBLES</h2><a href="<?= BASE_DIR; ?>/cursos/lista/&accept=yes"><button class="margin-lestb-bottom btn btn-default">Busca un Curso y Gana</button></a>
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
                                <img src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/<?= $Certified[2]; ?>" class="img-responsive" alt="">
                                <a href="<?= BASE_DIR; ?>/desk/cargar_certificado/<?= $helper->StringEncode($Certified[0]); ?>/<?= $helper->StringEncode($Certified[4]); ?>">
                                    <div class="mask waves-effect"></div>
                                </a>
                            </div>
                        </div>
                        <div class="card-image-res visible-xs">
                            <div class="view overlay hm-white-slight z-depth-1">
                                <img src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/<?= $Certified[2]; ?>" class="img-responsive" alt="">
                                <a href="<?= BASE_DIR; ?>/desk/cargar_certificado/<?= $helper->StringEncode($Certified[0]); ?>/<?= $helper->StringEncode($Certified[4]); ?>">
                                    <div class="mask waves-effect"></div>
                                </a>
                            </div>
                        </div>
                        <div class="card-content">
                            <h5><?= $Certified[1]; ?></h5>
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
</body>
<!-- /Content -->
<?= $footer; ?>
<?= $resource_script; ?>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Home/hostname.js"></script>