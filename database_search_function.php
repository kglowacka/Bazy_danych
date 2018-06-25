<?php

function normalizuj_autora(&$tabela, $numer_kolumny_z_nazwiskiem)
{
    for ($i = 0; $i < count($tabela); $i++) {
        if ($tabela[$i]["imie"] != NULL) {
            $tabela[$i]["imie"] = $tabela[$i]["imie"] . " " . $tabela[$i]["nazwisko"];
        } else {
            $tabela[$i]["imie"] = "Autor nieznany";
        }
        array_splice($tabela[$i], $numer_kolumny_z_nazwiskiem, 1);
    }
}

function konwertuj($slowo){
    if ($slowo == "typ") return "Typ dzieła";
    else if ($slowo== "wysokosc") return "Wysokość";
    else if ($slowo== "szerokosc") return "Szerokość";
    else if ($slowo== "waga") return "Waga";
    else if ($slowo== "imie") return "Autor";
    else return "";
}

function lokalizacja($skrot)
{
    if ($skrot == "G") return "Galeria";
    else if ($skrot == "M") return "Magazyn";
    else if ($skrot == "O") return "Wystawa objazdowa";
    else return "";
}

function normalizuj_lokalizacje(&$tabela)
{
    for ($i = 0; $i < count($tabela); $i++) {
        $tabela[$i]["obecna_lokalizacja"] = lokalizacja($tabela[$i]["obecna_lokalizacja"]);
    }
}

function normalizuj_koniec(&$tabela)
{
    for ($i = 0; $i < count($tabela); $i++) {
        if(!$tabela[$i]["koniec"]) $tabela[$i]["koniec"] = "Trwa";
    }
}

function rysuj_tabele($nazwy_kolumn, $wiersze)
{
    echo "<table border=\"1\" align=center width=\"80%\">";
    echo "<tr align=\"center\">";

    for ($i = 0; $i < count($nazwy_kolumn); $i++) {
        echo "<th> <pre style= \"text-align: center;\">" . $nazwy_kolumn[$i] . "</pre> </th>";
    }
    echo "</tr>";

    for ($i = 0; $i < count($wiersze); $i++) {
        echo "<tr align=\"center\">\n";
        foreach ($wiersze[$i] as $klucz => $wartosc):
            if ($klucz == 'tytul'){
                echo "<td align=\"center\"><a href='eksponat.php/?tytul=". $wartosc ."'>" . $wartosc . "</a></td>";
            } else {
                echo "<td align=\"center\">" . $wartosc . "</td>";
            }
        endforeach;
        echo "</tr>";
    }
    echo "</table >";
}

function wypisz_wszystkie_eksponaty($zapytanie)
{
    $zapytanie = "SELECT DISTINCT Eksponaty.id_eksponatu, Eksponaty.tytul, Eksponaty.obecna_lokalizacja 
				FROM eksponaty
				WHERE LOWER(Eksponaty.tytul) LIKE LOWER('%$zapytanie%')
				ORDER BY eksponaty.id_eksponatu";
    $nazwy_kolumn = array("ID eksponatu", "Tytuł", "Obecna lokalizacja");

    include "config.php";
    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_exec($link, $zapytanie);
    pg_close($link);
    $ile = pg_numrows($wynik);

    if ($ile == 0) {
        echo "<center><strong>Brak!</strong></center>";
    } else {
        $wiersze = pg_fetch_all($wynik);
        normalizuj_lokalizacje($wiersze);
        rysuj_tabele($nazwy_kolumn, $wiersze);
    }
}

function pokaz_dziela_w_galeriach($zapytanie)
{
    $zapytanie = "SELECT Eksponaty.tytul, Eksponaty.typ, Artysci.imie, Artysci.nazwisko, 
                Sale.nr_galerii, Sale.nr_sali
				FROM eksponaty LEFT JOIN artysci ON Artysci.id_autora=Eksponaty.id_autora
				LEFT JOIN historia_ekspozycji h on eksponaty.id_eksponatu = h.id_eksponatu
				LEFT JOIN sale on h.nr_sali = sale.nr_sali
				WHERE h.koniec is NULL AND h.nr_sali is not null
				AND (LOWER(Eksponaty.tytul) LIKE LOWER('%$zapytanie%') OR 
				(LOWER(Artysci.nazwisko) LIKE LOWER('%$zapytanie%') OR eksponaty.id_autora IS NULL))";

    $nazwy_kolumn = array("Tytuł", "Typ", "Autor", "Galeria", "Sala");

    include "config.php";

    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_query($link, $zapytanie);
    $ile = pg_numrows($wynik);
    pg_close($link);

    if ($ile == 0) {
        echo "<center><strong>Brak!</strong></center>";
    } else {
        $wiersze = pg_fetch_all($wynik);
        normalizuj_autora($wiersze, 3);
        rysuj_tabele($nazwy_kolumn, $wiersze);
    }
}

function pokaz_dziela_w_magazynie($zapytanie)
{

    $zapytanie = "SELECT Eksponaty.tytul, Eksponaty.typ, Artysci.imie, Artysci.nazwisko
				FROM Eksponaty LEFT JOIN Artysci ON Artysci.id_autora = Eksponaty.id_autora
				LEFT JOIN Historia_ekspozycji h ON Eksponaty.id_eksponatu = h.id_eksponatu
				WHERE h.koniec IS NULL AND h.id_magazynowania IS NOT NULL
				AND (LOWER(Eksponaty.tytul) LIKE LOWER('%$zapytanie%') OR 
				(LOWER(Artysci.nazwisko) LIKE LOWER('%$zapytanie%') OR eksponaty.id_autora IS NULL))";

    $nazwy_kolumn = array("Tytuł", "Typ", "Autor");

    include "config.php";

    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_query($link, $zapytanie);
    $ile = pg_numrows($wynik);
    pg_close($link);

    if ($ile == 0) {
        echo "<center><strong>Brak!</strong></center>";
    } else {
        $wiersze = pg_fetch_all($wynik);
        normalizuj_autora($wiersze, 3);
        rysuj_tabele($nazwy_kolumn, $wiersze);
    }
}

function pokaz_dziela_na_wystawach_objazdowych($zapytanie)
{

    $zapytanie = "SELECT Eksponaty.tytul, Eksponaty.typ, Artysci.imie, Artysci.nazwisko, 
                wo.nazwa_wystawy, wo.nazwa_miasta, wo.data_rozpoczenia, wo.data_zakonczenia
				FROM eksponaty LEFT JOIN artysci ON Artysci.id_autora=Eksponaty.id_autora
				LEFT JOIN historia_ekspozycji h ON eksponaty.id_eksponatu = h.id_eksponatu
				LEFT JOIN wystawy_objazdowe wo ON h.nazwa_wystawy = wo.nazwa_wystawy
				WHERE h.koniec IS NULL AND h.nazwa_wystawy IS NOT NULL
				AND (LOWER(Eksponaty.tytul) LIKE LOWER('%$zapytanie%') OR 
				(LOWER(Artysci.nazwisko) LIKE LOWER('%$zapytanie%') OR eksponaty.id_autora IS NULL))";

    $nazwy_kolumn = array("Tytuł", "Typ", "Autor", "Nazwa wystawy", "Miasto", "Data rozpoczęcia", "Data zakończenia");

    include "config.php";

    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_query($link, $zapytanie);
    $ile = pg_numrows($wynik);
    pg_close($link);

    if ($ile == 0) {
        echo "<center><strong>Brak!</strong></center>";
    } else {
        $wiersze = pg_fetch_all($wynik);
        normalizuj_autora($wiersze, 3);
        rysuj_tabele($nazwy_kolumn, $wiersze);
    }
}

function pokaz_wszystkie_wystawy_objazdowe(){
    $zapytanie = "SELECT *
				FROM wystawy_objazdowe";

    $nazwy_kolumn = array("Nazwa wystawy", "Miasto", "Początek", "Koniec");
    include "config.php";

    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_query($link, $zapytanie);
    $ile = pg_numrows($wynik);
    pg_close($link);

    if ($ile == 0) {
        echo "<center><strong>Brak!</strong></center>";
    } else {
        $wiersze = pg_fetch_all($wynik);
        rysuj_tabele($nazwy_kolumn, $wiersze);
    }
}

function wszyscy_autorzy(){
    $zapytanie = "SELECT id_autora, imie, nazwisko
                    FROM artysci";
    include "config.php";

    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_query($link, $zapytanie);
    pg_close($link);
    $wiersze = pg_fetch_all($wynik);
    normalizuj_autora($wiersze, 2);
    $autorzy = array();
    for($i = 0; $i < count($wiersze); $i++){
        $autorzy[$wiersze[$i]["id_autora"]] = $wiersze[$i]["imie"];
    }
    return $autorzy;
}

function wszystkie_eksponaty(){
    $zapytanie = "SELECT id_eksponatu, tytul
                    FROM eksponaty";
    include "config.php";

    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_query($link, $zapytanie);
    pg_close($link);
    $wiersze = pg_fetch_all($wynik);
    $eksponaty = array();
    for($i = 0; $i < count($wiersze); $i++){
        $eksponaty[$wiersze[$i]["id_eksponatu"]] = $wiersze[$i]["tytul"];
    }
    return $eksponaty;
}

function dostepne_eksponaty(){
    $zapytanie = "SELECT id_eksponatu, tytul
                    FROM eksponaty e1
                    WHERE (EXISTS (SELECT 1 FROM eksponaty e2 
                                  LEFT JOIN historia_ekspozycji h ON e2.id_eksponatu = h.id_eksponatu
                                  WHERE e2.id_autora = e1.id_autora
                                  AND e2.id_eksponatu != e1.id_eksponatu
                                  AND h.koniec IS NULL
                                  AND h.nazwa_wystawy IS NULL)
                          OR id_autora IS NULL)
                          AND dni_poza_muzeum_w_tym_roku(id_eksponatu, 2018) < 30";
    include "config.php";

    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_query($link, $zapytanie);
    pg_close($link);
    $wiersze = pg_fetch_all($wynik);
    $eksponaty = array();
    for($i = 0; $i < count($wiersze); $i++){
        $eksponaty[$wiersze[$i]["id_eksponatu"]] = $wiersze[$i]["tytul"];
    }
    return $eksponaty;
}

function wyswietl_galerie($zapytanie, $nr_sali = NULL)
{
    $zapytanie = "SELECT Eksponaty.tytul, Eksponaty.typ, Artysci.imie, Artysci.nazwisko, 
                Sale.nr_galerii, Sale.nr_sali
				FROM eksponaty LEFT JOIN artysci ON Artysci.id_autora=Eksponaty.id_autora
				LEFT JOIN historia_ekspozycji h on eksponaty.id_eksponatu = h.id_eksponatu
				LEFT JOIN sale on h.nr_sali = sale.nr_sali
				WHERE h.koniec is NULL AND (h.nr_sali = $nr_sali
				OR ($nr_sali IS NULL AND h.nr_sali IS NOT NULL ))
				AND LOWER(Eksponaty.tytul) LIKE LOWER('%$zapytanie%')";

    $nazwy_kolumn = array("Tytuł", "Typ", "Autor", "Galeria", "Sala");

    include "config.php";

    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_query($link, $zapytanie);
    $ile = pg_numrows($wynik);
    pg_close($link);

    if ($ile == 0) {
        echo "<center><strong>Brak!</strong></center>";
    } else {
        $wiersze = pg_fetch_all($wynik);
        normalizuj_autora($wiersze, 3);
        rysuj_tabele($nazwy_kolumn, $wiersze);
    }
}

function wszystkie_sale()
{
    $zapytanie = "SELECT nr_sali
                 FROM sale s";

    include "config.php";

    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_query($link, $zapytanie);
    pg_close($link);
    $wiersze = pg_fetch_all($wynik);
    return $wiersze;
}

function wolne_sale()
{
    $zapytanie = "SELECT nr_sali
                 FROM sale s 
                 WHERE (SELECT COUNT(*)
                        FROM historia_ekspozycji h
                        WHERE h.koniec IS NULL AND h.nr_sali = s.nr_sali) < pojemnosc";

    include "config.php";

    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_query($link, $zapytanie);
    pg_close($link);
    $wiersze = pg_fetch_all($wynik);
    return $wiersze;
}

function wszystkie_wystawy_objazdowe()
{
    $zapytanie = "SELECT nazwa_wystawy
                 FROM wystawy_objazdowe";

    include "config.php";

    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_query($link, $zapytanie);
    pg_close($link);
    $wiersze = pg_fetch_all($wynik);
    return $wiersze;
}

function biezace_wystawy_objazdowe()
{
    $teraz = date('Y-m-d H:i:s', strtotime("Now"));
    $zapytanie = "SELECT nazwa_wystawy
                 FROM wystawy_objazdowe
                 WHERE data_zakonczenia >= '${teraz}'";

    include "config.php";

    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_query($link, $zapytanie);
    pg_close($link);
    $wiersze = pg_fetch_all($wynik);
    return $wiersze;
}

function wyswietl_wystawy_objazdowe($fraza, $wystawa_objazdowa)
{
    $wystawa_objazdowa = pg_escape_string($wystawa_objazdowa);
    $zapytanie = "SELECT Eksponaty.tytul, Eksponaty.typ, Artysci.imie, Artysci.nazwisko, 
                wo.nazwa_wystawy, wo.nazwa_miasta, wo.data_rozpoczenia, wo.data_zakonczenia
				FROM eksponaty LEFT JOIN artysci ON Artysci.id_autora=Eksponaty.id_autora
				LEFT JOIN historia_ekspozycji h ON eksponaty.id_eksponatu = h.id_eksponatu
				LEFT JOIN wystawy_objazdowe wo ON h.nazwa_wystawy = wo.nazwa_wystawy
				WHERE h.koniec IS NULL AND (h.nazwa_wystawy = '{$wystawa_objazdowa}'
				OR ($wystawa_objazdowa IS NULL AND h.nazwa_wystawy IS NOT NULL ))
				AND (LOWER(Eksponaty.tytul) LIKE LOWER('%$fraza%'))";

    $nazwy_kolumn = array("Tytuł", "Typ", "Autor", "Nazwa wystawy", "Miasto", "Data rozpoczęcia", "Data zakończenia");

    include "config.php";

    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_query($link, $zapytanie);
    $ile = pg_numrows($wynik);
    pg_close($link);

    if ($ile == 0) {
        echo "<center><strong>Brak!</strong></center>";
    } else {
        $wiersze = pg_fetch_all($wynik);
        normalizuj_autora($wiersze, 3);
        rysuj_tabele($nazwy_kolumn, $wiersze);
    }
}

function wyswietl_historie($fraza, $poczatek, $koniec){
    $d_poczatek = date('Y-m-d', $poczatek);
    $d_koniec = date('Y-m-d', $koniec);
    $zapytanie = "SELECT Eksponaty.tytul, Eksponaty.typ, Artysci.imie, Artysci.nazwisko, 
                h.poczatek, h.koniec, h.nr_sali, h.id_magazynowania, h.nazwa_wystawy
				FROM eksponaty LEFT JOIN artysci ON Artysci.id_autora=Eksponaty.id_autora
				LEFT JOIN historia_ekspozycji h ON eksponaty.id_eksponatu = h.id_eksponatu
				WHERE (LOWER(Eksponaty.tytul) LIKE LOWER('%$fraza%'))
				AND h.poczatek <= '{$d_koniec}' AND (h.koniec >= '{$d_poczatek}' OR h.koniec IS NULL)";

    $nazwy_kolumn = array("Tytuł", "Typ", "Autor", "Początek", "Koniec", "Nr sali", "ID magazynowania",
        "Wystawa objazdowa");

    include "config.php";

    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_query($link, $zapytanie);
    $ile = pg_numrows($wynik);
    pg_close($link);

    if ($ile == 0) {
        echo "<center><strong>Brak!</strong></center>";
    } else {
        $wiersze = pg_fetch_all($wynik);
        normalizuj_autora($wiersze, 3);
        normalizuj_koniec($wiersze);
        rysuj_tabele($nazwy_kolumn, $wiersze);
    }
}

function dane_o_eksponacie($tytul){
    $zapytanie = "SELECT Eksponaty.typ, eksponaty.wysokosc, Eksponaty.szerokosc, eksponaty.waga, 
                Artysci.imie, Artysci.nazwisko
                FROM eksponaty LEFT JOIN artysci ON Artysci.id_autora=Eksponaty.id_autora
				WHERE eksponaty.tytul = '$tytul'";


    include "config.php";

    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_query($link, $zapytanie);
    pg_close($link);

    $wiersze = pg_fetch_all($wynik);
    normalizuj_autora($wiersze, 5);
    return $wiersze[0];
}

function historia_dziela($tytul){
    $zapytanie = "SELECT h.poczatek, h.koniec, h.nr_sali, h.id_magazynowania, h.nazwa_wystawy
				FROM eksponaty LEFT JOIN historia_ekspozycji h ON eksponaty.id_eksponatu = h.id_eksponatu
				WHERE eksponaty.tytul = '$tytul'";

    $nazwy_kolumn = array("Początek", "Koniec", "Nr sali", "ID magazynowania", "Wystawa objazdowa");

    include "config.php";

    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_query($link, $zapytanie);
    $ile = pg_numrows($wynik);
    pg_close($link);

    if ($ile == 0) {
        echo "<center><strong>Brak!</strong></center>";
    } else {
        $wiersze = pg_fetch_all($wynik);
        normalizuj_koniec($wiersze);
        rysuj_tabele($nazwy_kolumn, $wiersze);
    }
}

function id_nowego_artysty(){
    $zapytanie = "SELECT MAX(id_autora)
                FROM artysci";

    include "config.php";

    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_query($link, $zapytanie);
    pg_close($link);

    $wiersze = pg_fetch_all($wynik);
    return $wiersze[0]['max'] + 1;
}

function id_nowego_eksponatu(){
    $zapytanie = "SELECT MAX(id_eksponatu)
                FROM eksponaty";

    include "config.php";

    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_query($link, $zapytanie);
    pg_close($link);

    $wiersze = pg_fetch_all($wynik);
    return $wiersze[0]['max'] + 1;
}

function id_nowego_wydarzenia_historycznego(){
    $zapytanie = "SELECT MAX(id_wydarzenia)
                FROM historia_ekspozycji";

    include "config.php";

    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_query($link, $zapytanie);
    pg_close($link);

    $wiersze = pg_fetch_all($wynik);
    return $wiersze[0]['max'] + 1;
}

function id_nowego_magazynowania(){
    $zapytanie = "SELECT MAX(id_magazynowania)
                FROM magazyn";

    include "config.php";

    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_query($link, $zapytanie);
    pg_close($link);

    $wiersze = pg_fetch_all($wynik);
    return $wiersze[0]['max'] + 1;
}


function stworz_dzielo($tytul, $typ, $wysokosc, $szerokosc, $waga, $opcja_autor, $wybrane_id_autora, $imie, $nazwisko,
    $rok_urodzenia, $rok_smierci, $lokalizacja, $sala, $wystawa_objazdowa){
    include "config.php";
    if($opcja_autor == 'nowy'){
        $wybrane_id_autora = id_nowego_artysty();
        if($rok_smierci) {
            $zapytanie_nowy_autor = "INSERT INTO artysci VALUES 
                      ('$wybrane_id_autora', '$imie', '$nazwisko', '$rok_urodzenia', '$rok_smierci')";
        } else {
            $zapytanie_nowy_autor = "INSERT INTO artysci VALUES 
                      ('$wybrane_id_autora', '$imie', '$nazwisko', '$rok_urodzenia', NULL)";
        }
        $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
        pg_query($link, $zapytanie_nowy_autor);
    }
    $id_nowego_eksponatu = id_nowego_eksponatu();
    if ($wybrane_id_autora != 0) {
        $zapytanie_nowy_eksponat = "INSERT INTO eksponaty VALUES 
                      ('$id_nowego_eksponatu', '$tytul', '$typ', '$wysokosc', '$szerokosc', '$waga', 
                      '$wybrane_id_autora', '$lokalizacja')";
    } else {
        $zapytanie_nowy_eksponat = "INSERT INTO eksponaty VALUES 
                      ('$id_nowego_eksponatu', '$tytul', '$typ', '$wysokosc', '$szerokosc', '$waga', 
                      NULL, '$lokalizacja')";
    }
    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    pg_query($link, $zapytanie_nowy_eksponat);

    $id_wydarzenia = id_nowego_wydarzenia_historycznego();
    $poczatek = date('Y-m-d', strtotime("Now"));
    if($lokalizacja == 'G'){
        $zapytanie_historia = "INSERT INTO historia_ekspozycji VALUES 
                      ('$id_wydarzenia', '$id_nowego_eksponatu', '$poczatek', NULL, NULL,'$sala', NULL)";
    } else if($lokalizacja == 'M'){
        $id_magazynowania = id_nowego_magazynowania();
        $zapytanie_magazyn = "INSERT INTO magazyn VALUES ('$id_magazynowania')";
        $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
        pg_query($link, $zapytanie_magazyn);
        $zapytanie_historia = "INSERT INTO historia_ekspozycji VALUES 
                      ('$id_wydarzenia', '$id_nowego_eksponatu', '$poczatek', NULL, NULL, NULL, $id_magazynowania)";
    } else {
        $zapytanie_historia = "INSERT INTO historia_ekspozycji VALUES 
                      ('$id_wydarzenia', '$id_nowego_eksponatu', '$poczatek', NULL, '$wystawa_objazdowa', NULL, NULL)";
    }
    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    pg_query($link, $zapytanie_historia);
    pg_close($link);
}

