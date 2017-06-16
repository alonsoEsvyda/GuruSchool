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
                $SqlGetData->bind_result($IdVacancy,$NameCompany,$NameVacancy,$Description,$Categorie,$Country,$City,$Date);
                while ($SqlGetData->fetch()) {
                   $ArrayData[] = array("bool"=>"true","IdVacancy"=>$IdVacancy,"NameCompany"=>$NameCompany,"NameVacancy"=>$NameVacancy,"Description"=>strip_tags($Description),"Categorie"=>$Categorie,"Country"=>$Country,"City"=>$City,"Date"=>$Date);
                }
            }
            $SqlGetData->close();
            return $ArrayData;
        }
        
    }
?>