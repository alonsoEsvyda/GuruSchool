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
    }
?>