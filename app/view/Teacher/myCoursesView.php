<?= $headers; ?>
<?= $helper->PopUpBody(); ?>
	<!--Navigation-->
	<?= $menuFront; ?>
	<!--Front-->
  <!--Titulo de la sección-->
    <!--Titulo dela Sección-->
  <section id="sec-front" class="padding margin-top">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-front text-front-down">
                <center>
                  <h2>Plataforma del Maestro</h2>
                  <p>En esta Sección puedes Enseñar, Cobrar y Editar tus Cursos</p>
                  <a href="up_course"><button data-step="1" data-intro="Si tienes un talento que mostrár, enseñalo aquí en un Video-Curso" type="button" class="waves-effect waves-light wow pulse animated btn btn-default">Enseña Un Curso</button></a>
                </center>
            </div>
          </div>            
        </div>
      </div>
  </section>
  <!--Cursos Que Enseño-->
  <section class="courses-grid">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <!--Navegación-->
          <div class="container-nav-teacher">
            <ul id="nav">
                <li data-toggle="tooltip" data-placement="top" title="Aquí verás los cursos que enseñas y el estado de cada uno." ><a data-step="2" data-intro="Encuentra la lista de todos los cursos que enseñas, el estado y la cantidad de alumnos inscritos" href="teacher">Enseño</a></li>
                <li data-toggle="tooltip" data-placement="top" title="En esta sección puedes cobrar tus cursos, despues de tener minimo, $ 400.000 COP" ><a data-step="3" data-intro="Cobra tus cursos desde $ 400.000 COP en adelante." href="charge">Cobrar</a></li>
                <li data-toggle="tooltip" data-placement="top" title="En esta sección tienes un resumen completo de tus cobros.."><a data-step="4" data-intro="Encuentra la lista de tus cobros, Pagos, etc.." href="payments">Reporde de Cobros</a></li>
                <li><a href="javascript:void(0);" onclick="javascript:introJs().setOption('showProgress', true).start();" ><i class="fa fa-question-circle" aria-hidden="true"></i></a></li>
            </ul>
          </div>
          <!--Cursos-->
          <?php
          if ($MyCourses==false) {
            echo '<center>
                    <div class="intermediate margin-bottom padding">
                      <br><br><br>
                        <h2><i class="fa fa-smile-o" aria-hidden="true"></i> Usted no ha Creado Ningún Curso. <a href="up_course">Empieza Aquí</a></h2>
                    </div>
                  </center>' ;
          }else{
            foreach ($MyCourses as $Courses) {
              ?>
                <div class="contenible-card ">
                  <div class="card hoverable">
                      <div class="card-image hidden-xs">
                          <div class="view overlay hm-white-slight z-depth-1">
                              <img src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/<?= $Courses[2]; ?>" class="img-responsive" alt="">
                              <?php
                                switch ($Courses[3]) {
                                  case 'Publicado':
                                    ?>
                                      <a href="<?= BASE_DIR; ?>/cursos/detalles/<?= $Courses[0]; ?>/<?= str_replace(" ","-",$Courses[1]); ?>/">
                                        <div class="mask waves-effect"></div>
                                      </a>
                                    <?php
                                    break;
                                  
                                  case 'Rechazado':
                                    ?>
                                      <a href="update_course/<?= $Courses[0]; ?>">
                                          <div class="mask waves-effect"></div>
                                      </a>
                                    <?php
                                    break;

                                  case 'Aprobado':
                                    ?>
                                      <a href="up_video_course/<?= $Courses[0]; ?>">
                                          <div class="mask waves-effect"></div>
                                      </a>
                                    <?php
                                    break;

                                  case 'En Revision':
                                    ?>
                                      <div class="mask waves-effect"></div>
                                    <?php
                                    break;
                                    
                                  case 'En Revision Video':
                                    ?>
                                      <div class="mask waves-effect"></div>
                                    <?php
                                    break;
                                }
                              ?>
                          </div>
                      </div>
                      <div class="card-image-res visible-xs">
                          <div class="view overlay hm-white-slight z-depth-1">
                              <img src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/<?= $Courses[2]; ?>" class="img-responsive" alt="">
                              <?php
                                switch ($Courses[3]) {
                                  case 'Publicado':
                                    ?>
                                      <a href="<?= BASE_DIR; ?>/cursos/detalles/<?= $Courses[0]; ?>/<?= str_replace(" ","-",$Courses[1]); ?>/">
                                        <div class="mask waves-effect"></div>
                                      </a>
                                    <?php
                                    break;
                                  
                                  case 'Rechazado':
                                    ?>
                                      <a href="update_course/<?= $Courses[0]; ?>">
                                          <div class="mask waves-effect"></div>
                                      </a>
                                    <?php
                                    break;

                                  case 'Aprobado':
                                    ?>
                                      <a href="up_video_course/<?= $Courses[0]; ?>">
                                          <div class="mask waves-effect"></div>
                                      </a>
                                    <?php
                                    break;

                                  case 'En Revision':
                                    ?>
                                      <div class="mask waves-effect"></div>
                                    <?php
                                    break;

                                  case 'En Revision Video':
                                    ?>
                                      <div class="mask waves-effect"></div>
                                    <?php
                                    break;

                                }
                              ?>
                          </div>
                      </div>
                      <div class="card-content">
                          <h5><?= $Courses[1]; ?></h5>
                      </div>
                      <div class="card-btn text-left">
                      <?php
                        switch ($Courses[3]) {
                          case 'Publicado':
                            ?>
                              <span class="label label-success">Publicado&nbsp; • &nbsp;
                              <i class="fa fa-user" aria-hidden="true"></i>&nbsp; <?= $Courses[6]; ?></span>
                            <?php
                            break;
                          
                          case 'Rechazado':
                            ?>
                              <span class="label label-danger">Rechazado</span>
                            <?php
                            break;

                          case 'Aprobado':
                            ?>
                              <span class="label label-info">Aprobado</span>
                            <?php
                            break;

                          case 'En Revision':
                            ?>
                              <span class="label label-warning">En Revisión</span>
                            <?php
                            break;

                          case 'En Revision Video':
                            ?>
                              <span class="label label-warning">En Revisión Video</span>
                            <?php
                            break;
                        }
                      ?>
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
<!--subir vídeos-->
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/ajax/upload.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/config_tooltip.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Teachers/config_notify.js"></script>