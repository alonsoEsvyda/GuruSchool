<?php
/****GuruSchool-library V:0.1
define('DB_HOST','localhost'); 
define('DB_USER','avmsoluc_admin'); 
define('DB_PASS','Yousolicit1200'); 
define('DB_NAME','avmsoluc_GuruSchool'); 
define('DB_CHARSET','utf-8');*******/
//local
define('DB_HOST','localhost'); 
define('DB_USER','root'); 
define('DB_PASS',''); 
define('DB_NAME','GuruSchool'); 
define('DB_CHARSET','utf-8');

class Model 
{ 
    protected $_db; 

    public function __construct() 
    { 
        $this->_db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); 

        if ( $this->_db->connect_errno ) 
        { 
            echo "Fallo al conectar a MySQL: ". $this->_db->connect_error; 
            return;     
        } 

        $this->_db->set_charset(DB_CHARSET); 
    } 
} 
?>