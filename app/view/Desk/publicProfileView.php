<?= $headers; ?>
<?= $helper->PopUpBody(); ?>
<body>
	<!--Navigation-->
	<?= $menuFront; ?>
	<!--Front-->
  <?php
    if ($ArrDataUser!=0) {
      foreach ($ArrDataUser as $DataUser) {
      }
    }
    if ($ArrDataProfUser!=0) {
      foreach ($ArrDataProfUser as $DataProfessional) {
      }
    }
  ?>
  <!--Titulo de la sección-->
  <section id="sec-front" class="padding margin-top">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
           <!--Nombre y profesión-->
            <div class="text-front text-front-down">
                <h2>
                  <?php 
                    if ($ArrDataUser==0) {
                      echo "Este Usuario es Anonimo";
                    }else{
                      echo $DataUser[0];
                    }
                 ?>
                </h2>
                <p>
                  <?php
                    if ($ArrDataProfUser==0) {
                      echo "Este Usuario no tiene Profesión";
                    }else{
                      echo $DataProfessional[0];
                    }
                  ?>
                </p>
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
                  <img class="img_user_profile" src="<?= BASE_DIR; ?>/design/img/Perfil_Usuarios/defecto_user.jpg">
                <?php
              }else{
                ?>
                  <img class="img_user_profile" src="<?= BASE_DIR; ?>/design/img/Perfil_Usuarios/<?php echo $DataUser[5]; ?>">
                <?php
              }
            ?>
          </div>
          <div class="col-md-9">
            <h1>Biografía</h1>
            <p>
              <?php
                if ($ArrDataProfUser==0) {
                  echo "Este Usuario no ha Llenado su Biografía";
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
                if ($ArrSocialMedia==false) {
                  echo "<p>Este Usuario no ha Agregado Redes Sociales</p>";
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
    
  <!--Cursos que Aprende-->
  <hr>
  <section class="courses-grid">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <center>
            <div class="intermediate">
              <h1>Cursos que Aprende</h1>
            </div>
          </center>
          <?php
            if ($ArrDataCourse==false) {
              echo '<center>
                    <div class="intermediate margin-bottom padding-lestb">
                      <br><br><br>
                        <h2><i class="fa fa-smile-o" aria-hidden="true"></i> Este usuario no aprende ningún Curso</h2>
                    </div>
                  </center>' ;
            }else{
              foreach ($ArrDataCourse as $DataCourse) {
          ?>
          <div class="contenible-card ">
              <div class="card hoverable">
                  <div class="card-image hidden-xs">
                      <div class="view overlay hm-white-slight z-depth-1">
                          <img src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/<?php echo $DataCourse[2]; ?>" class="img-responsive" alt="">
                          <a href="<?= BASE_DIR; ?>/cursos/detalles/<?php echo $DataCourse[0]; ?>/<?= str_replace(" ","-",$DataCourse[1]); ?>&accept=yes">
                              <div class="mask waves-effect"></div>
                          </a>
                      </div>
                  </div>
                  <div class="card-image-res visible-xs">
                      <div class="view overlay hm-white-slight z-depth-1">
                          <img src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/<?php echo $DataCourse[2]; ?>" class="img-responsive" alt="">
                          <a href="<?= BASE_DIR; ?>/cursos/detalles/<?php echo $DataCourse[0]; ?>/<?= str_replace(" ","-",$DataCourse[1]); ?>&accept=yes">
                              <div class="mask waves-effect"></div>
                          </a>
                      </div>
                  </div>
                  <div class="card-content">
                      <span class=" span-card black-gray"><?php echo ucwords(substr($DataCourse[1],0,70)); ?>..</span>
                      <p>By: <?php echo $DataCourse[5]; ?></p>
                  </div>
                  <div class="card-btn text-left">
                    <?php 
                      if (utf8_encode($DataCourse[4])=="Gratis") 
                      {?>
                          <h2 class="h1-bold-second">Grátis</h2>
                      <?php
                        }else if($DataCourse[4] =="De Pago")
                      {?>
                        <h2 class="h1-bold-second">$ <?php echo $DataCourse[3]; ?> COP</h2>
                      <?php
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
  <!--Cursos que Enseña-->
  <hr>
  <section class="courses-grid">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <center>
            <div class="intermediate">
              <h1>Cursos que Enseña</h1>
            </div>
          </center>
          <?php
            if ($ArrDataTeachCourses==false) {
              echo '<center>
                    <div class="intermediate margin-bottom padding-lestb">
                      <br><br><br>
                        <h2><i class="fa fa-smile-o" aria-hidden="true"></i> Este usuario no enseña ningún Curso</h2>
                    </div>
                  </center>' ;
            }else{
              foreach ($ArrDataTeachCourses as $DataTeach) {
          ?>
          <div class="contenible-card ">
              <div class="card hoverable">
                  <div class="card-image hidden-xs">
                      <div class="view overlay hm-white-slight z-depth-1">
                          <img src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/<?php echo $DataTeach[2]; ?>" class="img-responsive" alt="">
                          <a href="<?= BASE_DIR; ?>/cursos/detalles/<?php echo $DataTeach[0]; ?>/<?= str_replace(" ","-",$DataTeach[1]); ?>&accept=yes">
                              <div class="mask waves-effect"></div>
                          </a>
                      </div>
                  </div>
                  <div class="card-image-res visible-xs">
                      <div class="view overlay hm-white-slight z-depth-1">
                          <img src="<?= BASE_DIR; ?>/design/img/Cursos_Usuarios/<?php echo $DataTeach[2]; ?>" class="img-responsive" alt="">
                          <a href="<?= BASE_DIR; ?>/cursos/detalles/<?php echo $DataTeach[0]; ?>/<?= str_replace(" ","-",$DataTeach[1]); ?>&accept=yes">
                              <div class="mask waves-effect"></div>
                          </a>
                      </div>
                  </div>
                  <div class="card-content">
                      <span class=" span-card black-gray"><?php echo ucwords(substr($DataTeach[1],0,70)); ?>..</span>
                  </div>
                  <div class="card-btn text-left">
                    <?php 
                      if (utf8_encode($DataTeach[4])=="Gratis") 
                      {?>
                          <h2 class="h1-bold-second">Grátis</h2>
                      <?php
                        }else if($DataTeach[4] =="De Pago")
                      {?>
                        <h2 class="h1-bold-second">$ <?php echo $DataTeach[5]; ?> COP</h2>
                      <?php
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