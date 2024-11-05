<?php

    function conectarDB(): mysqli{
        $db = mysqli_connect("127.0.0.1", "root", "", "industrial_maintenance", 3306);

        if($db){
            
        } else{
            echo "Conexion fallida";
        }
        return $db;
    }

?>