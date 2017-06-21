<?= $headers; ?>
<?= $helper->PopUpBody(); ?>
<style type="text/css">
  p{
    margin:0 !important;
  }
</style>
<body>
	<!--Navigation-->
	<?= $menuFront; ?>
	<!--Front-->
  <!--Titulo dela Sección-->
  <section id="sec-front" class="padding margin-top">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-front text-front-down">
                <center>
                  <h2>Empleos Postulados</h2>
                  <p>Aquí tienes una lista de los empleos que Publicaste en La Bolsa</p>
                  <a href="<?= BASE_DIR; ?>/la_bolsa/publicar_vacante/"><button type="button" class="waves-effect waves-light wow pulse animated btn btn-default">Publica una Vacante</button></a>
                </center>
            </div>
          </div>            
        </div>
      </div>
  </section>
  <!--Cursos Que Enseño-->
  <section class="jobs-grid">
    <div class="container">
      <div class="row">
        <div class="col-md-12 intermediate">
          <?php
            if ($GetVacancyUser==false) {
              echo '<center>
                    <div class="intermediate margin-bottom padding-lestc">
                      <br><br><br>
                        <h2><i class="fa fa-suitcase" aria-hidden="true"></i> Usted no Tiene ningúna Vacante Publicada. <a href="vacancy-published">Publique Aquí.</a></h2>
                    </div>
                  </center>' ;
            }else{
              foreach ($GetVacancyUser as $vacancy) {
                ?>
                  <div class="container-list-job">
                    <div class="company-job">
                      <a class="delete-vacancy" data-vacancy="<?php echo $helper->StringEncode($vacancy[0]); ?>" onclick="Delete(this)"><h3>X</h3></a>
                      <h2><?php echo $vacancy[1]; ?></h2>
                    </div>
                    <div class="description-job">
                      <hr style="margin:0;">
                      <p><?php echo strip_tags(substr($vacancy[5],0,130))." [...]"; ?></p>
                    </div>
                    <div class="add-job">
                      <h4><?php echo $vacancy[4]." - ".$vacancy[2]."/".$vacancy[3]." (".$vacancy[6].")";?></h4>
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
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Bag/jquery/delete_job.js"></script>