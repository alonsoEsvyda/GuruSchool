<?php
  include('session/session_parameters.php');
	include ("class/functions.php");
  include ("class/function_data.php");
  
  //traemos los datos con REQUEST
  if (isset($_REQUEST['signature'])) {
      $ApiKey = "rpfLb9n4HOXWxn0Z7RHGs1bt6v";
      $merchant_id = $_REQUEST['merchantId'];
      $referenceCode = $_REQUEST['referenceCode'];
      $TX_VALUE = $_REQUEST['TX_VALUE'];
      $New_value = number_format($TX_VALUE, 1, '.', '');
      $currency = $_REQUEST['currency'];
      $transactionState = $_REQUEST['transactionState'];
      $firma_cadena = "$ApiKey~$merchant_id~$referenceCode~$New_value~$currency~$transactionState";
      $firmacreada = md5($firma_cadena);
      $firma = $_REQUEST['signature'];
      $reference_pol = $_REQUEST['reference_pol'];
      $cus = $_REQUEST['cus'];
      $extra1 = $_REQUEST['description'];
      $pseBank = $_REQUEST['pseBank'];
      $lapPaymentMethod = $_REQUEST['lapPaymentMethod'];
      $transactionId = $_REQUEST['transactionId'];
    if (strtoupper($firma) != strtoupper($firmacreada)) {
      header("Location:user?request=Firma No Valida");
    }
  }else{
    header("Location:user");
  }

  //Llamamos la clase GuruApi
  $GuruApi = new GuruApi();
  //llamamos a  la clase ValidateData
  $ValidateData=new ValidateData();
  //Validamos el tiempo de vida de la sesión
  $TimeSession=$ValidateData->SessionTime($_SESSION['Data']['Tiempo'],"session/logout.php");
  //Asignamos el tiempo actual a la variable de sesión
  $_SESSION['Data']['Tiempo']=date("Y-n-j H:i:s");
  //traemos la ip real del usuario
  $GetRealIp = $GuruApi->getRealIP();
  //validamos que exista la sesión y las credenciales sean correctas
  $ValidateSession = $ValidateData->ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,"../iniciar-sesion.php?request=iniciar sesion");
?>
<!DOCTYPE html>
<html>
<head>
	<!--head-->
	<?php
     $baseUrl = dirname($_SERVER['PHP_SELF']).'/';
  ?>
  <base href="<?php echo $baseUrl; ?>" >
  <?php include ("../includes-front/head.php"); ?>
</head>
<body>
	<!--Menú-->
	<?php 
    include ("includes/menu-dev.php"); 
    include("includes/pop_up-dev.php");
  ?>
  <section class="container" style="width:100%;height:800px; background-image:url('../css/imagenes/request.png'); background-size: 100% 100%; no-repeat center center fixed; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="content-inside intermediate padding">
            <center>
              <h1 style="color:#33b5e5;">Muchas gracias por su Compra, su pago está en proceso, una vez se nos notifique, se activará su Curso.</h1>
              <a href="../Cursos?accept=yes" class="btn btn-default margin-lest-top">Buscar Más Cursos</a>
            </center>
            <!-- Modal Pop Up -->
            <div class="modal fade" id="myModalmsg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="intermediate modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h2 class="modal-title" id="myModalLabel">Estado de la Transacción.</h2>
                        </div>
                        <div id="ModalReq" class="intermediate modal-body">
                        <h4>Estado Transacción:
                        <?php
                          if ($_REQUEST['transactionState'] == 4 ) {
                            $estadoTx = "Transacción aprobada";
                          }
                          else if ($_REQUEST['transactionState'] == 6 ) {
                            $estadoTx = "Transacción rechazada";
                          }
                          else if ($_REQUEST['transactionState'] == 104 ) {
                            $estadoTx = "Error";
                          }
                          else if ($_REQUEST['transactionState'] == 7 ) {
                            $estadoTx = "Transacción pendiente";
                          }
                          else {
                            $estadoTx=$_REQUEST['message'];
                          }
                          echo $estadoTx;
                        ?>
                        </h4><br>
                        <h4>Referencia de la Venta: <?php echo $reference_pol; ?></h4><br>
                        <h4>Valor: $<?php echo number_format($TX_VALUE); ?> COP</h4><br>
                        <h4>Descripción: <?php echo ($extra1); ?></h4><br>
                        <h4>Entidad: <?php echo ($lapPaymentMethod); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
	<!--Footer-->
    <?php include ("../includes-front/footer.php"); ?>
    <!--Scripts-->
    <?php include ("includes/scripts-dev.html"); ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#myModalmsg').modal();
        });
    </script>
</body>
</html>