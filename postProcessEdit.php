<?php
    session_start();

    require_once('logic/userManager.inc.php');

    try {    
        $postId = isset($_GET['id']) ? $_GET['id'] : '';

        if($_SERVER['REQUEST_METHOD'] !== 'PUT' and $_POST['_method'] !== 'PUT' and $postId === '') {
            throw new Exception('To nie jest żądanie PUT edycji postu.');
        }
        
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $content = isset($_POST['content']) ? $_POST['content'] : '';
        
        $userManager = new UserManager();

        $result = $userManager->editPost($postId, $title, $content, session_id());

        if (!$result) {
            $errorMessage = "Nie udało się edytować postu.";
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
                Edycja postu przebiegło pomyślnie.<br><a href="postsShow.php">Zobacz wszystkie posty</a>
        <?php } ?>
    </p>

    <?php
        require('inc/sign.inc.php');
    ?>
</div>

<?php
    require('inc/footer.inc.php');
?>