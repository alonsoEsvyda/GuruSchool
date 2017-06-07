<?php
    class cursosController extends BaseController{
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
            //load rest
            $this->api_rest = new Rest();
            //load the model courses
            $this->courses = $this->model("cursos",$this->adapter,'G_Cursos');

        }

        public function lista(){
            $dataAccordeon = $this->courses->GetCategoriesAccordeon();
            $this->render("Courses","listView.php",array("Accordeon" => $dataAccordeon));
        }

        public function ApilistCourses(){
            if ($this->api_rest->API() == "GET") {
                $courses = $this->courses->GetViewCourses(0);
                echo json_encode($courses, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            }
        }

        public function ApiSearchCourses(){
            $objDatos = json_decode(file_get_contents("php://input"));
            if ($this->api_rest->API() == "POST" && $objDatos->filter) { 
                if ($objDatos->filter == "Cursos") {
                    $CoursesFound = $this->courses->GetViewCourses($objDatos->quantity);
                }else{
                    $State="Publicado";
                    $CoursesFound = $this->courses->GetFoundCourse($objDatos->filter,$State,$objDatos->quantity);
                }
                echo json_encode($CoursesFound, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            }
        }

    }
?>
