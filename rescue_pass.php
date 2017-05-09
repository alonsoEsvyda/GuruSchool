<?php
	include ("desk/class/functions.php");
	//Llamamos la clase GuruApi
	$GuruApi = new GuruApi();
    if (!isset($_GET['token_password'])) {
        header("Location:iniciar-sesion?request=No Existe el Token de Seguridad.");
    }else{
        $Token=$GuruApi->TestInput($_GET['token_password']);
        //verificamos si el token existe
        $SqlGetValidate=$conexion->prepare("SELECT Vc_Correo FROM G_Usuario WHERE Vc_Rescue_Token = ?");
        $SqlGetValidate->bind_param("s",$Token);
        $SqlGetValidate->execute();
        $SqlGetValidate->store_result();
            if ($SqlGetValidate->num_rows==0) {
                header("Location:iniciar-sesion?request=Token Invalido");
            }else{
                $SqlGetValidate->bind_result($StrEmail);
                $SqlGetValidate->fetch();
            }
    }
?>
<!DOCTYPE html>
<html>
<head>
   <?php 
    include ("includes-front/head.php");
   ?>
</head>
<body>
	<!--Navigation-->
    <?php include("includes-front/menu.php"); ?>   
    <div style="margin-top:150px;" class="intermediate">
    	<center>
    		<h1>Cambia tu Contraseña</h1>
    		<div class="container">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <form id="FrmPass">
                            <div class="request margin-lest-top margin-lestc-bottom"></div>
                            <input type="hidden" name="Key" class="key" value="<?php echo $GuruApi->StringEncode($StrEmail); ?>" required/>
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
    <!--Scripts-->
   	<?php include ("includes-front/scripts.html"); ?>
    <script type="text/javascript">
      function RescuePass(){
        var frm= $("#FrmPass").serialize();
        $.ajax({
            type: "POST",
            url: "desk/case_user/change_rescue_pass.php",
            data:frm
        }).done (function(info){
            if (info==true) {
                window.location="iniciar-sesion?requestok=Cambio de Contraseña Correcto, Inicie Sesión.";
            }else if(info==false){
                $('.request').html("<span style='color:rgba(192, 57, 43,1.0);'>Error, Escriba una Contraseña correcta, verifique que las contraseñas coincidan.</span>");
                $('.Btn-Rescue').removeAttr("disabled");
            }
        });
      }
      $(document).ready(function(){
        $('.Btn-Rescue').on('click', function(e){
          if ($('.new-pass').val()=="" || $('.repeat-pass').val()=="" || $('.key').val()=="") {
            $('.request').html("<span style='color:rgba(192, 57, 43,1.0);'>Llene los Campos correspondientes.</span>");
            $('.new-pass').css("border-bottom","2px solid red");
            $('.repeat-pass').css("border-bottom","2px solid red");
          }else{
            e.preventDefault();
            $(".Btn-Rescue").attr('disabled', 'disabled');
            RescuePass();
          }
        });
      });
    </script>
</body>
</html>