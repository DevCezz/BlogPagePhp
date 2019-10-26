<?php
    session_start();

    require_once('logic/redirect.inc.php');
    require_once('logic/userManager.inc.php');

    require('inc/header.inc.php');
    require('inc/menu.inc.php');

    try {
        RedirectHandler::checkIfUserIsLoggedIn(session_id());

        $userId = isset($_GET['id']) ? $_GET['id'] : '';

        $userManager = new UserManager();
        if($userId !== '') {
            $user = $userManager->getUser($userId);
        }
    } catch (Exception $exception) {
        $errorMessage = "Wystąpił wewnętrzny błąd serwera. Przepraszamy.<br>Informacja o błędzie: " . $exception->getMessage();
    }
?>

<div class="ui main text container">
    <?php if(isset($errorMessage)) {
        echo "<p class=\"textCenter\">" . $errorMessage . "</p>";
    } else { ?>
        <h1 class="ui header textCenter">Edytuj konto</h1>

        <form class="ui form" role="form" action="userProcessEdit.php" onsubmit="return validateEditUserForm(this)" method="post">
            <input type="hidden" name="_method" value="PUT" />
            <input type="hidden" name="id" value="<?php echo $userId; ?>" />

            <div class="field">
                <label>Nazwa Użytkownika</label>
                <input type="text" name="userName" placeholder="Nazwa Użytkownika" value="<?php echo $user['user_name']; ?>">
            </div>
            <div class="field">
                <label>Hasło</label>
                <input type="password" name="password" placeholder="Hasło">
            </div>
            <div class="field">
                <label>Powtórz hasło</label>
                <input type="password" name="repeatedPassword" placeholder="Powtórz hasło">
            </div>
            <div class="field">
                <label>Email</label>
                <input type="text" name="email" placeholder="Email" value="<?php echo $user['email']; ?>">
            </div>

            <div class="textCenter errorDiv">
                <span id="errorMessage"></span>
            </div>
            <button class="ui violet basic button fullWidth" type="submit">Zmień dane</button>
        </form>
    <?php } ?>
    
    <?php
        require('inc/sign.inc.php');
    ?>
</div>

<?php
    require('inc/footer.inc.php');
?>