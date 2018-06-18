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
    $id = $_POST["id"];
    $tytul = $_POST["tytul"];
    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_exec($link, "SELECT id_eksponatu, tytul
				FROM Eksponaty
				WHERE obecna_lokalizacja!='S' AND ((LOWER(tytul) LIKE LOWER('%$tytul%') AND id_eksponatu=$id) OR (LOWER(tytul) LIKE LOWER('%$tytul%') AND $id=0))");
    $ile=pg_numrows($wynik);
    if($ile==0){
        echo "<center><strong>Brak takiego eksponatu!</strong></center>";
    }
    else if($ile>1){
        echo "<center><strong>Za dużo eksponatów!</strong></center>";
    }
    else if($ile==1){
        $szukany=pg_fetch_array($wynik, 0);
        $nazwa=$szukany["tytul"];
        $numer=$szukany["id_eksponatu"];
        echo "<h2 align=center>Oto historia wystaw objazdowych dla $nazwa</h2>";
        $dane = pg_exec($link, "SELECT Historia_ekspozycji.id_wystawy, Historia_ekspozycji.poczatek, Historia_ekspozycji.koniec, Wystawy_objazdowe.id_wystawy, Miasta.nazwa
				  FROM Eksponaty LEFT JOIN historia_ekspozycji
				  ON Eksponaty.id_eksponatu=historia_ekspozycji.id_eksponatu
				  LEFT JOIN Wystawy_objazdowe
				  ON historia_ekspozycji.id_wystawy=Wystawy_objazdowe.id_wystawy
				  LEFT JOIN Miasta
				  ON Wystawy_objazdowe.nazwa_miasta=Miasta.nazwa
				  WHERE Eksponaty.id_eksponatu=$numer AND historia_ekspozycji.id_wystawy_objazdowej IS NOT NULL
				  ORDER BY poczatek");
        $il_wierszy=pg_numrows($dane);
        ?>
        <table border="1" align=center>
        <tr>
            <th>ID wystawy objazdowej</th>
            <th>Początek</th>
            <th>Koniec</th>
            <th>Nazwa wystawy objazdowej</th>
            <th>Nazwa miasta</th>
        </tr>
        <?php
        for($i = 0; $i < $il_wierszy; $i++) {
            echo "<tr>\n";
            $wiersz = pg_fetch_array($dane, $i);
            echo "<td>" . $wiersz["id_wystawy"] . "</td>";
            echo "<td>" . $wiersz["poczatek"] . "</td>";
            if(!is_null($wiersz["koniec"]))echo "<td>" . $wiersz["koniec"] . "</td>";
            else echo "<td>  trwa nadal  </td>";
            echo "<td>" . $wiersz["id_wystawy"] . "</td>
	    <td>" . $wiersz["nazwa_miasta"] . "</td>
	    </tr>";
        }
        ?></table><?php
    }
    pg_close($link);
    ?>
    </br>
    <form action=menu_pracownik.php align="center">
        <input type="submit" value="Powrót"/>
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