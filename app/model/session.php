<?php
class Session extends EntityBase{
    private $id;
    private $nombre;
    private $apellido;
    private $email;
    private $password;
    
    public function __construct($adapter) {
        $table="G_Usuario";
        parent::__construct($table, $adapter);
    }

    public function validate_facebook($email,$token_id){
        $SqlGetDate=$this->db()->prepare("SELECT Id_Pk_Usuario,Vc_Correo,Vc_Password,Int_NivelUsuario,Vc_facebook_token FROM G_Usuario WHERE Vc_Correo= ? AND Vc_facebook_token = ? ");
        $SqlGetDate->bind_param("ss", $email,$token_id);
        $SqlGetDate->execute();
        $SqlGetDate->store_result();
            if ($SqlGetDate->num_rows!=0) {
                $SqlGetDate->bind_result($idBd,$MailBd,$PassBd,$NivelBd,$FcebookToken);
                while($SqlGetDate->fetch()){
                    $ArrayData[]=array($idBd,$MailBd,$PassBd,$NivelBd,$FcebookToken);
                }

                return $ArrayData;
            }else{
                return false;
            }
    }


    public function insert_data_facebook($email,$level,$token){
        $SqlInsert = $this->db()->prepare("INSERT INTO G_Usuario (Vc_Correo,Int_NivelUsuario,Vc_facebook_token) VALUES (?,?,?)");
        $SqlInsert->bind_param("sss", $email, $level,$token);
        if ($SqlInsert->execute()) {
            return true;
        }else{
            return false;
        }   
    }

    public function email_validate($email){
        $SqlCompare = $this->db()->prepare("SELECT Vc_Correo FROM G_Usuario WHERE Vc_Correo= ? ");//preparamos la consulta
        $SqlCompare->bind_param("s", $email);//asignamos el parametro
        if ($SqlCompare->execute()) {//ejecutamos la consulta
            $SqlCompare->store_result();//traemos el conjunto de resultados
            if ($NumRows = $SqlCompare->num_rows!=0) {//verificamos si el número de filas es diferente de 0
                return false;
            }else{
                return true; 
            }
        }else{
            echo $conexion->error;
        }
    }

    public function insert_user($email,$pass,$level){
        $SqlInsert = $this->db()->prepare("INSERT INTO G_Usuario (Vc_Correo,Vc_Password,Int_NivelUsuario) VALUES (?, ?, ?)");
        $SqlInsert->bind_param("sss", $email, $pass, $level);
        if ($SqlInsert->execute()) {
            return true;
        }else{
            return false;
        }
    }

    public function user_session($email){
        $SqlGetDate = $this->db()->prepare("SELECT Id_Pk_Usuario,Vc_Correo,Vc_Password,Int_NivelUsuario FROM G_Usuario WHERE Vc_Correo= ? ");//preparamos la consulta
        $SqlGetDate->bind_param("s", $email);//asignamos el parametro
        $SqlGetDate->execute();//ejecutamos la consulta
        $SqlGetDate->store_result();//traemos el conjunto de resultados
        if ($NumRows = $SqlGetDate->num_rows==0) {//validamos si la consulta no trajo ningún registro
            return false;
        }else{
            $SqlGetDate->bind_result($idBd,$MailBd,$PassBd,$NivelBd);//Asignamos variables a la consulta parametrizada
            while ($SqlGetDate->fetch()) {
                $ArrayData[]=array($idBd,$MailBd,$PassBd,$NivelBd);
            }

            return $ArrayData;
        }
    }
}
?>