<?= $headers; ?>
<?= $helper->PopUpBody(); ?>
<body>
	<!--Navigation-->
	<?= $menuFront; ?>
	<!--Front-->
  <?php
    if ($ArrDataUser!=0) {
        foreach ($ArrDataUser as $DataUser){
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
                    echo "No haz llenado tu Nombre";
                  }else{
                      echo $DataUser[0];
                    }
                 ?>
                </h2>
                <p>
                  <?php
                    if ($ArrDataProfUser==0) {
                      echo "No Haz Puesto Profesión";
                    }else{
                      echo $DataProfessional[0];
                    }
                  ?>
                </p>
                <a href="<?= BASE_DIR; ?>/desk/perfil_publico/<?php echo $ArrEmailData; ?>"><button type="button" class="btn btn-default">Ver Perfil Público</button></a>
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
                  echo "No haz llenado tu biografía, Llenala <a href='".BASE_DIR."/usuarios/mis_datos/'> Aquí</a>";
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
              if ($ArrSocialMedia==0) {
                echo "<p>No haz agregado Redes sociales, Agrega tus Redes <a href='".BASE_DIR."/usuarios/mis_datos/'>Aquí</a></p>";
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
</body>
<!-- /Content -->
<?= $footer; ?>
<?= $resource_script; ?>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Home/hostname.js"></script>