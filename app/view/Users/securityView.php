<?= $headers; ?>
<?= $helper->PopUpBody(); ?>
<body>
	<!--Navigation-->
	<?= $menuFront; ?>
	<!--Front-->
  <!--Titulo de la sección-->
  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="padding margin-top intermediate">
            <h1>Cambia tu Contraseña</h1>
                  <hr>
                  <form action="<?= BASE_DIR; ?>/usuarios/changePassword/" method="POST">
                    <div class="form-group">
                    <div class="col-md-6 col-md-offset-3 margin-top">
                        <input type="password" name="ActualPass" placeholder="* Password Actual" required/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <input type="password" name="NewPass" placeholder="* Nuevo Password, Ej:Ramonvaldez50" data-toggle="tooltip" data-placement="top" title="El password debe ser Mayor a 8 digitos, tener 1 letra Mayúscula minimo, 1 dígito y 1 letra Minúscula minimo." required/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <input type="password" name="RepeatPass" placeholder="* Repite el Password" required/>
                    </div>
                </div>
                <div class="form-group">
                  <div class="col-md-6 col-md-offset-3 margin-lesta-top margin-bottom">
                    <center>
                      <button type="submit" class="btn btn-default">Guardar</button>
                    </center>
                  </div>
                </div>
                  </form>
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
