<?php
    class Geographics extends EntityBase{
        private $id;
        private $nombre;
        private $apellido;
        private $email;
        private $password;
        
        public function __construct($adapter,$table) {
            parent::__construct($table, $adapter);
        }

        public function SQLGetDataCountry(){// taremos una lista de paises para insertarlos en un select
            $SqlGetDataCoun=$this->db()->prepare("SELECT Pais FROM Paises");
            $SqlGetDataCoun->execute();
            $SqlGetDataCoun->store_result();
            $SqlGetDataCoun->bind_result($Country);
            while ($SqlGetDataCoun->fetch()) {
                $ArrayCountry[]=array($Country);
            }
            $SqlGetDataCoun->close();
            return $ArrayCountry;
        }
        
    }
?>