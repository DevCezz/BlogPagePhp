<?php
    session_start();

    require_once('logic/userManager.inc.php');
    
    $username = isset($_POST['userName']) ? $_POST['userName'] : '';
    $userPassword = isset($_POST['password']) ? $_POST['password'] : '';

    try {
        $userManager = new UserManager();
        $result = $userManager->login($username, $userPassword);

        if (!$result) {
            $errorMessage = "Podane dane są niepoprawne lub nie istnieje taki użytkownik w systemie.";
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
                echo "Pomyślnie zalogowano do serwisu. Witamy!";
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