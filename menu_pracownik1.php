<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bazy danych - Katarzyna Głowacka</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        /* Remove the navbar's default margin-bottom and rounded borders */
        .navbar {
            margin-bottom: 0;
            border-radius: 0;
        }

        /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
        .row.content {
            height: 450px
        }

        /* Set gray background color and 100% height */
        .sidenav {
            padding-top: 20px;
            background-color: #f1f1f1;
            height: 100%;
        }

        /* Set black background color, white text and some padding */
        footer {
            background-color: #555;
            color: white;
            padding: 15px;
        }

        /* On small screens, set height to 'auto' for sidenav and grid */
        @media screen and (max-width: 767px) {
            .sidenav {
                height: auto;
                padding: 15px;
            }

            .row.content {
                height: auto;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li><a href="http://students.mimuw.edu.pl/~kg359266/bd/">Zadanie</a></li>
                <li><a href="diagram.php">Diagram ERD</a></li>
                <li><a href="skrypt.php">Skrypt generujący</a></li>
                <li><a href="aplikacja.php">Aplikacja</a></li>
            </ul>
            </ul>

            <form action="menu_pracownik.php" method="post" class="navbar-form navbar-right">
                <input type="submit" class="form-control" value="Powrót do menu pracownika">
            </form>

            <form action="wyloguj.php" method="post" class="navbar-form navbar-right">
                <input type="submit" name="logout" class="form-control" value="Wyloguj">
            </form>

        </div>
    </div>
</nav>
<div class="col-sm-11 text-left">
    <div>
        <div style="float: right;">
            <form action="wyloguj.php" method="post">
                <input type="submit" value="Wyloguj">
            </form>
        </div>
        <div style="float: right;">
            <form action="aplikacja.php" method="post">
                <input type="submit" value="Powrót do strony głównej">
            </form>
        </div>
        <div style="float: right;">
            <form action="menu_dodawanie.php" method="post">
                <input type="submit" value="Przejdź do menu edycji zasobów">
            </form>
        </div>

    </div>
    </br>
    <h2 align="center">Wyszukiwarka dzieł</h2>
    <form action="wyniki_pracownik.php" method="post">
        <center>
            ID: <input type="text" name="id" value="0"><br>
            Tytuł: <input type="text" name="tytul"><br>
            Autor: <input type="text" name="autor"><br>
            <input type="radio" name="opcja_wyszukaj" value="1" checked> Szukaj tylko w dziełach na wystawach<br>
            <input type="radio" name="opcja_wyszukaj" value="2"> Szukaj w niedostępnych dziełach<br>
            <input type="radio" name="opcja_wyszukaj" value="4"> Pokaż pełne informacje<br>
            <input type="radio" name="opcja_wyszukaj" value="3"> Pokaż całą historię<br>
            <input type="submit" value="Szukaj">
        </center>
    </form>
    <h2 align="center">Obsługa wystaw</h2>
    <form action="wszystkie_wystawy.php" method="post">
        <center>
            <input type="submit" value="Pokaż wszystkie dzieła na wystawach">
        </center>
    </form>
    <center>
        <form action="show_hist_wystaw.php" method="post">
            ID: <input type="text" name="id" value="0"><br>
            Tytuł: <input type="text" name="tytul"><br>
            <input type="submit" value="Pokaż historię wystaw tego dzieła">
    </center>
    </form>
    <h2 align="center">Obsługa magazynu</h2>
    <form action="wszystko_magazyn.php" method="post">
        <center>
            <input type="submit" value="Pokaż wszystkie dzieła w magazynie">
        </center>
    </form>
    <center>
        <form action="show_hist_magazynu.php.php" method="post">
            ID: <input type="text" name="id" value="0"><br>
            Tytuł: <input type="text" name="tytul"><br>
            <input type="submit" value="Pokaż historię magazynowania tego dzieła">
    </center>
    </form>
    <h2 align="center">Dzieła na wystawach objazdowych</h2>
    <form action="wszystko_wyst_obj.php" method="post">
        <center>
            <input type="submit" value="Pokaż wszystkie dzieła na wystawach objazdowych">
        </center>
    </form>
    <center>
        <form action="show_hist_wystaw_obj.php" method="post">
            ID: <input type="text" name="id" value="0"><br>
            Tytuł: <input type="text" name="tytul"><br>
            <input type="submit" value="Pokaż historię wystaw objazdowych tego dzieła">
    </center>
    </form>
    <h2 align="center">Wyszukiwanie po dacie</h2>
    <form action="szukanie_data.php" method="post">
        <center>
            <form action="show_hist_wystaw_obj.php" method="post">
                ID: <input type="text" name="id" value="0"><br>
                Tytuł: <input type="text" name="tytul"><br>
                Od: <input type="date" name="poczatek"><br>
                Do: <input type="date" name="koniec"><br>
                <input type="submit" value="Szukaj">
        </center>
    </form>

</div>
<p><br> <br> <br> <br><br><br><br><br><br><br></p>
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