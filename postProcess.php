<?php
    session_start();

    require_once('logic/userManager.inc.php');

    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $content = isset($_POST['content']) ? $_POST['content'] : '';

    try {
        $userManager = new UserManager();

        $postId = $userManager->createPost($title, $content, session_id());

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
        <?php
            if (isset($errorMessage)) {
                echo $errorMessage;
            } else {
                echo <<<HTML
                    Dodanie postu przebiegło pomyślnie.<br><a href="postsShow.php">Zobacz wszystkie posty</a>";
                HTML;
            }
        ?>
    </p>

    <?php
        require('inc/sign.inc.php');
    ?>
</div>

<?php
    require('inc/footer.inc.php');
?>