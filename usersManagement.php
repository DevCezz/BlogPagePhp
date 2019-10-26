<?php
    session_start();

    require_once('logic/redirect.inc.php');
    require_once('logic/userManager.inc.php');

    try {
        RedirectHandler::checkIfUserIsLoggedIn(session_id());
        
        $userManager = new UserManager();
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
        <table id="userTable" class="ui celled table">
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
                            <?php
                                echo "<div class=\"button-right\">";
                                echo    "<form action=\"userProcessDelete.php?id=$id\" method=\"POST\">";
                                echo        "<input type=\"hidden\" name=\"_method\" value=\"DELETE\" />";
                                echo        "<button class=\"ui compact red button\">Usuń</button>";
                                echo    "</form>";

                                echo    "<a href=\"userEditForm.php?id=$id\" class=\"ui compact yellow button\" name=\"editPost\" value=\"editPost\">Edytuj</a>";
                                echo "</div>";
                            ?>
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