<?php
    class DbConn {
        private static $host = "127.0.0.1";
        private static $db_user = "root";
        private static $db_password = "root";
        private static $db_name = "csanecki_blog";

        public static function getConnection() {  
            $connection = new mysqli(self::$host, self::$db_user, self::$db_password, self::$db_name);

            if (mysqli_connect_errno() != 0) {
                throw new Exception('Nie udało się nawiązać połączenia.');
            }
            
            return $connection;
        }
    }
?>