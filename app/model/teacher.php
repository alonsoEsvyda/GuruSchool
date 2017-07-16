<?php
    class teacher extends EntityBase{
        private $id;
        private $nombre;
        private $apellido;
        private $email;
        private $password;
        
        public function __construct($adapter,$table) {
            parent::__construct($table, $adapter);
        }

        public function ChargeCourse($IdUser){//metodo para traer os pagos del usuario
            $SqlGetCharge=$this->db()->prepare("SELECT a.Int_Id_Curso,a.Int_MontoCurso,a.Vc_EstadoCobro,b.Vc_NombreCurso,b.Vc_Imagen_Promocional FROM Pagos_Usuarios AS a INNER JOIN 
                G_Cursos AS b ON a.Int_Id_Curso=b.Id_Pk_Curso  WHERE a.Int_Fk_GUsuario=?");
            $SqlGetCharge->bind_param("i",$IdUser);
            $SqlGetCharge->execute();
            $SqlGetCharge->store_result();
            if ($SqlGetCharge->num_rows==0) {
                $ArrayData=false;
            }else{
                $SqlGetCharge->bind_result($IntIdCourse,$IntMonto,$StrEstado,$StrNameCourse,$StrImage);
                while ($SqlGetCharge->fetch()) {
                    $ArrayData[]= array($IntIdCourse,$IntMonto,$StrEstado,$StrNameCourse,$StrImage);
                }
            }
            $SqlGetCharge->close();
            return $ArrayData;
        }

        public function ConfirmIdPayment($IdCourseSane){
            $SqlValidateUser=$this->db()->prepare("SELECT Int_Id_Curso FROM Pagos_Usuarios WHERE Int_Id_Curso= ?");
            $SqlValidateUser->bind_param("i",$IdCourseSane);
            $SqlValidateUser->execute();
            $SqlValidateUser->store_result();
            if ($SqlValidateUser->num_rows==0) {
                return false;
            }else{
                return true;
            }
        }

        public function GetActualAmmount($IdUser,$IdCourseSane){
            $SqlGetAmount=$this->db()->prepare("SELECT Int_MontoCurso FROM Pagos_Usuarios WHERE Int_Fk_GUsuario=? AND Int_Id_Curso= ? ");
            $SqlGetAmount->bind_param("ii",$IdUser,$IdCourseSane);
            $SqlGetAmount->execute();
            $SqlGetAmount->store_result();
            $SqlGetAmount->bind_result($IntAmmount);
            $SqlGetAmount->fetch();

            return $IntAmmount;
        }

        public function InsertAmmount($IdUser,$IdCourseSane,$SqlGetAmount,$StateCharge,$Date,$IntNumberPay){
            $SqlInsertData=$this->db()->prepare("INSERT INTO Cobros_Usuarios (Int_Fk_GUsuario,Int_Id_Curso,Int_MontoCobrado,Vc_EstadoCobro,Da_FechaCobro,Int_NumerPay) VALUES (?,?,?,?,?,?)");
            $SqlInsertData->bind_param("iiissi",$IdUser,$IdCourseSane,$SqlGetAmount,$StateCharge,$Date,$IntNumberPay);
            if ($SqlInsertData->execute()) {
                return true;
            }else{
                return false;
            }
        }

        public function DeleteAmmount($IdCourseSane,$IdUser){
            $SqlDeleteDataUser=$this->db()->prepare("DELETE FROM Pagos_Usuarios WHERE Int_Id_Curso=? AND Int_Fk_GUsuario=?");
            $SqlDeleteDataUser->bind_param("ii",$IdCourseSane,$IdUser);
            if ($SqlDeleteDataUser->execute()) {
                return true;
            }else{
                return false;
            }
        }

        public function PaymentsCourse($IdUser){
            $SqlGetPayment=$this->db()->prepare("SELECT a.Int_MontoCobrado,a.Vc_EstadoCobro,a.Da_FechaCobro,b.Vc_NombreCurso,a.Int_NumerPay FROM Cobros_Usuarios AS a INNER JOIN G_Cursos AS b ON a.Int_Id_Curso=b.Id_Pk_Curso WHERE a.Int_Fk_GUsuario = ? ");
            $SqlGetPayment->bind_param("i",$IdUser);
            $SqlGetPayment->execute();
            $SqlGetPayment->store_result();
            if ($SqlGetPayment->num_rows==0) {
                $ArrayData=false;
            }else{
                $SqlGetPayment->bind_result($IntAmmount,$StrState,$StrDate,$StrNameCourse,$IntNumberPay);
                while ($SqlGetPayment->fetch()) {
                    $ArrayData[] = array($IntAmmount,$StrState,$StrDate,$StrNameCourse,$IntNumberPay);
                }
            }
            $SqlGetPayment->close();
            return $ArrayData;
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
    }
?>