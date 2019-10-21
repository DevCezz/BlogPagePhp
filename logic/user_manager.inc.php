<?php
    require_once('db_conn.inc.php');

    class UserManager {
        private $dbConn;

        public function __construct() {
            $dbConn = DbConn::getConnection();
        }

        public function createUser($userName, $userPassword, $repeatedUserPassword, $userEmail) {
            if($userName == '' or $userPassword == '' or $repeatedUserPassword == '' or $userEmail == '') {
                throw new Exception('Nie podano wszystkich danych wejściowych przy tworzeniu konta.');
            }

            if($userPassword != $repeatedUserPassword) {
                throw new Exception('Podane hasła są różne.');
            }

            $checkedUserName = $dbConn->real_escape_string($userName);
            $checkedUserEmail = $dbConn->real_escape_string($userEmail);
            $userPasswordMD5 = md5($userPassword);

            try {
                if($this->checkIfUserExists($checkedUserName)) {
                    return FALSE;
                }

                $insertUserQuery = "INSERT INTO user(`username`, `password`, `email`) values ('$checkedUserName', '$userPasswordMD5', '$checkedUserEmail')";
                $result = $dbConn->query($insertUserQuery);

                if($result === FALSE) {
                    throw new Excepton("Zapytanie do bazy danych nie powiodło się.");
                }
            } catch(Exception $exeption) {
                if(isset($dbConn)) {
                    $dbConn->close();
                }

                throw $exeption;
            }

            $dbConn->close();
            return TRUE;
        }

        private function checkIfUserExists($checkedUserName) {
            $selectUserByUsernameQuery = "SELECT * FROM `user` WHERE username = '$checkedUserName'";
            $result = $dbConn->query($selectUserByUsernameQuery);

            if ($result === FALSE) {
                throw new Excepton("Zapytanie do bazy danych nie powiodło się.");
            }
                
            if (($row = $result->fetch_assoc()) === NULL) {
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }
?>