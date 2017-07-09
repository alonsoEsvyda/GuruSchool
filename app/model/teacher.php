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
    }
?>