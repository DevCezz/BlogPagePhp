<?php
    class DbConn {
        public static function getConnection() {
            $host = "127.0.0.1";
            $db_user = "root";
            $db_password = "root";
            $db_name = "php_nielip";
    
            $connection = new mysqli($host, $db_user, $db_password, $db_name);
    
            if (mysqli_connect_errno() != 0) {
                throw new Exception('Nie udało się nawiązać połączenia.');
            }
    
            return $connection;
        }
    }
?>