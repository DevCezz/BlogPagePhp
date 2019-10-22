<?php
    class DbConn {
        private $host = "127.0.0.1";
        private $db_user = "root";
        private $db_password = "root";
        private $db_name = "csanecki_blog";

        private $connection;

        public function __construct() {
            $this->connection = new mysqli($this->host, $this->db_user, $this->db_password, $this->db_name);

            if (mysqli_connect_errno() != 0) {
                throw new Exception('Nie udało się nawiązać połączenia.');
            }
        }

        public function getConnection() {    
            return $this->connection;
        }
    }
?>