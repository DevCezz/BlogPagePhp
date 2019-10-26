<?php
    session_start();

    require_once('logic/redirect.inc.php');
    require_once('logic/postManager.inc.php');

    require('inc/header.inc.php');
    require('inc/menu.inc.php');

    try {
        RedirectHandler::checkIfUserIsLoggedIn(session_id());

        $postId = isset($_GET['id']) ? $_GET['id'] : '';

        $postManager = new PostManager();
        if($postId !== '') {
            $post = $postManager->getPost($postId);
        }
    } catch (Exception $exception) {
        $errorMessage = "Wystąpił wewnętrzny błąd serwera. Przepraszamy.<br>Informacja o błędzie: " . $exception->getMessage();
    }
?>

<div class="ui main text container">
    <?php if(isset($errorMessage)) { 
        echo "<p class=\"textCenter\">" . $errorMessage . "</p>";
    } else { ?>
        <?php if($postId === '') { ?>
            <h1 class="ui header textCenter">Dodaj post</h1>
        <?php } else { ?>
            <h1 class="ui header textCenter">Edytuj post: '<?php echo $post['title']; ?>'</h1>
            <h3 class="ui header textCenter"><?php echo $post['user_name'] . ' | ' . $post['modification_date']; ?></h3>
        <?php } ?>

        <form class="ui form" role="form" action="<?php if($postId === '') { echo 'postProcess.php'; } else { echo 'postProcessEdit.php?id=' . $postId; }?>" 
                onsubmit="return validatePostForm(this)" method="post">
            <?php if($postId !== '') { ?>
                <input type="hidden" name="_method" value="PUT" />
            <?php }?>

            <div class="field">
                <label>Tytuł</label>
                <input type="text" name="title" placeholder="Tytuł" value="<?php if($postId === '') { echo ''; } else { echo $post['title']; }?>">
            </div>
            <div class="field">
                <label>Treść</label>
                <textarea name="content" cols="100" rows="10"><?php if($postId === '') { echo ''; } else { echo $post['content']; }?></textarea>
            </div>

            <div class="textCenter errorDiv">
                <span id="errorMessage"></span>
            </div>
            <button class="ui violet basic button fullWidth" type="submit">Zatwierdź</button>
        </form>
    <?php } ?>

    <?php
        require('inc/sign.inc.php');
    ?>
</div>

<?php
    require('inc/footer.inc.php');
?>