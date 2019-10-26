<?php
    require_once('userManager.inc.php');

    class RedirectHandler {
        public static function checkIfUserIsLoggedIn($sessionId) {
            $loggedUserName = UserManager::checkIfUserIsLoggedIn($sessionId);

            if(is_null($loggedUserName)) {
                self::redirect('404.php');
            }
        }

        private static function redirect($url, $permanent = false) {
            if (headers_sent() === false) {
                header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
            }

            exit();
        }
    }
?>