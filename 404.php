<?php
    session_start();

    require('inc/header.inc.php');
    require('inc/menu.inc.php');
?>

<div class="ui main text container">
    <div class="textCenter">
        <h1 class="ui header">Przykro nam, podana strona nie została znaleziona.</h1>
        <h3 class="ui header">Przejdź do <a href="index.php">strony głównej</a></h3>
    </div>
    
    <?php
        require('inc/sign.inc.php');
    ?>
</div>

<?php
    require('inc/footer.inc.php');
?>