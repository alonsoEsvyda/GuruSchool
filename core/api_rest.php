<?php
/**
* 
* @state IN PROCESS
*
*/
class Rest {    
    public function API(){
        header('Content-Type: application/json; charset=UTF-8');                
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
        case 'GET'://consulta
            return 'GET';
            break;     
        case 'POST'://inserta
            return 'POST';
            break;                
        case 'PUT'://actualiza
            return 'PUT';
            break;      
        case 'DELETE'://elimina
            return 'DELETE';
            break;
        default://metodo NO soportado
            return 'METODO NO SOPORTADO';
            break;
        }
    }
    
}
?>