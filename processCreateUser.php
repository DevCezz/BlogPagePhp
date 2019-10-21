<?php
    require_once('logic/user_manager.inc.php');

    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $userPassword = isset($_POST['password']) ? $_POST['password'] : '';
    $repeatedUserPassword = isset($_POST['repeatedPassword']) ? $_POST['repeatedPassword'] : '';
    $userEmail = isset($_POST['email']) ? $_POST['email'] : '';

    try {
        $userManager = new UserManager();
        $result = $userManager->createUser($username, $userPassword, $repeatedUserPassword, $userEmail);

        if (!$result) {
            $errorMessage = "Użytkownik $username już istnieje w bazie danych. Należy wybrać inną nazwę użytkownika. Wybierz inną nazwę: <a href=\"createUser.php\"> Załóż nowe konto</a> ";
        }
    } catch (Exception $exception) {
        $errorMessage = "Wystąpił wewnętrzny błąd serwera. Przepraszamy.<br>Informacje o błędzie: $exception->getMessage()";
    }
?>

<?php
    require('inc/header.inc.php');
    require('inc/menu.inc.php');
?>

<div class="ui main text container">
    <?php
        if (isset($errorMessage)) {
            echo $errorMessage;
        } else {
            echo "Użytkownik został utworzony z powodzeniem. W celu zalogowania się kliknij <a href=\"login.php\"> logowanie </a> ";
        }
    ?>

    <?php
        require('inc/sign.inc.php');
    ?>
</div>

<?php
    require('inc/footer.inc.php');
?>