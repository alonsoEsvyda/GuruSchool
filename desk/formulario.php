<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form action="case_courses/pay_confirmation.php" method="POST">
	<input type="text" placeholder="state pol" name="state_pol">
	<input type="text" placeholder="code pol" name="response_code_pol">
	<input type="text" placeholder="mesage pol" name="response_message_pol">
	<input type="text" placeholder="method type" name="payment_method_type">
	<input type="text" placeholder="date transaccion" name="transaction_date">
	<input type="text" placeholder="reference pol" name="reference_pol">
	<input type="text" placeholder="reference sale" name="reference_sale">
	<input type="text" placeholder="merchant id" name="merchant_id">
	<input type="text" placeholder="value" name="value">
	<input type="text" placeholder="currency" name="currency">
	<input type="text" placeholder="sing" name="sign">
	<input type="submit" value="enviar">
</form>
<?
function porcentaje($cantidad,$porciento){
	return $cantidad*$porciento/100;
}

$porciento =  porcentaje(15000,30);

echo "el 30 por ciento de 15000 es ".$porciento." con dos decimales<br>";

echo $porciento;
?>
</body>
</html>