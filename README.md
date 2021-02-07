BlogPagePhp
===========

**Projekt powstał w celu zapoznania się z:**

- PHP

Projekt został stworzony na zaliczenie przedmiotu na studiach. Jest to bardzo uproszczona wersja aplikacja do
**rządzania własnym blogiem**.

![Wygląd strony bloga](/assets/images/blog.png)

Stworzona aplikacja umożliwia:

- Dodawanie, edycję i usuwanie wpisów;
- Wyświetlanie wpisów;
- Rejestrowanie, modyfikowanie i usuwanie użytkowników;
- Logowanie i wylogowywanie się użytkowników;

## Opis projektu:

Każdy odwiedzający witrynę ma możliwość założenia konta w systemie. Wprowadzane dane podczas tworzenia konta użytkownika są 
walidowane po stronie klienta oraz serwera. Po założeniu konta istnieje możliwość zalogowania się na to konto do systemu. 
Uwierzytelnianie użytkowników zostało stworzone **bez korzystania z gotowych rozwiązań (framework)** i został wkomponowany w 
stronę WWW. Po zalogowaniu użytkownik ma możliwość **dodania, edycji bądź usuwania wpisów**. Może także edytować i usuwać 
istniejących użytkowników w systemie. Odwiedzający stronę bez logowania może tylko przeglądać istniejące wpisy.

W celu uruchomienia projektu trzeba utworzyć bazę danych MySQL, następnie wykonać skrypt *sql/database.sql*.
Dodatkowo dane do nogowania znajdują się w *logic/dbConn.inc.php*:

    private static $host = <host>;
    private static $db_user = <user>;
    private static $db_password = <password>;
    private static $db_name = <database>;