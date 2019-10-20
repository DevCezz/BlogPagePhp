<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" http-equiv="content-type" content="text/html">
    <title>Zaawansowane Aplikacje Internetowe - Moduł 1</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <?php
        require('menu.inc.php');
    ?>

    <div class="ui main text container">
        <h1 class="ui header">Opis projektu:</h1>
        <h3 class="ui header">Zaawansowane aplikacje internetowe (moduł 1)</h3>

        <p>Stworzona aplikacja umożliwia:</p>
        <ul>
            <li>Dodawanie, edycję i usuwanie wpisów;</li>
            <li>Wyświetlanie wpisów;</li>
            <li>Rejestrowanie, modyfikowanie i usuwanie użytkowników;</li>
            <li>Logowanie i wylogowywanie się użytkowników;</li>
        </ul>

        <p class="blogContent">Każdy odwiedzający witrynę ma możliwość założenia konta w systemie. Wprowadzane dane podczas tworzenia konta użytkownika są walidowane po stronie 
        klienta oraz serwera. Po założeniu konta istnieje możliwość zalogowania się na to konto do systemu. Uwierzytelnianie użytkowników zostało stworzone 
        bez korzystania z gotowych rozwiązań (framework) i został wkomponowany w stronę WWW. Po zalogowaniu użytkownik ma możliwość dodania, edycji bądź 
        usuwania wpisów. Może także edytować i usuwać istniejących użytkowników w systemie. Odwiedzający stronę bez logowania może tylko przeglądać 
        istniejące wpisy.</p>

        <p>Cezary Sanecki, s251957</p>

        <?php
            require('footer.inc.php');
        ?>
    </div>
</body>