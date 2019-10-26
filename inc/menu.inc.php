<?php
    require_once('logic/userManager.inc.php');

    try {
        $loggedUserName = UserManager::checkIfUserIsLoggedIn(session_id());
    } catch (Exception $e) {
        $error_message = "Przepraszamy, ale wystąpił błąd na stronie.<br>Informacja o błędzie:<br> " . $e->getMessage();
    }
?>
<div class="ui fixed inverted menu">
    <div class="ui container">
        <a href="index.php" class="item"><i class="keyboard outline icon"></i> Blog ZAI</a>
        <a href="postsShow.php" class="item">Posty</a>

        <?php if(!is_null($loggedUserName)) { ?>
            <a class="item" href="postForm.php">Dodaj post</a>
        <?php } ?>

        <div class="right menu">
            <?php if(is_null($loggedUserName)) { ?>
                <a class="item" href="userForm.php">Rejestracja</a>
                <a class="item" href="loginForm.php">Zaloguj</a>
            <?php } else { ?>
                <span class="item">Zalogowany jako <?php echo $loggedUserName ?></span>
                <a class="item" href="usersManagement.php">Zarządzaj</a>
                <a class="item" href="logoutProcess.php">Wyloguj</a>
            <?php } ?>
        </div>
    </div>
</div>