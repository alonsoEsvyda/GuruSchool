<?php
	include('session_parameters.php');

	session_destroy();//destruimos la sesión
	$parametros_cookies = session_get_cookie_params();// traemos lo que contenga la cookie
	setcookie(session_name(),0,1,$parametros_cookies["path"],null, null, true);// destruimos la cookie
	session_start();
	session_regenerate_id(true);
	header("Location:../../iniciar-sesion");
?>