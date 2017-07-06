<?php
    class users extends EntityBase{
        private $id;
        private $nombre;
        private $apellido;
        private $email;
        private $password;
        
        public function __construct($adapter,$table) {
            parent::__construct($table, $adapter);
        }

        public function GetDataUser($IdFkUser){
            $SqlGetDataUser=$this->db()->prepare("SELECT a.Int_Fk_IdUsuario,a.Vc_NombreUsuario,a.Txt_ImagenUsuario,a.Txt_ImagenMin,b.Txt_Biografia,b.Vc_Profesion,b.Txt_Facebook,b.Txt_Google,b.Txt_LinkedIn,b.Txt_Twitter FROM G_Datos_Usuario AS a INNER JOIN G_Profesion_Usuario AS b ON a.Int_Fk_IdUsuario=b.Int_Fk_DatosUsuario WHERE a.Int_Fk_IdUsuario = ? ");
            $SqlGetDataUser->bind_param("s", $IdFkUser);
            $SqlGetDataUser->execute();
            $SqlGetDataUser->store_result();
            if ($SqlGetDataUser->num_rows==0) {
                return false;
            }else{
                $SqlGetDataUser->bind_result($IntIdUser,$StrName,$StrImagenUser,$StrImageMin,$StrBiogra,$StrProfession,$StrFace,$StrGoogle,$StrLinked,$StrTwitt);
                $SqlGetDataUser->fetch();
                return array($IntIdUser,$StrName,$StrImagenUser,$StrImageMin,$StrBiogra,$StrProfession,$StrFace,$StrGoogle,$StrLinked,$StrTwitt);
                $SqlGetDataUser->close();
            }
        }

        public function GetEmailUser($IdUser){
            $SqlGetData=$this->db()->prepare("SELECT Vc_Correo FROM G_Usuario WHERE Id_Pk_Usuario = ?");
            $SqlGetData->bind_param("i", $IdUser);
            $SqlGetData->execute();
            $SqlGetData->store_result();
            $SqlGetData->bind_result($StrMail);
            $SqlGetData->fetch();
            $ArrayData=$StrMail;
            $SqlGetData->close();
            return $ArrayData;
        }

        public function GetPasswordHash($IdUser){
            $SQLValidatePass=$this->db()->prepare("SELECT Vc_Password FROM G_Usuario WHERE Id_Pk_Usuario = ?");
            $SQLValidatePass->bind_param("i", $IdUser);
            $SQLValidatePass->execute();
            $SQLValidatePass->store_result();
            if ($SQLValidatePass->num_rows==0) {
                return false;
            }else{
                $SQLValidatePass->bind_result($HashPassword);
                $SQLValidatePass->fetch();
                return $HashPassword;
            }
        }

        public function validateDataPersonalUser($IdUser){
            $SqlGetData=$this->db()->prepare("SELECT a.Vc_NombreUsuario,a.Int_Cedula,a.Int_Edad,a.Vc_Pais,a.Vc_Ciudad,b.Vc_Correo FROM G_Datos_Usuario AS a INNER JOIN G_Usuario AS b ON a.Int_Fk_IdUsuario=b.Id_Pk_Usuario WHERE a.Int_Fk_IdUsuario = ?");
            $SqlGetData->bind_param("i", $IdUser);
            $SqlGetData->execute();
            $SqlGetData->store_result();
            $SqlGetData->bind_result($Name,$Dni,$Age,$Country,$City,$MailUser);
            $SqlGetData->fetch();
            return array($Name,$Dni,$Age,$Country,$City,$MailUser);
        }

        public function ValidateIssetDatUser($IdUser){//validamos que el usuario tenga llenos sus datos principales
            $SqlGetData=$this->db()->prepare("SELECT Vc_NombreUsuario,Int_Cedula,Int_Edad,Vc_Pais,Vc_Ciudad FROM G_Datos_Usuario WHERE Int_Fk_IdUsuario = ?");
            $SqlGetData->bind_param("i", $IdUser);
            $SqlGetData->execute();
            $SqlGetData->store_result();
            if ($SqlGetData->num_rows==0){
                return false;
            }else{
                return true;
            }
        }

        public function ValidateDataProfessional($IdUser){//validamos que el usuario tenga llenos sus datos PROFESIONALES
            $SqlGetData=$this->db()->prepare("SELECT Vc_Profesion,Txt_Biografia FROM G_Profesion_Usuario WHERE Int_Fk_DatosUsuario = ?");
            $SqlGetData->bind_param("i", $IdUser);
            $SqlGetData->execute();
            $SqlGetData->store_result();
            if ($SqlGetData->num_rows==0){
                return false;
            }else{
                return true;
            }
        }

        public function ValidateAllDataProfessional($IdSession){
            $SqlValidate=$this->db()->prepare("SELECT Vc_Profesion,Txt_Biografia,Txt_Facebook,Txt_Twitter,Txt_Google,Txt_LinkedIn FROM G_Profesion_Usuario WHERE Int_Fk_DatosUsuario = ?");
            $SqlValidate->bind_param("i",$IdSession);
            $SqlValidate->execute();
            $SqlValidate->store_result();
            if ($SqlValidate->num_rows == 0) {
                return false;
            }else{
                return true;
            }
        }

        public function ValidateDataAccount($IdUser){//validamos que el usuario halla llenado los datos bancarios
            $SqlGetData=$this->db()->prepare("SELECT Vc_Cuenta FROM G_Cuenta_Usuario WHERE Int_Fk_DatosUsuario = ?");
            $SqlGetData->bind_param("i", $IdUser);
            $SqlGetData->execute();
            $SqlGetData->store_result();
            if ($SqlGetData->num_rows==0){
                return false;
            }else{
                return true;
            }
        }

        public function InsertDataBank($SessionId,$CryptAccount,$StrBank){
            $SqlInsertData=$this->db()->prepare("INSERT INTO G_Cuenta_Usuario (Int_Fk_DatosUsuario,Vc_Cuenta,Vc_Banco) VALUES (?,?,?) ");
            $SqlInsertData->bind_param("iss", $SessionId,$CryptAccount,$StrBank);
            if ($SqlInsertData->execute()) {
                return true;
            }else{
                return false;
            }
        }

        public function UpdateDataBank($CryptAccount,$StrBank,$SessionId){
            $SqlInsertData=$this->db()->prepare("UPDATE G_Cuenta_Usuario SET Vc_Cuenta=?, Vc_Banco=? WHERE  Int_Fk_DatosUsuario = ?");
            $SqlInsertData->bind_param("ssi", $CryptAccount,$StrBank,$SessionId);
            if ($SqlInsertData->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function InsertDataProfessional($IdSession,$StrProfession,$StrBiografia,$UrlFacebook,$UrlTwitter,$UrlGoogle,$UrlLinkedIn){
            $SqlInsertData = $this->db()->prepare("INSERT INTO G_Profesion_Usuario (Int_Fk_DatosUsuario,Vc_Profesion,Txt_Biografia,Txt_Facebook,Txt_Twitter,Txt_Google,Txt_LinkedIn) VALUES (?,?,?,?,?,?,?) ");
            $SqlInsertData->bind_param("issssss",$IdSession,$StrProfession,$StrBiografia,$UrlFacebook,$UrlTwitter,$UrlGoogle,$UrlLinkedIn);
            if ($SqlInsertData->execute()) {
                return true;
            }else{
                return false;
            }
        }

        public function UpdateDataProfessional($StrProfession,$StrBiografia,$UrlFacebook,$UrlTwitter,$UrlGoogle,$UrlLinkedIn,$IdSession){
            $SqlInsertData=$this->db()->prepare("UPDATE G_Profesion_Usuario SET Vc_Profesion=?,Txt_Biografia=?,Txt_Facebook=?,Txt_Twitter=?,Txt_Google=?,Txt_LinkedIn=? WHERE  Int_Fk_DatosUsuario = ?");
            $SqlInsertData->bind_param("ssssssi",$StrProfession,$StrBiografia,$UrlFacebook,$UrlTwitter,$UrlGoogle,$UrlLinkedIn,$IdSession);
            if ($SqlInsertData->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function DataUserPersonal($IdUser){//Traemos datos principales del usuario
            $SqlGetData=$this->db()->prepare("SELECT Vc_NombreUsuario,Int_Cedula,Int_Edad,Vc_Pais,Vc_Ciudad,Txt_ImagenUsuario,Txt_ImagenMin,Vc_Telefono FROM G_Datos_Usuario WHERE Int_Fk_IdUsuario = ?");
            $SqlGetData->bind_param("i", $IdUser);
            $SqlGetData->execute();
            $SqlGetData->store_result();
            if ($SqlGetData->num_rows==0) {
                 $ArrayData=0;
            }else{
                $SqlGetData->bind_result($StrName,$IntDni,$IntAge,$StrCountry,$StrCity,$StrImage,$StrImagenMin,$IntTelf);
                $SqlGetData->fetch();
                $ArrayData[]=array($StrName,$IntDni,$IntAge,$StrCountry,$StrCity,$StrImage,$StrImagenMin,$IntTelf);
            }
            $SqlGetData->close();
            return $ArrayData;
        }

        public function InsertDataPersonal($StrName,$IntDni,$StrAge,$StrCountry,$StrCity,$resFoto,$minFoto,$SessionId,$IntTelf){
            $SqlUpdateData=$this->db()->prepare("INSERT INTO G_Datos_Usuario (Vc_NombreUsuario,Int_Cedula,Int_Edad,Vc_Pais,Vc_Ciudad,Txt_ImagenUsuario,Txt_ImagenMin,Int_Fk_IdUsuario,Vc_Telefono) VALUES (?,?,?,?,?,?,?,?,?) ");
            $SqlUpdateData->bind_param("siissssii",$StrName,$IntDni,$StrAge,$StrCountry,$StrCity,$resFoto,$minFoto,$SessionId,$IntTelf);
            if ($SqlUpdateData->execute()) {
                return true;
            }else{
                return false;
            }
        }

        public function UpdateDataUser($StrName,$IntDni,$StrAge,$StrCountry,$StrCity,$resFoto,$minFoto,$IntTelf,$SessionId){
            //Actualizamos los datos
            $SqlUpdateData=$this->db()->prepare("UPDATE G_Datos_Usuario SET Vc_NombreUsuario=?,Int_Cedula=?,Int_Edad=?,Vc_Pais=?,Vc_Ciudad=?,Txt_ImagenUsuario=?,Txt_ImagenMin=?,Vc_Telefono=? WHERE Int_Fk_IdUsuario = ? ");
            $SqlUpdateData->bind_param("siissssii",$StrName,$IntDni,$StrAge,$StrCountry,$StrCity,$resFoto,$minFoto,$IntTelf,$SessionId);
            if ($SqlUpdateData->execute()) {
                return true;
            }else{
                return false;
            }
        }

        public function UpdateDataWithOutPhoto($StrName,$IntDni,$StrAge,$StrCountry,$StrCity,$IntTelf,$SessionId){
            $SqlUpdateData = $this->db()->prepare("UPDATE G_Datos_Usuario SET Vc_NombreUsuario=?,Int_Cedula=?,Int_Edad=?,Vc_Pais=?,Vc_Ciudad=?,Vc_Telefono=? WHERE Int_Fk_IdUsuario = ?");
            $SqlUpdateData->bind_param("siissii",$StrName,$IntDni,$StrAge,$StrCountry,$StrCity,$IntTelf,$SessionId);
            if ($SqlUpdateData->execute()) {
                return true;
            }else{
                return false;
            }
        }

        public function DataUserProfesional($IdUser){//Traemos datos profesionales del usuario
            $SqlGetData=$this->db()->prepare("SELECT Vc_Profesion,Txt_Biografia FROM G_Profesion_Usuario WHERE Int_Fk_DatosUsuario = ?");
            $SqlGetData->bind_param("i", $IdUser);
            $SqlGetData->execute();
            $SqlGetData->store_result();
            if ($SqlGetData->num_rows==0) {
                $ArrayData=0;
            }else{
                $SqlGetData->bind_result($StrProfession,$StrBiografy);
                $SqlGetData->fetch();
                $ArrayData[]=array($StrProfession,$StrBiografy);
            }
            $SqlGetData->close();
            return $ArrayData;
        }

        public function GetDataCertified($IdUser){
            $SqlGetIdCourse=$this->db()->prepare("SELECT Int_IdCurso,Vc_NumberCertified FROM Certificados_Usuarios WHERE  Int_Fk_IdUsuario = ?");
            $SqlGetIdCourse->bind_param("i",$IdUser);
            $SqlGetIdCourse->execute();
            $SqlGetIdCourse->store_result();
                if ($SqlGetIdCourse->num_rows==0) {
                    $ArrayData=false;
                }else{
                    $SqlGetIdCourse->bind_result($IdCourse,$IntNumberCertified);
                    while ($SqlGetIdCourse->fetch()) {
                        $SqlGetCourse=$this->db()->prepare("SELECT Id_Pk_Curso,Vc_NombreCurso,Vc_Imagen_Promocional,Int_Fk_IdUsuario FROM G_Cursos WHERE  Id_Pk_Curso = ?");
                        $SqlGetCourse->bind_param("i",$IdCourse);
                        $SqlGetCourse->execute();
                        $SqlGetCourse->store_result();
                        $SqlGetCourse->bind_result($IntIdCourse,$StrNameCourse,$StrImage,$IntIdUser);
                        $SqlGetCourse->fetch();
                        $ArrayData[]=array($IntIdCourse,$StrNameCourse,$StrImage,$IntIdUser,$IntNumberCertified);
                    }
                }
            $SqlGetIdCourse->close();
            return $ArrayData;
        }

        public function ValidateissetCertified($IdCourse,$IdUser,$NumberCertified){
            //validamos que el curso pertenezca al usuario
            $SqlValidate=$this->db()->prepare("SELECT Int_IdCurso FROM Certificados_Usuarios WHERE Int_IdCurso = ? AND Int_Fk_IdUsuario = ? AND Vc_NumberCertified = ?");
            $SqlValidate->bind_param("iii", $IdCourse,$IdUser,$NumberCertified);
            $SqlValidate->execute();
            $SqlValidate->store_result();
            if ($SqlValidate->num_rows == 0) {
                return false;
            }else{
                return true;
            }
        }

        public function GetDataUserCertified($IdCourse,$IdUser){
            $SqlGetData=$this->db()->prepare("SELECT a.Vc_NombreCurso,b.Vc_NombreUsuario,b.Int_Cedula,c.Vc_NumberCertified FROM Certificados_Usuarios AS c INNER JOIN G_Cursos AS a ON c.Int_IdCurso=a.Id_Pk_Curso INNER JOIN G_Datos_Usuario AS b ON c.Int_Fk_IdUsuario=b.Int_Fk_IdUsuario WHERE c.Int_IdCurso = ? AND c.Int_Fk_IdUsuario = ?");
            $SqlGetData->bind_param("ii",$IdCourse,$IdUser);
            $SqlGetData->execute();
            $SqlGetData->store_result();
            $SqlGetData->bind_result($StrNameCourse,$StrNameUser,$IntDniUser,$IntCertified);
            $SqlGetData->fetch();
            return array($StrNameCourse,$StrNameUser,$IntDniUser,$IntCertified);
            $SqlGetData->close();
        }

        public function GetSocialMediaUser($IdUser){
            $SqlGetData=$this->db()->prepare("SELECT Txt_Facebook,Txt_Google,Txt_LinkedIn,Txt_Twitter FROM G_Profesion_Usuario WHERE Int_Fk_DatosUsuario= ?");
            $SqlGetData->bind_param("i", $IdUser);
            $SqlGetData->execute();
            $SqlGetData->store_result();
            if ($SqlGetData->num_rows==0) {
                $ArrayData=false;
            }else{
                $SqlGetData->bind_result($Face,$Google,$Linked,$Twitt);
                $SqlGetData->fetch();
                $ArrayData[]=array($Face,$Google,$Linked,$Twitt);
            }
            $SqlGetData->close();
            return $ArrayData;
        }

        public function ReturnIdEmail($Email){
            $SqlGetData=$this->db()->prepare("SELECT Id_Pk_Usuario FROM G_Usuario WHERE Vc_Correo = ?");
            $SqlGetData->bind_param("s", $Email);
            $SqlGetData->execute();
            $SqlGetData->store_result();
            $SqlGetData->bind_result($StrId);
            $SqlGetData->fetch();
            $ArrayData=$StrId;
            $SqlGetData->close();
            return $ArrayData;
        }

        public function GetAccountUser($IdUser){
            $SqlGetData=$this->db()->prepare("SELECT Vc_Cuenta,Vc_Banco FROM G_Cuenta_Usuario WHERE Int_Fk_DatosUsuario= ?");
            $SqlGetData->bind_param("i", $IdUser);
            $SqlGetData->execute();
            $SqlGetData->store_result();
            if ($SqlGetData->num_rows==0) {
                $ArrayData=0;
            }else{
                $SqlGetData->bind_result($Account,$Bank);
                $SqlGetData->fetch();
                $ArrayData[]=array($Account,$Bank);
            }
            $SqlGetData->close();
            return $ArrayData;
        }

        public function UpdatePasswordUser($StrPassHash,$IdUser){
            //Actualizamos la contraseña 
            $SQLUpdate=$this->db()->prepare("UPDATE G_Usuario SET Vc_Password = ?  WHERE Id_Pk_Usuario = ? ");
            $SQLUpdate->bind_param("si",$StrPassHash,$IdUser);
            //verificamos que se ejecute correctamente la consulta
            if ($SQLUpdate->execute()) {
                return true;
            }else{
                return false;
            }
        }
    }
?>