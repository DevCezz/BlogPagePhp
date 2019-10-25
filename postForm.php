<?php
    session_start();

    require_once('logic/userManager.inc.php');
    require_once('logic/redirect.inc.php');

    require('inc/header.inc.php');
    require('inc/menu.inc.php');

    try {
        $userManager = new UserManager();
        $loggedUserName = $userManager->checkIfUserIsLoggedIn(session_id());
        if(is_null($loggedUserName)) {
            RedirectHandler::redirect('/', false);
        }

        $postId = isset($_GET['id']) ? $_GET['id'] : '';

        if($postId !== '') {
            $post = $userManager->getPost($postId);
        }
    } catch (Exception $exception) {
        $errorMessage = "Wystąpił wewnętrzny błąd serwera. Przepraszamy.<br>Informacja o błędzie: " . $exception->getMessage();
    }
?>

<div class="ui main text container">
    <?php if(is_null($post)) { ?>
        <h1 class="ui header textCenter">Dodaj post</h1>
    <?php } else { ?>
        <h1 class="ui header textCenter">Edytuj post <?php echo $post['title']; ?></h1>
        <h3 class="ui header textCenter"><?php echo $post['user_name'] . ' | ' . $post['modification_date']; ?></h3>
    <?php } ?>

    <form class="ui form" role="form" action="<?php if(is_null($post)) { echo 'postProcess.php'; } else { echo 'postProcessEdit.php?id=' . $postId; }?>" 
            onsubmit="return validateCreatePostForm(this)" method="post">
        <?php if(is_null($post)) { ?>
            <input type="hidden" name="_method" value="PUT" />
        <?php }?>

        <div class="field">
            <label>Tytuł</label>
            <input type="text" name="title" placeholder="Tytuł" value="<?php if(is_null($post)) { echo ''; } else { echo $post['title']; }?>">
        </div>
        <div class="field">
            <label>Treść</label>
            <textarea name="content" cols="100" rows="10"><?php if(is_null($post)) { echo ''; } else { echo $post['content']; }?></textarea>
        </div>

        <div class="textCenter errorDiv">
            <span id="errorMessage"></span>
        </div>
        <button class="ui violet basic button fullWidth" type="submit"><?php if(is_null($post)) { echo 'Utwórz post'; } else { echo 'Edytuj post'; }?></button>
    </form>

    <?php
        require('inc/sign.inc.php');
    ?>
</div>

<?php
    require('inc/footer.inc.php');
?>