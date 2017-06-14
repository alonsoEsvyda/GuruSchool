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
    }
?>