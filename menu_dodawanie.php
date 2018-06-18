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

    <?php
    session_start();
    if($_SESSION["login"]!=1)
//    {
//        header('Location: aplikacja.php');
//    }
    ?>
    <?php
    include 'config.php';
    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $n_miasto = $_POST["n_miasto"];
    $n_instytucja = $_POST["n_instytucja"];
    $miasto_l = $_POST["miasto_l"];
    ?>
    <div>
        <div style="float: right;">
            <form action="wyloguj.php" method="post">
                <input type="submit" value="Wyloguj">
            </form>
        </div>
        <div style="float: right;">
            <form action="menu_pracownik.php" method="post">
                <input type="submit" value="Przejdź do wyszukiwarki">
            </form>
        </div>
    </div><br>
    <h2 align="center">Dodaj dzieło</h2>
    <form action="dodaj_eksp_szczegoly.php" method="post">
        <center>
            Tytuł: <input type="text" name="tytul">
            Typ: <select name="typ">
                <option>obraz</option>
                <option>rzeźba</option>
                <option> rycina</option>
            </select><br>
            Wysokość: <input type="text" name="wysokosc">
            Szerokość: <input type="text" name="szerokosc">
            Waga: <input type="text" name="waga">
            Gdzie umieścić:<select name="lokalizacja">
                <option>Galeria</option>
                <option>Magazyn</option>
                <option>Wystawa objazdowa</option>
            </select><br>
            Autor:<br>
            <input type="radio" name="opcja_autor" value="1" checked> Wybierz z listy:
            <select name="autor_l">
                <option>nieznany</option>
                <?php
                $wynik = pg_exec($link, "SELECT nazwisko, imie
			      FROM artysci");
                $ile=pg_numrows($wynik);
                for($i = 0; $i < $ile; $i++) {
                    $wiersz = pg_fetch_array($wynik, $i);
                    echo "<option>" . $wiersz["nazwisko"] . ", " . $wiersz["imie"] . "</option>";
                }
                ?>
            </select><br>
            <input type="radio" name="opcja_autor" value="2"> Dodaj nowego autora:<br>
            Nazwisko: <input type="text" name="n_autor_nazw">
            Imię: <input type="text" name="n_autor_imie">
            Rok urodzenia: <input type="text" name="n_autor_roku">
            Rok śmierci: <input type="text" name="n_autor_roks"><br>
            <input type="submit" value="Kolejny krok">
        </center>
    </form>
    <h2 align="center">Dodaj nowe miasto</h2><center>
        <form action="menu_dodawanie.php" method="post">
            Nazwa miasta: <input type="text" name="n_miasto"><br>
            <input type="submit" value="Dodaj">
        </form>
    </center>
    <?php
    if(!empty($n_miasto)){
        $nowe_id_miasto_t = pg_exec($link, "SELECT MAX(nazwa) AS max
      FROM Miasta");
        $nowe_id_miasto_w = pg_fetch_array($nowe_id_miasto_t, 0);
        $id_miasto = $nowe_id_miasto_w["max"] + 1;
        pg_exec($link, "INSERT INTO Miasta VALUES ('$id_miasto', '$n_miasto')");
    }
    ?>
    <h2 align="center">Rozpocznij nowe wydarzenie dla eksponatu</h2><center>
        Uwaga! Dodanie nowego wydarzenia zakończy obecne wydarzenie dla danego eksponatu ze wczorajszą datą i rozpocznie wybrane z dzisiejszą!
        <form action="new_event.php" method="post">
            ID: <input type="text" name="id" value="0"><br>
            Tytuł: <input type="text" name="tytul"><br>
            Nowe wydarzenie: <select name="lokalizacja">
                <option>Galeria</option>
                <option>Magazyn</option>
                <option>Wystawa objazdowa</option>
            </select><br>
            <input type="submit" value="Dalej">
        </form></center>
    <h2 align="center">Edytuj parametry dzieła</h2><center>
        <form action="edytuj_eksp.php" method="post">
            ID: <input type="text" name="id" value="0"><br>
            Tytuł: <input type="text" name="tytul"><br>
            <input type="submit" value="Edytuj ten eksponat">
        </form></center>
    <h2 align="center">Usuń dzieło</h2><center>
        <form action="usun_eksp.php" method="post">
            Uwaga! Usuwanie nie następuje w pełni. Zmieniany jest tylko stan eksponatu na sprzedany.
            Od tego momentu nie będzie się on wyświetlać w żadnym wyszukiwaniu, jednak bedzie można go przywrócić do bazy
            zmieniając jego status. Cała historia również zostanie zapamiętana, jednak do momentu przywrócenia nie będzie możliwości jej przeglądania.<br>
            ID: <input type="text" name="id" value="0"><br>
            Tytuł: <input type="text" name="tytul"><br>
            <input type="submit" value="Usuń ten eksponat">
        </form></center>
    <?php pg_close($link); ?>

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