<?php
include('session_parameters.php');
require_once __DIR__ . '/../library/api-facebook/src/Facebook/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '981554355256359',
  'app_secret' => '2d2e0414e108688b045fd8f44f6e3ffb',
  'default_graph_version' => 'v2.4',
  ]);
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // optional
	
try {
	if (isset($_SESSION['facebook_access_token'])) {
		$accessToken = $_SESSION['facebook_access_token'];
	} else {
  		$accessToken = $helper->getAccessToken();
	}
} catch(Facebook\Exceptions\FacebookResponseException $e) {
 	// Cuando el Gráfico devuelve un error
 	echo 'Graph returned an error: ' . $e->getMessage();
  	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
 	//Cuando la falla es validación u otros problemas locales
	echo 'Facebook SDK returned an error1: ' . $e->getMessage();
  	exit;
 }


if (isset($accessToken)) {
	if (isset($_SESSION['facebook_access_token'])) {
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	} else {
		// conseguir token de acceso de corta duración
		$_SESSION['facebook_access_token'] = (string) $accessToken;
	  	// OAuth 2.0 controlador de cliente
		$oAuth2Client = $fb->getOAuth2Client();
		// Intercambiamos un token de acceso de corta duración para una larga vida
		$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
		$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
		// establecemos un token de acceso por defecto que se utilizará en la escritura
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}
	// redirigir al usuario a la misma página si tiene la variable " código"

	if (isset($_GET['code'])) {
		header("Location:../../iniciar-sesion.php");
	}
	// Obtener Información del usuario
	try {
		$profile_request = $fb->get('/me?fields=name,first_name,last_name,email');
		$profile = $profile_request->getGraphNode()->asArray();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// Cuando el Gráfico devuelve un error
		echo 'Graph returned an error: ' . $e->getMessage();
		session_destroy();
		// Redireccionamos al usuario a la pagina de incio
		header("Location:../../iniciar-sesion.php");
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// Cuando la falla es validación u otros problemas locales
		echo 'Facebook SDK returned an error2: ' . $e->getMessage();
		exit;
	}
	
	// Imprimimos en un array la información básica del usuario
	$_SESSION['Data_Facebook']=array('email'=>$profile['email']);
	header("Location:validate-facebook.php");
  	// Ahora se puede dirigir a otra pagina utilizando el token de acceso de  $_SESSION['facebook_access_token']
} else {
	header("Location:../../iniciar-sesion.php");
}
?>