<?php
    session_start();

    require('inc/header.inc.php');
    require('inc/menu.inc.php');
?>

<div class="ui main text container">
    <h1 class="ui header textCenter">Edytuj konto</h1>

    <form class="ui form" role="form" action="userProcess.php" onsubmit="return validateCreateUserForm(this)" method="post">
        <div class="field">
            <label>Nazwa Użytkownika</label>
            <input type="text" name="userName" placeholder="Nazwa Użytkownika">
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
            <input type="text" name="email" placeholder="Email">
        </div>

        <div class="textCenter errorDiv">
            <span id="errorMessage"></span>
        </div>
        <button class="ui violet basic button fullWidth" type="submit">Utwórz konto</button>
    </form>

    <?php
        require('inc/sign.inc.php');
    ?>
</div>

<?php
    require('inc/footer.inc.php');
?>