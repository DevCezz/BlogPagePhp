<?php
    session_start();

    require_once('logic/userManager.inc.php');

    $userId = isset($_POST['id']) ? $_POST['id'] : '';

    if($_SERVER['REQUEST_METHOD'] !== 'PUT' and $_POST['_method'] !== 'PUT' and $postId === '') {
        throw new Exception('To nie jest żądanie PUT edycji użytkownika.');
    }

    $username = isset($_POST['userName']) ? $_POST['userName'] : '';
    $userPassword = isset($_POST['password']) ? $_POST['password'] : '';
    $repeatedUserPassword = isset($_POST['repeatedPassword']) ? $_POST['repeatedPassword'] : '';
    $userEmail = isset($_POST['email']) ? $_POST['email'] : '';

    try {
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