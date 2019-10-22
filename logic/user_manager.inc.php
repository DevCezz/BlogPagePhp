<?php
    require_once('db_conn.inc.php');

    class UserManager {
        public function createUser($userName, $userPassword, $repeatedUserPassword, $userEmail) {
            if($userName == '' or $userPassword == '' or $repeatedUserPassword == '' or $userEmail == '') {
                throw new Exception('Nie podano wszystkich danych wejściowych przy tworzeniu konta.');
            }

            if($userPassword != $repeatedUserPassword) {
                throw new Exception('Podane hasła są różne.');
            }

            $connection = DBConn::getConnection();

            $checkedUserName = $connection->real_escape_string($userName);
            $checkedUserEmail = $connection->real_escape_string($userEmail);
            $userPasswordMD5 = md5($userPassword);

            try {
                if($this->checkIfUserExists($checkedUserName)) {
                    return FALSE;
                }

                $insertUserQuery = "INSERT INTO user(`username`, `password`, `email`) values ('$checkedUserName', '$userPasswordMD5', '$checkedUserEmail')";
                $result = $connection->query($insertUserQuery);

                if($result === FALSE) {
                    throw new Excepton("Zapytanie do bazy danych nie powiodło się.");
                }
            } catch(Exception $exeption) {
                if(isset($connection)) {
                    $connection->close();
                }

                throw $exeption;
            }

            $connection->close();
            return TRUE;
        }

        private function checkIfUserExists($checkedUserName) {
            $connection = DBConn::getConnection();

            $selectUserByUsernameQuery = "SELECT * FROM `user` WHERE username = '$checkedUserName'";
            $result = $connection->query($selectUserByUsernameQuery);

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