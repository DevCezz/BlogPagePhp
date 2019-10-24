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
    <h1 class="ui huge header textCenter">Posty</h1>

    <div class="ui top attached segment">
        <div class="ui divided items">
            <?php foreach (array_keys($posts) as $id) { ?>
                <div class="item">
                    <div class="content">
                        <h1 class="ui large header"><?php echo $posts[$id]['title']; ?></h1>
                        <div class="description">
                            <?php echo $posts[$id]['content']; ?>
                        </div>
                        <div class="extra"><?php echo $posts[$id]['modification_date'] . ' | <strong>' . $posts[$id]['user_name'] . '</strong>'; ?></div>

                        <?php
                            if(!is_null($loggedUserName)) {
                                echo <<<HTML
                                    <div class="sm-t button-right">
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