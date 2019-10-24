<?php
    session_start();

    require('inc/header.inc.php');
    require('inc/menu.inc.php');
?>

<div class="ui main text container">
    <h1 class="ui header textCenter">Dodaj post</h1>

    <form class="ui form" role="form" action="postProcess.php" onsubmit="return validateCreatePostForm(this)" method="post">
        <div class="field">
            <label>Tytuł</label>
            <input type="text" name="title" placeholder="Tytuł">
        </div>
        <div class="field">
            <label>Treść</label>
            <textarea name="content" cols="100" rows="10"></textarea>
        </div>

        <div class="textCenter errorDiv">
            <span id="errorMessage"></span>
        </div>
        <button class="ui violet basic button fullWidth" type="submit">Utwórz post</button>
    </form>

    <?php
        require('inc/sign.inc.php');
    ?>
</div>

<?php
    require('inc/footer.inc.php');
?>