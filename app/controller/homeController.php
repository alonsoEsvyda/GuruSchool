<?php
    class homeController extends BaseController{
        private $conectar;
    	private $adapter;
        private $users;
        private $api_rest;
    	
        public function __construct() {
            parent::__construct();
            $this->conectar=new Connect();
            //conexion
            $this->adapter=$this->conectar->con();

        }
        
        public function index(){
            $this->render("Home","homeView.php",$data="");
        }

        public function iniciar_session(){
            $this->render("Home","startSessionView.php",$data="");
        }
    }
?>
