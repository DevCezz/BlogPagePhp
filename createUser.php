<?php
    session_start();
    require('inc/header.inc.php');
    require('inc/menu.inc.php');
?>

<div class="ui main text container">
    <form class="ui form">
        <div class="field">
            <label>Nazwa Użytownika</label>
            <input type="text" name="username" placeholder="Nazwa Użytownika">
        </div>
        <div class="field">
            <label>Hasło</label>
            <input type="password" name="password" placeholder="Hasło">
        </div>
        <div class="field">
            <label>Powtórz hasło</label>
            <input type="password" name="repeated_password" placeholder="Powtórz hasło">
        </div>
        <div class="field">
            <label>Email</label>
            <input type="text" name="email" placeholder="Email">
        </div>
        <button class="ui violet basic button" type="submit">Utwórz konto</button>
    </form>

    <?php
        require('inc/sign.inc.php');
    ?>
</div>

<?php
    require('inc/footer.inc.php');
?>