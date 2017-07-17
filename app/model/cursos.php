<?php
    class Cursos extends EntityBase{
        private $id;
        private $nombre;
        private $apellido;
        private $email;
        private $password;
        
        public function __construct($adapter,$table) {
            parent::__construct($table, $adapter);
        }


        //En este modelo traemos el resultado de los cursos aleatorios sin definir una categoría, HOJA CURSOS.PHP
        public function GetViewCourses($quantity){
            if ($quantity == 0) {
               $value = 30;
            }else{
                $value = $quantity;
            }
            $SqlGetView=$this->db()->prepare("SELECT Id_Pk_Curso,Int_Fk_IdUsuario,Vc_NombreCurso,Vc_Imagen_Promocional,Int_PrecioCurso,Vc_TipoCurso,Vc_NombreUsuario,Vc_EstadoCurso FROM vw_seleccioncursos ORDER BY RAND() DESC LIMIT ?");
            $SqlGetView->bind_param("i",$value);
            $SqlGetView->execute();
            $SqlGetView->store_result();
            $SqlGetView->bind_result($IdPkCurso,$IdFkUser,$StrNameCurso,$Imagen,$Intprecio,$StrTipoCurso,$NameUser,$StateCourse);
            while ($SqlGetView->fetch()) {
                $StundentsIn = $this->SQLStudentsIn($IdPkCurso);
                $ArrayData[] = array('bool'=>'verdadero','IdPkCurso'=>$IdPkCurso,'IdFkUser'=>$IdFkUser,'StrNameCurso'=>$StrNameCurso,'Imagen'=>$Imagen,'Intprecio'=>$Intprecio,'StrTipoCurso'=>$StrTipoCurso,'NameUser'=>$NameUser,'StateCourse'=>$StateCourse,'StundentsIn'=>$StundentsIn);
            }
            $SqlGetView->close();
            return $ArrayData;
        }

        public function GetViewCourseSubCategorie($SubCategoria){
            $SqlGetView=$this->db()->prepare("SELECT Id_Pk_Curso,Int_Fk_IdUsuario,Vc_NombreCurso,Vc_Imagen_Promocional,Int_PrecioCurso,Vc_TipoCurso,Vc_NombreUsuario,Vc_EstadoCurso FROM vw_seleccioncursos WHERE Vc_SubCategoria = ? ORDER BY RAND() DESC LIMIT  4 ");
            $SqlGetView->bind_param("s", $SubCategoria);
            $SqlGetView->execute();
            $SqlGetView->store_result();
            $SqlGetView->bind_result($IdPkCurso,$IdFkUser,$StrNameCurso,$Imagen,$Intprecio,$StrTipoCurso,$NameUser,$StateCourse);
            while ($SqlGetView->fetch()) {
                $ArrayData[]=array($IdPkCurso,$IdFkUser,$StrNameCurso,$Imagen,$Intprecio,$StrTipoCurso,$NameUser,$StateCourse);
            }
            $SqlGetView->close();
            return $ArrayData;
        }

        public function GetDataVideos($IdPkCurso){
            $SqlGetNameVideos=$this->db()->prepare("SELECT Txt_NombreVideo,Id_Pk_VideosCurso,Vc_VideoArchivo FROM G_Videos_Curso WHERE Int_Fk_IdCurso = ?");
            $SqlGetNameVideos->bind_param("s",$IdPkCurso);
            $SqlGetNameVideos->execute();
            $SqlGetNameVideos->store_result();
            if ($SqlGetNameVideos->num_rows==0) {
                return false;
            }else{
                $SqlGetNameVideos->bind_result($NameVideo,$IntIdVideo,$Srcvideo);
                while($SqlGetNameVideos->fetch()){
                    $ArrayNameVideo[]=array($NameVideo,$IntIdVideo,$Srcvideo);
                }
                $SqlGetNameVideos->close();
                return $ArrayNameVideo;
            }
        }
        

        public function GetCategoriesAccordeon(){
            $SqlGetCategorie=$this->db()->prepare("SELECT a.Id_Pk_Categorias,a.Vc_NombreCat,b.Vc_SubCat,b.Int_Fk_IdCat FROM G_Categorias AS a INNER JOIN G_Sub_Categoria AS b ON a.Id_Pk_Categorias = b.Int_Fk_IdCat");
            $SqlGetCategorie->execute();
            $SqlGetCategorie->store_result();
            $SqlGetCategorie->bind_result($idCat,$NameCat,$NameSubCat,$IdFk);
            while ($SqlGetCategorie->fetch()) {
                $ArrayData[] = array($idCat,$NameCat,$NameSubCat,$IdFk);
            }
            $SqlGetCategorie->close();
            return $ArrayData;
        }

        public function GetFoundCourse($NameSubCat,$State,$quantity){
            if ($quantity == 0) {
               $value = 30;
            }else{
                $value = $quantity;
            }
            $SqlGetCourses=$this->db()->prepare("SELECT a.Id_Pk_Curso,a.Int_Fk_IdUsuario,a.Vc_NombreCurso,a.Vc_Imagen_Promocional,a.Int_PrecioCurso,a.Vc_TipoCurso,b.Vc_NombreUsuario,a.Vc_EstadoCurso FROM G_Cursos AS a INNER JOIN G_Datos_Usuario AS b ON a.Int_Fk_IdUsuario = b.Int_Fk_IdUsuario WHERE a.Vc_SubCategoria = ? AND a.Vc_EstadoCurso = ? ORDER BY RAND() DESC LIMIT ? ");
            $SqlGetCourses->bind_param("ssi", $NameSubCat,$State,$value);
            $SqlGetCourses->execute();
            $SqlGetCourses->store_result();
            if ($SqlGetCourses->num_rows == 0) {
                $ArrayData[] = array("bool"=>"falso");
            }else{
                $SqlGetCourses->bind_result($IdPkCurso,$IdFkUser,$StrNameCurso,$Imagen,$Intprecio,$StrTipoCurso,$NameUserCourse,$StateCourse);
                while ($SqlGetCourses->fetch()) {
                    $StundentsIn = $this->SQLStudentsIn($IdPkCurso);
                    $ArrayData[] = array('bool'=>'verdadero','IdPkCurso'=>$IdPkCurso,'IdFkUser'=>$IdFkUser,'StrNameCurso'=>$StrNameCurso,'Imagen'=>$Imagen,'Intprecio'=>$Intprecio,'StrTipoCurso'=>$StrTipoCurso,'NameUser'=>$NameUserCourse,'StateCourse'=>$StateCourse,'StundentsIn'=>$StundentsIn);
                }
            }
            return $ArrayData;
        }

        public function GetDataCourse($IdCurso){
            $State="Publicado";
            $SqlGetDataCourse=$this->db()->prepare("SELECT Id_Pk_Curso,Int_Fk_IdUsuario,Vc_NombreCurso,Vc_ResumenCurso,Txt_DescripcionCompleta,Vc_Imagen_Promocional,Vc_VideoPromocional,Int_PrecioCurso,Vc_TipoCurso,Vc_SubCategoria,Vc_Categoria FROM G_Cursos WHERE Id_Pk_Curso = ? AND Vc_EstadoCurso= ?  ");
            $SqlGetDataCourse->bind_param("is",$IdCurso,$State);
            $SqlGetDataCourse->execute();
            $SqlGetDataCourse->store_result();
            if ($SqlGetDataCourse->num_rows==0) {
                return false;
            }else{
                $SqlGetDataCourse->bind_result($IdPkCurso,$IdFkUser,$StrNameCurso,$StrResumen,$StrResComplete,$ImagenCurso,$VideoCurso,$Intprecio,$StrTipoCurso,$StrSubCategoria,$StrCategoria);
                $SqlGetDataCourse->fetch();
                return array($IdPkCurso,$IdFkUser,$StrNameCurso,$StrResumen,$StrResComplete,$ImagenCurso,$VideoCurso,$Intprecio,$StrTipoCurso,$StrSubCategoria,$StrCategoria);
                $SqlGetDataCourse->close();
            }
        }

        public function ValidUserCourse($IdCourse,$IdUser){
            $ValidCouserUser=$this->db()->prepare("SELECT Int_Fk_IdCurso,Int_Fk_IdUsuario FROM G_Usuarios_Cursos WHERE Int_Fk_IdCurso= ? AND Int_Fk_IdUsuario = ? ");
            $ValidCouserUser->bind_param("ii", $IdCourse,$IdUser);
            $ValidCouserUser->execute();
            $ValidCouserUser->store_result();
            if ($ValidCouserUser->num_rows > 0) {
                return true;
            }else{
                return false;
            }
        }

        public function ValidTypeCourse($IdCurso,$StrType,$IdSession){
            //verificamos que el curso sea De Pago
            $SqlValidateFree=$this->db()->prepare("SELECT Vc_TipoCurso FROM G_Cursos WHERE Id_Pk_Curso= ? AND Vc_TipoCurso=? AND Int_Fk_IdUsuario= ? ");
            $SqlValidateFree->bind_param("isi", $IdCurso,$StrType,$IdSession);
            $SqlValidateFree->execute();
            $SqlValidateFree->store_result();
            if ($SqlValidateFree->num_rows == 0) {
                return false;
            }else{
                return true;
            }
        }

        public function GetTypeCourse($IdCourse){
            $GetTypeCourse=$this->db()->prepare("SELECT Vc_TipoCurso,Int_PrecioCurso,Vc_NombreCurso,Int_Fk_IdUsuario FROM G_Cursos WHERE Id_Pk_Curso = ? ");
            $GetTypeCourse->bind_param("i", $IdCourse);
            $GetTypeCourse->execute();
            $GetTypeCourse->store_result();
            $GetTypeCourse->bind_result($StrTypeCourse,$IntPrecio,$NameCourse,$IdUserSeller);
            $GetTypeCourse->fetch();

            return array($StrTypeCourse,$IntPrecio,$NameCourse,$IdUserSeller);
        }

        public function InsertCourseUser($IdCourse,$IdUser,$StrNameVideo,$StateVideo){
            $InsertCourse=$this->db()->prepare("INSERT INTO G_Usuarios_Cursos (Int_Fk_IdCurso,Int_Fk_IdUsuario,Vc_NombreVideo,Vc_EstadoVideo) 
                                                                                        VALUES (?,?,?,?)");
            $InsertCourse->bind_param("ssss", $IdCourse,$IdUser,$StrNameVideo,$StateVideo);
            $InsertCourse->execute();
        }

        public function SelectNameVideo($IdCourse,$StateVideo,$IdUser){
            $GetDataCourse=$this->db()->prepare("SELECT Txt_NombreVideo FROM G_Videos_Curso WHERE Int_Fk_IdCurso= ? ");
            $GetDataCourse->bind_param("i", $IdCourse);
            $GetDataCourse->execute();
            $GetDataCourse->store_result();
            $GetDataCourse->bind_result($StrNameVideo);
            while ($GetDataCourse->fetch()) {
                $this->InsertCourseUser($IdCourse,$IdUser,$StrNameVideo,$StateVideo);
            }
        }

        public function InsertPurchase($referencecode,$description,$amount,$Name,$MailUser,$IdUserSeller,$IdCourse,$IdUser){
            $InsertPurchase=$this->db()->prepare("INSERT INTO Historial_Pagos (Vc_Reference_Sale,Txt_NameCourse,Int_MontoCurso,Vc_Nickname_Buyer,Vc_Email_Buyer,    Int_Id_UsuarioVende,Int_Id_CursoComprado,Int_Id_UsuarioCompro) VALUES ('".$referencecode."','".$description."','".$amount."','".$Name."','".$MailUser."','".$IdUserSeller."','".$IdCourse."','".$IdUser."')");
            if ($InsertPurchase->execute()) {
                return true;
            }else{
                return false;
            }
        }

        public function GetCategoriesHtml(){
            $SqlGetCategorie=$this->db()->prepare("SELECT Vc_NombreCat FROM G_Categorias");
            $SqlGetCategorie->execute();
            $SqlGetCategorie->store_result();
            $SqlGetCategorie->bind_result($NameCat);
            while ($SqlGetCategorie->fetch()) {
                $ArrayCat[]=array($NameCat);
            }
            $SqlGetCategorie->close();
            return $ArrayCat;
        }

        public function GetCategorie($categoria){
            $SQLGetIdCat=$this->db()->prepare("SELECT Id_Pk_Categorias FROM G_Categorias WHERE Vc_NombreCat= ? ");
            $SQLGetIdCat->bind_param("s", $categoria);
            $SQLGetIdCat->execute();
            $SQLGetIdCat->store_result();
            if ($SQLGetIdCat->num_rows == 0) {
                return false;
            }else{
                $SQLGetIdCat->bind_result($IdCat);
                $SQLGetIdCat->fetch();
                return $IdCat;
            }
        }

        public function GetSubCategorie($IdCat){
            $SQLGetSubCat=$this->db()->prepare("SELECT Vc_SubCat FROM G_Sub_Categoria WHERE Int_Fk_IdCat= ? ");
            $SQLGetSubCat->bind_param("s", $IdCat);
            $SQLGetSubCat->execute();
            $SQLGetSubCat->store_result();
            $SQLGetSubCat->bind_result($NameSubCat);
            while ($SQLGetSubCat->fetch()) {
                $ArrayData[] = array($NameSubCat);
            }
            $SQLGetSubCat->close();
            return $ArrayData;
        }

        public function SQLProgressCourse($IdUser,$IdCourse,$StateVideo){
            $SqlGetProgress=$this->db()->prepare("SELECT ROUND((SELECT COUNT(a.Vc_EstadoVideo) as videos FROM G_Usuarios_Cursos AS a WHERE a.Vc_EstadoVideo=? AND a.Int_Fk_IdCurso=$IdCourse AND a.Int_Fk_IdUsuario=$IdUser)*100/(SELECT COUNT(b.Int_Fk_IdCurso) AS Id FROM G_Usuarios_Cursos AS b WHERE b.Int_Fk_IdCurso=? AND b.Int_Fk_IdUsuario=$IdUser)) AS Porcentaje FROM G_Usuarios_Cursos WHERE Int_Fk_IdUsuario=? ");
            $SqlGetProgress->bind_param("sii",$StateVideo,$IdCourse,$IdUser);
            $SqlGetProgress->execute();
            $SqlGetProgress->store_result();
            $SqlGetProgress->bind_result($Porcentaje);
            $SqlGetProgress->fetch();
            if ($Porcentaje==0) {
                return 0;
            }else{
                return $Porcentaje;
            }
            $SqlGetProgress->close();
        }

        public function SQLGetCoursesUser($IdUser){//esta función nos retorna los datos de los cursos que estamos aprendiendo
            $SqlGetId=$this->db()->prepare("SELECT DISTINCT(Int_Fk_IdCurso) FROM G_Usuarios_Cursos WHERE Int_Fk_IdUsuario = ? ");
            $SqlGetId->bind_param("i", $IdUser);
            $SqlGetId->execute();
            $SqlGetId->store_result();
            if ($SqlGetId->num_rows==0) {
                $ArrayData = false;
            }else{
                $SqlGetId->bind_result($IntIdCurso);
                while ($SqlGetId->fetch()) {
                    $ProgressCourse = $this->SQLProgressCourse($IdUser,$IntIdCurso,"Completo");
                    $SqlCourses=$this->db()->prepare("SELECT a.Id_Pk_Curso,a.Vc_NombreCurso,a.Vc_Imagen_Promocional,a.Int_PrecioCurso,a.Vc_TipoCurso,b.Vc_NombreUsuario  FROM G_Cursos AS a INNER JOIN G_Datos_Usuario AS b ON a.Int_Fk_IdUsuario=b.Int_Fk_IdUsuario WHERE a.Id_Pk_Curso = ? ");
                    $SqlCourses->bind_param("i",$IntIdCurso);
                    $SqlCourses->execute();
                    $SqlCourses->store_result();
                    $SqlCourses->bind_result($IntIdCourse,$StrNameCourse,$StrImageCourse,$IntPrecioCourse,$StrTipoCourse,$StrNameUser);
                    while ($SqlCourses->fetch()) {
                        $ArrayData[] = array($IntIdCourse,$StrNameCourse,$StrImageCourse,$IntPrecioCourse,$StrTipoCourse,$StrNameUser,$ProgressCourse); 
                    }
                }
                $SqlCourses->close();
            }
            $SqlGetId->close();
            return $ArrayData;
        }

        public function GetMyTeachCourses($IdUser){//Aquí traemos los cursos que enseña el usuario en sesión
            $SqlGetDataTeach=$this->db()->prepare("SELECT Id_Pk_Curso,Vc_NombreCurso,Vc_Imagen_Promocional,Vc_EstadoCurso,Vc_TipoCurso,Int_PrecioCurso FROM G_Cursos WHERE Int_Fk_IdUsuario = ?");
            $SqlGetDataTeach->bind_param("i", $IdUser);
            $SqlGetDataTeach->execute();
            $SqlGetDataTeach->store_result();
            if ($SqlGetDataTeach->num_rows==0) {
                $ArrayData=false;
            }else{
                $SqlGetDataTeach->bind_result($IntIdCourse,$StrNameTeachC,$StrImage,$StrStateCourse,$StrTypecourse,$Intprice);
                while ($SqlGetDataTeach->fetch()) {
                    $StudentsIn = $this->SQLStudentsIn($IntIdCourse);
                    $ArrayData[]= array($IntIdCourse,$StrNameTeachC,$StrImage,$StrStateCourse,$StrTypecourse,$Intprice,$StudentsIn);
                }
            }
            $SqlGetDataTeach->close();
            return $ArrayData;
        }

        public function GetMyPublicCourses($IdUser,$State){//Aquí traemos los cursos que enseña el usuario en sesión PUBLICADOS para su perfíl público
            $SqlGetDataTeach=$this->db()->prepare("SELECT Id_Pk_Curso,Vc_NombreCurso,Vc_Imagen_Promocional,Vc_EstadoCurso,Vc_TipoCurso,Int_PrecioCurso FROM G_Cursos WHERE Int_Fk_IdUsuario = ? AND Vc_EstadoCurso= ?");
            $SqlGetDataTeach->bind_param("is", $IdUser,$State);
            $SqlGetDataTeach->execute();
            $SqlGetDataTeach->store_result();
            if ($SqlGetDataTeach->num_rows==0) {
                $ArrayData=false;
            }else{
                $SqlGetDataTeach->bind_result($IntIdCourse,$StrNameTeachC,$StrImage,$StrStateCourse,$StrTypecourse,$Intprice);
                while ($SqlGetDataTeach->fetch()) {
                    $ArrayData[]= array($IntIdCourse,$StrNameTeachC,$StrImage,$StrStateCourse,$StrTypecourse,$Intprice);
                }
            }
            $SqlGetDataTeach->close();
            return $ArrayData;
        } 

        public function InsertNewCourse($IdCategorie,$IdSession,$StrNombreCurso,$StrResumen,$StrDescripcion,$StrCategoria,$StrSubCategoria,$StrIdYoutube,$ResFoto,$StrTipoCurso,$StrEstadoCurso,$IntPrecio){
            $SqlInsertData=$this->db()->prepare("INSERT INTO G_Cursos (Int_Fk_IdCat,Int_Fk_IdUsuario,Vc_NombreCurso,Vc_ResumenCurso,Txt_DescripcionCompleta,Vc_Categoria,Vc_SubCategoria,Vc_VideoPromocional,Vc_Imagen_Promocional,Vc_TipoCurso,Vc_EstadoCurso,Int_PrecioCurso) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
            $SqlInsertData->bind_param("iisssssssssi", $IdCategorie,$IdSession,$StrNombreCurso,$StrResumen,$StrDescripcion,$StrCategoria,$StrSubCategoria,$StrIdYoutube,$ResFoto,$StrTipoCurso,$StrEstadoCurso,$IntPrecio);
            if ($SqlInsertData->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function GetDataRejectedCourse($IdCurso,$IdUser,$State){
            //Traemos los datos relevantes del curso
            $SqlGetDataCourse=$this->db()->prepare("SELECT Id_Pk_Curso,Vc_NombreCurso,Vc_Imagen_Promocional,Vc_EstadoCurso,Vc_TipoCurso,Int_PrecioCurso,Vc_ResumenCurso,Txt_DescripcionCompleta,Vc_Categoria,Vc_SubCategoria,Vc_VideoPromocional,Txt_Nota FROM G_Cursos WHERE Id_Pk_Curso = ? AND Int_Fk_IdUsuario= ? AND Vc_EstadoCurso= ?  ");
            $SqlGetDataCourse->bind_param("iis",$IdCurso,$IdUser,$State);
            $SqlGetDataCourse->execute();
            $SqlGetDataCourse->store_result();
            if ($SqlGetDataCourse->num_rows==0) {
                return false;
            }else{
                $SqlGetDataCourse->bind_result($IntIdCourse,$StrNameTeachC,$StrImage,$StrStateCourse,$StrTypecourse,$Intprice,$StrResumen,$StrDescripcion,$StrCategorie,$StrSubcategorie,$StrVideo,$StrNota);

                $SqlGetDataCourse->fetch();
                
                return array($IntIdCourse,$StrNameTeachC,$StrImage,$StrStateCourse,$StrTypecourse,$Intprice,$StrResumen,$StrDescripcion,$StrCategorie,$StrSubcategorie,$StrVideo,$StrNota);
                $SqlGetDataCourse->close();
            }
        }

        public function UpdatePartialDataCourse($IdCategorie,$StrNombreCurso,$StrResumen,$StrDescripcion,$StrCategoria,$StrSubCategoria,$StrIdYoutube,$StrTipoCurso,$IntPrecio,$IdCurso,$IdSession,$State){
            //Actualizamos los datos parciales dle curso
            $SqlUpdateData=$this->db()->prepare("UPDATE G_Cursos SET Int_Fk_IdCat=?,Vc_NombreCurso=?,Vc_ResumenCurso=?,Txt_DescripcionCompleta=?,Vc_Categoria=?,Vc_SubCategoria=?,Vc_VideoPromocional=?,Vc_TipoCurso=?,Int_PrecioCurso=? WHERE Id_Pk_Curso= ? AND Int_Fk_IdUsuario= ? AND Vc_EstadoCurso= ?");
            $SqlUpdateData->bind_param("isssssssiiis", $IdCategorie,$StrNombreCurso,$StrResumen,$StrDescripcion,$StrCategoria,$StrSubCategoria,$StrIdYoutube,$StrTipoCurso,$IntPrecio,$IdCurso,$IdSession,$State);
            if ($SqlUpdateData->execute()) {
                return true;
            }else{
                return false;
            }
        }

        public function UpdateAllDataCourse($IdCategorie,$StrNombreCurso,$StrResumen,$StrDescripcion,$StrCategoria,$StrSubCategoria,$StrIdYoutube,$ResFoto,$StrTipoCurso,$IntPrecio,$IdCurso,$IdSession,$State){
            //Actualizamos toda la información del curso
            $SqlUpdateData=$this->db()->prepare("UPDATE G_Cursos SET Int_Fk_IdCat=?,Vc_NombreCurso=?,Vc_ResumenCurso=?,Txt_DescripcionCompleta=?,Vc_Categoria=?,Vc_SubCategoria=?,Vc_VideoPromocional=?,Vc_Imagen_Promocional=?,Vc_TipoCurso=?,Int_PrecioCurso=? WHERE Id_Pk_Curso= ? AND Int_Fk_IdUsuario= ? AND Vc_EstadoCurso= ?");
            $SqlUpdateData->bind_param("issssssssiiis", $IdCategorie,$StrNombreCurso,$StrResumen,$StrDescripcion,$StrCategoria,$StrSubCategoria,$StrIdYoutube,$ResFoto,$StrTipoCurso,$IntPrecio,$IdCurso,$IdSession,$State);
            if ($SqlUpdateData->execute()) {
                return true;
            }else{
                return false;
            }
        }

        public function SendReviewCourse($State,$IdCourse,$IdSession){
            $SqlUpdateState=$this->db()->prepare("UPDATE G_Cursos SET Vc_EstadoCurso= ? WHERE Id_Pk_Curso= ? AND Int_Fk_IdUsuario= ?");
            $SqlUpdateState->bind_param("sii", $State,$IdCourse,$IdSession);
            if ($SqlUpdateState->execute()) {
                return true;
            }else{
                return false;
            }
        }

        public function GetPromotionalImgCourse($IdCourse){
            $SqlImage = $this->db()->prepare("SELECT Vc_Imagen_Promocional FROM G_Cursos WHERE Id_Pk_Curso = ?");
            $SqlImage->bind_param("i",$IdCourse);
            $SqlImage->execute();
            $SqlImage->store_result();
            $SqlImage->bind_result($image);
            $SqlImage->fetch();

            return $image;
            $SqlImage->close();
        }

        public function SQLDataVideos($IdPkCurso){
            $SqlGetNameVideos = $this->db()->prepare("SELECT Txt_NombreVideo,Id_Pk_VideosCurso,Vc_VideoArchivo FROM G_Videos_Curso WHERE Int_Fk_IdCurso = ?");
            $SqlGetNameVideos->bind_param("s",$IdPkCurso);
            $SqlGetNameVideos->execute();
            $SqlGetNameVideos->store_result();
            if ($SqlGetNameVideos->num_rows==0) {
                return false;
            }else{
                $SqlGetNameVideos->bind_result($NameVideo,$IntIdVideo,$Srcvideo);
                while($SqlGetNameVideos->fetch()){
                    $ArrayNameVideo[]=array($NameVideo,$IntIdVideo,$Srcvideo);
                }
                $SqlGetNameVideos->close();
                return $ArrayNameVideo;
            }
        }

        public function InsertVideoCourse($IdCurso,$StrName,$NameVideoFile){
            $SqlInsertVideo=$this->db()->prepare("INSERT INTO G_Videos_Curso (Int_Fk_IdCurso,Txt_NombreVideo,Vc_VideoArchivo) VALUES(?,?,?)");
            $SqlInsertVideo->bind_param("iss", $IdCurso,$StrName,$NameVideoFile);

            if ($SqlInsertVideo->execute()) {
                return true;
            }else{
                return false;
            }
        }

        public function SelectMaxIdVideo(){
            //sacamos el último Id Insertado
            $SqlGetVideoId=$this->db()->prepare("SELECT MAX(Id_Pk_VideosCurso) as IdVideo FROM G_Videos_Curso");
            $SqlGetVideoId->execute();
            $SqlGetVideoId->store_result();
            $SqlGetVideoId->bind_result($IdVideo);
            $SqlGetVideoId->fetch();

            return $IdVideo;
        }

        public function GetDataAndFileVideo($IdVideo,$IdUser){
            $SqlGetName=$this->db()->prepare("SELECT a.Vc_VideoArchivo FROM G_Videos_Curso AS a INNER JOIN G_Cursos AS b ON a.Int_Fk_IdCurso = b.Id_Pk_Curso  WHERE a.Id_Pk_VideosCurso = ? AND b.Int_Fk_IdUsuario = ?");
            $SqlGetName->bind_param("ii",$IdVideo,$IdUser);
            $SqlGetName->execute();
            $SqlGetName->store_result();
            if ($SqlGetName->num_rows == 0) {
                return false;
            }else{
                $SqlGetName->bind_result($NameVideo);
                $SqlGetName->fetch();

                return $NameVideo;
            }
            $SqlGetName->close;
        }

        public function DeleteCourse($IdVideo){
            $SqlDeleteVideo=$this->db()->prepare("DELETE FROM G_Videos_Curso WHERE Id_Pk_VideosCurso = ?");
            $SqlDeleteVideo->bind_param("i",$IdVideo);
            if ($SqlDeleteVideo->execute()) {
                return true;
            }else{
                return false;
            }
        }
    }
?>