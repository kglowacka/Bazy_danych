<?php
$id_eksponatu = $_POST["eksponaty"];
$nazwa_wystawy_objazdowej = $_POST["wystawy_objazdowe"];

include "database_search_function.php";
include "config.php";

$id_wydarzenia = id_nowego_wydarzenia_historycznego();
$teraz = date('Y-m-d', strtotime("Now"));

$zapytanie_akutalizuj_eksponat = "UPDATE eksponaty SET obecna_lokalizacja='O' WHERE id_eksponatu=$id_eksponatu";

$zapytanie_akutalizuj_historie = "UPDATE historia_ekspozycji 
                                  SET koniec='$teraz' 
                                  WHERE id_eksponatu=$id_eksponatu AND koniec IS NULL";

$zapytanie_dodaj_do_historii = "INSERT INTO historia_ekspozycji VALUES 
                  ('$id_wydarzenia', '$id_eksponatu', '$teraz', NULL, '$nazwa_wystawy_objazdowej', NULL, NULL)";


$link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
pg_query($link, $zapytanie_akutalizuj_eksponat);
pg_query($link, $zapytanie_akutalizuj_historie);
pg_query($link, $zapytanie_dodaj_do_historii);
pg_close($link);
header('Location: wystawy_objazdowe.php');

