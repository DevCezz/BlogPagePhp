<?php
    session_start();

    require('inc/header.inc.php');
    require('inc/menu.inc.php');
?>

<div class="ui main text container">
    <h1 class="ui header textCenter">Zaloguj się</h1>

    <form class="ui form" role="form" action="processLogin.php" onsubmit="return validateLoginForm(this)" method="post">
        <div class="field">
            <label>Nazwa Użytkownika</label>
            <input type="text" name="username" placeholder="Nazwa Użytkownika">
        </div>
        <div class="field">
            <label>Hasło</label>
            <input type="password" name="password" placeholder="Hasło">
        </div>
        <button class="ui violet basic button fullWidth" type="submit">Zaloguj</button>
    </form>

    <?php
        require('inc/sign.inc.php');
    ?>
</div>

<?php
    require('inc/footer.inc.php');
?>