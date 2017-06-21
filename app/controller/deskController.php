<?php
    class deskController extends BaseController{
        private $conectar;
    	private $adapter;
        private $users;
        private $courses;
        private $load_trait;
        private $api_rest;
    	

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

    }
?>
