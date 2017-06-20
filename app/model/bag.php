<?php
    class Bag extends EntityBase{
        private $id;
        private $nombre;
        private $apellido;
        private $email;
        private $password;
        
        public function __construct($adapter,$table) {
            parent::__construct($table, $adapter);
        }

        public function GetViewAllVacancy($State){
            $SqlGetData=$this->db()->prepare("SELECT Id_Pk_Vacante,Vc_Empresa,Vc_NombreVacante,Txt_DescripcionVacante,Vc_Categoria,Vc_Pais,Vc_Ciudad,Da_Fecha FROM vw_vacantes WHERE  Vc_EstadoVacante=? ORDER BY RAND() LIMIT 50 ");
            $SqlGetData->bind_param("s",$State);
            $SqlGetData->execute();
            $SqlGetData->store_result();
                if ($SqlGetData->num_rows==0) {
                    $ArrayData=false;
                }else{
                    $SqlGetData->bind_result($IdVacancy,$NameCompany,$NameVacancy,$Description,$Categorie,$Country,$City,$Date);
                    while ($SqlGetData->fetch()) {
                        $ArrayData[]=array($IdVacancy,$NameCompany,$NameVacancy,$Description,$Categorie,$Country,$City,$Date);
                    }
                }
            $SqlGetData->close();
            return $ArrayData;
        }

        public function GetVacancyUser($IdUser){
            $SqlGetDataVacancy=$this->db()->prepare("SELECT Id_Pk_Vacante,Vc_NombreVacante,Vc_Pais,Vc_Ciudad,Vc_Categoria,Txt_DescripcionVacante,Da_Fecha FROM G_Vacantes WHERE Int_Fk_IdUsuario=? ");
            $SqlGetDataVacancy->bind_param("i",$IdUser);
            $SqlGetDataVacancy->execute();
            $SqlGetDataVacancy->store_result();
                if ($SqlGetDataVacancy->num_rows==0) {
                    $ArrayData=false;
                }else{
                    $SqlGetDataVacancy->bind_result($IdVacancy,$Vacancy,$Country,$City,$Categorie,$Description,$Date);
                    while ($SqlGetDataVacancy->fetch()) {
                        $ArrayData[]=array($IdVacancy,$Vacancy,$Country,$City,$Categorie,$Description,$Date);
                    }
                }
            $SqlGetDataVacancy->close();
            return $ArrayData;
        }

        public function SearchJobs($City,$Country,$Categorie,$Type,$State){
            if ($City != NULL) {
                //creamos la consulta que nos retorna los datos
                $SqlGetData=$this->db()->prepare("SELECT Id_Pk_Vacante,Vc_Empresa,Vc_NombreVacante,Txt_DescripcionVacante,Vc_Categoria,Vc_Pais,Vc_Ciudad,Da_Fecha FROM G_Vacantes WHERE Vc_Pais= ? AND Vc_Ciudad=? AND Vc_Categoria= ? AND Vc_TipoVacante= ? AND Vc_EstadoVacante=? ");
                $SqlGetData->bind_param("sssss", $Country,$City,$Categorie,$Type,$State);
            }else{
                //creamos la consulta que nos retorna los datos
                $SqlGetData=$this->db()->prepare("SELECT Id_Pk_Vacante,Vc_Empresa,Vc_NombreVacante,Txt_DescripcionVacante,Vc_Categoria,Vc_Pais,Vc_Ciudad,Da_Fecha FROM G_Vacantes WHERE Vc_Pais= ? AND Vc_Categoria= ? AND Vc_TipoVacante= ? AND Vc_EstadoVacante=? ");
                $SqlGetData->bind_param("ssss", $Country,$Categorie,$Type,$State);
            }
            $SqlGetData->execute();
            $SqlGetData->store_result();
            if ($SqlGetData->num_rows == 0){
                $ArrayData[] = array("bool"=>"false");
            }else{
                $SqlGetData->bind_result($IdVacancy,$NameCompany,$NameVacancy,$Description,$Categorie,$Country,$cit,$Date);
                while ($SqlGetData->fetch()) {
                   $ArrayData[] = array("bool"=>"true","IdVacancy"=>$IdVacancy,"NameCompany"=>$NameCompany,"NameVacancy"=>$NameVacancy,"Description"=>strip_tags($Description),"Categorie"=>$Categorie,"Country"=>$Country,"City"=>$cit,"Date"=>$Date);
                }
            }
            $SqlGetData->close();
            return $ArrayData;
        }

        public function GetDataVacancy($IdVacancy,$State){
            $SqlGetDataVacancy=$this->db()->prepare("SELECT a.Vc_Empresa,a.Vc_NombreVacante,a.Vc_Pais,a.Vc_Ciudad,a.Vc_Categoria,a.Vc_TipoVacante,a.Int_Salario,a.Int_NumVacantes,a.Vc_Correo,a.Txt_DescripcionVacante,b.Vc_NombreUsuario,b.Txt_ImagenUsuario,a.Da_Fecha FROM G_Vacantes AS a INNER JOIN G_Datos_Usuario AS b ON a.Int_Fk_IdUsuario=b.Int_Fk_IdUsuario WHERE a.Id_Pk_Vacante=? AND a.Vc_EstadoVacante=?");
            $SqlGetDataVacancy->bind_param("is",$IdVacancy,$State);
            $SqlGetDataVacancy->execute();
            $SqlGetDataVacancy->store_result();
                if ($SqlGetDataVacancy->num_rows==0) {
                    $ArrayData=false;
                }else{
                    $SqlGetDataVacancy->bind_result($Company,$NameVacancy,$Country,$City,$Cat,$Type,$Salary,$NumVacancy,$Email,$Description,$NameUser,$ImageUser,$Date);
                    $SqlGetDataVacancy->fetch();
                    $ArrayData[]=array($Company,$NameVacancy,$Country,$City,$Cat,$Type,$Salary,$NumVacancy,$Email,$Description,$NameUser,$ImageUser,$Date);
                }
            $SqlGetDataVacancy->close();
            return $ArrayData;
        }

        public function InsertVacancy($IdUser,$Company,$Vacancy,$Country,$City,$Categorie,$TypeJob,$Salary,$NumVacancy,$Email,$Description,$State,$Fecha){
            $SqlInsert=$this->db()->prepare("INSERT INTO G_Vacantes (Int_Fk_IdUsuario,Vc_Empresa,Vc_NombreVacante,Vc_Pais,Vc_Ciudad,Vc_Categoria,Vc_TipoVacante,Int_Salario,Int_NumVacantes,Vc_Correo,Txt_DescripcionVacante,Vc_EstadoVacante,Da_Fecha) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $SqlInsert->bind_param("issssssiissss",$IdUser,$Company,$Vacancy,$Country,$City,$Categorie,$TypeJob,$Salary,$NumVacancy,$Email,$Description,$State,$Fecha);
            if ($SqlInsert->execute()) {
                return true;
            }else{
                return false;
            }
        }

        public function DeleteVacancy($DataIdSane,$IdUser){
            //eliminamos la vacante
            $SqlDeelete=$this->db()->prepare("DELETE FROM G_Vacantes WHERE Id_Pk_Vacante = ? AND Int_Fk_IdUsuario = ?");
            $SqlDeelete->bind_param("ii",$DataIdSane,$IdUser);
              if ($SqlDeelete->execute()) {
                return  true;
              }else{
                return  false;
              }
        }
        
    }
?>