<?php
    session_start();

    require_once('logic/userManager.inc.php');

    try {    
        if($_SERVER['REQUEST_METHOD'] !== 'DELETE' and $_POST['_method'] !== 'DELETE') {
            throw new Exception('To nie jest żądanie DELETE usunięcia postu.');
        }
        $postId = $_GET['id'];

        $userManager = new UserManager();

        $result = $userManager->deletePost($postId, session_id());

        if (!$result) {
            $errorMessage = "Nie udało się usunąć postu.";
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
        <?php if (isset($errorMessage)) {
                echo $errorMessage;
            } else { ?>
                Usunięcie postu przebiegło pomyślnie.<br><a href="postsShow.php">Zobacz wszystkie posty</a>
        <?php } ?>
    </p>

    <?php
        require('inc/sign.inc.php');
    ?>
</div>

<?php
    require('inc/footer.inc.php');
?>