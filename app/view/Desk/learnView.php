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
                  <h2>Cursos Que Aprendo</h2>
                  <p>Sección del Alumno</p>
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
                  <h1>!Cursos en Progreso¡</h1>
                  <hr>
                </div>
              </div>
            </div>
          </section>
          <?php
            if ($DataMyCourse == false) {
              echo "<center>
                    <div class='intermediate margin-bottom padding-lestb'>
                      <br><br><br>
                        <h2><i class='fa fa-pencil' aria-hidden='true'></i> Usted no Está apuntadoa ningún Curso. Busque un Curso <a href='../Cursos?accept=yes'>Aquí</a></h2>
                    </div>
                  </center>" ;
            }else{
              foreach ($DataMyCourse as $DataCourse) {
              ?>
                <div class="contenible-card ">
                  <div class="card hoverable">
                      <div class="card-image hidden-xs">
                          <div class="view overlay hm-white-slight z-depth-1">
                              <img src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/<?= $DataCourse[2]; ?>" class="img-responsive" alt="">
                              <a href="classroom/player/<?= $DataCourse[0]; ?>/">
                                  <div class="mask waves-effect"></div>
                              </a>
                          </div>
                      </div>
                      <div class="card-image-res visible-xs">
                          <div class="view overlay hm-white-slight z-depth-1">
                              <img src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/<?= $DataCourse[2]; ?>" class="img-responsive" alt="">
                              <a href="classroom/player/<?= $DataCourse[0]; ?>/">
                                  <div class="mask waves-effect"></div>
                              </a>
                          </div>
                      </div>
                      <div class="card-content">
                          <h5><?= $DataCourse[1]; ?></h5>
                          <p>By: <?= $DataCourse[5]; ?></p>
                      </div>
                      <div class="card-btn text-left">
                        <p style="float: right; margin-top: 5px;" class="green-letter margin-lestc-right"><?= $DataCourse[6] ?> %</p>
                        <div style="height: 3px; float: right; width: 60%;" class="margin-lestb-top margin-lestb-right progress">
                          <div class="progress-bar" role="progressbar" aria-valuenow="<?= $DataCourse[6]; ?>"
                          aria-valuemin="0" aria-valuemax="100" style="width:<?= $DataCourse[6]; ?>%">
                          </div>
                        </div>
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