<?= $headers; ?>
<?= $helper->PopUpBody(); ?>
<?= $menuFront; ?>
<?php
    foreach ($email as $data) {
        $StrEmail = $data[0];
    }
?>
<body>
    <div style="margin-top:150px;" class="intermediate">
        <center>
            <h1>Cambia tu Contraseña</h1>
            <div class="container">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <form id="FrmPass">
                            <div class="request margin-lest-top margin-lestc-bottom"></div>
                            <input type="hidden" name="Key" class="key" value="<?= $helper->StringEncode($StrEmail); ?>" required/>
                            <input type="password" data-toggle="tooltip" data-placement="top" title="El password debe ser Mayor a 8 digitos, tener 1 letra Mayúscula minimo, 1 dígito y 1 letra Minúscula minimo." autofocus="autofocus" class="new-pass" placeholder="Escibre tu nueva Contraseña" name="NewPass" required/>
                            <input type="password" placeholder="Repite tu Contraseña" class="repeat-pass" name="RepeatPass" required/>
                            <input type="submit" style="width:100%;" name="button-res" class="Btn-Rescue btn btn-default" value="Cambiar Contraseña">
                        </form>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
        </center>
        <hr style="width:50%; margin-top:100px;">
    </div>
</body>
<?= $footer; ?>
<?= $resource_script; ?>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Home/hostname.js"></script>
<script type="text/javascript" src="<?= BASE_DIR; ?>/design/js/local_apps/Home/rescue_pass/change_rescue_pass.js"></script>