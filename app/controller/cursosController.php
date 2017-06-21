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
            //load Uri Helper
            $this->helper("crypt");
            //load rest
            $this->api_rest = new Rest();
            //load the model courses
            $this->courses = $this->model("cursos",$this->adapter,'G_Cursos');
            //load the model users
            $this->users = $this->model("users",$this->adapter,'G_Datos_Usuario');

        }

        public function lista(){
            $dataAccordeon = $this->courses->GetCategoriesAccordeon();
            $this->render("Courses","listView.php",array("Accordeon" => $dataAccordeon));
        }

        public function ApilistCourses(){
            if ($this->api_rest->API() == "POST") {
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

        public function detalles(){
            if (!isset($_GET['parametro']) || $_GET['parametro']=="") {
                redirect("cursos","lista","request","Ocurrió un error","");
            }else{
                $IdCurso = TestInput($_GET['parametro']);
                $GetDataCourse = $this->courses->GetDataCourse($IdCurso);
                if ($GetDataCourse == false) {
                    redirect("cursos","lista","request","Este curso no existe","");
                }
                //Detalles Curso
                list($IdPkCurso,$IdFkUser,$StrNameCurso,$StrResumen,$StrResComplete,$ImagenCurso,$VideoCurso,$Intprecio,$StrTipoCurso,$StrSubCategoria,$StrCategoria)=$GetDataCourse;

                $GetDataUser = $this->users->GetDataUser($IdFkUser);
                //Detalles Usuario
                list($IntIdUser,$StrName,$StrImagenUser,$StrImageMin,$StrBiogra,$StrProfession,$StrFace,$StrGoogle,$StrLinked,$StrTwitt)=$GetDataUser;
                //Traemos los nombres de los vídeos del curso
                $GetDataVideos = $this->courses->GetDataVideos($IdPkCurso);
                //traemos el email del profesor
                $EmailTeach = $this->users->GetEmailUser($IntIdUser);
                //Traemos los cursos aleatorios en una vista de la clase ViewsSQL
                $GetDataViewCategorie = $this->courses->GetViewCourseSubCategorie($StrSubCategoria);
                //Número de estudiantes inscritos
                $SQLStudentsIn = $this->courses->SQLStudentsIn($IdCurso); 

                $this->render("Courses","detailsView.php",array("GetDataCourse"=>$GetDataCourse,
                                                                "GetDataUser"=>$GetDataUser,
                                                                "GetDataVideos"=>$GetDataVideos,
                                                                "EmailTeach"=>$EmailTeach,
                                                                "GetDataViewCategorie"=>$GetDataViewCategorie,
                                                                "SQLStudentsIn"=>$SQLStudentsIn,
                                                                "IntIdCourse"=>$IdCurso));
            }
        }

        public function pointCourse(){
            if (!isset($_SESSION['Data']['Tiempo'])) {
                echo true;
            }else{
                $InicioSesion=$_SESSION['Data']['Tiempo'];
                $TiempoActual = date("Y-n-j H:i:s"); 
                $TiempoTotal=(strtotime($TiempoActual)-strtotime($InicioSesion)); 
                if ($TiempoTotal>=900) {
                  echo 1;
                }else{
                    //Validamos que se hallan enviado datos por Post
                    if (!isset($_POST['Id'])|| $_POST['Id']=="") {
                        echo 0;
                    }else{
                        //validamos que exista la sesión primeramente
                        if (isset($_SESSION['Data']['Id_Usuario'])) {
                            //Traemos la IP verdadera del Usuario y Verificamos que las variables de sesión concuerden con la ip, servidor y navegador actual del usuario.
                            $Ip=getRealIP();
                            //Decodificamos el Id del Curso y definimos la variable del Id del Usuario
                            $IdDecode=StringDecode($_POST['Id']);
                            $IdCourse=TestInput($IdDecode);
                            $IdUser=$_SESSION['Data']['Id_Usuario'];
                            //Validamos que las credenciales sean correctas
                            if ($_SESSION['Data']['navUser'] != $_SERVER['HTTP_USER_AGENT'] or 
                                $_SESSION['Data']['Ipuser'] != $Ip or 
                                $_SESSION['Data']['hostUser'] != gethostbyaddr($Ip)) 
                            {
                               //Si no son iguales, se destruye la sesión
                               session_destroy();//destruimos la sesión
                               $parametros_cookies = session_get_cookie_params();// traemos lo que contenga la cookie
                               setcookie(session_name(),0,1,$parametros_cookies["path"]);// destruimos la cookie
                               session_start();
                               session_regenerate_id(true);
                               echo true;
                            }else{
                                //validamos que el usuario halla llenado sus datos personales principales
                                $UserValidate = $this->users->validateDataPersonalUser($IdUser);
                                list($Name,$Dni,$Age,$Country,$City,$MailUser) = $UserValidate;

                                if ($Name == NULL or $Dni == NULL or $Age == NULL or $Country == NULL or $City == NULL ){
                                    echo false;
                                }else{
                                    //Validamos si el usuario ya está inscrito en ese curso
                                    $validDataUserCourse = $this->courses->ValidUserCourse($IdCourse,$IdUser);
                                    if ($validDataUserCourse) {
                                        echo '<center>
                                                <i style="font-weight:100; font-size:130px; color:#C9DAE1;" class="fa fa-thumbs-o-up" aria-hidden="true"></i><br><br>
                                                <h2 class="h1-light black-gray">!Usted Ya está en este Curso¡</h2><br>
                                                <h4 class="semi-gray">Vamos, continuemos</h4><br>
                                                <button type="button" class="buttongray btn btn-secondary" value="no" data-dismiss="modal">cancelar</button>    
                                                <a class="btn btn-default" href="classroom/player/'.$IdCourse.'/">Click Aquí</a>
                                            </center>';
                                    }else{
                                        //caso contrario verificamos si el curso es grátis o de pago y traemos los datos
                                        $GetTypeCourse = $this->courses->GetTypeCourse($IdCourse);
                                        list($StrTypeCourse,$IntPrecio,$NameCourse,$IdUserSeller) = $GetTypeCourse;

                                        if ($StrTypeCourse == "Gratis") {
                                            //insertamos en la tabla de de cursos del usuario
                                            $StateVideo="Incompleto";
                                            $InsertCourse = $this->courses->SelectNameVideo($IdCourse,$StateVideo,$IdUser);
                                            echo '
                                                <center>
                                                    <i style="font-weight:100; font-size:130px; color:#C9DAE1;" class="fa fa-smile-o" aria-hidden="true"></i><br><br>
                                                    <h2 class="h1-light black-gray">!Te Haz Apuntado Correctamente¡</h2><br>
                                                    <h4 class="semi-gray">Empecemos!!!</h4><br>
                                                    <button type="button" class="buttongray btn btn-secondary" value="no" data-dismiss="modal">cancelar</button>    
                                                    <a class="btn btn-default" href="classroom/player/'.$IdCourse.'/">Click Aquí.</a><br>
                                                </center>';
                                                
                                        }else if($StrTypeCourse=="De Pago"){
                                          $merchant=546832;
                                          $apikey="rpfLb9n4HOXWxn0Z7RHGs1bt6v";
                                          $referencecode=time().rand(1,9999);
                                          $amount=$IntPrecio;
                                          $description=$NameCourse;
                                          $currency="COP";
                                          $cifrado=md5($apikey."~".$merchant."~".$referencecode."~".$amount."~".$currency);
                                          //insertamos los datos relevantes en la BD, en la tabla Cursos_PorPagar
                                          $InsertPurchase = $this->courses->InsertPurchase($referencecode,$description,$amount,$Name,$MailUser,$IdUserSeller,$IdCourse,$IdUser);
                                                //validamos que se haga la insercción
                                                if ($InsertPurchase) {
                                                    echo '
                                                        <center>
                                                        <i style="font-weight:100; font-size:120px; color:#C9DAE1;" class="fa fa-usd" aria-hidden="true"></i><br><br>
                                                        <h3>Tienes que Completar el Pago</h3><br>
                                                            <form method="post" action="https://gateway.payulatam.com/ppp-web-gateway">
                                                              <input name="merchantId"    type="hidden"  value="'.$merchant.'"   >
                                                              <input name="accountId"     type="hidden"  value="549050" >
                                                              <input name="description"   type="hidden"  value="'.$description.'"  >
                                                              <input name="referenceCode" type="hidden"  value="'.$referencecode.'" >
                                                              <input name="amount"        type="hidden"  value="'.$amount.'"   >
                                                              <input name="tax"           type="hidden"  value="0" >
                                                              <input name="taxReturnBase" type="hidden"  value="0" >
                                                              <input name="currency"      type="hidden"  value="'.$currency.'" >
                                                              <input name="signature"     type="hidden"  value="'.$cifrado.'"  >
                                                              <input name="test"          type="hidden"  value="0" >
                                                              <input name="buyerEmail"    type="hidden"  value="'.$MailUser.'" >
                                                              <input name="buyerFullName"    type="hidden"  value="'.$Name.'" >
                                                              <input name="responseUrl"    type="hidden"  value="http://avmsolucionweb.com/PHP/respuesta.php" >
                                                              <input name="confirmationUrl"    type="hidden"  value="http://avmsolucionweb.com/PHP/confirmacion.php" >
                                                              <input name="Submit" class="btn btn-default"  type="submit"  value="Dando Click Aquí" >
                                                            </form>
                                                        </center>
                                                    ';
                                                }else{
                                                    echo 0;
                                                }
                                        }else{
                                            echo "error ejecutando el proceso";
                                        }
                                    }
                                }
                            }
                        }else{
                            echo true;
                        }
                    }
                }
            }
        }

    }
?>
