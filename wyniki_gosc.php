<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'config.php'; ?>
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
                <li class="active"><a href="aplikacja.php">Aplikacja</a></li>
            </ul>
            <!--<ul class="nav navbar-nav navbar-right">-->
            <!--<li><a href="log.php"><span class="glyphicon glyphicon-log-in"></span> Logowanie</a></li>-->
            <!--</ul>-->

            <form action="logresult.php" method="post" id="signin" class="navbar-form navbar-right" role="form">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input type="text" name="login" class="form-control" value="" placeholder="Login Pracownika">
                </div>

                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="password" type="password" class="form-control" name="password" value=""
                           placeholder="Hasło Pracownika">
                </div>

                <button type="submit" class="btn btn-default">Loguj</button>
            </form>
        </div>
    </div>
</nav>
<div class="col-sm-11 text-left">
    <h1>Wyniki wyszukiwań</h1>
    <p align=\"justify\">

        <form action=aplikacja.php>
    <p align="center">
        <button class="btn default">Powrót do katalogu</button>
    </p>
    </form>

    <?php
    //        session_start();
    ?>

    <?php


    function wypisz_tabele($gdzie)
    {
        include 'config.php';
        $search = $_POST["search"];
        if ($gdzie == "G") {
            $zapytanie = "SELECT Eksponaty.tytul, Eksponaty.typ, Artysci.imie, Artysci.nazwisko,
                Eksponaty.obecna_lokalizacja, Sale.nr_sali, Sale.nr_galerii
				FROM eksponaty LEFT JOIN artysci ON Artysci.id_autora=Eksponaty.id_autora
				LEFT JOIN historia_ekspozycji h on eksponaty.id_eksponatu = h.id_eksponatu
				LEFT JOIN sale on h.nr_sali = sale.nr_sali
				WHERE h.koniec is NULL AND h.nr_sali is not null
               AND (LOWER(Eksponaty.tytul) LIKE LOWER('%$search%') OR (LOWER(Artysci.nazwisko) LIKE LOWER('%$search%') OR eksponaty.id_autora IS NULL))";
        } elseif ($gdzie == "M") {
            $zapytanie = "SELECT Eksponaty.tytul, Eksponaty.typ, Artysci.imie, Artysci.nazwisko,
                Eksponaty.obecna_lokalizacja
				FROM eksponaty LEFT JOIN artysci ON Artysci.id_autora=Eksponaty.id_autora
				LEFT JOIN historia_ekspozycji h on eksponaty.id_eksponatu = h.id_eksponatu
				WHERE h.koniec is NULL AND h.id_magazynowania is not null
                AND (LOWER(Eksponaty.tytul) LIKE LOWER('%$search%') OR (LOWER(Artysci.nazwisko) LIKE LOWER('%$search%') OR eksponaty.id_autora IS NULL))";
        } else {
            $zapytanie = "SELECT Eksponaty.tytul, Eksponaty.typ, Artysci.imie, Artysci.nazwisko,
                Eksponaty.obecna_lokalizacja, wo.id_wystawy, wo.nazwa_miasta, wo.data_rozpoczenia, wo.data_zakonczenia
				FROM eksponaty LEFT JOIN artysci ON Artysci.id_autora=Eksponaty.id_autora
				LEFT JOIN historia_ekspozycji h on eksponaty.id_eksponatu = h.id_eksponatu
				LEFT JOIN wystawy_objazdowe wo on h.id_wystawy = wo.id_wystawy
				WHERE h.koniec is NULL AND h.id_wystawy is not null
                AND (LOWER(Eksponaty.tytul) LIKE LOWER('%$search%') OR (LOWER(Artysci.nazwisko) LIKE LOWER('%$search%') OR eksponaty.id_autora IS NULL))";
        }
        $dbhost = "labdb";
        $dbname = "mrbd";
        $dbuser = "kg359266";
        $dbpass = "apollo";
        $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
        $wynik = pg_exec($link, $zapytanie);
        $ile = pg_numrows($wynik);

//        if ($ile == 0) {
//            echo "<center><strong>Brak!</strong></center>";
//        } else {
            if ($ile != 0 AND $gdzie == "G") {
                echo "<h2 align=center> <br> </br> Eksponaty spełniające kryteria wyszukiwania dostępne w muzeum: <br> </br> </h2>";
            } elseif ($ile != 0 AND $gdzie == "M") {
                echo "<h2 align=center> <br> </br> Eksponaty spełniające kryteria wyszukiwania umieszczone w magazynie: <br> </br></h2>";
            } elseif ($ile != 0 AND $gdzie == "O") {
                echo "<h2 align=center> <br> </br> Eksponaty spełniające kryteria wyszukiwania dostępne na wystawach objazdowych: <br> </br></h2>";
            }

            if($ile >0){
            echo "<table border=\"1\" align=center width=\"80%\">";
            echo "<tr align=\"center\">";

            echo "<th> <pre style= \"text-align: center;\"> Tytuł </pre> </th>";
            echo "<th> <pre style= \"text-align: center;\"> Typ </pre> </th>";
            echo "<th> <pre style= \"text-align: center;\"> Autor</pre> </th>";
            if ($gdzie == "G") {
                echo "<th> <pre style= \"text-align: center;\"> Galeria  </pre> </th>";
                echo "<th> <pre style= \"text-align: center;\"> Sala </pre></th>";
            } elseif ($gdzie == "O") {
                echo "<th> <pre style= \"text-align: center;\"> Wystawa </pre> </th>";
                echo "<th> <pre style= \"text-align: center;\"> Miasto </pre></th>";
                echo "<th> <pre style= \"text-align: center;\"> Początek </pre></th>";
                echo "<th> <pre style= \"text-align: center;\"> Koniec </pre></th>";
            }
            echo "</tr>";
            for ($i = 0; $i < $ile; $i++) {
                echo "<tr align=\"center\">\n";
                $wiersz = pg_fetch_array($wynik, $i);
                echo " <td align=\"center\">" . $wiersz["tytul"] . "</td>";
                echo "<td align=\"center\">" . $wiersz["typ"] . "</td>";
                if (!is_null($wiersz["nazwisko"])) echo "<td align=\"center\">" . $wiersz["imie"] . " " . $wiersz["nazwisko"] . "</td>";
                else echo "<td align=\"center\"> Autor nieznany </td>";
                if ($gdzie == "G") {
                    echo "<td align=\"center\">" . $wiersz["nr_galerii"] . "</td>";
                    echo "<td align=\"center\">" . $wiersz["nr_sali"] . "</td>";
                } elseif ($gdzie == "O") {
                    echo "<td align=\"center\">" . $wiersz["id_wystawy"] . "</td>";
                    echo "<td align=\"center\">" . $wiersz["nazwa_miasta"] . "</td>";
                    echo "<td align=\"center\">" . $wiersz["data_rozpoczenia"] . "</td>";
                    echo "<td align=\"center\">" . $wiersz["data_zakonczenia"] . "</td>";
                }
                echo "</tr>";
            }
            echo "</table >";
            }
        }
        pg_close($link);
//    } ?>

    <?php
    $search = $_POST["search"];
    $zapytanie = "SELECT eksponaty.tytul, artysci.imie, artysci.nazwisko FROM eksponaty 
                  LEFT JOIN artysci ON eksponaty.id_autora = artysci.id_autora
                  WHERE LOWER(Eksponaty.tytul) LIKE LOWER('%$search%')  
                  OR LOWER(Artysci.imie) LIKE LOWER('%$search%')
                  OR LOWER(Artysci.nazwisko) LIKE LOWER('%$search%')";
    $dbhost = "labdb";
    $dbname = "mrbd";
    $dbuser = "kg359266";
    $dbpass = "apollo";
    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_exec($link, $zapytanie);
    $zmienna = pg_numrows($wynik);
    $tutaj = $_POST["cala_baza"];


//    if ($zmienna > 0){
//        if($tutaj == 'on') {
//            wypisz_tabele("G");
//        }
//        else{
//            wypisz_tabele("G");
//            wypisz_tabele("M");
//            wypisz_tabele("O");
//        }
//}
//    else {
//        echo "<center><strong>Brak!</strong></center>";
//    }



    if($tutaj == 'on') {
        if ($zmienna > 0) {
            wypisz_tabele("G");
        } else {
            echo "<center><strong>Brak!</strong></center>";
        }
    }
    else {
        if ($zmienna > 0) {

            wypisz_tabele("G");
            wypisz_tabele("M");
            wypisz_tabele("O");
        } else {
            echo "<center><strong>Brak!</strong></center>";
        }
    }
    pg_close($link);
?>
    <p><br> <br> <br> <br><br><br><br><br><br><br></p>


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
