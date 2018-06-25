<?php
$id_eksponatu = $_POST["eksponaty"];

include "database_search_function.php";
include "config.php";

$id_wydarzenia = id_nowego_wydarzenia_historycznego();
$teraz = date('Y-m-d', strtotime("Now"));
$id_magazynowania = id_nowego_magazynowania();

$zapytanie_magazyn = "INSERT INTO magazyn VALUES ('$id_magazynowania')";

$zapytanie_akutalizuj_eksponat = "UPDATE eksponaty SET obecna_lokalizacja='M' WHERE id_eksponatu=$id_eksponatu";

$zapytanie_akutalizuj_historie = "UPDATE historia_ekspozycji 
                                  SET koniec='$teraz' 
                                  WHERE id_eksponatu=$id_eksponatu AND koniec IS NULL";

$zapytanie_dodaj_do_historii = "INSERT INTO historia_ekspozycji VALUES 
                  ('$id_wydarzenia', '$id_eksponatu', '$teraz', NULL, NULL, NULL, $id_magazynowania)";


$link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
pg_query($link, $zapytanie_magazyn);
pg_query($link, $zapytanie_akutalizuj_eksponat);
pg_query($link, $zapytanie_akutalizuj_historie);
pg_query($link, $zapytanie_dodaj_do_historii);
pg_close($link);
header('Location: magazyn.php');

