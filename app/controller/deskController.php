<?php
    class deskController extends BaseController{
        private $conectar;
        private $adapter;
        private $users;
        private $courses;
        private $load_trait;
        private $api_rest;
        private $fpdf;
        

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
            //load rest
            $this->api_rest = new Rest();
            //load FPDF
            $this->fpdf = new FPDF('L','mm','A4');
            //load the model courses
            $this->courses = $this->model("cursos",$this->adapter,'G_Cursos');
            //load the model users
            $this->users = $this->model("users",$this->adapter,'G_Datos_Usuario');

        }

        public function dashboard(){
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");
            //Validamos el tiempo de vida de la sesión  
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");

            //traemos los cursos en aprendizaje del usuario en sesión
            $DataMyCourse = $this->courses->SQLGetCoursesUser($_SESSION['Data']['Id_Usuario']);
            //traemos los datos personales del usuario en sesión para validar que estén llenos 
            $ArrDataUser = $this->users->DataUserPersonal($_SESSION['Data']['Id_Usuario']);
            //traemos los datos profesionales del usuario en sesión para validar que estén llenos 
            $ArrDataProfUser = $this->users->DataUserProfesional($_SESSION['Data']['Id_Usuario']);
            //traemos los cursos que enseña el usuario en sesión
            $DataTeache = $this->courses->GetMyTeachCourses($_SESSION['Data']['Id_Usuario']);


            $this->render("Desk","dashboardView.php",array("DataMyCourse"=>$DataMyCourse,
                                                            "ArrDataUser"=>$ArrDataUser,
                                                            "ArrDataProfUser"=>$ArrDataProfUser,
                                                            "DataTeache"=>$DataTeache));
        }

        public function mis_cursos(){
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");
            //Validamos el tiempo de vida de la sesión  
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");

            //traemos los cursos en aprendizaje del usuario en sesión
            $DataMyCourse = $this->courses->SQLGetCoursesUser($_SESSION['Data']['Id_Usuario']);

            $this->render("Desk","learnView.php",array("DataMyCourse"=>$DataMyCourse));
        }

        public function mis_certificados(){
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");
            //Validamos el tiempo de vida de la sesión  
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");

            //llamamos al metodo que nos retorna los datos del certificado
            $GetDataCertified = $this->users->GetDataCertified($_SESSION['Data']['Id_Usuario']);

            $this->render("Desk","certificateView.php",array("GetDataCertified"=>$GetDataCertified));
        }

        public function perfil(){
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");
            //Validamos el tiempo de vida de la sesión  
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");

            //traemos los datos personales del usuario en sesión
            $ArrDataUser = $this->users->DataUserPersonal($_SESSION['Data']['Id_Usuario']);
            //traemos los datos profesionales del usuario en sesión
            $ArrDataProfUser = $this->users->DataUserProfesional($_SESSION['Data']['Id_Usuario']);
            //traemos las redes sociales que halla insertado el usuario
            $ArrSocialMedia = $this->users->GetSocialMediaUser($_SESSION['Data']['Id_Usuario']);
            //traemos el correo del usuario para enviarlo a su perfil público
            $ArrEmailData = $this->users->GetEmailUser($_SESSION['Data']['Id_Usuario']);

            $this->render("Desk","profileView.php",array("ArrDataUser"=>$ArrDataUser,
                                                            "ArrDataProfUser"=>$ArrDataProfUser,
                                                            "ArrSocialMedia"=>$ArrSocialMedia,
                                                            "ArrEmailData"=>$ArrEmailData));
        }

        public function perfil_publico(){
            if (!isset($_GET['parametro']) || $_GET['parametro']=="") {
                redirect("desk","dashboard","request","Ups, hubo un error","");
            }else{
                if (TestMail($_GET['parametro']) == false) {
                  redirect("desk","dashboard","request","Escriba un Correo Valido","");
                }else{
                  $StrGetEmail = TestInput($_GET['parametro']);
                  //treamos el metodo que nos retorna el id por el correo que pasamos por parametro
                  $IntDataId = $this->users->ReturnIdEmail($StrGetEmail);
                  //traemos el metodo que nos retorna los datos personales del usuario
                  $ArrDataUser = $this->users->DataUserPersonal($IntDataId);
                  //traemos el metodo que nos retorna los datos profesionales del usuario
                  $ArrDataProfUser = $this->users->DataUserProfesional($IntDataId);
                  //traemos el metodo que nos retorna las redes sociales que halla insertado el usuario
                  $ArrSocialMedia = $this->users->GetSocialMediaUser($IntDataId);
                  //Traemos el metodo que nos retorna los cursos que el usuario aprende
                  $ArrDataCourse = $this->courses->SQLGetCoursesUser($IntDataId);
                  //traemos el metodo que nos retorna los cursos que el usuario enseña
                  $ArrDataTeachCourses = $this->courses->GetMyPublicCourses($IntDataId,"Publicado");
                }
            }

            $this->render("Desk","publicProfileView.php",array("ArrDataUser"=>$ArrDataUser,
                                                                "ArrDataProfUser"=>$ArrDataProfUser,
                                                                "ArrSocialMedia"=>$ArrSocialMedia,
                                                                "ArrDataCourse"=>$ArrDataCourse,
                                                                "ArrDataTeachCourses"=>$ArrDataTeachCourses));
        }

        public function cargar_certificado(){
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");
            //Validamos el tiempo de vida de la sesión  
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");

            //validamos que la variable exista y tenga contenido
            if (!isset($_GET['parametro']) || empty($_GET['parametro']) || !isset($_GET['parametro2']) || empty($_GET['parametro2'])) {
                redirect("desk","mis_certificados","request","Hubo un Error, Lo sentimos.","");
            }else{
                //definimos las variable y las sanamos
                $IdCourse = StringDecode(TestInput($_GET['parametro']));
                $NumberCertified = StringDecode(TestInput($_GET['parametro2']));
                $IdUser = $_SESSION['Data']['Id_Usuario'];

                        $ValidateissetCertified = $this->users->ValidateissetCertified($IdCourse,$IdUser,$NumberCertified);
                        //verificamos si el curso existe en los datos del usuario
                        if ($ValidateissetCertified == false) {
                            redirect("desk","mis_certificados","request","Hubo un Error, Lo sentimos.","");
                        }else{
                            //traemos los datos del usuario en caso de que si existan en la tabla
                            $SqlGetData = $this->users->GetDataUserCertified($IdCourse,$IdUser);

                            list($StrNameCourse,$StrNameUser,$IntDniUser,$IntCertified) = $SqlGetData;

                            $this->fpdf->AddPage();
                            $this->fpdf->SetFont('Arial','',10);
                            $this->fpdf->Cell(1,10,'',0,0);
                            $this->fpdf->Image(SERVER_DIR.BASE_DIR.'/design/css/imagenes/Plantilla2.png' ,10,8,278,'PNG');
                            $this->fpdf->SetFont('Arial','I',22);
                            $this->fpdf->SetXY(140.2,100); 
                            $this->fpdf->Cell(20,20,$StrNameUser,0,0,'C');
                            $this->fpdf->SetFont('Helvetica','I',12);
                            $this->fpdf->SetXY(140.2,107); 
                            $this->fpdf->Cell(20,20,'DNI:'.$IntDniUser,0,0,'C');
                            $this->fpdf->SetFont('Arial','I',15);
                            $this->fpdf->SetXY(140.2,133); 
                            $this->fpdf->Cell(20,20,utf8_decode($StrNameCourse),0,0,'C');
                            $this->fpdf->SetFont('Arial','I',10);
                            $this->fpdf->SetXY(247.2,179); 
                            $this->fpdf->Cell(10,10,utf8_decode($IntCertified),0,0,'C');
                            $this->fpdf->Output();
                        }
            }
        }

    }
?>