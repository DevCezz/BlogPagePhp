<?php
    session_start();

    require_once('logic/userManager.inc.php');

    try {    
        $userId = isset($_GET['id']) ? $_GET['id'] : '';

        if($_SERVER['REQUEST_METHOD'] !== 'DELETE' and $_POST['_method'] !== 'DELETE' and $userId === '') {
            throw new Exception('To nie jest żądanie DELETE usunięcia użytkownika.');
        }
        
        $userManager = new UserManager();

        $result = $userManager->deleteUser($userId, session_id());

        if (!$result) {
            $errorMessage = "Nie udało się usunąć użytkownika.";
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
                Usunięcie użytkownika przebiegło pomyślnie.<br><a href="usersManagement.php">ZARZĄDZANIE PRACOWNIKAMI</a>
        <?php } ?>
    </p>

    <?php
        require('inc/sign.inc.php');
    ?>
</div>

<?php
    require('inc/footer.inc.php');
?>