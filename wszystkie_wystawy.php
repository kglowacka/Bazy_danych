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
    $wynik = pg_exec($link, "SELECT Eksponaty.id_eksponatu, Eksponaty.tytul, Eksponaty.typ, Sale.nr_galerii, Sale.nr_sali, Historia_ekspozcyji.poczatek, Prezentowane_eksponaty.planowany_koniec
			      FROM Eksponaty LEFT JOIN historia_ekspozycji
			      ON Eksponaty.id_eksponatu=historia_ekspozycji.id_eksponatu
			      LEFT JOIN Prezentowane_eksponaty
			      ON historia_ekspozycji.id_wystawy=Prezentowane_eksponaty.id_wystawy
			      LEFT JOIN Sale
			      ON Prezentowane_eksponaty.nr_sali=Sale.nr_sali
			      WHERE historia_ekspozycji.koniec IS NULL AND Eksponaty.obecna_lokalizacja='W'
			      ORDER BY eksponaty.id_eksponatu");
    $ile=pg_numrows($wynik);
    if ($ile==0) {
        echo "<center><strong>Brak wystaw!</strong></center>";
    }
    else{
        ?>
        <h2 align=center>Eksponaty w galeriach</h2>
        <table border="1" align=center>
        <tr>
            <th>ID</th>
            <th>Tytuł</th>
            <th>Typ</th>
            <th>Numer galerii</th>
            <th>Numer sali</th>
            <th>Początek wystawiania</th>
            <th>Planowany koniec</th>
        </tr>
        <?php
        for($i = 0; $i < $ile; $i++) {
            echo "<tr>\n";
            $wiersz = pg_fetch_array($wynik, $i);
            echo " <td>" . $wiersz["id_eksponatu"] . "</td>
	    <td>" . $wiersz["tytul"] . "</td>
	    <td>" . $wiersz["typ"] . "</td>";
            echo "<td>" . $wiersz["nr_galerii"] . "</td>
	    <td>" . $wiersz["nr_sali"] . "</td>
	    <td>" . $wiersz["poczatek"] . "</td>";
            if(!is_null($wiersz["planowany_koniec"])) echo "<td> " . $wiersz["planowany_koniec"] . "</td>";
            else echo "<td> Brak danych </td>";
            echo "</tr>";
        }
        ?></table><?php
    }
    pg_close($link);
    ?>
    </br>
    <form action=obsluga_wystaw.php align="center">
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
