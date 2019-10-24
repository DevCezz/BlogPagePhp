<?php
    require_once('logic/userManager.inc.php');

    try {
        $userManager = new UserManager();
        $loggedUserName = $userManager->checkIfUserIsLoggedIn(session_id());
    } catch (Exception $e) {
        $error_message = "Przepraszamy, ale wystąpił błąd na stronie.<br>Informacja o błędzie:<br> " . $e->getMessage();
    }
?>
<div class="ui fixed inverted menu">
    <div class="ui container">
        <div class="header item"><i class="keyboard outline icon"></i> Blog ZAI</div>
        <a href="/" class="item">Opis projektu</a>
        <a href="showPosts.php" class="item">Posty</a>

        <?php
            if(!is_null($loggedUserName)) {
                echo "<a class=\"item\" href=\"createPost.php\"\">Dodaj post</a>";
            }
        ?>

        <div class="right menu">
            <?php
                if(is_null($loggedUserName)) {
                    echo "<a class=\"item\" href=\"createUser.php\">Rejestracja</a>";
                    echo "<a class=\"item\" href=\"login.php\">Zaloguj</a>";
                } else {
                    echo "<span class=\"item\">Zalogowany jako $loggedUserName</span>";
                    echo "<a class=\"item\" href=\"editUsers.php\">Zarządzaj</a>";
                    echo "<a class=\"item\" href=\"processLogout.php\">Wyloguj</a>";
                }
            ?>
        </div>
    </div>
</div>