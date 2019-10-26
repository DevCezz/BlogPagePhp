<?php
    session_start();

    require_once('logic/redirect.inc.php');
    require_once('logic/userManager.inc.php');

    try {
        RedirectHandler::checkIfUserIsLoggedIn(session_id());

        $userId = isset($_POST['id']) ? $_POST['id'] : '';
        $method = isset($_POST['_method']) ? $_POST['_method'] : '';
        
        if($_SERVER['REQUEST_METHOD'] !== 'PUT' and $method !== 'PUT' and $userId === '') {
            throw new Exception('To nie jest żądanie PUT edycji użytkownika.');
        }

        $username = isset($_POST['userName']) ? $_POST['userName'] : '';
        $userPassword = isset($_POST['password']) ? $_POST['password'] : '';
        $repeatedUserPassword = isset($_POST['repeatedPassword']) ? $_POST['repeatedPassword'] : '';
        $userEmail = isset($_POST['email']) ? $_POST['email'] : '';
    
        $userManager = new UserManager();
        $result = $userManager->editUser($userId, $username, $userPassword, $repeatedUserPassword, $userEmail);

        if (!$result) {
            $errorMessage = "Wewnętrzny błąd serwera.";
        }
    } catch (Exception $exception) {
        $errorMessage = "Wystąpił wewnętrzny błąd serwera. Przepraszamy.<br>Informacja o błędzie: " . $exception->getMessage();
    }
?>

<?php
    require('inc/header.inc.php');
    require('inc/menu.inc.php');
?>

<div class="ui main text container">
    <p class="textCenter">
        <?php if (isset($errorMessage)) {
                echo $errorMessage;
            } else { ?>
                Edycja użytkownika przebiegła pomyślnie.
        <?php } ?>
    </p>

    <?php
        require('inc/sign.inc.php');
    ?>
</div>

<?php
    require('inc/footer.inc.php');
?>