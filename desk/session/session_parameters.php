<?php
/*
Parámetros
lifetime
	Tiempo de vida de la cookie de sesión, definido en segundos.
path
	Ruta en el dominio donde la cookie trabajará. Use una barras simple ('/') para todas las rutas en el dominio.
domain
	Dominio de la cookie, por ejemplo 'www.php.net'. Para hacer las cookies visibles en todos los sub-dominios, el dominio debe ser prefijado con un punto, como '.php.net'.
secure
	Si es TRUE la cookie sólo será enviada sobre conexiones seguras.
httponly
	Si es TRUE PHP intentará enviar la bandera httponly cuando se establezca la cookie de sesión.
*/
$sess_name = session_name();
  if (session_start()) {
    setcookie($sess_name, session_id(), null, '/', null, null, true);
  }
?>