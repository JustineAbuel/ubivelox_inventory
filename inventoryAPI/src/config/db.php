<?php
    class db{
        public function connect(){
            // $host = "localhost";
            // $user = "ubivelox";
            // $pass = "4#40mfQj";
            // $db="admin_ubivelox";
            
            $host = "localhost";
            $user = "root";
            $pass = "";
            $db="ubivelox_inventory";
            $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $pdo;
        }
    }
    ?>