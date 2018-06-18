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

</head>
<body>

<?php
$activePage = "aplikacja.php";
include 'navbar.php';
?>

<?php
//if($_SESSION["login"]==1)
//{
//    echo '<div style="float: right;"><form action="wyloguj.php" method="post">
//                <input type="submit" value="Wyloguj">
//                </form></div>
//                <div style="float: right;"><form action="menu_pracownik.php" method="post">
//                <input type="submit" value="Menu pracownika">
//                </form></div></br>';
//}
//else
//{
//    echo $_SESSION["login"];
//}
//?>

<div class="col-sm-11 text-left">
    <h1>Witamy w katalogu muzeum!</h1>
    <p align=\"justify\"></p>
    Zapraszamy do zapoznania się z listą aktualnie prezentowanych eksponatów i ich rozmieszczeniem oraz przeszukiwania
    całego zbioru.

    <p><br></p>
    <?php
            session_start();
    ?>

    </br><h3 align="center"></h3>
    <form action="wyniki_gosc.php" class="example" method="post" style="margin:auto;max-width:600px">
        <center>
            <input type="text" name="search" class="form-control" placeholder="Wyszukiwanie w bazie muzeum: wpisz tytuł lub autora">
            <br>
            <input type="checkbox" name="cala_baza" value="on"> Szukaj wyłącznie wśród eksponatów dostępnych w naszych
            galeriach <br>
            <br>
            <button class="btn default">Szukaj</button>


        </center>
    </form>

    <?php
    //        function lokalizacja($skrot)
    //        {
    //            if ($skrot == 'G') $napis = 'Zobacz u nas';
    //            else if ($skrot == 'M') $napis = 'Eksponat w magazynie';
    //            else if ($skrot == 'O') $napis = 'Szukaj na wystawie objazdowej!';
    //            return $napis;
    //        }

    function wypisz_tabele($gdzie)
    {
        if ($gdzie == "G") {
            $zapytanie = "SELECT Eksponaty.tytul, Eksponaty.typ, Artysci.imie, Artysci.nazwisko, 
                Eksponaty.obecna_lokalizacja, Sale.nr_sali, Sale.nr_galerii
				FROM eksponaty LEFT JOIN artysci ON Artysci.id_autora=Eksponaty.id_autora
				LEFT JOIN historia_ekspozycji h on eksponaty.id_eksponatu = h.id_eksponatu
				LEFT JOIN sale on h.nr_sali = sale.nr_sali
				WHERE h.koniec is NULL AND h.nr_sali is not null";
        } elseif ($gdzie == "M") {
            $zapytanie = "SELECT Eksponaty.tytul, Eksponaty.typ, Artysci.imie, Artysci.nazwisko, 
                Eksponaty.obecna_lokalizacja
				FROM eksponaty LEFT JOIN artysci ON Artysci.id_autora=Eksponaty.id_autora
				LEFT JOIN historia_ekspozycji h on eksponaty.id_eksponatu = h.id_eksponatu
				WHERE h.koniec is NULL AND h.id_magazynowania is not null";
        } else {
            $zapytanie = "SELECT Eksponaty.tytul, Eksponaty.typ, Artysci.imie, Artysci.nazwisko, 
                Eksponaty.obecna_lokalizacja, wo.id_wystawy, wo.nazwa_miasta, wo.data_rozpoczenia, wo.data_zakonczenia
				FROM eksponaty LEFT JOIN artysci ON Artysci.id_autora=Eksponaty.id_autora
				LEFT JOIN historia_ekspozycji h on eksponaty.id_eksponatu = h.id_eksponatu
				LEFT JOIN wystawy_objazdowe wo on h.id_wystawy = wo.id_wystawy
				WHERE h.koniec is NULL AND h.id_wystawy is not null";
        }
        $dbhost = "labdb";
        $dbname = "mrbd";
        $dbuser = "kg359266";
        $dbpass = "apollo";
        $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
        $wynik = pg_exec($link, $zapytanie);
        $ile = pg_numrows($wynik);

        if ($ile == 0) {
            echo "<center><strong>Brak!</strong></center>";
        } else {
            if ($gdzie == "G") {
                echo "<h2 align=center> <br> </br> Zobacz w naszych galeriach: <br> </br> </h2>";
            } elseif ($gdzie == "M") {
                echo "<h2 align=center> <br> </br> Te eksponaty są w magazynie - czekaj, aż wrócą do galerii: <br> </br></h2>";
            } else {
                echo "<h2 align=center> <br> </br>  Tych eksponatów szukaj na bieżących wystawach objazdowych: <br> </br></h2>";
            }
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
        pg_close($link);
    } ?>

    <?php wypisz_tabele("G") ?>
    <?php wypisz_tabele("M") ?>
    <?php wypisz_tabele("O") ?>

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
