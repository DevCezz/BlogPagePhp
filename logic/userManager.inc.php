<?php
    require_once('dbConn.inc.php');

    class UserManager {
        public function createUser($userName, $userPassword, $repeatedUserPassword, $userEmail) {
            if($userName == '' or $userPassword == '' or $repeatedUserPassword == '' or $userEmail == '') {
                throw new Exception('Nie podano wszystkich danych wejściowych przy tworzeniu konta.');
            }

            if(!preg_match('/^\w+$/', $userName)) {
                throw new Exception('Nazwa użytkownika może się składać tylko ze znaków alfanumerycznych.');
            }

            if($userPassword != $repeatedUserPassword) {
                throw new Exception('Podane hasła są różne.');
            }

            if(!preg_match('/^\w+@[a-zA-Z]+\.[a-zA-Z]+$/', $userEmail)) {
                throw new Exception('Podany adres email jest nieprawidłowy.');
            }

            try {
                $connection = DBConn::getConnection();

                $checkedUserName = $connection->real_escape_string($userName);
                $checkedUserEmail = $connection->real_escape_string($userEmail);
                $userPasswordMD5 = md5($userPassword);

                if($this->checkIfUserExists($checkedUserName)) {
                    $connection->close();
                    return FALSE;
                }

                $insertUserQuery = "INSERT INTO `user`(`user_name`, `password`, `email`) VALUES ('$checkedUserName', '$userPasswordMD5', '$checkedUserEmail')";
                $result = $connection->query($insertUserQuery);

                if($result === FALSE) {
                    $connection->close();
                    throw new Exception("Zapytanie do bazy danych nie powiodło się.");
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
            try {
                $connection = DBConn::getConnection();

                $selectUserByUserNameQuery = "SELECT * FROM `user` WHERE `user_name` = '$checkedUserName'";
                $result = $connection->query($selectUserByUserNameQuery);

                if ($result === FALSE) {
                    $connection->close();
                    throw new Exception("Zapytanie do bazy danych nie powiodło się.");
                }
                    
                if (($row = $result->fetch_assoc()) === NULL) {
                    $userExists = FALSE;
                } else {
                    $userExists = TRUE;
                }
            } catch(Exception $exeption) {
                if(isset($connection)) {
                    $connection->close();
                }

                throw $exeption;
            }

            $result->close();
            $connection->close();
            
            return $userExists;
        }

        public function getUser($userId) {
            try {
                $connection = DBConn::getConnection();

                $selectUserByIdQuery = "SELECT `user_name`, `email` FROM `user` WHERE `id`=$userId";
                $result = $connection->query($selectUserByIdQuery);

                if ($result === FALSE) {
                    $connection-close();
                    throw new Exception("Zapytanie do bazy danych nie powiodło się.");
                }
                
                $user = array();
                if (($row = $result->fetch_assoc()) === NULL) {
                    throw new Exception("Nie znaleziono takiego użytkownika dla id $userId.");
                } else {
                    $user['user_name'] = $row['user_name'];
                    $user['email'] = $row['email'];
                }
            } catch(Exception $exeption) {
                if(isset($connection)) {
                    $connection->close();
                }

                throw $exeption;
            }

            $result->close();
            $connection->close();

            return $user;
        }

        public function getAllUsers() {
            try {
                $connection = DBConn::getConnection();

                $selectAllUsersQuery = "SELECT * FROM `user`";
                $result = $connection->query($selectAllUsersQuery);

                if ($result === FALSE) {
                    $connection-close();
                    throw new Exception("Zapytanie do bazy danych nie powiodło się.");
                }
                
                $users = array();
                while ($row = $result->fetch_assoc()) {
                    $users[$row['id']]['user_name'] = $row['user_name'];
                    $users[$row['id']]['email'] = $row['email'];
                }
            } catch(Exception $exeption) {
                if(isset($connection)) {
                    $connection->close();
                }

                throw $exeption;
            }

            $result->close();
            $connection->close();

            return $users;
        }

        public function editUser($userId, $userName, $userPassword, $repeatedUserPassword, $userEmail) {
            if($userName == '' or $userEmail == '') {
                throw new Exception('Pozostawiono puste pole: nazwa użytkownia lub email.');
            }

            if(!preg_match('/^\w+$/', $userName)) {
                throw new Exception('Nazwa użytkownika może się składać tylko ze znaków alfanumerycznych.');
            }

            if(!preg_match('/^\w+@[a-zA-Z]+\.[a-zA-Z]+$/', $userEmail)) {
                throw new Exception('Podany adres email jest nieprawidłowy.');
            }

            if (($userPassword !== '') !== ($repeatedUserPassword !== '')) {
                throw new Exception('Nie wypełniono jednego z pól dotyczącego hasła.');
            }

            if(($userPassword !== '') && ($userPassword != $repeatedUserPassword)) {
                throw new Exception('Podane hasła są różne.');
            }

            try {
                $connection = DBConn::getConnection();
    
                $checkedUserName = $connection->real_escape_string($userName);
                $checkedUserEmail = $connection->real_escape_string($userEmail);

                if($userPassword !== '') {
                    $userPasswordMD5 = md5($userPassword);

                    $updateUserWithPasswordQuery = "UPDATE `user` SET `user_name`='$checkedUserName', `password`='$userPasswordMD5', 
                            `email`='$checkedUserEmail' WHERE `id`=$userId";
                    $result = $connection->query($updateUserWithPasswordQuery);
                } else {
                    $updateUserQuery = "UPDATE `user` SET `user_name`='$checkedUserName', `email`='$checkedUserEmail' WHERE `id`=$userId";
                    $result = $connection->query($updateUserQuery);
                }               

                if($result === FALSE) {
                    throw new Exception("Zapytanie do bazy danych nie powiodło się.");
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

        public function deleteUser($userId, $sessionId) {
            try {
                $connection = DBConn::getConnection();

                $selectPostsByUserIdQuery = "SELECT * FROM `post` WHERE `user_id`=$userId";
                $result = $connection->query($selectPostsByUserIdQuery);

                if($result === FALSE) {
                    throw new Exception("Zapytanie do bazy danych nie powiodło się.");
                }

                if (($row = $result->fetch_assoc()) !== NULL) {
                    throw new Exception("Nie można usunąć użytkownika - ma przypisane do siebie posty.");
                }

                $deleteUserLogQuery = "DELETE FROM `logged_user` WHERE `user_id`=$userId";
                $result = $connection->query($deleteUserLogQuery);

                if($result === FALSE) {
                    throw new Exception("Zapytanie do bazy danych nie powiodło się.");
                }

                $deleteUserQuery = "DELETE FROM `user` WHERE `id`=$userId";
                $result = $connection->query($deleteUserQuery);

                if($result === FALSE) {
                    throw new Exception("Zapytanie do bazy danych nie powiodło się.");
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

        public function login($userName, $userPassword) {
            if($userName == '' or $userPassword == '') {
                throw new Exception('Nie podano żadnych danych do logowania.');
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
            try {
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
            } catch(Exception $exeption) {
                if(isset($connection)) {
                    $connection->close();
                }

                throw $exeption;
            }

            $result->close();
            $connection->close();

            return $isChecked;
        }

        public function logout() {
            try {
                $connection = DBConn::getConnection();

                $checkedSessionId = $connection->real_escape_string(session_id());
                $deleteLoggedUserQuery = "DELETE FROM `logged_user` WHERE `session_id` = '$checkedSessionId'";
                $result = $connection->query($deleteLoggedUserQuery);

                if ($result === FALSE) {
                    $connection->close();
                    throw new Exception("Zapytanie do bazy danych nie powiodło się.");
                }
            } catch(Exception $exeption) {
                if(isset($connection)) {
                    $connection->close();
                }

                throw $exeption;
            }

            $connection->close();
        }

        private function setUserLog($userName) {
            try {
                $connection = DBConn::getConnection();  
                $checkedUserName = $connection->real_escape_string($userName);

                $this->deleteUserLogEntry($connection, $checkedUserName);
                $this->insertUserLogEntry($connection, $checkedUserName);
            } catch(Exception $exeption) {
                if(isset($connection)) {
                    $connection->close();
                }

                throw $exeption;
            }
        }

        private function deleteUserLogEntry($connection, $checkedUserName) {
            $deleteUserLogQuery = "DELETE FROM `logged_user` WHERE `user_id` = (SELECT `id` FROM `user` WHERE `user_name` = '$checkedUserName')";
            $result = $connection->query($deleteUserLogQuery);

            if ($result === FALSE) {
                throw new Exception("Zapytanie do bazy danych nie powiodło się.");
            }
        }
    
        private function insertUserLogEntry($connection, $checkedUserName) {
            $sessionId = session_id();

            $insertUserLogQuery = "INSERT INTO `logged_user` (`session_id`, `user_id`) SELECT '$sessionId', `id` FROM `user` WHERE `user_name` = '$checkedUserName'";
            $result = $connection->query($insertUserLogQuery);

            if($result === FALSE) {
                throw new Exception("Zapytanie do bazy danych nie powiodło się.");
            }
        }

        public static function checkIfUserIsLoggedIn($sessionId) {
            $connection = DBConn::getConnection();

            try {
                $checkedSessionId = $connection->real_escape_string($sessionId);

                $selectLogUserQuery = "SELECT `user_name` FROM `logged_user` lu INNER JOIN `user` u ON u.`id`=lu.`user_id` WHERE `session_id` = '$checkedSessionId'";
                $result = $connection->query($selectLogUserQuery);

                if($result === FALSE) {
                    $connection->close();
                    throw new Exception("Zapytanie do bazy danych nie powiodło się.");
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
    }
?>