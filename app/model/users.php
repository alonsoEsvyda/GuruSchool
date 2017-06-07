<?php
    class users extends EntityBase{
        private $id;
        private $nombre;
        private $apellido;
        private $email;
        private $password;
        
        public function __construct($adapter) {
            $table="G_Datos_Usuario";
            parent::__construct($table, $adapter);
        }

        //Cuantos estudiantes están apuntados
        public function SQLStudentsIn($IdCurso){
            $SqlGetDataCourse=$this->db()->prepare("SELECT COUNT(DISTINCT(Int_Fk_IdUsuario)) AS numero FROM G_Usuarios_Cursos WHERE Int_Fk_IdCurso= ? ");
            $SqlGetDataCourse->bind_param("i",$IdCurso);
            $SqlGetDataCourse->execute();
            $SqlGetDataCourse->store_result();
            $SqlGetDataCourse->bind_result($NumberStudents);
            $SqlGetDataCourse->fetch();
            if ($NumberStudents==0) {
                return 0;
            }else{
                return $NumberStudents;
                $SqlGetDataCourse->close();
            }
        }
    }
?>