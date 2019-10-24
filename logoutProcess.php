<?php
    session_start();

    require_once('logic/userManager.inc.php');
    
    try {
        $userManager = new UserManager();
        $loggedUserName = $userManager->checkIfUserIsLoggedIn(session_id());

        if (is_null($loggedUserName)) {
            $errorMessage = "Brak możliwość wylogowania niezalogowanego użytkownika.";
        } else {
            $userManager->logout();
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
        <?php
            if (isset($errorMessage)) {
                echo $errorMessage;
            } else {
                echo "Pomyślnie wylogowano z serwisu!";
            }
        ?>
    </p>

    <?php
        require('inc/sign.inc.php');
    ?>
</div>

<?php
    require('inc/footer.inc.php');
?>