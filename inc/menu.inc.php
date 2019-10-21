<?php
    require_once('logic/user_manager.inc.php');
?>
<div class="ui fixed inverted menu">
    <div class="ui container">
        <div class="header item"><i class="keyboard outline icon"></i> Blog ZAI</div>
        <a href="/" class="item">Opis projektu</a>
        <a href="/posts" class="item">Posty</a>
        <a href="/posts/new" class="item">Dodaj post</a>

        <div class="right menu">
            <?php
                echo "<a class=\"item\" href=\"createUser.php\">Rejestracja</a>"
            ?>
        </div>
    </div>
</div>