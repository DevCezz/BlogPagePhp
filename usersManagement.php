<?php
    session_start();

    require_once('logic/userManager.inc.php');
    require_once('logic/redirect.inc.php');

    try {
        $userManager = new UserManager();
        $loggedUserName = $userManager->checkIfUserIsLoggedIn(session_id());
        if(is_null($loggedUserName)) {
            RedirectHandler::redirect('/', false);
        }

        $users = $userManager->getAllUsers();
    } catch (Exception $exception) {
        $errorMessage = "Wystąpił wewnętrzny błąd serwera. Przepraszamy.<br>Informacja o błędzie: " . $exception->getMessage();
    }
?>

<?php
    require('inc/header.inc.php');
    require('inc/menu.inc.php');
?>

<div class="ui main text container">
    <?php if (isset($errorMessage)) { ?>
        <p class="textCenter">
            <?php echo $errorMessage; ?>
        </p>
    <?php } else { ?>
        <table class="ui celled table">
            <thead>
                <tr>
                    <th>Nazwa użytkownika</th>
                    <th>Email</th>
                    <th>Operacje</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_keys($users) as $id) { ?>
                    <tr>
                        <td><?php echo $users[$id]['user_name']; ?></td>
                        <td><?php echo $users[$id]['email']; ?></td>
                        <td>
                            <button class="ui compact red button">Usuń</button>
                            <button class="ui compact yellow button">Edytuj</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>

    <?php
        require('inc/sign.inc.php');
    ?>
</div>

<?php
    require('inc/footer.inc.php');
?>