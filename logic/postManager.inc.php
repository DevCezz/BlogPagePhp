<?php
    require_once('dbConn.inc.php');
    require_once('userManager.inc.php');

    class PostManager {
        public function createPost($title, $content, $sessionId) {
            if($title == '' or $content == '') {
                throw new Exception('Wszystkie dane muszą być wypełnione.');
            }

            $title = self::eraseScriptTags($title);
            $content = self::eraseScriptTags($content);

            try {
                $connection = DBConn::getConnection();

                $checkTitle = $connection->real_escape_string($title);
                $checkedContent = $connection->real_escape_string($content);

                $selectUserIdBySessionIdQuery = "SELECT `user_id` FROM `logged_user` WHERE `session_id` = '$sessionId'";
                $result = $connection->query($selectUserIdBySessionIdQuery);

                if($result === FALSE) {
                    throw new Exception("Zapytanie do bazy danych nie powiodło się.");
                }

                if (($row = $result->fetch_assoc()) === NULL) {
                    throw new Exception("Nie znaleziono takiego id dla zalogowanego użytkownika.");
                } else {
                    $loggedUserId = $row['user_id'];
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

        public function getPost($postId) {
            try {
                $connection = DBConn::getConnection();

                $selectPostByIdQuery = "SELECT p.`id`, u.`user_name`, p.`title`, p.`content`, p.`modification_date` FROM `post` p INNER JOIN `user` u 
                    ON u.`id`=p.`user_id` WHERE p.`id`=$postId";
                $result = $connection->query($selectPostByIdQuery);

                if ($result === FALSE) {
                    $connection-close();
                    throw new Exception("Zapytanie do bazy danych nie powiodło się.");
                }
                
                $post = array();
                if (($row = $result->fetch_assoc()) === NULL) {
                    throw new Exception("Nie znaleziono takiego postu dla id $postId.");
                } else {
                    $post['id'] = $row['user_name'];
                    $post['user_name'] = $row['user_name'];
                    $post['title'] = $row['title'];
                    $post['content'] = $row['content'];
                    $post['modification_date'] = $row['modification_date'];
                }
            } catch(Exception $exeption) {
                if(isset($connection)) {
                    $connection->close();
                }

                throw $exeption;
            }

            $result->close();
            $connection->close();

            return $post;
        }

        public function getAllPosts() {
            try {
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
            } catch(Exception $exeption) {
                if(isset($connection)) {
                    $connection->close();
                }

                throw $exeption;
            }

            $result->close();
            $connection->close();

            return $posts;
        }

        public function editPost($postId, $title, $content, $sessionId) {
            if($title == '' or $content == '') {
                throw new Exception('Wszystkie dane muszą być wypełnione.');
            }

            $title = self::eraseScriptTags($title);
            $content = self::eraseScriptTags($content);

            try {
                $connection = DBConn::getConnection();

                $checkTitle = $connection->real_escape_string($title);
                $checkedContent = $connection->real_escape_string($content);

                $selectUserIdBySessionIdQuery = "SELECT `user_id` FROM `logged_user` WHERE `session_id` = '$sessionId'";
                $result = $connection->query($selectUserIdBySessionIdQuery);

                if($result === FALSE) {
                    throw new Exception("Zapytanie do bazy danych nie powiodło się.");
                }

                if (($row = $result->fetch_assoc()) === NULL) {
                    throw new Exception("Nie znaleziono takiego id dla zalogowanego użytkownika.");
                }

                $editPostQuery = "UPDATE `post` SET `title`='$checkTitle', `content`='$checkedContent', `modification_date`=NOW() WHERE `id`=$postId";
                $result = $connection->query($editPostQuery);

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

        public function deletePost($postId, $sessionId) {
            try {
                $connection = DBConn::getConnection();

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

        private function eraseScriptTags($content) {
            $content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $content);

            return $content;
        }
    }
?>