<?php
    require_once('dbConn.inc.php');

    class UserManager {
        public function checkIfUserIsLoggedIn($sessionId) {
            $connection = DBConn::getConnection();

            try {
                $checkedSessionId = $connection->real_escape_string($sessionId);

                $selectLogUserQuery = "SELECT `user_name` FROM `logged_user` lu INNER JOIN `user` u ON u.`id`=lu.`user_id` WHERE `session_id` = '$checkedSessionId'";
                $result = $connection->query($selectLogUserQuery);

                if($result === FALSE) {
                    $connection->close();
                    throw new Excepton("Zapytanie do bazy danych nie powiodło się.");
                }

                if (($row = $result->fetch_assoc()) === NULL) {
                    $loggedUserName = null;
                } else {
                    $loggedUserName = $row['user_name'];
                }

            } catch(Exception $exeption) {
                if(isset($connection)) {
                    $connection->close();
                }

                throw $exeption;
            }

            $result->close();
            $connection->close();

            return $loggedUserName;
        }

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
                    $connection->close();
                    return FALSE;
                }

                $insertUserQuery = "INSERT INTO `user`(`user_name`, `password`, `email`) values ('$checkedUserName', '$userPasswordMD5', '$checkedUserEmail')";
                $result = $connection->query($insertUserQuery);

                if($result === FALSE) {
                    $connection->close();
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

            $selectUserByUserNameQuery = "SELECT * FROM `user` WHERE `user_name` = '$checkedUserName'";
            $result = $connection->query($selectUserByUserNameQuery);

            if ($result === FALSE) {
                throw new Excepton("Zapytanie do bazy danych nie powiodło się.");
            }
                
            if (($row = $result->fetch_assoc()) === NULL) {
                $userExists = FALSE;
            } else {
                $userExists = TRUE;
            }

            $result->close();
            return $userExists;
        }

        public function login($userName, $userPassword) {
            if($userName == '' or $userPassword == '') {
                throw new Exception('Podano błędne dane do logowania.');
            }

            try {
                $successfulLogin = $this->checkUserNameAndPassword($userName, $userPassword);

                if ($successfulLogin === FALSE) {
                    return FALSE;
                }
    
                $this->setUserLog($userName);
            } catch(Exception $exeption) {
                throw $exeption;
            }

            return TRUE;
        }

        private function checkUserNameAndPassword($userName, $userPassword) {
            $connection = DBConn::getConnection();      

            $checkedUserName = $connection->real_escape_string($userName);
            $userPasswordMD5 = md5($userPassword);

            $selectLoginQuery = "SELECT * FROM `user` WHERE `user_name` = '$checkedUserName' AND `password` = '$userPasswordMD5'";
            $result = $connection->query($selectLoginQuery);

            if ($result === FALSE) {
                $connection->close();
                throw new Exception("Zapytanie do bazy danych nie powiodło się.");
            }
            
            if (($row = $result->fetch_assoc()) === NULL) {
                $isChecked = FALSE;
            } else {
                $isChecked = TRUE;
            }

            $result->close();
            $connection->close();

            return $isChecked;
        }

        public function logout() {
            $connection = DBConn::getConnection();

            try {
                $checkedSessionId = $connection->real_escape_string(session_id());
                $deleteLoggedUserQuery = "DELETE FROM `logged_user` WHERE `session_id` = '$checkedSessionId'";
                $result = $connection->query($deleteLoggedUserQuery);

                if ($result === FALSE) {
                    $connection->close();
                    throw new Exception("Zapytanie do bazy danych nie powiodło się.");
                }
            } catch(Exception $exeption) {
                $connection->close();
                throw $exeption;
            }

            $connection->close();
        }

        private function setUserLog($userName) {
            $connection = DBConn::getConnection();  
            $checkedUserName = $connection->real_escape_string($userName);

            try {
                $this->deleteUserLogEntry($checkedUserName, $connection);
                $this->insertUserLogEntry($checkedUserName, $connection);
            } catch(Exception $exeption) {
                $connection->close();

                throw $exeption;
            }
        }

        private function deleteUserLogEntry($checkedUserName, $connection) {
            $deleteUserLogQuery = "DELETE FROM `logged_user` WHERE `user_id` = (SELECT `id` FROM `user` WHERE `user_name` = '$checkedUserName')";
            $result = $connection->query($deleteUserLogQuery);

            if ($result === FALSE) {
                throw new Exception("Zapytanie do bazy danych nie powiodło się.");
            }
        }
    
        private function insertUserLogEntry($checkedUserName, $connection) {
            $sessionId = session_id();

            $insertUserLogQuery = "INSERT INTO `logged_user` (`session_id`, `user_id`) SELECT '$sessionId', `id` FROM `user` WHERE `user_name` = '$checkedUserName'";
            $result = $connection->query($insertUserLogQuery);

            if($result === FALSE) {
                throw new Exception("Zapytanie do bazy danych nie powiodło się.");
            }
        }
    }
?>