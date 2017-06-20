<?= $headers; ?>
<?= $helper->PopUpBody(); ?>
<body>
	<!--Navigation-->
	<?= $menuFront; ?>
	<!--Front-->
  <!--Nombre-->
  <section id="sec-front" class="padding margin-top">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
           <!--Nombre y profesión-->
            <div class="text-front text-front-down">
                <h2>
                  <?php echo $Data[0]; ?>
                </h2>
                <p>
                  <?php echo $Data[1]; ?>
                </p>
            </div>
          </div>            
        </div>
      </div>
  </section>
  <!--Biografía-->
  <section class="grid-left-profile">
      <div class="container">
        <div class="row">
        <!--Imagen de perfil-->
          <div class="intermediate col-md-3">
            <img class="img_user_profile" src="<?= BASE_DIR; ?>/design/img/Perfil_Usuarios/<?php echo $Data[11]; ?>">
            <hr style="margin: 8px;">
            <center>
              <h4 style="font-size:20px; font-weight:600;color:rgba(52, 152, 219,1.0);"><?php echo $Data[10]; ?></h4>
            </center>
          </div>
          <div class="col-md-9">
            <div style="margin-bottom: 10px;" class="intermediate">
              <h3>Pais: <?php echo $Data[2]; ?> - Ciudad: <?php echo $Data[3]; ?> (<?php echo $Data[12]; ?>)</h3>
              <hr>
              <h3><?php echo $Data[4]; ?> - <?php echo $Data[5]; ?></h3>
              <hr>
              <h4>Salario: $<?php echo $Data[6]; ?> - Vacantes: <?php echo $Data[7]; ?> - <label class="label label-warning">Enviar CV: <?php echo $Data[8]; ?></label></h4>
              <hr>
              <h3>Descripción:</h3>
            </div>
            <p><?php echo $Data[9]; ?></p>
          </div>
        </div>
      </div>
  </section>
</body>
<!-- /Content -->
<?= $footer; ?>
<?= $resource_script; ?>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Home/hostname.js"></script>