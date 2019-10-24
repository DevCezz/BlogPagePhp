<?php
    session_start();

    require('inc/header.inc.php');
    require('inc/menu.inc.php');

    require_once('logic/userManager.inc.php');

    try {
        $userManager = new UserManager();
        $loggedUserName = $userManager->checkIfUserIsLoggedIn(session_id());
        $posts = $userManager->getAllPosts();
    } catch (Exception $exception) {
        $errorMessage = "Wystąpił wewnętrzny błąd serwera. Przepraszamy.<br>Informacja o błędzie: " . $exception->getMessage();
    }
?>

<div class="ui main text container">
    <h1 class="ui header textCenter">Posty</h1>

    <div class="ui top attached segment">
        <div class="ui divided items">
            <?php foreach (array_keys($posts) as $id) { ?>
                <div class="item">
                    <div class="content">
                        <h1><?php echo $posts[$id]['title']; ?></h1>
                        <h4><?php echo $posts[$id]['user_name']; ?></h4>
                        <div class="met">
                            <span><?php echo $posts[$id]['content']; ?></span>
                        </div>
                        <div class="description">
                            <p><?php echo $posts[$id]['modification_date']; ?></p>
                        </div>
                        <?php
                            if(!is_null($loggedUserName)) {
                                echo <<<HTML
                                    <div class="sm-t">
                                        <button class="ui compact red button">Usuń</button>
                                        <button class="ui compact yellow button">Edytuj</button>
                                    </div>
                                HTML;
                            }
                        ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php
        require('inc/sign.inc.php');
    ?>
</div>

<?php
    require('inc/footer.inc.php');
?>