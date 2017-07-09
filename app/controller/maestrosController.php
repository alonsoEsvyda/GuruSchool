<?php
    class maestrosController extends BaseController{
        private $conectar;
        private $adapter;
        private $users;
        private $teacher;
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
            //load the model teacher
            $this->teacher = $this->model("teacher",$this->adapter,'G_Datos_Usuario');
            //load the model geographics
            $this->geographics = $this->model("Geographics",$this->adapter,'Paises');

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

            // cursos que enseño
            $MyCourses = $this->courses->GetMyTeachCourses($_SESSION['Data']['Id_Usuario']);

            //llamamos al metodo que nos retorna los cursos pagados
            $ChargeCourse = $this->teacher->ChargeCourse($_SESSION['Data']['Id_Usuario']);

            //Historial de apgos, del usuario
            $PaymentsCourse = $this->teacher->PaymentsCourse($_SESSION['Data']['Id_Usuario']);

            $this->render("Teacher","dashboardTeacherView.php",array("MyCourses"=>$MyCourses, 
                                                              "ChargeCourse"=>$ChargeCourse, 
                                                              "PaymentsCourse"=>$PaymentsCourse));
        }

        public function paymentCharge(){
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");
            //Validamos el tiempo de vida de la sesión  
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");

            //recibimos las variables y las sanamos
            $DataDecode = StringDecode($_POST['Data']);
            $IdCourseSane = TestInput($DataDecode);
            $IdUser = $_SESSION['Data']['Id_Usuario'];
            $Date = date("Y-m-d");
            $StateCharge = "Pending";
            
            //verificamos que el id exista en la tabla de pagos usuarios
            $SqlValidateUser = $this->teacher->ConfirmIdPayment($IdCourseSane);

            if (!$SqlValidateUser) {
                echo false;
            }else{
                //sacamos el monto a cobrar de la tabla
                $SqlGetAmount = $this->teacher->GetActualAmmount($IdUser,$IdCourseSane);
                //validamos que el monto sea mayor a 400 mil
                if ($SqlGetAmount >= 400000) {
                    $IntNumberPay = time().rand(1,9999);
                    //Insertamos el monto en las tablas de cobros
                    $SqlInsertData = InsertAmmount($IdUser,$IdCourseSane,$SqlGetAmount,$StateCharge,$Date,$IntNumberPay);
                    if ($SqlInsertData) {
                        //borramos los datos de las tablas de pagos
                        $SqlDeleteDataUser = DeleteAmmount($IdCourseSane,$IdUser);
                        if ($SqlDeleteDataUser) {
                            echo true;
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
        }

    }
?>