<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <?php include "head.php"; ?>
</head>
<body>
<?php
    $activePage = "index.php";
    include "navbar.php";
?>
<div class="col-sm-10 text-left">
    <h1>Obsługa muzeum</h1>

    <p style="line-height: 180%; "> Laboratoryjne zadanie zaliczeniowe </p>
    <br>
    <p align="justify"><p align="justify">
    Pewne muzeum sztuki zgromadziło dużą ilość dzieł sztuki (obrazów, rzeźb itp.) - będziemy je
    nazywać eksponatami.
    Muzeum ma skomputeryzowaną księgowość i dysponuje sprzętem komputerowym, który chce wykorzystać do wprowadzenia
        komputerowej obsługi informacji o posiadanych eksponatach.
</p>
    <p align="justify">
    Każdy eksponat jest opisany unikalnym kodem eksponatu (identyfikatorem), tytułem, typem i rozmiarem; rozmiar
        składa się z wysokości, szerokości i wagi.
    Każdy eksponat jest dziełem jakiegoś twórcy, ale dla niektórych eksponatów artysta nie jest znany (i
        raczej już nie będzie). Opis artysty obejmuje unikalne ID (identyfikator), imię i nazwisko, rok urodzenia i rok
        śmierci (pusty dla artystów żyjących). Baza danych ma przechowywać informacje wyłącznie o tych artystach,
        których dzieła są własnością muzeum. </p>
    <p align="justify">
    Muzeum posiada kilka galerii, w których wystawia eksponaty, organizuje też okazjonalnie wystawy
        objazdowe. Galeria może mieć kilka numerowanych sal, dla każdej sali określona jest maksymalna liczba obrazów,
        które można w niej powiesić (,,pojemność''). </p>
    <p align="justify">
    W każdym momencie eksponat może być więc:
        <ul>
            <li> zamknięty w magazynie, np. w celu konserwacji;</li>
            <li> wystawiony w którejś galerii i przechowujemy wtedy informację o galerii i sali;</li>
            <li> na wystawie objazdowej, wtedy powinniśmy pamiętać identyfikator wystawy, miasto gdzie się odbywa oraz
                daty
                rozpoczęcia i zakończenia.
            </li>
</ul>
        Dla każdego eksponatu muzeum chce przechowywać całą historię ekspozycji, nie tylko bieżące
        zdarzenia. </p>
    <p align="justify"> Potrzebna jest baza danych wraz z aplikacją wspierającą opisany proces. Kontakt z użytkownikami może
        odbywać się przez przeglądarkę WWW lub lokalny program kliencki, ale powinien być komfortowy (czyli interfejs
        tekstowy wykluczamy). Zadaniem jest zaprojektowanie i realizacja aplikacji wspomagającej opisany proces. Aplikacja powinna
        być wygodna w użyciu i używać bazy danych. </p>

<center>
    <img src="muzeum.gif"/>
</center>
</div>
    <div class="container-fluid text-center">
        <div class="row content">
            <p><br><br><br><br><br><br><br><br></p>
        </div>
    </div>



    <footer class="container-fluid text-center">
        <p>Katarzyna Głowacka - Bazy Danych 2018</p>
    </footer>

</body>
</html>
