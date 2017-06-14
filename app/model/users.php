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

        public function validateDataPersonalUser($IdUser){
            $SqlGetData=$this->db()->prepare("SELECT a.Vc_NombreUsuario,a.Int_Cedula,a.Int_Edad,a.Vc_Pais,a.Vc_Ciudad,b.Vc_Correo FROM G_Datos_Usuario AS a INNER JOIN G_Usuario AS b ON a.Int_Fk_IdUsuario=b.Id_Pk_Usuario WHERE a.Int_Fk_IdUsuario = ?");
            $SqlGetData->bind_param("i", $IdUser);
            $SqlGetData->execute();
            $SqlGetData->store_result();
            $SqlGetData->bind_result($Name,$Dni,$Age,$Country,$City,$MailUser);
            $SqlGetData->fetch();
            return array($Name,$Dni,$Age,$Country,$City,$MailUser);
        }
    }
?>