<?php
class EntityBase{
    private $table;
    private $db;
    private $conectar;

    public function __construct($table, $adapter) {
        $this->table=(string) $table;
		$this->conectar = null;
		$this->db = $adapter;
    }
    
    public function getConetar(){
        return $this->conectar;
    }
    
    public function db(){
        return $this->db;
    }
    
    public function getAll(){
        $query=$this->db->query("SELECT * FROM $this->table ORDER BY id DESC");

        while ($row = $query->fetch_object()) {
           $resultSet[]=$row;
        }
        
        return $resultSet;
    }
    
    public function getById($id){
        $query=$this->db->query("SELECT * FROM $this->table WHERE id=$id");

        if($row = $query->fetch_object()) {
           $resultSet=$row;
        }
        
        return $resultSet;
    }

    public function getMaxId($id){
        $SqlGetId = $this->db->prepare("SELECT MAX($id) AS id FROM $this->table");
        $SqlGetId->execute();
        $SqlGetId->store_result();
        $SqlGetId->bind_result($IdBd);
        $SqlGetId->fetch();
        $ArrayData[]=array($IdBd);

        return $ArrayData;
    }
    
    public function getBy($column,$value){
        $query=$this->db->query("SELECT * FROM $this->table WHERE $column='$value'");

        while($row = $query->fetch_object()) {
           $resultSet[]=$row;
        }
        
        return $resultSet;
    }
    
    public function deleteById($id){
        $query=$this->db->query("DELETE FROM $this->table WHERE id=$id"); 
        return $query;
    }
    
    public function deleteBy($column,$value){
        $query=$this->db->query("DELETE FROM $this->table WHERE $column='$value'"); 
        return $query;
    }

    /*
     * Aqui podemos montarnos un monton de métodos que nos ayuden
     * a hacer operaciones con la base de datos de la entidad
     */
    
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
