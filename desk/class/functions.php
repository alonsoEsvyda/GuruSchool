<?php
/****GuruSchool-library V:0.1
define('DB_HOST','localhost'); 
define('DB_USER','avmsoluc_admin'); 
define('DB_PASS','Yousolicit1200'); 
define('DB_NAME','avmsoluc_GuruSchool'); 
define('DB_CHARSET','utf-8');*******/
//local
/*define('DB_HOST','localhost'); 
define('DB_USER','root'); 
define('DB_PASS',''); 
define('DB_NAME','GuruSchool'); 
define('DB_CHARSET','utf-8');*/

//cabeceras para evitar clickjacking y, no permitir el enmarcado de mi sitio
header( 'X-Content-Type-Options: nosniff' );
header( 'X-Frame-Options: SAMEORIGIN' );
header( 'X-XSS-Protection: 1;mode=block' );

date_default_timezone_set('America/Bogota');
$conexion = new mysqli('localhost', 'root', '', 'GuruSchool')or die(mysqli_error());//Conexión A Base de datos


class GuruApi
{
	//Atributtes
	private $data;
	private $stringEncode;
	private $StringDecode;

	//Methods
    public function TestInput($input)//limpiar inputs
    {
    	$Array= array('<script>','</script>');
    	$this->data = trim($input);
	    $this->data = stripslashes($input);
	    $this->data = htmlspecialchars($input);
	    $this->data = strip_tags($input);
	    $this->data = addslashes($input);
	    $this->data = str_replace($Array, "_", $input);
	    return $this->data;
    }

    public function TestMail($direccion)//validar Correos
	{
	   $express='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
	   if(preg_match($express,$direccion))
	      return true;
	   else
	     return false;
	}

	public function GetIdYoutube($Url)//Validamos una Url de Youtube
	{
		if (preg_match('/(?:https?:\/\/|www\.|m\.|^)youtu(?:be\.com\/watch\?(?:.*?&(?:amp;)?)?v=|\.be\/)([\w‌​\-]+)(?:&(?:amp;)?[\w\?=]*)?/', $Url)) 
		{
			$Step1 = explode('v=', $Url);//dividimos la url que insertamos en 2 partes, la función no tiene en cuenta el delimitador que sería v=
			$Step2 = explode('&',$Step1[1]);//en caso de que la url tenga algún otro identificador que contenga ampersand
			$IdVideo = $Step2[0];//aquí guardamos el identificador

			return $IdVideo;
		}
		return false;
	}

	public function TestFacebook($Url)//Validamos Url de Facebook
	{
		if(!preg_match('/^(http\:\/\/|https\:\/\/)?((w{3}\.)?)facebook\.com\/(?:#!\/)?(?:pages\/)?(?:[\w\-\.]*\/)*([\w\-\.]*)+$/', $Url))
	    {
	        return false;
	    }
	    return true;
	}

	public function TestTwitter($Url)//Validamos Url de Twitter
	{
		if(!preg_match('/^(https?:\/\/)?((w{3}\.)?)twitter\.com\/(#!\/)?[a-z0-9_]+$/', $Url))
	    {
	        return false;   
	    }
	    return true;
	}

	public function TestUrl($Url)//Validamos una Url Común
	{
		if(!filter_var($Url, FILTER_VALIDATE_URL))
	    {
	        return false;   
	    }
	    return true;
	}

	public function TestPassword($val,$route)//validar seguridad de un password
	{
	 if(strlen($val) < 8)
	 {
		 header("Location:".$route."?request=El password es demasiado corto");
		 return false;
	 }
	 else if(!preg_match('/(?=\d)/', $val)) 
	 {
		 header("Location:".$route."?request=El pasword debe contener al menos un digito");
		 return false;
	 }
	 else if(!preg_match('/(?=[a-z])/', $val)) 
	 {
		 header("Location:".$route."?request=El pasword debe contener al menos una minuscula");
		 return false;
	 }
	 else if(!preg_match('/(?=[A-Z])/', $val)) 
	 {
		 header("Location:".$route."?request=El pasword debe contener al menos una mayuscula");
		 return false;
	 }
	 	return true;
	}

    public function StringEncode($ses)//Encriptar cadena de caracteres
    {     
      $this->stringEncode=$ses;
	  $sesencoded = $this->stringEncode;  
	  $num = mt_rand(4,4);  

	  for($i=1;$i<=$num;$i++)
	  {  
	     $sesencoded = base64_encode($sesencoded);  
	  }  
	  $alpha_array =  
	  array('Y','D','U','R','P',  
	  'S','B','M','A','T','H');  
	  $sesencoded =  
	  $sesencoded."+".$alpha_array[$num];  
	  $sesencoded = base64_encode($sesencoded);  
	  return $sesencoded;  
	}

	public function StringDecode($str)//Des-Encriptar cadena de caracteres
	{  
	   $this->StringDecode=$str;
	   $alpha_array =  
	   array('Y','D','U','R','P',  
	   'S','B','M','A','T','H');  
	   $decoded = base64_decode($this->StringDecode);  
	   list($decoded,$letter) = split("\+",$decoded);  

	   for($i=0;$i<count($alpha_array);$i++)
	   {  
		   if($alpha_array[$i] == $letter)  
		   break;  
	   }  

	   for($j=1;$j<=$i;$j++)
	   {  
	      $decoded = base64_decode($decoded);  
	   }  
	   return $decoded;  
	}

	public function HashPassword($password)//Función Para encriptar contraseñas....
	{
	    $opciones = [
	    'cost' => 11,
	    ];
	    return password_hash($password, PASSWORD_BCRYPT, $opciones);
	}

	
	public function generateFormToken($form) //Función para crear token
	{
	   // generar token de forma aleatoria
	   $token = md5(uniqid(microtime(), true));
	   // generar fecha de generación del token
	   $token_time = time();
	   // escribir la información del token en sesión para poder
	   // comprobar su validez cuando se reciba un token desde un formulario
	   $_SESSION['csrf'][$form.'_token'] = array('token'=>$token, 'time'=>$token_time);; 
	   return $token;
	}


	public function verifyFormToken($form, $token, $delta_time=0)//función para valira tokens
	{
	   // comprueba si hay un token registrado en sesión para el formulario
	   if(!isset($_SESSION['csrf'][$form.'_token']))
	   {
	       return false;
	   }
	   // compara el token recibido con el registrado en sesión
	   if ($_SESSION['csrf'][$form.'_token']['token'] !== $token) 
	   {
	       return false;
	   }
	   // si se indica un tiempo máximo de validez del ticket se compara la
	   // fecha actual con la de generación del ticket
	   if($delta_time > 0)
	   {
	       $token_age = time() - $_SESSION['csrf'][$form.'_token']['time'];
	       if($token_age >= $delta_time)
	       {
	          return false;
	       }
	   }
	   return true;
	}

	public function getRealIP() 
	{
		if (!empty($_SERVER["HTTP_CLIENT_IP"]))
		{
			return $_SERVER["HTTP_CLIENT_IP"];
		}
		if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
		{
			return $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		return $_SERVER["REMOTE_ADDR"];

	}

	public function resizeImagen($ruta, $nombre, $alto, $ancho,$nombreN,$extension){
	    $rutaImagenOriginal = $ruta.$nombre;
	   
	    if($extension == 'GIF' || $extension == 'gif'){
	        $img_original = imagecreatefromgif($rutaImagenOriginal);
	    }
	    
	    if($extension == 'jpg' || $extension == 'JPG'){
	        $img_original = imagecreatefromjpeg($rutaImagenOriginal);
	    }
	    
	    if($extension == 'png' || $extension == 'PNG'){
	        $img_original = imagecreatefrompng($rutaImagenOriginal);
	    }
	    
	    $max_ancho = $ancho;
	    $max_alto = $alto;
	    
	    list($ancho,$alto)=getimagesize($rutaImagenOriginal);
	    
	    $x_ratio = $max_ancho / $ancho;
	    $y_ratio = $max_alto / $alto;
	    
	    if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){//Si ancho 
	  	    $ancho_final = $ancho;
			$alto_final = $alto;
		} elseif (($x_ratio * $alto) < $max_alto){
			$alto_final = ceil($x_ratio * $alto);
			$ancho_final = $max_ancho;
		} else{
			$ancho_final = ceil($y_ratio * $ancho);
			$alto_final = $max_alto;
		}

	    $tmp=imagecreatetruecolor($ancho_final,$alto_final);
	    imagecopyresampled($tmp,$img_original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
	    imagedestroy($img_original);
	    $calidad=70;
	    imagejpeg($tmp,$ruta.$nombreN,$calidad);
	}

	public function SizeFile($File)//Calculamos el tamaño de un archivo
	{
        $Max = 30000000;
        if($File > $Max){
          return false;
        } 
        return true;
  	}
  	public function Percentage($cantidad,$porciento){//función para calcular el porcentaje
  		return $cantidad*$porciento/100;
	}
}
?>