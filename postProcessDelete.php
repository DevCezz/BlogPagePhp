<?php
    session_start();

    require_once('logic/redirect.inc.php');
    require_once('logic/postManager.inc.php');

    try {    
        RedirectHandler::checkIfUserIsLoggedIn(session_id());

        $postId = isset($_GET['id']) ? $_GET['id'] : '';
        $method = isset($_GET['_method']) ? $_GET['_method'] : '';

        if($_SERVER['REQUEST_METHOD'] !== 'DELETE' and $method !== 'DELETE' and $postId === '') {
            throw new Exception('To nie jest żądanie DELETE usunięcia postu.');
        }
        
        $postManager = new PostManager();

        $result = $postManager->deletePost($postId, session_id());

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