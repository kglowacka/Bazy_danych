<?php
$nazwa_wystawy_objazdowej = $_POST["nazwa"];
$miasto = $_POST["miasto"];
$poczatek = date('Y-m-d H:i:s', strtotime($_POST["poczatek"]));
$koniec = date('Y-m-d H:i:s', strtotime($_POST["koniec"]));

include "database_search_function.php";
include "config.php";

$zapytanie_znajdz_miasto = "SELECT nazwa FROM miasta WHERE nazwa = '$miasto'";

$link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
$wynik = pg_query($link, $zapytanie_znajdz_miasto);
$ile = pg_numrows($wynik);

if ($ile == 0) {
    $zapytanie_wstaw_miasto = "INSERT INTO miasta VALUES ('$miasto')";
    pg_query($link, $zapytanie_wstaw_miasto);
}

$zapytanie_dodaj_wystawe_objazdowa = "INSERT INTO wystawy_objazdowe VALUES 
                  ('$nazwa_wystawy_objazdowej', '$miasto', '$poczatek', '$koniec')";


pg_query($link, $zapytanie_dodaj_wystawe_objazdowa);
pg_close($link);
header('Location: wystawy_objazdowe.php');

