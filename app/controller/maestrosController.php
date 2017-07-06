<?php
    class maestrosController extends BaseController{
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

        public function mis_cursos(){
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");
            //Validamos el tiempo de vida de la sesión  
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");

            $MyCourses = $this->courses->GetMyTeachCourses($_SESSION['Data']['Id_Usuario']);

            $this->render("Teacher","myCoursesView.php",array("MyCourses"=>$MyCourses));
        }

    }
?>