<?php
   define("HOST","127.0.0.1");
   define("USER","root");
   define("PASSWORD","");
   define("DATABASE","bioblioteca");
   
   function connexio() {        
        $mysqli = new mysqli(HOST,USER,PASSWORD,DATABASE);
        if ($mysqli->connect_error) {           
          die('Connect Error (' . $mysqli->connect_errno . ') '. $mysqli->connect_error);
         }
        $mysqli->set_charset("utf8");
        return $mysqli;
    }

    function consulta($mysqli,$sql) {        
       $result=  $mysqli->query($sql)  or die("<h4>Operació Incorrecta. Consulta:$sql</h4>");    
       return $result;     
    }    
    
    function escapa($mysqli,$text) {
        return $mysqli->real_escape_string($text);
    }

