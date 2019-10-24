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

            $connection = DBConn::getConnection();

            $checkedUserName = $connection->real_escape_string($userName);
            $checkedUserEmail = $connection->real_escape_string($userEmail);
            $userPasswordMD5 = md5($userPassword);

            try {
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

            $result->close();
            $connection->close();
            
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

        public function getAllUsers() {
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

            $result->close();
            $connection->close();

            return $users;
        }

        public function getAllPosts() {
            $connection = DBConn::getConnection();

            $selectAllPostsQuery = "SELECT p.`id`, u.`user_name`, p.`title`, p.`content`, p.`modification_date` FROM `post` p INNER JOIN `user` u 
                ON u.`id`=p.`user_id` ORDER BY p.`modification_date` DESC";
            $result = $connection->query($selectAllPostsQuery);

            if ($result === FALSE) {
                $connection-close();
                throw new Exception("Zapytanie do bazy danych nie powiodło się.");
            }
            
            $posts = array();
            while ($row = $result->fetch_assoc()) {
                $posts[$row['id']]['user_name'] = $row['user_name'];
                $posts[$row['id']]['title'] = $row['title'];
                $posts[$row['id']]['content'] = $row['content'];
                $posts[$row['id']]['modification_date'] = $row['modification_date'];
            }

            $result->close();
            $connection->close();

            return $posts;
        }

        public function createPost($title, $content, $sessionId) {
            if($title == '' or $content == '') {
                throw new Exception('Wszystkie dane muszą być wypełnione.');
            }

            $connection = DBConn::getConnection();

            $checkTitle = $connection->real_escape_string($title);
            $checkedContent = $connection->real_escape_string($content);

            try {
                $loggedUserName = $this->checkIfUserIsLoggedIn($sessionId);

                if(is_null($loggedUserName)) {
                    throw new Exception("Jesteś niezalogowany, więc nie możesz dodać postu.");
                }

                $selectUserIdByUserNameQuery = "SELECT `id` FROM `user` WHERE `user_name` = '$loggedUserName'";
                $result = $connection->query($selectUserIdByUserNameQuery);

                if($result === FALSE) {
                    throw new Exception("Zapytanie do bazy danych nie powiodło się.");
                }

                if (($row = $result->fetch_assoc()) === NULL) {
                    throw new Exception("Nie znaleziono takiego id użytkownika dla nazwy użytkownika '$loggedUserName'.");
                } else {
                    $loggedUserId = $row['id'];
                }

                $insertPostQuery = "INSERT INTO `post`(`user_id`, `title`, `content`) VALUES ($loggedUserId, '$checkTitle', '$checkedContent')";
                $result = $connection->query($insertPostQuery);

                if($result === FALSE) {
                    throw new Exception("Zapytanie do bazy danych nie powiodło się.");
                } else {
                    $postId = $connection->insert_id;
                }
            } catch(Exception $exeption) {
                if(isset($connection)) {
                    $connection->close();
                }

                throw $exeption;
            }

            $connection->close();
            return $postId;
        }

        public function deletePost($postId, $sessionId) {
            $connection = DBConn::getConnection();

            try {
                $loggedUserName = $this->checkIfUserIsLoggedIn($sessionId);

                if(is_null($loggedUserName)) {
                    throw new Exception("Jesteś niezalogowany, więc nie możesz usunąć postu.");
                }

                $deletePostQuery = "DELETE FROM `post` WHERE `id`=$postId";
                $result = $connection->query($deletePostQuery);

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
    }
?>