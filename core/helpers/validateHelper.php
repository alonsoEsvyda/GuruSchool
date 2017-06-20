<?php

	function ValidateSession($session,$ip,$nav,$host,$IpReal,$route){//Función para validar las sesiones{
		if (isset($session)) {
			if ($nav != $_SERVER['HTTP_USER_AGENT'] or 
				$ip != $IpReal or 
				$host != gethostbyaddr($IpReal)) 
			{
			   session_destroy();//destruimos la sesión
			   $parametros_cookies = session_get_cookie_params();// traemos lo que contenga la cookie
			   setcookie(session_name(),0,1,$parametros_cookies["path"]);// destruimos la cookie
			   session_start();
			   session_regenerate_id(true);
			   header("Location:$route");
			}else{
				return true;
			}
		}else{
			header("Location:$route");
		}
	}
	function SessionTime($Session,$route){//validamos el estado de vida, de la sesión
		if (isset($Session)) {
		    $InicioSesion=$Session;
		    $TiempoActual = date("Y-n-j H:i:s"); 
		    $TiempoTotal=(strtotime($TiempoActual)-strtotime($InicioSesion)); 
		    if ($TiempoTotal>=1500) {
		      header("Location:$route");
		    }else{
		    	return true;
		    }
		}
	}

?>