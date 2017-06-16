<?php
    class la_bolsaController extends BaseController{
        private $conectar;
    	private $adapter;
        private $users;
        private $bags;
        private $courses;
        private $geographics;
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
            //load rest
            $this->api_rest = new Rest();
            //load the model bags
            $this->bags = $this->model("Bag",$this->adapter,'G_Vacantes');
            //load the model geographics
            $this->geographics = $this->model("Geographics",$this->adapter,'Paises');
            //load the model courses
            $this->courses = $this->model("cursos",$this->adapter,'G_Cursos');
        }

        public function trabajos(){
            //traemos el metodo que nos retorna una vista de todas las vacantes
            $GetViewAllVacancy=$this->bags->GetViewAllVacancy("Public");
            //llamamos la clase para traer  los paises
            $GetCountry=$this->geographics->SQLGetDataCountry();
            //Traemos el meotod que nos retona la categorías
            $ArrCategorias=$this->courses->GetCategoriesHtml();

            $this->render("Bag","listBagView.php",array('GetViewAllVacancy'=>$GetViewAllVacancy,'GetCountry'=>$GetCountry,'ArrCategorias'=>$ArrCategorias));
        }

        public function ApiSearchJobs(){
            //traemos las variables y las sanamos
            $Country=TestInput($_POST['Country']);
            $Categorie=TestInput($_POST['Categorie']);
            $Type=TestInput($_POST['Type']);
            $State="Public";

            //validamos si ciudad tiene algún dato o no
            if (!empty($_POST['City'])) {
                $City=TestInput($_POST['City']);
                $Search = $this->bags->SearchJobs($City,$Country,$Categorie,$Type,$State);    
            }else{
                $Search = $this->bags->SearchJobs(NULL,$Country,$Categorie,$Type,$State); 
            }
            echo json_encode($Search, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

    }
?>
