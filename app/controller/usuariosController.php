<?php
    class usuariosController extends BaseController{
        private $conectar;
        private $adapter;
        private $users;
        private $courses;
        private $load_trait;
        private $api_rest;
        private $resize;
        private $geographics;
        

        public function __construct() {
            parent::__construct();
            $this->conectar=new Connect();
            //conexion
            $this->adapter=$this->conectar->con();
            //load Uri Helper
            $this->helper("test");
            //load Uri Helper
            $this->helper("uri");
            //load Uri Helper
            $this->helper("crypt");
            //load Validate Helper
            $this->helper("validate");
            //load Validate Helper
            $this->helper("process");
            //load rest
            $this->api_rest = new Rest();
            //load the model courses
            $this->courses = $this->model("cursos",$this->adapter,'G_Cursos');
            //load the model users
            $this->users = $this->model("users",$this->adapter,'G_Datos_Usuario');
            //load the model geographics
            $this->geographics = $this->model("Geographics",$this->adapter,'Paises');

        }

        public function mis_datos(){
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");
            //Validamos el tiempo de vida de la sesión  
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");

            //llamamos al metodo que nos retorna los datos especificos del usuario
            $DataUserPersonal = $this->users->DataUserPersonal($_SESSION['Data']['Id_Usuario']);
            //lamamos al metodo que nos retorna los datos profesionales del usuario
            $DataUserProfesional = $this->users->DataUserProfesional($_SESSION['Data']['Id_Usuario']);
            //llamamos al metodo que nos retorna las redes sociales
            $GetSocialMediaUser = $this->users->GetSocialMediaUser($_SESSION['Data']['Id_Usuario']);
            //llamamos al metodo que nos retorna la cuenta del usuario
            $GetAccountUser = $this->users->GetAccountUser($_SESSION['Data']['Id_Usuario']);
            //llamamos la clase para traer  los paises
            $GetCountry = $this->geographics->SQLGetDataCountry();

            $this->render("Users","myDataView.php",array("DataUserPersonal"=>$DataUserPersonal,
                                                            "DataUserProfesional"=>$DataUserProfesional,
                                                            "GetSocialMediaUser"=>$GetSocialMediaUser,
                                                            "GetAccountUser"=>$GetAccountUser,
                                                            "GetCountry"=>$GetCountry));
        }

        public function updateDataUser(){
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");
            //Validamos el tiempo de vida de la sesión  
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");

            //definimos las variables y las sanamos
            $ImgPhoto = TestInput($_FILES['foto']['name']);
            $StrName = TestInput($_POST['Nombre']);
            $IntDni = TestInput($_POST['Dni']);
            $StrAge = TestInput($_POST['Edad']);
            $StrCountry = TestInput($_POST['Pais']);
            $StrCity = TestInput($_POST['Ciudad']);
            $IntTelf = TestInput($_POST['Telefono']);

            //verificamos que los campos no excedan su limite o tengan contenido indebido
            if (strlen($StrName)>100 || is_numeric($StrName) || empty($StrName)) {
                redirect("usuarios","mis_datos","request","No es un Nombre Valido","");
            }else if(strlen($IntDni)>15 || !is_numeric($IntDni) || empty($IntDni)){
                redirect("usuarios","mis_datos","request","Escribe un Dni Valido","");
            }else if (strlen($StrAge)>3 || !is_numeric($StrAge) || empty($StrAge)) {
                redirect("usuarios","mis_datos","request","Escribe una edad Valida","");
            }else if (strlen($IntTelf)>10 || !is_numeric($IntTelf) || empty($IntTelf)) {
                redirect("usuarios","mis_datos","request","Escribe un Teléfono Válido","");
            }else if (strlen($StrCountry)>150 || is_numeric($StrCountry) || empty($StrCountry)) {
                redirect("usuarios","mis_datos","request","Escribe un País Válido","");
            }else if (strlen($StrCity)>100 || is_numeric($StrCity) || empty($StrCity)) {
                redirect("usuarios","mis_datos","request","Escribe una Ciudad Válida","");
            }else{
                $SessionId=$_SESSION['Data']['Id_Usuario'];
                $SqlValidate = $this->users->DataUserPersonal($SessionId);
                //verificamos que el usuario no tenga datos guardados
                if ($SqlValidate == 0) {
                    if($ImgPhoto == ""){
                        redirect("usuarios","mis_datos","request","Inserte una Imagen","");
                    }else{
                        // Primero, hay que validar que se trata de un JPG/GIF/PNG
                        $allowedExts = array("jpg", "jpeg", "gif", "png", "JPG", "GIF", "PNG");
                        $extension = end(explode(".", $_FILES["foto"]["name"]));
                        if ((($_FILES["foto"]["type"] == "image/gif")
                                || ($_FILES["foto"]["type"] == "image/jpeg")
                                || ($_FILES["foto"]["type"] == "image/png")
                                || ($_FILES["foto"]["type"] == "image/pjpeg"))
                                && in_array($extension, $allowedExts)) {
                            // el archivo es un JPG/GIF/PNG, entonces...
                            $extension = end(explode('.', $_FILES['foto']['name']));
                            //limpiamos la imagen y la nombramos
                            $FotoOriginal=TestInput($_FILES['foto']['name']);
                            $CleanFoto=str_replace(' ', '_',$FotoOriginal);
                            $CleanSigns=preg_replace('/[¿!¡;,:?#@()"]/','_',$CleanFoto);
                            $time = time();
                            $foto = $time."_".$CleanSigns;
                            $directorio = $_SERVER['DOCUMENT_ROOT'].BASE_DIR."/design/img/Perfil_Usuarios/"; // directorio de tu elección
                            
                            // almacenar imagen en el servidor
                            $minFoto = 'min_'.$foto;
                            $resFoto = 'res_'.$foto;
                            if (file_exists($directorio.$minFoto)) {
                                redirect("usuarios","mis_datos","request","Ya existe esta Imagen MIN","");
                            }else if(file_exists($directorio.$resFoto)){
                                redirect("usuarios","mis_datos","request","Ya existe esta Imagen RES","");
                            }else{
                                //Insertamos los datos del usuario
                                $SqlUpdateData = $this->users->InsertDataPersonal($StrName,$IntDni,$StrAge,$StrCountry,$StrCity,$resFoto,$minFoto,$SessionId,$IntTelf);
                                if ($SqlUpdateData) {
                                    //movemos la imagen al directorio
                                    move_uploaded_file($_FILES['foto']['tmp_name'], $directorio.$foto);
                                    //load php resize Res
                                    $this->resize = new \Eventviva\ImageResize($directorio.$foto);
                                    $this->resize
                                                ->scale(30)
                                                ->save($directorio.$resFoto)

                                                ->scale(15)
                                                ->save($directorio.$minFoto);
                                    //borramos la imagen del directorio
                                    unlink($directorio.$foto);
                                    //redireccionamos al usuario
                                    redirect("usuarios","mis_datos","requestok","Datos Actualizados Correctamente","");
                                }else{
                                    redirect("usuarios","mis_datos","request","Intente Más Tarde","");
                                }
                            }
                        } else { // El archivo no es JPG/GIF/PNG
                            $malformato = $_FILES["foto"]["type"];
                            redirect("usuarios","mis_datos","request","imagen: ".$malformato." con Formato Incorrecto","");
                            exit;
                        }
                    }
                //si ya tiene datos, actualizamos   
                }else{
                    if($ImgPhoto == ""){
                        $SqlUpdateData = $this->users->UpdateDataWithOutPhoto($StrName,$IntDni,$StrAge,$StrCountry,$StrCity,$IntTelf,$SessionId);
                        if ($SqlUpdateData) {
                            redirect("usuarios","mis_datos","requestok","Datos Actualizados Correctamente","");
                        }else{
                            redirect("usuarios","mis_datos","request","Intente Más Tarde","");
                        }
                    }else{
                        //traemos los datos de las imagenes actuales de la consulta
                        $DataImage = $SqlValidate;
                        foreach ($DataImage as $DataUser) {
                        }
                        // Primero, hay que validar que se trata de un JPG/GIF/PNG
                        $allowedExts = array("jpg", "jpeg", "gif", "png", "JPG", "GIF", "PNG");
                        $extension = end(explode(".", $_FILES["foto"]["name"]));
                        if ((($_FILES["foto"]["type"] == "image/gif")
                                || ($_FILES["foto"]["type"] == "image/jpeg")
                                || ($_FILES["foto"]["type"] == "image/png")
                                || ($_FILES["foto"]["type"] == "image/pjpeg"))
                                && in_array($extension, $allowedExts)) {
                            //limpiamos la imagen y la nombramos
                            $FotoOriginal=TestInput($_FILES['foto']['name']);
                            $CleanFoto=str_replace(' ', '_',$FotoOriginal);
                            $CleanSigns=preg_replace('/[¿!¡;,:?#@()"]/','_',$CleanFoto);
                            $time = time();
                            $foto = $time."_".$CleanSigns;
                            $directorio = $_SERVER['DOCUMENT_ROOT'].BASE_DIR."/design/img/Perfil_Usuarios/"; // directorio de tu elección
                            
                            // almacenar imagen en el servidor
                            $minFoto = 'min_'.$foto;
                            $resFoto = 'res_'.$foto;
                            if (file_exists($directorio.$minFoto)) {
                                redirect("usuarios","mis_datos","request","Ya existe esta Imagen MIN","");
                            }else if(file_exists($directorio.$resFoto)){
                                redirect("usuarios","mis_datos","request","Ya existe esta Imagen RES","");
                            }else{
                                if (unlink($directorio.$DataUser[5]) && unlink($directorio.$DataUser[6])) {
                                    //Actualizamos los datos
                                    $SqlUpdateData = $this->users->UpdateDataUser($StrName,$IntDni,$StrAge,$StrCountry,$StrCity,$resFoto,$minFoto,$IntTelf,$SessionId);
                                    //ejecutamos la consulta
                                    if ($SqlUpdateData) {
                                        //guardamos la imagen en la carpeta
                                        move_uploaded_file($_FILES['foto']['tmp_name'], $directorio.$foto);
                                        //load php resize Res
                                        $this->resize = new \Eventviva\ImageResize($directorio.$foto);
                                        $this->resize
                                                    ->scale(30)
                                                    ->save($directorio.$resFoto)

                                                    ->scale(15)
                                                    ->save($directorio.$minFoto);
                                        //borramos la imagen del directorio
                                        unlink($directorio.$foto);
                                        //redireccionamos al usuario
                                        redirect("usuarios","mis_datos","requestok","Datos Actualizados Correctamente","");
                                    }else{
                                        redirect("usuarios","mis_datos","request","Intente Más Tarde","");
                                    }
                                }else{
                                    redirect("usuarios","mis_datos","request","Hubo un Error, Intente Más Tarde","");
                                }
                            }
                        } else { // El archivo no es JPG/GIF/PNG
                            $malformato = $_FILES["foto"]["type"];
                            redirect("usuarios","mis_datos","request","imagen: ".$malformato." con Formato Incorrecto","");
                            exit;
                        }
                    }
                }
            }
        }

        public function updateProfessionalUser(){
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");
            //Validamos el tiempo de vida de la sesión  
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");

            //Definimos las variables
            $IdSession = $_SESSION['Data']['Id_Usuario'];
            $StrProfession = TestInput($_POST['profesion']);
            $StrBiografia = TestInput($_POST['biografia']);
            $UrlFacebook = TestInput($_POST['Facebook']);
            $UrlTwitter = TestInput($_POST['Twitter']);
            $UrlGoogle = TestInput($_POST['Google']);
            $UrlLinkedIn = TestInput($_POST['LinkedIn']);

            //Verificamos que sean URL validas
            if ($UrlFacebook!="") {
                if (TestFacebook($UrlFacebook) == false) {
                    redirect("usuarios","mis_datos","request","Url Facebook No Valida","");
                }
            }
            if($UrlTwitter!=""){
                if(TestTwitter($UrlTwitter) == false){
                    redirect("usuarios","mis_datos","request","Url Twitter No Valida","");
                }
            }
            if($UrlGoogle!=""){
                if(TestUrl($UrlGoogle) == false){
                    redirect("usuarios","mis_datos","request","Url Google No Valida","");
                }
            }
            if ($UrlLinkedIn!="") {
                if(TestUrl($UrlLinkedIn) == false){
                    redirect("usuarios","mis_datos","request","Url LinkedIn No Valida","");
                }
            }

            //validamos que los campos obligatorios no estén vacíos
            if (empty($StrProfession) || empty($StrBiografia)) {
                redirect("usuarios","mis_datos","request","Llene los Campos Obliatorios","");
            }else{
                if (strlen($StrProfession)>150) {
                    redirect("usuarios","mis_datos","request","No exceda el limite de caracteres en su Profesión","");
                }else{
                    //verificamos que el usuario no tenga datos en la tabla
                    $SqlValidate = $this->users->ValidateAllDataProfessional($IdSession);
                        if (!$SqlValidate) {

                            $SqlInsertData = $this->users->InsertDataProfessional($IdSession,$StrProfession,$StrBiografia,$UrlFacebook,$UrlTwitter,$UrlGoogle,$UrlLinkedIn); 
                            if ($SqlInsertData) {
                                redirect("usuarios","mis_datos","requestok","Datos Insertados Correctamente","");
                            }else{
                                redirect("usuarios","mis_datos","request","Hubo un Error, Intente más Tarde","");
                            }
                        }else{
                            $SqlInsertData=$this->users->UpdateDataProfessional($StrProfession,$StrBiografia,$UrlFacebook,$UrlTwitter,$UrlGoogle,$UrlLinkedIn,$IdSession);
                            if($SqlInsertData){    
                                redirect("usuarios","mis_datos","requestok","Datos Actualizados Correctamente","");
                            }else{
                                redirect("usuarios","mis_datos","request","Hubo un Error, Intente más Tarde","");
                            }
                        }
                }
            }
        }

        public function updateAccountBank(){
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");
            //Validamos el tiempo de vida de la sesión  
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");

            //antes de realizar cualquier acción, validamos si el usuario pertenece a Colombia
            $SessionId = $_SESSION['Data']['Id_Usuario'];
            $DataPersonal = $this->users->DataUserPersonal($SessionId);
            foreach ($DataPersonal as $personal) {
            }
            if ($personal[3] == "Colombia") {
                //Definimos las Variables
                $IntAccount = TestInput($_POST['Cuenta']);
                $StrBank = TestInput($_POST['Banco']);

                if (empty($StrBank) || empty($IntAccount)) {
                    redirect("usuarios","mis_datos","request","Llene todos los Campos de su Cuenta","");
                }else{
                    if (strlen($IntAccount)>12) {
                        redirect("usuarios","mis_datos","request","Cuenta demasiado Larga","");
                    }else if (strlen($StrBank)>50){
                        redirect("usuarios","mis_datos","request","Nombre del Banco muy Largo","");
                    }else{

                        //Ciframos la cuenta para guardarla en la base de datos
                        $CryptAccount = StringEncode($IntAccount);
                        $SqlValidateDataAccount=$this->users->ValidateDataAccount($SessionId);
                        
                        if (!$SqlValidateDataAccount) {
                            $SqlInsertData=$this->users->InsertDataBank($SessionId,$CryptAccount,$StrBank);
                            if ($SqlInsertData) {
                                redirect("usuarios","mis_datos","requestok","Datos Insertados Correctamente","");
                            }else{
                                redirect("usuarios","mis_datos","request","Hubo un Error Insertando, Intente más Tarde","");
                            }
                        }else{
                            $SqlInsertData=$this->users->UpdateDataBank($CryptAccount,$StrBank,$SessionId);
                            if ($SqlInsertData) {
                                redirect("usuarios","mis_datos","requestok","Datos Actualizados Correctamente","");
                            }else{
                                redirect("usuarios","mis_datos","request","Hubo un Error Insertando, Intente más Tarde","");
                            }
                        }
                    }
                }
            }else{
                redirect("usuarios","mis_datos","request","Usted no es de Colombia","");
            }
            
        }
    }
?>