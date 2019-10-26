<?php
    session_start();

    require_once('logic/redirect.inc.php');
    require_once('logic/postManager.inc.php');

    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';

    try {
        RedirectHandler::checkIfUserIsLoggedIn(session_id());

        $postManager = new PostManager();
        $postId = $postManager->createPost($title, $content, session_id());

        if (is_null($postId)) {
            $errorMessage = "Nie udało się dodać poprawnie postu.";
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
                Dodanie postu przebiegło pomyślnie.<br><a href="postsShow.php">Zobacz wszystkie posty</a>
        <?php } ?>
    </p>

    <?php
        require('inc/sign.inc.php');
    ?>
</div>

<?php
    require('inc/footer.inc.php');
?>