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

        public function nuevo_curso(){
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");
            //Validamos el tiempo de vida de la sesión  
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");

            //Validamos que el usuario tenga sus datos Profesionales llenos
            $ValidateDataProfessional = $this->users->ValidateDataProfessional($_SESSION['Data']['Id_Usuario']);
            //Validamos que el usuario tenga sus datos Bancarios llenos
            $ValidateDataAccount = $this->users->ValidateDataAccount($_SESSION['Data']['Id_Usuario']);
            //validamos que el usuario tenga sus datos personales completos
            $ValidateIssetDatUser = $this->users->ValidateIssetDatUser($_SESSION['Data']['Id_Usuario']);

            if (!$ValidateDataProfessional) {
                redirect("usuarios","mis_datos","request","Debes de llenar tus Datos Profesionales.","");
            }else if (!$ValidateDataAccount) {
                redirect("usuarios","mis_datos","request","Debes de llenar tus Datos Bancarios.","");
            }else if (!$ValidateIssetDatUser) {
                redirect("usuarios","mis_datos","request","Llena Primero tu Datos Personales.","");
            }

            //Traemos el meotod que nos retona la categorías
            $ArrCategorias=$this->courses->GetCategoriesHtml();

            $this->render("Teacher","upCourseView.php",array("ArrCategorias"=>$ArrCategorias));
        }

        public function actualizar(){
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");
            //Validamos el tiempo de vida de la sesión  
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");

            if (!isset($_GET['parametro']) || $_GET['parametro']=="") {
                redirect("maestros","dashboard","request","Ups, Hubo un Error","");
            }else{

                //traemos el metodo que nos retorna los datos del curso
                $ArrDataCourse = $this->teacher->GetDataRejectedCourse(TestInput($_GET['parametro']),$_SESSION['Data']['Id_Usuario'],"Rechazado");
                if ($ArrDataCourse == false) {
                    redirect("maestros","actualizar","request","Amig@ lo siento mucho, hubo un error.","");
                }

                //Traemos el meotod que nos retona la categorías
                $ArrCategorias=$this->courses->GetCategoriesHtml();

                $this->render("Teacher","updateCourseView.php",array("ArrDataCourse"=>$ArrDataCourse,
                                                                    "ArrCategorias"=>$ArrCategorias));
            }
        }

        public function UpdateCourse(){
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");
            //Validamos el tiempo de vida de la sesión  
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");

            //Definimos las Variables
            $IdSession = $_SESSION['Data']['Id_Usuario'];
            $StrNombreCurso = TestInput($_POST['NombreCurso']);
            $StrResumen = TestInput($_POST['Resumen']);
            $StrDescripcion = TestInput($_POST['Descripcion']);
            $StrCategoria = TestInput($_POST['categoria']);
            $StrSubCategoria = TestInput($_POST['sub-categoria']);
            $UrlVideoYoutube = TestInput($_POST['VideoYoutube']);
            $StrImagen = TestInput($_FILES['foto']['name']);
            $StrRadio = TestInput($_POST['radio']);

            if (empty($StrNombreCurso) || empty($StrResumen) || empty($StrDescripcion) || empty($StrCategoria) || empty($StrSubCategoria)) {
                    redirect("maestros","dashboard","request","Llena bien los datos, no juegues con migo :@","");
            }else{
                //Saneamos el ID del curso y lo des-encriptamos
                if (!isset($_POST['IdC']) || $_POST['IdC']=="") {
                    redirect("maestros","dashboard","request","No Alteres los Datos, te Tenemos Vigilado...","");
                }else{
                    $IdEncodeCurso = TestInput($_POST['IdC']);
                    $IdCurso = StringDecode($IdEncodeCurso);
                }
                //estado del curso
                $State = "Rechazado";

                //Validamos que el Nombre y el resumen no supere los 100 y 260 caracteres
                if (strlen($StrNombreCurso)>100 || strlen($StrResumen)>260) {
                    redirect("maestros","dashboard","request","Número de Caracteres Superado, revise Nombre o Descripción","");
                }
                
                //Validamos que valor trae el radio, para definir el precio y tipo de curso
                if ($StrRadio==1){
                    //Si es igual a 1, el precio es 0 y el curso es Gratis
                    $IntPrecio=0;
                    $StrTipoCurso="Gratis";
                }else if ($StrRadio==0){
                    //Si es igual a 0, el precio es el de el Input y el Curso es de Pago
                    $IntPrecio=TestInput($_POST['precio']);
                    $StrTipoCurso="De Pago";
                }else{
                    //Si trae un valor diferente, redireccionamos
                    redirect("maestros","dashboard","request","No Modifique los Campos","");
                }
                
                //Validamos si se insertó una URL de Youtube
                if (!empty($UrlVideoYoutube)) {
                    $StrIdYoutube=GetIdYoutube($UrlVideoYoutube);
                    if ($StrIdYoutube == false) {
                        redirect("maestros","dashboard","request","Video no valido, solo vídeos de Youtube","");
                    }
                }else{
                    $StrIdYoutube=NULL;
                }
                    
                //Traemos el ID de la categoría
                $IdCategorie = $this->courses->GetCategorie($StrCategoria);

                //Validamos Que se halla subido una Imagen 
                if (empty($StrImagen)) {
                    //Actualizamos los datos del Curso
                    $SqlUpdateData=$this->teacher->UpdatePartialDataCourse($IdCategorie,$StrNombreCurso,$StrResumen,$StrDescripcion,$StrCategoria,$StrSubCategoria,$StrIdYoutube,$StrTipoCurso,$IntPrecio,$IdCurso,$IdSession,$State);

                    if ($SqlUpdateData) {
                        header("Location:".BASE_DIR."/maestros/actualizar/".$IdCurso);
                    }else{
                        redirect("maestros","dashboard","request","Hubo un Error, Intente Más Tarde","");
                    }
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
                        //limpiamos la imagen y la nombramos
                        $FotoOriginal=TestInput($_FILES['foto']['name']);
                        $CleanFoto=str_replace(' ', '_',$FotoOriginal);
                        $CleanSigns=preg_replace('/[¿!¡;,:?#@()"]/','_',$CleanFoto);
                        $time = time();
                        $foto = $time."_".$CleanSigns;
                        $directorio = $_SERVER['DOCUMENT_ROOT'].BASE_DIR."/design/img/Cursos_Usuarios/";
                        
                        // almacenar imagen en el servidor
                        $ResFoto = 'Res_Curso_'.$foto;
                        if(file_exists($directorio.$ResFoto)){
                            redirect("maestros","dashboard","request","Ya existe esta Imagen en el Servidor","");
                        }else{
                            //Traemos la imagen actual del Curso
                            $DataImage = $this->teacher->GetPromotionalImgCourse($IdCurso);

                            //Actualizamos los datos del Curso
                            $SqlUpdateData = $this->teacher->UpdateAllDataCourse($IdCategorie,$StrNombreCurso,$StrResumen,$StrDescripcion,$StrCategoria,$StrSubCategoria,$StrIdYoutube,$ResFoto,$StrTipoCurso,$IntPrecio,$IdCurso,$IdSession,$State);
                            if ($SqlUpdateData) {
                                //movemos la imagen al directorio
                                move_uploaded_file($_FILES['foto']['tmp_name'], $directorio.$foto);
                                //redimensionamos la imagen
                                $this->resize = new \Eventviva\ImageResize($directorio.$foto);
                                $this->resize->resizeToBestFit(750, 1350);
                                $this->resize->save($directorio.$ResFoto);
                                //borramos la imagen del directorio
                                unlink($directorio.$DataImage);
                                unlink($directorio.$foto);
                                //redireccionamos al usuario
                                header("Location:".BASE_DIR."/maestros/actualizar/".$IdCurso);
                            }else{
                                redirect("maestros","dashboard","request","Hubo un Error, Intente Más Tarde","");
                            }
                        }
                    } else { // El archivo no es JPG/GIF/PNG
                        $malformato = $_FILES["foto"]["type"];
                        redirect("maestros","dashboard","request","imagen: ".$malformato." con Formato Incorrecto","");
                        exit;
                    }
                }
            }
        }

        public function UpNewCourse(){
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");
            //Validamos el tiempo de vida de la sesión  
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");

            //Definimos las Variables
            $IdSession=$_SESSION['Data']['Id_Usuario'];
            $StrNombreCurso = TestInput($_POST['NombreCurso']);
            $StrResumen = TestInput($_POST['Resumen']);
            $StrDescripcion = TestInput($_POST['Descripcion']);
            $StrCategoria = TestInput($_POST['categoria']);
            $StrSubCategoria = TestInput($_POST['sub-categoria']);
            $UrlVideoYoutube = TestInput($_POST['VideoYoutube']);
            $StrImagen = TestInput($_FILES['archivo']['name']);
            $StrRadio = TestInput($_POST['radio']);
            $StrEstadoCurso="En Revision";

            if (empty($StrNombreCurso) || empty($StrResumen) || empty($StrDescripcion) || empty($StrCategoria) || empty($StrSubCategoria)) {
                redirect("maestros","nuevo_curso","request","Llena bien los datos, no juegues con migo :@","");
            }else{

                //Validamos que el Nombre y el resumen no supere los 100 y 260 caracteres
                if (strlen($StrNombreCurso)>100 || strlen($StrResumen)>260) {
                    redirect("maestros","nuevo_curso","request","Número de Caracteres Superado, revise Nombre o Descripción","");
                }

                //Validamos que valor trae el radio, para definir el precio y tipo de curso
                if ($StrRadio==1){
                    //Si es igual a 1, el precio es 0 y el curso es Gratis
                    $IntPrecio=0;
                    $StrTipoCurso="Gratis";
                }else if ($StrRadio==0){
                    //Si es igual a 0, el precio es el de el Input y el Curso es de Pago
                    $IntPrecio = TestInput($_POST['precio']);
                    $StrTipoCurso="De Pago";
                }else{
                    //Si trae un valor diferente, redireccionamos
                    redirect("maestros","nuevo_curso","request","No Modifique los Campos","");
                }

                //Validamos si se insertó una URL de Youtube
                if ($UrlVideoYoutube!="") {
                    $StrIdYoutube = GetIdYoutube($UrlVideoYoutube);
                    if ($StrIdYoutube==false) {
                        redirect("maestros","nuevo_curso","request","Video no Valido","");
                    }
                }else{
                    $StrIdYoutube=NULL;
                }

                //Validamos Que se halla subido una Imagen 
                if ($StrImagen=="") {
                    redirect("maestros","nuevo_curso","request","Inserte una Imagen","");
                }else{
                    // Primero, hay que validar que se trata de un JPG/GIF/PNG
                    $allowedExts = array("jpg", "jpeg", "gif", "png", "JPG", "GIF", "PNG");
                    $extension = end(explode(".", $_FILES["archivo"]["name"]));
                    if ((($_FILES["archivo"]["type"] == "image/gif")
                            || ($_FILES["archivo"]["type"] == "image/jpeg")
                            || ($_FILES["archivo"]["type"] == "image/png")
                            || ($_FILES["archivo"]["type"] == "image/pjpeg"))
                            && in_array($extension, $allowedExts)) {
                        // el archivo es un JPG/GIF/PNG, entonces...
                        //limpiamos la imagen y la nombramos
                        $FotoOriginal = TestInput($_FILES['archivo']['name']);
                        $CleanFoto=str_replace(' ', '_',$FotoOriginal);
                        $CleanSigns=preg_replace('/[¿!¡;,:?#@()-"]/','_',$CleanFoto);
                        $time = time();
                        $foto = $time."_".$CleanSigns;
                        $directorio = $_SERVER['DOCUMENT_ROOT'].BASE_DIR."/design/img/Cursos_Usuarios/"; // directorio de tu elección
                        
                        // almacenar imagen en el servidor
                        $ResFoto = 'Res_Curso_'.$foto;
                        if(file_exists($directorio.$ResFoto)){
                            redirect("maestros","nuevo_curso","request","Ya existe esta Imagen en el Servidor","");
                        }else{
                            //Traemos el ID de la categoría
                            $IdCategorie=$this->courses->GetCategorie($StrCategoria);
                            if (!$IdCategorie) {
                                redirect("maestros","nuevo_curso","request","Hubo un Error, Intente Un Poco Más Tarde","");
                            }else{
                                //Insertamos los datos del Curso
                                $SqlInsertData=$this->courses->InsertNewCourse($IdCategorie,$IdSession,$StrNombreCurso,$StrResumen,$StrDescripcion,$StrCategoria,$StrSubCategoria,$StrIdYoutube,$ResFoto,$StrTipoCurso,$StrEstadoCurso,$IntPrecio);

                                if ($SqlInsertData) {
                                    //movemos la imagen al directorio
                                    move_uploaded_file($_FILES['archivo']['tmp_name'], $directorio.$foto);
                                    //redimensionamos la imagen
                                    $this->resize = new \Eventviva\ImageResize($directorio.$foto);
                                    $this->resize->resizeToBestFit(750, 1350);
                                    $this->resize->save($directorio.$ResFoto);
                                    //borramos la imagen del directorio
                                    unlink($directorio.$foto);
                                    //redireccionamos al usuario
                                    redirect("maestros","dashboard","requestok","Curso Insertado Correctamente, espere su aprobación.","");
                                }else{
                                    redirect("maestros","nuevo_curso","request","Hubo un Error, Intente Más Tarde","");
                                }
                            }
                        }
                    } else { // El archivo no es JPG/GIF/PNG
                        $malformato = $_FILES["archivo"]["type"];
                        redirect("maestros","nuevo_curso","request","imagen: ".$malformato." con Formato Incorrecto","");
                        exit;
                    }
                }
            }
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

        public function sendConfirmationCourse(){
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");
            //Validamos el tiempo de vida de la sesión  
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");

            //validamos que exista en ID del curso
            if (!isset($_POST['Id']) || empty($_POST['Id'])) {
                echo false;
            }
            //DesEncriptamos Id del Curso
            $IdEncondeCourse = StringDecode($_POST['Id']);
            //Definimos variables y  las sanamos
            $IdSession = $_SESSION['Data']['Id_Usuario'];
            $IdCourse = TestInput($IdEncondeCourse);
            $State = "En Revision";

            //Actualizamos el Estado
            $SqlUpdateState = $this->teacher->SendReviewCourse($State,$IdCourse,$IdSession);
            if ($SqlUpdateState) {
                echo true;
            }else{
                echo false;
            }
        }

        public function GetSubCategorie(){
            //Asignamos el tiempo actual a la variable de sesión
            $_SESSION['Data']['Tiempo'] = date("Y-n-j H:i:s");
            //traemos la ip real del usuario
            $GetRealIp = getRealIP();
            //validamos que exista la sesión y las credenciales sean correctas
            $ValidateSession = ValidateSession($_SESSION['Data']['Id_Usuario'],$_SESSION['Data']['Ipuser'],$_SESSION['Data']['navUser'],$_SESSION['Data']['hostUser'],$GetRealIp,BASE_DIR."/home/iniciar_session/&request=Iniciar Sesión");
            //Validamos el tiempo de vida de la sesión  
            $TimeSession = SessionTime($_SESSION['Data']['Tiempo'],BASE_DIR."/session/logout/");

            if (isset($_POST['categoria'])) {
                //taremos el id de la categoría
                $categoria=TestInput($_POST['categoria']);

                $SQLGetIdCat = $this->courses->GetCategorie($categoria);
                if (!$SQLGetIdCat) {
                    echo false;
                }else{
                    //traemos las sub-categoría
                    $SQLGetSubCat = $this->courses->GetSubCategorie($SQLGetIdCat); 
                    foreach ($SQLGetSubCat as $SubCat) {
                         echo '<option>'.$SubCat[0].'</option>';
                    }
                }
            }
        }

    }
?>