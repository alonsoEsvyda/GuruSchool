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
            //load Test Helper
            $this->helper("test");
            //load Uri Helper
            $this->helper("uri");
            //load Cryp Helper
            $this->helper("crypt");
            //load Validate Helper
            $this->helper("validate");
            //load rest
            $this->api_rest = new Rest();
            //load the model bags
            $this->bags = $this->model("Bag",$this->adapter,'G_Vacantes');
            //load the model geographics
            $this->geographics = $this->model("Geographics",$this->adapter,'Paises');
            //load the model courses
            $this->courses = $this->model("cursos",$this->adapter,'G_Cursos');
            //load the model users
            $this->users = $this->model("users",$this->adapter,'G_Datos_Usuario');
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


        public function trabajo(){
            //Validamos el tiempo de vida de la sesión
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");

            $IdJob = TestInput($_REQUEST['parametro']);
            //llamamos al metodo que nos retorna los datos de la vacante
            $GetDataVacancy = $this->bags->GetDataVacancy($IdJob,"Public");
            if ($GetDataVacancy == false) {
                redirect("la_bolsa","trabajos","request","Lo siento, no encontramos tu busqueda","");
            }else{
                foreach ($GetDataVacancy as $Data) {
                }
            }
            $this->render("Bag","jobView.php",array("Data"=>$Data));
        }


        public function publicar_vacante(){
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");
            //Validamos el tiempo de vida de la sesión  
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");

            //Validamos que el usuario tenga sus datos Profesionales llenos
            $DatapProfesional = $this->users->ValidateDataProfessional($_SESSION['Data']['Id_Usuario']);
            //Validamos que el usuario tenga sus datos Bancarios llenos
            $DataAccount = $this->users->ValidateDataAccount($_SESSION['Data']['Id_Usuario']);
            //validamos que el usuario tenga sus datos personales completos
            $DataUser = $this->users->ValidateIssetDatUser($_SESSION['Data']['Id_Usuario']);

            if ($ValidateSession && $TimeSession) {
                if ($DatapProfesional == false) {
                    redirect("ususario","datos","request","Debes de llenar tus Datos Profesionales.","");
                }else if($DataAccount == false){
                    redirect("ususario","datos","request","Debes de llenar tus Datos Bancarios.","");
                }else if($DataUser == false){
                    redirect("ususario","datos","request","Llena Primero tu Datos Personales.","");
                }
            }

            //llamamos la clase para traer  los paises
            $GetCountry = $this->geographics->SQLGetDataCountry();
            //Traemos el meotod que nos retona la categorías
            $ArrCategorias = $this->courses->GetCategoriesHtml();

            $this->render("Bag","newJobView.php",array("GetCountry"=>$GetCountry,"ArrCategorias"=>$ArrCategorias));
        }

        public function mis_vacantes(){
            //Validamos el tiempo de vida de la sesión
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");

            //traemos el método que nos retorna las vacantes en lista
            $GetVacancyUser = $this->bags->GetVacancyUser($_SESSION['Data']['Id_Usuario']);

            $this->render("Bag","listMyJobsView.php",array("GetVacancyUser"=>$GetVacancyUser));
        }

        public function insertar_vacante(){
            //Validamos el tiempo de vida de la sesión
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");

            //Recibimos los datos y los sanamos
            $Company=TestInput($_POST['Company']);
            $Vacancy=TestInput($_POST['Vacancy']);
            $Country=TestInput($_POST['Country']);
            $City=TestInput($_POST['City']);
            $Categorie=TestInput($_POST['Categorie']);
            $TypeJob=TestInput($_POST['TypeJob']);
            $Salary=TestInput($_POST['Salary']);
            $NumVacancy=TestInput($_POST['NumVacancy']);
            $Email=TestInput($_POST['Email']);
            $Description=TestInput($_POST['Description']);
            $State="Pending";
            $IdUser=$_SESSION['Data']['Id_Usuario'];
            $Fecha=date("Y-m-d");

            //validamos que no vengan vacíos
            if (empty($Company) || empty($Vacancy) || empty($Country) || empty($City) || empty($Categorie) || empty($TypeJob) || empty($Salary) || empty($NumVacancy) || empty($Email) || empty($Description)) {
                redirect("la_bolsa","publicar_vacante","request","Llena los datos, no jueges :@","");
            }else{
                //verificamos que no superen los caracteres
                if (strlen($Company)>40 || strlen($Vacancy)>50 || strlen($Country)>70 || strlen($City)>30 || strlen($Categorie)>25 || strlen($TypeJob)>20 || strlen($Email)>45 ) {
                    redirect("la_bolsa","publicar_vacante","request","No superes los datos, te tengo en la mira 0.0","");
                }else{
                    if ($Salary < 0 || $NumVacancy < 0) {
                        redirect("la_bolsa","publicar_vacante","request","No inserte valores negativos","");
                    }else{
                        //validamos el email
                        if (TestMail($Email)) {
                            //insertamos en la BD
                            $SqlInsert = $this->bags->InsertVacancy($IdUser,$Company,$Vacancy,$Country,$City,$Categorie,$TypeJob,$Salary,$NumVacancy,$Email,$Description,$State,$Fecha);
                            if ($SqlInsert) {
                                redirect("la_bolsa","mis_vacantes","request","Vacante Enviada, si cumple con los requisitos será Publicada, de lo contario será Eliminada.","");
                            }else{
                                redirect("la_bolsa","publicar_vacante","request","Lo siento, hubo un error intente más tarde.","");
                            }
                        }else{
                            redirect("la_bolsa","publicar_vacante","request","Debes escribir un Correo Valido","");
                        }
                    }
                }
            }
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

        public function ApiDeleteJob(){
            //Validamos el tiempo de vida de la sesión
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");

            if (!$ValidateSession || !$TimeSession) {
                echo false;
            }else if (!isset($_POST['Data']) || empty($_POST['Data'])) {//trverificamos que venga algo en las variables
                echo false;
            }else{
                //sanamos las variables
                $DataIdDecode = StringDecode($_POST['Data']);
                $DataIdSane = TestInput($DataIdDecode);
                $IdUser = $_SESSION['Data']['Id_Usuario'];

                $Delete = $this->bags->DeleteVacancy($DataIdSane,$IdUser);

                if ($Delete) {
                    echo true;
                }else{
                    echo false;
                }
            }
        }

    }
?>
