<?php
    require_once('logic/userManager.inc.php');

    $username = isset($_POST['userName']) ? $_POST['userName'] : '';
    $userPassword = isset($_POST['password']) ? $_POST['password'] : '';
    $repeatedUserPassword = isset($_POST['repeatedPassword']) ? $_POST['repeatedPassword'] : '';
    $userEmail = isset($_POST['email']) ? $_POST['email'] : '';

    try {
        $userManager = new UserManager();
        $result = $userManager->createUser($username, $userPassword, $repeatedUserPassword, $userEmail);

        if (!$result) {
            $errorMessage = "Użytkownik \"$username\" już istnieje w bazie danych. Należy wybrać inną nazwę użytkownika.<br>
                <a href=\"userForm.php\"> ZAŁÓŻ NOWE KONTO</a>";
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
                Rejestracja użytkownika przebiegła pomyślnie.<br><a href="loginForm.php">ZALOGUJ SIĘ</a>
        <?php } ?>
    </p>

    <?php
        require('inc/sign.inc.php');
    ?>
</div>

<?php
    require('inc/footer.inc.php');
?>