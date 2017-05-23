<?php
    class sessionController extends BaseController{
        private $conectar;
    	private $adapter;
        private $session;
        private $api_rest;
    	
        public function __construct() {
            parent::__construct();
            $this->conectar=new Connect();
            //conexion
            $this->adapter=$this->conectar->con();
            //load Uri Helper
            $this->helper("uri");
            //load Uri Helper
            $this->helper("test");
            //load Uri Helper
            $this->helper("crypt");
            //load rest
            $this->api_rest = new Rest();
            //load the model Session
            $this->session = $this->model("Session",$this->adapter);
        }
        
        public function validate_session_facebook(){
            if ($this->api_rest->API() == "POST") {
                //Traemos la Ip Real del Usuario
                $Ip=getRealIP();
                //DEFINO VARIABLES
                $StrMail = TestInput($_POST['email']);
                $IntToken = TestInput($_POST['token_id']);
                $Nivel=1;

                $valid_facebook = $this->session->validate_facebook($StrMail,$IntToken,$Nivel);
                if ($valid_facebook) {
                    //recorremos los datos
                    foreach ($valid_facebook as $value) {
                        //validamos el token
                        if ($value[4] == $IntToken) {
                            //verificamos si este usuario ya tiene contraseña
                            if ($value[2]!= "" || $value[2] != NULL) {
                                echo "HavePass";
                               // header("Location:../../iniciar-sesion.php?request=Inicie con la contraseña de su usuario");
                            }else{
                                //validamos el nivel de acceso
                                if ($value[3]==1) {
                                    //Creamos la sesión
                                    $_SESSION['Data']=array('Id_Usuario' => $value[0], 'Ipuser' => $Ip, 'navUser' => $_SERVER["HTTP_USER_AGENT"], 'hostUser' => gethostbyaddr($Ip),'Tiempo'=>time());
                                    // header("Location:../user.php?request=lo lograste");
                                    echo true;
                                }else if ($value[3]==0) {
                                    echo false;
                                }
                            }    
                        }else{
                            echo false;
                        }
                    }
                }else{
                    $insert_facebook = $this->session->insert_data_facebook($StrMail,$Nivel,$IntToken);
                    if ($insert_facebook) {
                        //traemos el ultimo id insertado en la tabla
                        $value_user = $this->session->getMaxId("Id_Pk_Usuario");
                        foreach ($value_user as $value) {
                         $_SESSION['Data']=array('Id_Usuario' => $value[0], 'Ipuser' => $Ip, 'navUser' => $_SERVER["HTTP_USER_AGENT"], 'hostUser' => gethostbyaddr($Ip) );
                        }
                        echo true;
                        // header("Location:../user.php");
                    }else{
                        echo "NoInsert";
                        // header("Location:../../index.php?request=error usuario");
                    }
                }
            }else{
                echo false;
            }
        }

        public function register_user(){
            if ($this->api_rest->API() == "POST") {
                if ($_POST['email']=="" || $_POST['password']=="" ) {
                    header("Location:".BASE_DIR."/home/&request=Inserta datos validos.");
                }else{
                    $StrMail = TestInput($_POST['email']);
                    $StrPass = TestInput($_POST['password']);

                    //seteamos el contenido de las variables que nos pasan por POST
                    if (is_string($StrMail) && is_string($StrPass)) {
                        //validamos que la contraseña sea correcta
                        if (TestPassword($StrPass,BASE_DIR."/home")) {
                            //validamos que halla llegado un correo valido
                            if (TestMail($StrMail)) {
                                $validate_email = $this->session->email_validate($StrMail);
                                if ($validate_email) {
                                    $EncodePass = HashPassword($StrPass);
                                    $nivel = 1;
                                    $insert = $this->session->insert_user($StrMail,$EncodePass,$nivel);
                                    if ($insert) {
                                        header("Location:".BASE_DIR."/home/iniciar_session/&requestok=Inicia Sesión&email=".$StrMail);
                                     }else{
                                        header("Location:".BASE_DIR."/home/&request=error");
                                     } 
                                }else{
                                    header("Location:".BASE_DIR."/home/iniciar_session/&request=Correo Existe, inicie sesión&email=".$StrMail);
                                }   
                            }else{
                                header("Location:".BASE_DIR."/home/&request=Inserta un Correo Valido");
                            }
                        }
                    }else{
                        header("Location:".BASE_DIR."/home/&request=Inserta datos validos.");
                    }
                    
                }
            }
        }

        public function load_session(){
            if ($this->api_rest->API() == "POST") {
                $token=$_POST['auth_token'];
                $NameSession="";
                if (isset($_POST['button-lg'])) {//validamos que se presionó el botón de la versión escritorio
                    $NameSession="send_message";
                }else if(isset($_POST['button-res'])){//validamos que se presionó el botón de la versión móvil
                    $NameSession="send_message2";
                }
                $ValidToken= verifyFormToken($NameSession, $token, 300);
                if (!$ValidToken) {
                   session_destroy();//destruimos la sesión
                   $parametros_cookies = session_get_cookie_params();// traemos lo que contenga la cookie
                   setcookie(session_name(),0,1,$parametros_cookies["path"],null, null, true);// destruimos la cookie
                   session_start();
                   session_regenerate_id(true);
                   header("Location:".BASE_DIR."/home/iniciar_session/&request=Tu token no es valido. Intenta de nuevo.&email=".$_POST['email']);
                   exit();
                }else{
                    if ($_POST['email']==" " || $_POST['password']==" " ) {
                        header("Location:".BASE_DIR."/home/iniciar_session/?request=inserta texto");
                    }else{
                        $StrMail = TestInput($_POST['email']);
                        $StrPass = TestInput($_POST['password']);

                        if (is_string($StrMail) && is_string($StrPass)) {
                            if (TestMail($StrMail)) {
                                $user = $this->session->user_session($StrMail);
                                if ($user == false) {//validamos si la consulta no trajo ningún registro
                                    header("Location:../../iniciar-sesion?request=Usuario Invalido");
                                }else{
                                    foreach ($user as $session) {
                                        if (password_verify($StrPass,$session[2])) {
                                            if ($session[3]==1) {
                                                //Traemos la Ip Real del Usuario
                                                $Ip=getRealIP();
                                                //Creamos la sesión
                                                $_SESSION['Data']=array('Id_Usuario' => $session[0], 'Ipuser' => $Ip, 'navUser' => $_SERVER["HTTP_USER_AGENT"], 'hostUser' => gethostbyaddr($Ip), 'Tiempo'=>date("Y-n-j H:i:s"));

                                                //por modificarse
                                                header("Location:".BASE_DIR."/home/iniciar_session/&requestok=Felicidades, iniciaste sesion");
                                            }else if ($session[3]==0) {
                                                header("Location:".BASE_DIR."/home/&request=Error");  
                                            }
                                        }else{
                                            header("Location:".BASE_DIR."/home/iniciar_session&request=Contraseña no coincide&email=".$StrMail);
                                        }
                                    }
                                }
                            }else{
                                header("Location:".BASE_DIR."/home/iniciar_session/&request=Inserta un Correo Valido");
                            }
                        }else{
                            header("Location:".BASE_DIR."/home/iniciar_session/&request=Inserta texto valido");
                        }
                    }
                }
            }
        }
    }
?>
