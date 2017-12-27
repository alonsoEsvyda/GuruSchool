<?php
    class sessionController extends BaseController{
        private $conectar;
    	private $adapter;
        private $session;
        private $api_rest;
        private $mail;
    	
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
            //load PhpMailer
            $this->mail = new PHPMailer(true);
            //load the model Session
            $this->session = $this->model("Session",$this->adapter,'G_Usuario');
        }
        
        public function validate_session_facebook(){
            if ($_POST) {
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
                                    session_write_close();
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
                    if (TestMail($StrMail)) {
                        $insert_facebook = $this->session->insert_data_facebook($StrMail,$Nivel,$IntToken);
                        if ($insert_facebook) {
                            //traemos el ultimo id insertado en la tabla
                            $value_user = $this->session->getMaxId("Id_Pk_Usuario");
                            foreach ($value_user as $value) {
                             $_SESSION['Data']=array('Id_Usuario' => $value[0], 'Ipuser' => $Ip, 'navUser' => $_SERVER["HTTP_USER_AGENT"], 'hostUser' => gethostbyaddr($Ip));
                            }
                            session_write_close();
                            echo true;
                            // header("Location:../user.php");
                        }else{
                            echo false;
                            // header("Location:../../index.php?request=error usuario");
                        }
                    }else{
                        echo false;
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
                                $validate_email = $this->session->email_validate_false($StrMail);
                                if ($validate_email) {
                                    $EncodePass = HashPassword($StrPass);
                                    $nivel = 1;
                                    $insert = $this->session->insert_user($StrMail,$EncodePass,$nivel);
                                    if ($insert) {
                                        header("Location:".BASE_DIR."/home/iniciar_session/&requestok=Inicia Sesión&email=".$StrMail);
                                     }else{
                                        header("Location:".BASE_DIR."/home&request=error");
                                     } 
                                }else{
                                    header("Location:".BASE_DIR."/home/iniciar_session/&request=Correo Existe, inicie sesión&email=".$StrMail);
                                }   
                            }else{
                                header("Location:".BASE_DIR."/home&request=Inserta un Correo Valido");
                            }
                        }
                    }else{
                        header("Location:".BASE_DIR."/home&request=Inserta datos validos.");
                    }
                    
                }
            }else{
                header("Location:".BASE_DIR."/home&request=Error");
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
                                    header("Location:".BASE_DIR."/home/iniciar_session&request=Usuario Invalido");
                                }else{
                                    foreach ($user as $session) {
                                        if (password_verify($StrPass,$session[2])) {
                                            if ($session[3]==1) {
                                                //Traemos la Ip Real del Usuario
                                                $Ip=getRealIP();
                                                //Creamos la sesión
                                                $_SESSION['Data']=array('Id_Usuario' => $session[0], 'Ipuser' => $Ip, 'navUser' => $_SERVER["HTTP_USER_AGENT"], 'hostUser' => gethostbyaddr($Ip), 'Tiempo'=>date("Y-n-j H:i:s"));
                                                session_write_close();
                                                //por modificarse
                                                header("Location:".BASE_DIR."/desk/dashboard/");
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
            }else{
                header("Location:".BASE_DIR."/home/iniciar_session/&request=Error");
            }
        }

        public function rescue_pass(){
            if (isset($_POST['Email'])) {
                //definimos las variables
                $StrToken = md5(uniqid(microtime(), true));
                $StrEmail = TestInput($_POST['Email']);
                    //seteamos las variables yverificamos que sean del tipo string
                    if (is_string($StrEmail)) {
                        //Validmos que sea un Correo Valido
                        if (TestMail($StrEmail)) {
                            $validate_email = $this->session->email_validate_true($StrEmail);
                                if ($validate_email) {
                                    $insert_token = $this->session->update_token_user_pass($StrEmail,$StrToken);
                                    if ($insert_token) {
                                        //cuerpo del mensaje
                                        $body='
                                        <html>
                                        <head>
                                        </head>
                                        <body>
                                        <div>
                                            <div style="width:100%; height:auto; padding:10px; background-color:rgba(189, 195, 199,0.4);font-family: sans-serif;">
                                            <strong style="color:rgba(52, 73, 94,1.0);"><h2>¡Hola '.$StrEmail.'!</h2></strong>
                                            <h3 style="font-weight:100;">Alguien solicitó cambiar tu password. Puedes hacerlo:</h3>
                                            <a  href=http://localhost/GuruSchool/home/rescatar_password/&token_password='.$StrToken.'> DANDO CLIK EN ESTE ENLACE</a>
                                            <h3 style="font-weight:100;">Si tú no solicitaste este cambio, por favor ignora este mail, tu contraseña no se modificará si no hasta que accedas al link de arriba.</h3>
                                            <hr>
                                            <p class="dis" style="font-size:12px;">La información contenida en este correo electrónico está dirigida únicamente a su destinatario, es estrictamente confidencial y por lo tanto legalmente protegida. Cualquier comentario o declaración hecha no es necesariamente de GURÚ SCHOOL. GURÚ SCHOOL no es responsable de ninguna recomendación, solicitud, oferta y convenio. El envio de este correo se realizó por medio de una aplicación de GURÚ SCHOOL, por favor no contestar este mensaje, si desea comunicarse con nosotros, hagalo por medio de <a href="mailto:baja@guruschool.co" title="Sugerencia-reclamo-pregunta">baja@guruschool.co</a></p>
                                            </div>
                                         </div> 
                                        </body>
                                        </html>
                                        ';
                                        $body .= "";

                                        $this->mail->IsSMTP();
                                        $this->mail->Host = "smtp.gmail.com";     
                                        $this->mail->Port = 465;  
                                        $this->mail->SMTPAuth = true;
                                        $this->mail->SMTPSecure = "ssl"; 
                                        $this->mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only

                                        $this->mail->From     = "avmsolucion@gmail.com";
                                        $this->mail->FromName = "GURU SCHOOL";
                                        $this->mail->Subject  = "Cambio de Contraseña";
                                        $this->mail->AltBody  = "Leer"; 
                                        $this->mail->MsgHTML($body);
                                        // Activo condificacción utf-8
                                        $this->mail->CharSet = 'UTF-8';

                                        $this->mail->AddAddress($StrEmail);
                                        $this->mail->SMTPAuth = true;
                                        
                                        $this->mail->Username="avmsolucion@gmail.com";
                                        $this->mail->Password="yousolicit1200";
                                        //enviamos el email
                                        if ($this->mail->Send()) {
                                            echo true;
                                        }else{
                                            echo false;
                                            die();
                                        }
                                    }else{
                                        echo false;
                                    }
                                }else{
                                    echo false;
                                }
                        }else{
                            echo false;
                        }
                    }else{
                        echo false;
                    }   
            }else{
                echo false;
            }
        }

        public function change_rescue_pass(){
            if ($this->api_rest->API() == "POST") {
                if (isset($_POST['token_received'])) {
                    $validate_token = $this->session->token_validate_pass($_POST['token_received']);
                    if ($validate_token) {
                        //definimos las variables y las sanamos
                        $EmailDecode = StringDecode($_POST['Key']);
                        $StrEmail = TestInput($EmailDecode);
                        if (TestMail($StrEmail)) {
                            $Token_received = $_POST['token_received'];
                            $NewPass = TestInput($_POST['NewPass']);
                            $RepeatPass = TestInput($_POST['RepeatPass']);
                            $NewVal = NULL;
                            //validamos que la contraseña sea igual a la contraseña que se repite
                            if ($RepeatPass == $NewPass) {
                                if (strlen($NewPass) < 8) {
                                    echo false;
                                }else if(!preg_match('/(?=\d)/', $NewPass)){
                                    echo false;
                                }else if(!preg_match('/(?=[a-z])/', $NewPass)){
                                    echo false;
                                }else if(!preg_match('/(?=[A-Z])/', $NewPass)){
                                    echo false;
                                }else{
                                    //convertimos la contraseña nueva a un Hash
                                    $StrPassHash=HashPassword($NewPass);
                                    //Actualizamos la contraseña 
                                    $update_password = $this->session->update_pass_user($StrPassHash,$StrEmail);
                                    //verificamos que se ejecute correctamente la consulta
                                    if ($update_password) {
                                        $update_token = $this->session->update_token_user_pass($StrEmail,$NewVal);
                                        if ($update_token) {
                                            echo true;
                                        }else{
                                            echo false;
                                        }
                                    }else{
                                        echo false;
                                    }
                                }
                            }else{
                                echo false;
                            }   
                        }else{
                          echo false;
                        }
                    }else{
                       echo false;
                    }
                }else{
                    echo false;
                }
            }else{
                echo false;
            }
        } 

        public function logout(){
            session_destroy();//destruimos la sesión
            $parametros_cookies = session_get_cookie_params();// traemos lo que contenga la cookie
            setcookie(session_name(),0,1,$parametros_cookies["path"],null, null, true);// destruimos la cookie
            session_start();
            session_regenerate_id(true);
            header("Location:".BASE_DIR."/home/iniciar_session/");
        }
    }
?>
