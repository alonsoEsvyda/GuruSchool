<?php
    class homeController extends BaseController{
        private $conectar;
    	private $adapter;
        private $users;
        private $session;
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
            //load the model Session
            $this->session = $this->model("Session",$this->adapter,'G_Usuario');

        }
        
        public function index(){
            if (isset($_SESSION['Data']['Id_Usuario'])) {
                redirect("desk","dashboard","","",2);
            }
            $this->render("Home","homeView.php",$data="");
        }

        public function iniciar_session(){
            if (isset($_SESSION['Data']['Id_Usuario'])) {
                redirect("desk","dashboard","","",2);
            }
            $this->render("Home","startSessionView.php",$data="");
        }

        public function certificados(){
            $this->render("Home","certifiedView.php",$data="");
        }

        public function rescatar_password(){
            if (!isset($_GET['token_password'])) {
                redirect("home","iniciar_session","request","No Existe el Token de Seguridad","");
            }else{
                $Token=TestInput($_GET['token_password']);
                $validate_token = $this->session->token_validate_pass($Token);
                if ($validate_token == false) {
                    redirect("home","iniciar_session","request","Token Invalido","");
                }else{
                    $this->render("Home","rescuePassView.php",array("email"=>$validate_token,"token_received"=>$Token));
                }
            }
        }
    }
?>
