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
    <html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Menu dla pracowników</title>
    <body>
    <form action="menu_dodawanie.php" method="post">
        <p align="right">
            <input type="submit" value="Powrót">
        </p>
    </form>
    <?php
    include 'config.php';
    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $tytul = $_POST["tytul"];
    $id = $_POST["id"];
    $wynik = pg_exec($link, "SELECT id_eksponatu
				FROM Eksponaty
				WHERE LOWER(tytul) LIKE LOWER('%$tytul%') AND (id_eksponatu=$id OR $id=0)");
    $ile=pg_numrows($wynik);
    if($ile==0){
        echo "<center><strong>Brak!</strong></center>";
    }
    else if($ile>1){
        echo "<center><strong>Za dużo eksponatów!</strong></center>";
    }
    else if($ile==1){
        $wiersz = pg_fetch_array($wynik, 0);
        $id_eksponatu = $wiersz["id_eksponatu"];
        pg_exec($link, "UPDATE Eksponaty SET obecna_lokalizacja='S' WHERE id_eksponatu=$id_eksponatu");
        pg_exec($link, "UPDATE historia_ekspozycji SET koniec=CURRENT_DATE WHERE id_eksponatu=$id_eksponatu AND koniec IS NULL");
        $wynik=pg_exec($link, "SELECT Eksponaty.tytul, Eksponaty.typ, eksponaty.szerokosc, eksponaty.wysokosc, eksponaty.waga, Artysci.imie, Artysci.nazwisko
                FROM eksponaty LEFT JOIN artysci
                ON artysci.id_autora=Eksponaty.id_autora
                WHERE id_eksponatu=$id_eksponatu");
        ?>
        <center>Usunięto eksponat:</center>
        <table border="1" align=center>
            <tr>
                <th>Tytuł</th>
                <th>Typ</th>
                <th>Wysokość</th>
                <th>Szerokość</th>
                <th>Waga</th>
                <th>Imię autora</th>
                <th>Nazwisko autora</th>
            </tr>
            <?php
            echo "<tr>\n";
            $wiersz = pg_fetch_array($wynik, 0);
            echo "<td>" . $wiersz["tytul"] . "</td>
                <td>" . $wiersz["typ"] . "</td>";
            echo "<td>" . $wiersz["wysokosc"] . "</td>
                <td>" . $wiersz["szerokosc"] . "</td>
                <td>" . $wiersz["waga"] . "</td>";
            if(!is_null($wiersz["imie"])) echo "<td>" . $wiersz["imie"] . "</td>";
            else echo "<td> Autor nieznany </td>";
            if(!is_null($wiersz["nazwisko"]))echo "<td>" . $wiersz["nazwisko"] . "</td>";
            else echo "<td> Autor nieznany </td>";
            echo "</tr>";
            ?>
        </table>
        <?php
    }
    pg_close($link);
    ?>


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

