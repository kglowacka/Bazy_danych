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
    function lokalizacja($slowo)
    {
        if($slowo == 'Galeria') $litera='G';
        else if($slowo == 'Magazyn') $litera='M';
        else if($slowo == 'Wystawa objazdowa') $litera='O';
        return $litera;
    }

    function odzyskaj_nazwisko($slowo)
    {
        $nazwisko_i_imie=explode(",", $slowo);
        $nazwisko=$nazwisko_i_imie[0];
        return $nazwisko;
    }
    ?>
    <form action="menu_dodawanie.php" method="post">
        <p align="right">
            <input type="submit" value="Powrót">
        </p>
    </form>
    <?php
    include 'config.php';
    $tytul = $_POST["tytul"];
    $typ = $_POST["typ"];
    $wysokosc = $_POST["wysokosc"];
    $szerokosc = $_POST["szerokosc"];
    $waga = $_POST["waga"];
    $opcja_autor = $_POST["opcja_autor"];
    $autor_l = $_POST["autor_l"];
    $n_autor_nazw= $_POST["n_autor_nazw"];
    $n_autor_imie= $_POST["n_autor_imie"];
    $n_autor_roku= $_POST["n_autor_roku"];
    $n_autor_roks= $_POST["n_autor_roks"];
    $lokalizacja = $_POST["lokalizacja"];
    $galeria = $_POST["galeria"];
    $sala = $_POST["sala"];
    $opcja_miasto = $_POST["opcja_miasto"];
    $miasto_l=$_POST["miasto_l"];
    $n_miasto = $_POST["n_miasto"];
    $przewidywany_koniec = $_POST["przewidywany_koniec"];
    $opcja_wysto = $_POST["opcja_wysto"];
    $n_wysto_l = $_POST["n_wysto_l"];
    $n_wysto_n = $_POST["n_wysto_n"];
    $miasto = $_POST["miasto"];
    $lok=lokalizacja($lokalizacja);
    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    ?>
    <form action="dodaj_eksp_szczegoly.php" method="post">
        <input type="hidden" name="tytul" value="<?php echo $tytul;?>">
        <input type="hidden" name="typ" value="<?php echo $typ;?>">
        <input type="hidden" name="wysokosc" value="<?php echo $wysokosc;?>">
        <input type="hidden" name="szerokosc" value="<?php echo $szerokosc;?>">
        <input type="hidden" name="waga" value="<?php echo $waga;?>">
        <input type="hidden" name="autor_l" value="<?php echo $autor_l;?>">
        <input type="hidden" name="opcja_autor" value="<?php echo $opcja_autor;?>">
        <input type="hidden" name="n_autor_nazw" value="<?php echo $n_autor_nazw;?>">
        <input type="hidden" name="n_autor_imie" value="<?php echo $n_autor_imie;?>">
        <input type="hidden" name="n_autor_roku" value="<?php echo $n_autor_roku;?>">
        <input type="hidden" name="n_autor_roks" value="<?php echo $n_autor_roks;?>">
        <input type="hidden" name="lokalizacja" value="<?php echo $lokalizacja;?>">
        Przewidywany koniec: <input type="date" name="przewidywany_koniec"><br>
        <input type="submit" value="Wybierz datę">
    </form>
    <?php
    if($lok == 'G'){
        ?>
        <h2 align="center">Wskaż dokładną lokalizację dzieła</h2>
        <form action="dodawanie_dziela_szczegoly.php" method="post">
            <input type="hidden" name="tytul" value="<?php echo $tytul;?>">
            <input type="hidden" name="typ" value="<?php echo $typ;?>">
            <input type="hidden" name="wysokosc" value="<?php echo $wysokosc;?>">
            <input type="hidden" name="szerokosc" value="<?php echo $szerokosc;?>">
            <input type="hidden" name="waga" value="<?php echo $waga;?>">
            <input type="hidden" name="autor_l" value="<?php echo $autor_l;?>">
            <input type="hidden" name="opcja_autor" value="<?php echo $opcja_autor;?>">
            <input type="hidden" name="n_autor_nazw" value="<?php echo $n_autor_nazw;?>">
            <input type="hidden" name="n_autor_imie" value="<?php echo $n_autor_imie;?>">
            <input type="hidden" name="n_autor_roku" value="<?php echo $n_autor_roku;?>">
            <input type="hidden" name="n_autor_roks" value="<?php echo $n_autor_roks;?>">
            <input type="hidden" name="lokalizacja" value="<?php echo $lokalizacja;?>">
            <input type="hidden" name="przewidywany_koniec" value="<?php echo $przewidywany_koniec;?>">
            Galeria: <select name="galeria">
                <?php
                $wynik = pg_exec($link, "SELECT nr_galerii
        FROM Galerie");
                $ile=pg_numrows($wynik);
                for($i = 0; $i < $ile; $i++) {
                    $wiersz = pg_fetch_array($wynik, $i);
                    echo "<option>" . $wiersz["nr_galerii"] . "</option>";
                }
                ?>
            </select>
            <input type="submit" value="Wybierz galerię">
        </form>
        <form action="dodaj_eksp_szczegoly.php" method="post">
            <input type="hidden" name="tytul" value="<?php echo $tytul;?>">
            <input type="hidden" name="typ" value="<?php echo $typ;?>">
            <input type="hidden" name="wysokosc" value="<?php echo $wysokosc;?>">
            <input type="hidden" name="szerokosc" value="<?php echo $szerokosc;?>">
            <input type="hidden" name="waga" value="<?php echo $waga;?>">
            <input type="hidden" name="autor_l" value="<?php echo $autor_l;?>">
            <input type="hidden" name="opcja_autor" value="<?php echo $opcja_autor;?>">
            <input type="hidden" name="n_autor_nazw" value="<?php echo $n_autor_nazw;?>">
            <input type="hidden" name="n_autor_imie" value="<?php echo $n_autor_imie;?>">
            <input type="hidden" name="n_autor_roku" value="<?php echo $n_autor_roku;?>">
            <input type="hidden" name="n_autor_roks" value="<?php echo $n_autor_roks;?>">
            <input type="hidden" name="lokalizacja" value="<?php echo $lokalizacja;?>">
            <input type="hidden" name="przewidywany_koniec" value="<?php echo $przewidywany_koniec;?>">
            Sala: <select name="sala">
                <?php
                $wynik = pg_exec($link, "SELECT nr_sali
        FROM Sale
        WHERE nr_galerii='$galeria'");
                $ile=pg_numrows($wynik);
                for($i = 0; $i < $ile; $i++) {
                    $wiersz = pg_fetch_array($wynik, $i);
                    echo "<option>" . $wiersz["nr_sali"] . "</option>";
                }
                ?>
            </select>
            <input type="submit" value="Wybierz salę">
        </form>
        <?php
        if(!empty($sala)){
            $nowe_id_eks_t=pg_exec($link, "SELECT MAX(id_eksponatu) AS max
            FROM Eksponaty");
            $nowe_id_eks_w=pg_fetch_array($nowe_id_eks_t, 0);
            $nowe_id_eks=$nowe_id_eks_w["max"]+1;
            $nowe_id_hist_t=pg_exec($link, "SELECT MAX(id) AS max
            FROM Historia_ekspozycji");
            $nowe_id_hist_w=pg_fetch_array($nowe_id_hist_t, 0);
            $nowe_id_hist=$nowe_id_hist_w["max"]+1;
            $nowe_id_wyst_t=pg_exec($link, "SELECT MAX(id_wystawy) AS max
            FROM Prezentowane_eksponaty");
            $nowe_id_wyst_w=pg_fetch_array($nowe_id_wyst_t, 0);
            $nowe_id_wyst=$nowe_id_wyst_w["max"]+1;
            if($opcja_autor=='1') {
                if ($autor_l != "nieznany") {
                    $autor_nazw = odzyskaj_nazwisko($autor_l);
                    $autor_pom = pg_exec($link, "SELECT id_autora
                    FROM Artysci
                    WHERE nazwisko='$autor_nazw'");
                    $autor_id_wiersz = pg_fetch_array($autor_pom, 0);
                    $autor_id = $autor_id_wiersz["id_autora"];
                }
                else $autor_id=NULL;
            }
            else if($opcja_autor=='2'){
                $nowe_id_autor_t=pg_exec($link, "SELECT MAX(id_autora) AS max
                                                FROM Artysci");
                $nowe_id_autor_w=pg_fetch_array($nowe_id_autor_t, 0);
                $autor_id=$nowe_id_autor_w["max"]+1;
                if(!empty($n_autor_roks)){
                    pg_exec($link, "INSERT INTO Artysci VALUES ('$autor_id', '$n_autor_imie', '$n_autor_nazw', '$n_autor_roku', '$n_autor_roks')");
                }
                else pg_exec($link, "INSERT INTO Artysci VALUES ('$autor_id', '$n_autor_imie', '$n_autor_nazw', '$n_autor_roku', NULL)");
            }
            if(!is_null($autor_id)) pg_exec($link, "INSERT INTO Eksponaty VALUES ('$nowe_id_eks', '$tytul', '$typ', '$wysokosc', '$szerokosc', '$waga', '$autor_id', 'W', '$cen')");
            else  pg_exec($link, "INSERT INTO Eksponaty VALUES ('$nowe_id_eks', '$tytul', '$typ', '$wysokosc', '$szerokosc', '$waga', NULL, 'W', '$cen')");
            pg_exec($link, "INSERT INTO Prezentowane_eksponaty VALUES ('$nowe_id_wyst', '$sala', '$przewidywany_koniec')");
            pg_exec($link, "INSERT INTO Historia_ekspozycji VALUES ('$nowe_id_hist', '$nowe_id_eks', '$nowe_id_wyst', NULL, NULL, NULL, CURRENT_DATE, NULL)");
            $nowy_t=pg_exec($link, "SELECT Eksponaty.id_eksponatu, Eksponaty.tytul, Eksponaty.typ, Eksponaty.cenny, Eksponaty.wysokosc, Eksponaty.szerokosc, Eksponaty.waga, Autorzy.imie, Autorzy.nazwisko, Sale.nr_galerii, Sale.nr_sali, Prezentowane_eksponaty.planowany_koniec
            FROM Eksponaty LEFT JOIN Artysci
            ON Eksponaty.id_autora=Artysci.id_autora
            LEFT JOIN historia_ekspozycji
            ON eksponaty.id_eksponatu = historia_ekspozycji.id_eksponatu
            LEFT JOIN prezentowane_eksponaty
            ON historia_ekspozycji.id_wystawy = prezentowane_eksponaty.id_wystawy
            LEFT JOIN sale
            ON prezentowane_eksponaty.nr_sali = sale.nr_sali 
            WHERE Eksponaty.id_eksponatu='$nowe_id_eks'");
            ?>
            <table border="1" align=center>
            <tr>
                <th>ID</th>
                <th>Tytuł</th>
                <th>Typ</th>
                <th>Wysokość</th>
                <th>Szerokość</th>
                <th>Waga</th>
                <th>Imię autora</th>
                <th>Nazwisko autora</th>
                <th>Galeria</th>
                <th>Sala</th>
                <th>Planowany koniec</th>
            </tr>
            <?php
            echo "Dodano do bazy: <tr>\n";
            $nowy_w = pg_fetch_array($nowy_t, 0);
            echo "<td>" . $nowy_w["id_eksponatu"] . "</td>
            <td>" . $nowy_w["tytul"] . "</td>
            <td>" . $nowy_w["typ"] . "</td>
            <td>" . $nowy_w["wysokosc"] . "</td>
            <td>" . $nowy_w["szerokosc"] . "</td>
            <td>" . $nowy_w["waga"] . "</td>";
            if(!is_null($nowy_w["imie"])) echo "<td>" . $nowy_w["imie"] . "</td>";
            else echo "<td>  Brak danych  </td>";
            if(!is_null($nowy_w["nazwisko"])) echo "<td>" . $nowy_w["nazwisko"] . "</td>";
            else echo "<td>  Brak danych  </td>";
            echo "<td>" . $nowy_w["nr_galerii"] . "</td>
            <td>" . $nowy_w["nr_sali"] . "</td>";
            if(!is_null($nowy_w["planowany_koniec"])) echo "<td>" . $nowy_w["planowany_koniec"] . "</td>";
            else echo "<td>  Brak danych  </td>";
            echo "</tr>";
            ?></table><?php
        }
    }
    else if($lok == 'M'){
        if(!empty($przewidywany_koniec)) {
            $nowe_id_eks_t = pg_exec($link, "SELECT MAX(id_eksponatu) AS max
                                              FROM Eksponaty");
            $nowe_id_eks_w = pg_fetch_array($nowe_id_eks_t, 0);
            $nowe_id_eks = $nowe_id_eks_w["max"] + 1;
            $nowe_id_hist_t = pg_exec($link, "SELECT MAX(id) AS max
                                              FROM Historia_ekspozycji");
            $nowe_id_hist_w = pg_fetch_array($nowe_id_hist_t, 0);
            $nowe_id_hist = $nowe_id_hist_w["max"] + 1;
            $nowe_id_mag_t = pg_exec($link, "SELECT MAX(id_umieszczenia_w_magazynie) AS max
                                              FROM Magazyn");
            $nowe_id_mag_w = pg_fetch_array($nowe_id_mag_t, 0);
            $nowe_id_mag = $nowe_id_mag_w["max"] + 1;
            if ($opcja_autor == '1') {
                if ($autor_l != "nieznany") {
                    $autor_nazw = odzyskaj_nazwisko($autor_l);
                    $autor_pom = pg_exec($link, "SELECT id_autora
                    FROM Artysci
                    WHERE nazwisko='$autor_nazw'");
                    $autor_id_wiersz = pg_fetch_array($autor_pom, 0);
                    $autor_id = $autor_id_wiersz["id_autora"];
                } else $autor_id = NULL;
            } else if ($opcja_autor == '2') {
                $nowe_id_autor_t = pg_exec($link, "SELECT MAX(id_autora) AS max
                                                FROM Artysci");
                $nowe_id_autor_w = pg_fetch_array($nowe_id_autor_t, 0);
                $autor_id = $nowe_id_autor_w["max"] + 1;
                if (!empty($n_autor_roks)) {
                    pg_exec($link, "INSERT INTO Artysci VALUES ('$autor_id', '$n_autor_imie', '$n_autor_nazw', '$n_autor_roku', '$n_autor_roks')");
                } else pg_exec($link, "INSERT INTO Artysci VALUES ('$autor_id', '$n_autor_imie', '$n_autor_nazw', '$n_autor_roku', NULL)");
            }
            if (!is_null($autor_id)) pg_exec($link, "INSERT INTO Eksponaty VALUES ('$nowe_id_eks', '$tytul', '$typ', '$wysokosc', '$szerokosc', '$waga', '$autor_id', 'M', '$cen')");
            else  pg_exec($link, "INSERT INTO Eksponaty VALUES ('$nowe_id_eks', '$tytul', '$typ', '$wysokosc', '$szerokosc', '$waga', NULL, 'M', '$cen')");
            pg_exec($link, "INSERT INTO Magazyn VALUES ('$nowe_id_mag', '$przewidywany_koniec')");
            pg_exec($link, "INSERT INTO Historia_ekspozycji VALUES ('$nowe_id_hist', '$nowe_id_eks', NULL, '$nowe_id_mag', NULL, NULL, CURRENT_DATE, NULL)");
            $nowy_t = pg_exec($link, "SELECT Eksponaty.id_eksponatu, Eksponaty.tytul, Eksponaty.typ, Eksponaty.cenny, Eksponaty.wysokosc, Eksponaty.szerokosc, Eksponaty.waga, Artysci.imie, Artysci.nazwisko, magazyn.planowany_koniec
                                        FROM Eksponaty LEFT JOIN artysci
                                        ON Eksponaty.id_autora=Autorzy.id_autora
                                        LEFT JOIN historia
                                        ON eksponaty.id_eksponatu = historia.id_eksponatu
                                        LEFT JOIN magazyn
                                        ON historia.id_umieszczenia_w_magazynie = magazyn.id_umieszczenia_w_magazynie
                                        WHERE Eksponaty.id_eksponatu='$nowe_id_eks'");
            ?>
            <table border="1" align=center>
            <tr>
                <th>ID</th>
                <th>Tytuł</th>
                <th>Typ</th>
                <th>Wysokość</th>
                <th>Szerokość</th>
                <th>Waga</th>
                <th>Imię autora</th>
                <th>Nazwisko autora</th>
                <th>Planowany koniec</th>
            </tr>
            <?php
            echo "Dodano do bazy: <tr>\n";
            $nowy_w = pg_fetch_array($nowy_t, 0);
            echo "<td>" . $nowy_w["id_eksponatu"] . "</td>
            <td>" . $nowy_w["tytul"] . "</td>
            <td>" . $nowy_w["typ"] . "</td>
   
            <td>" . $nowy_w["wysokosc"] . "</td>
            <td>" . $nowy_w["szerokosc"] . "</td>
            <td>" . $nowy_w["waga"] . "</td>";
            if (!is_null($nowy_w["imie"])) echo "<td>" . $nowy_w["imie"] . "</td>";
            else echo "<td>  Brak danych  </td>";
            if (!is_null($nowy_w["nazwisko"])) echo "<td>" . $nowy_w["nazwisko"] . "</td>";
            else echo "<td>  Brak danych  </td>";
            if(!is_null($nowy_w["planowany_koniec"])) echo "<td>" . $nowy_w["planowany_koniec"] . "</td>";
            else echo "<td>  Brak danych  </td>";
            echo "</tr>";
            ?></table><?php
        }
    }
    else if($lok == 'I'){
        if($cen=='T'){
            echo "<center> Nie można wypożyczać cennego dzieła! </center>";

        }
        else {
            ?>
            <h2 align="center">Wskaż instytucję, której chcesz wypożyczyć dzieło</h2>
            <form action="dodawanie_dziela_szczegoly.php" method="post">
                <input type="hidden" name="tytul" value="<?php echo $tytul; ?>">
                <input type="hidden" name="typ" value="<?php echo $typ; ?>">
                <input type="hidden" name="wysokosc" value="<?php echo $wysokosc; ?>">
                <input type="hidden" name="szerokosc" value="<?php echo $szerokosc; ?>">
                <input type="hidden" name="waga" value="<?php echo $waga; ?>">
                <input type="hidden" name="autor_l" value="<?php echo $autor_l; ?>">
                <input type="hidden" name="opcja_autor" value="<?php echo $opcja_autor; ?>">
                <input type="hidden" name="n_autor_nazw" value="<?php echo $n_autor_nazw; ?>">
                <input type="hidden" name="n_autor_imie" value="<?php echo $n_autor_imie; ?>">
                <input type="hidden" name="n_autor_roku" value="<?php echo $n_autor_roku; ?>">
                <input type="hidden" name="n_autor_roks" value="<?php echo $n_autor_roks; ?>">
                <input type="hidden" name="lokalizacja" value="<?php echo $lokalizacja; ?>">
                <input type="hidden" name="przewidywany_koniec" value="<?php echo $przewidywany_koniec; ?>">

                </select><br>
                <input type="radio" name="opcja_miasto" value="2"> Dodaj nowe miasto:<br>
                Nazwa miasta: <input type="text" name="n_miasto"><br>
                <input type="submit" value="Wypożycz tej instytucji">
            </form>
            <?php
            if($opcja_instytucja=='1'){
                $id_inst_t = pg_exec($link, "SELECT id_instytucji
                                              FROM Instytucje
                                              WHERE nazwa='$instytucja_l'");
                $id_inst_w = pg_fetch_array($id_inst_t, 0);
                $id_inst = $id_inst_w["id_instytucji"];
            }
            else if($opcja_instytucja=='2'){
                if($opcja_miasto=='1'){
                    $id_miasto_t = pg_exec($link, "SELECT id_miasta
                                              FROM Miasta
                                              WHERE nazwa_miasta='$miasto_l'");
                    $id_miasto_w = pg_fetch_array($id_miasto_t, 0);
                    $id_miasto = $id_miasto_w["id_miasta"];
                }
                else if($opcja_miasto=='2'){
                    $nowe_id_miasto_t = pg_exec($link, "SELECT MAX(id_miasta) AS max
                                                      FROM Miasta");
                    $nowe_id_miasto_w = pg_fetch_array($nowe_id_miasto_t, 0);
                    $id_miasto = $nowe_id_miasto_w["max"] + 1;
                    pg_exec($link, "INSERT INTO Miasta VALUES ('$id_miasto', '$n_miasto')");
                    echo"Dodano miasto " . $n_miasto . " do bazy<br>";
                }
                $nowe_id_inst_t = pg_exec($link, "SELECT MAX(id_instytucji) AS max
                                                      FROM instytucje");
                $nowe_id_inst_w = pg_fetch_array($nowe_id_inst_t, 0);
                $id_inst = $nowe_id_inst_w["max"] + 1;
                pg_exec($link, "INSERT INTO instytucje VALUES ('$id_inst', '$n_instytucja', '$id_miasto')");
                echo"Dodano instytucję " . $n_instytucja . " do bazy<br>";
            }
            if (!empty($id_inst)) {
                $koniec = mktime(0, 0, 0, date("m",strtotime($przewidywany_koniec)), date("d",strtotime($przewidywany_koniec)), date("Y",strtotime($przewidywany_koniec)));
                $max_koniec = mktime(0, 0, 0, date("m"), date("d") + 29, date("Y"));
                if ($koniec > $max_koniec) echo "zbyt długie wypożyczenie";
                else {
                    $nowe_id_eks_t = pg_exec($link, "SELECT MAX(id_eksponatu) AS max
        FROM Eksponaty");
                    $nowe_id_eks_w = pg_fetch_array($nowe_id_eks_t, 0);
                    $nowe_id_eks = $nowe_id_eks_w["max"] + 1;
                    $nowe_id_hist_t = pg_exec($link, "SELECT MAX(id) AS max
        FROM Historia");
                    $nowe_id_hist_w = pg_fetch_array($nowe_id_hist_t, 0);
                    $nowe_id_hist = $nowe_id_hist_w["max"] + 1;
                    $nowe_id_inst_t = pg_exec($link, "SELECT MAX(id_wypozyczenia) AS max
        FROM Wypozyczenia_instytucjom");
                    $nowe_id_inst_w = pg_fetch_array($nowe_id_inst_t, 0);
                    $nowe_id_inst = $nowe_id_inst_w["max"] + 1;
                    if($opcja_autor=='1') {
                        if ($autor_l != "nieznany") {
                            $autor_nazw = odzyskaj_nazwisko($autor_l);
                            $autor_pom = pg_exec($link, "SELECT id_autora
                    FROM Autorzy
                    WHERE nazwisko='$autor_nazw'");
                            $autor_id_wiersz = pg_fetch_array($autor_pom, 0);
                            $autor_id = $autor_id_wiersz["id_autora"];
                        }
                        else $autor_id=NULL;
                    }
                    else if($opcja_autor=='2'){
                        $nowe_id_autor_t=pg_exec($link, "SELECT MAX(id_autora) AS max
                                                FROM Autorzy");
                        $nowe_id_autor_w=pg_fetch_array($nowe_id_autor_t, 0);
                        $autor_id=$nowe_id_autor_w["max"]+1;
                        if(!empty($n_autor_roks)){
                            pg_exec($link, "INSERT INTO Autorzy VALUES ('$autor_id', '$n_autor_imie', '$n_autor_nazw', '$n_autor_roku', '$n_autor_roks')");
                        }
                        else pg_exec($link, "INSERT INTO Autorzy VALUES ('$autor_id', '$n_autor_imie', '$n_autor_nazw', '$n_autor_roku', NULL)");
                    }
                    if(!is_null($autor_id)) pg_exec($link, "INSERT INTO Eksponaty VALUES ('$nowe_id_eks', '$tytul', '$typ', '$wysokosc', '$szerokosc', '$waga', '$autor_id', 'I', '$cen')");
                    else  pg_exec($link, "INSERT INTO Eksponaty VALUES ('$nowe_id_eks', '$tytul', '$typ', '$wysokosc', '$szerokosc', '$waga', NULL, 'I', '$cen')");
                    pg_exec($link, "INSERT INTO Wypozyczenia_instytucjom VALUES ('$nowe_id_inst', '$id_inst', '$przewidywany_koniec')");
                    pg_exec($link, "INSERT INTO Historia VALUES ('$nowe_id_hist', '$nowe_id_eks', NULL, NULL, '$nowe_id_inst', NULL, CURRENT_DATE, NULL)");
                    $nowy_t = pg_exec($link, "SELECT Eksponaty.id_eksponatu, Eksponaty.tytul, Eksponaty.typ, Eksponaty.cenny, Eksponaty.wysokosc, Eksponaty.szerokosc, Eksponaty.waga, Autorzy.imie, Autorzy.nazwisko, instytucje.nazwa, miasta.nazwa_miasta, wypozyczenia_instytucjom.planowany_koniec
                                              FROM Eksponaty LEFT JOIN Autorzy
                                              ON Eksponaty.id_autora=Autorzy.id_autora
                                              LEFT JOIN historia
                                              ON eksponaty.id_eksponatu = historia.id_eksponatu
                                              LEFT JOIN wypozyczenia_instytucjom
                                              ON historia.id_wypozyczenia = wypozyczenia_instytucjom.id_wypozyczenia
                                              LEFT JOIN instytucje
                                              ON wypozyczenia_instytucjom.id_instytucji = instytucje.id_instytucji
                                              LEFT JOIN miasta
                                              ON instytucje.id_miasta = miasta.id_miasta
                                              WHERE Eksponaty.id_eksponatu='$nowe_id_eks'");
                    ?>
                    <table border="1" align=center>
                    <tr>
                        <th>ID</th>
                        <th>Tytuł</th>
                        <th>Typ</th>
                        <th>Cenny</th>
                        <th>Wysokość</th>
                        <th>Szerokość</th>
                        <th>Waga</th>
                        <th>Imię autora</th>
                        <th>Nazwisko autora</th>
                        <th>Instytucja</th>
                        <th>Miasto</th>
                        <th>Planowany koniec</th>
                    </tr>
                    <?php
                    echo "Dodano do bazy: <tr>\n";
                    $nowy_w = pg_fetch_array($nowy_t, 0);
                    echo "<td>" . $nowy_w["id_eksponatu"] . "</td>
                    <td>" . $nowy_w["tytul"] . "</td>
                    <td>" . $nowy_w["typ"] . "</td>
                    <td>" . $nowy_w["cenny"] . "</td>
                    <td>" . $nowy_w["wysokosc"] . "</td>
                    <td>" . $nowy_w["szerokosc"] . "</td>
                    <td>" . $nowy_w["waga"] . "</td>";
                    if(!is_null($nowy_w["imie"])) echo "<td>" . $nowy_w["imie"] . "</td>";
                    else echo "<td>  Brak danych  </td>";
                    if(!is_null($nowy_w["nazwisko"])) echo "<td>" . $nowy_w["nazwisko"] . "</td>";
                    else echo "<td>  Brak danych  </td>";
                    echo "<td>" . $nowy_w["nazwa"] . "</td>
                    <td>" . $nowy_w["nazwa_miasta"] . "</td>";
                    if(!is_null($nowy_w["planowany_koniec"])) echo "<td>" . $nowy_w["planowany_koniec"] . "</td>";
                    else echo "<td>  Brak danych  </td>";
                    echo "</tr>";
                    ?></table><?php
                }
            }
        }
    }
    else if($lok == 'O'){
        if($cen=='T'){
            echo "<center> Nie można wypożyczać cennego dzieła! </center>";

        }
        else {
            ?>
            <h2 align="center">Podaj wystawę objazdową, na którą chcesz wysłać dzieło</h2>
            <form action="dodawanie_dziela_szczegoly.php" method="post">
                <input type="hidden" name="tytul" value="<?php echo $tytul; ?>">
                <input type="hidden" name="typ" value="<?php echo $typ; ?>">
                <input type="hidden" name="cenny" value="<?php echo $cenny; ?>">
                <input type="hidden" name="wysokosc" value="<?php echo $wysokosc; ?>">
                <input type="hidden" name="szerokosc" value="<?php echo $szerokosc; ?>">
                <input type="hidden" name="waga" value="<?php echo $waga; ?>">
                <input type="hidden" name="autor_l" value="<?php echo $autor_l; ?>">
                <input type="hidden" name="opcja_autor" value="<?php echo $opcja_autor; ?>">
                <input type="hidden" name="n_autor_nazw" value="<?php echo $n_autor_nazw; ?>">
                <input type="hidden" name="n_autor_imie" value="<?php echo $n_autor_imie; ?>">
                <input type="hidden" name="n_autor_roku" value="<?php echo $n_autor_roku; ?>">
                <input type="hidden" name="n_autor_roks" value="<?php echo $n_autor_roks; ?>">
                <input type="hidden" name="lokalizacja" value="<?php echo $lokalizacja; ?>">
                <input type="hidden" name="przewidywany_koniec" value="<?php echo $przewidywany_koniec; ?>">
                Wystawa objazdowa:<br>
                <input type="radio" name="opcja_wysto" value="1" checked> Wybierz z listy:
                <select name="n_wysto_l">
                    <?php
                    $wynik = pg_exec($link, "SELECT nazwa_wystawy_objazdowej
                                              FROM wystawy_objazdowe
                                              GROUP BY nazwa_wystawy_objazdowej");
                    $ile = pg_numrows($wynik);
                    for ($i = 0; $i < $ile; $i++) {
                        $wiersz = pg_fetch_array($wynik, $i);
                        echo "<option>" . $wiersz["nazwa_wystawy_objazdowej"] . "</option>";
                    }
                    ?>
                </select><br>
                <input type="radio" name="opcja_wysto" value="2"> Dodaj nową wystawę objazdową:<br>
                Nazwa: <input type="text" name="n_wysto_n"><br>
                Miasto: <input type="radio" name="opcja_miasto" value="1" checked> Wybierz z listy:
                <select name="miasto_l">
                    <?php
                    $wynik = pg_exec($link, "SELECT nazwa_miasta
                        FROM miasta");
                    $ile = pg_numrows($wynik);
                    for ($i = 0; $i < $ile; $i++) {
                        $wiersz = pg_fetch_array($wynik, $i);
                        echo "<option>" . $wiersz["nazwa_miasta"] . "</option>";
                    }
                    ?>
                </select><br>
                <input type="radio" name="opcja_miasto" value="2"> Dodaj nowe miasto:<br>
                Nazwa miasta: <input type="text" name="n_miasto"><br>
                <input type="submit" value="Wyślij na tę wystawę objazdową">
            </form>
            <?php
            if($opcja_wysto=='1'){
                $n_wysto=$n_wysto_l;
                $id_miasto_t = pg_exec($link, "SELECT id_miasta
                                              FROM wystawy_objazdowe
                                              WHERE nazwa_wystawy_objazdowej='$n_wysto'");
                $id_miasto_w = pg_fetch_array($id_miasto_t, 0);
                $id_miasto = $id_miasto_w["id_miasta"];
            }
            else if($opcja_wysto=='2'){
                $n_wysto=$n_wysto_n;
                if($opcja_miasto=='1'){
                    $id_miasto_t = pg_exec($link, "SELECT id_miasta
                                              FROM Miasta
                                              WHERE nazwa_miasta='$miasto_l'");
                    $id_miasto_w = pg_fetch_array($id_miasto_t, 0);
                    $id_miasto = $id_miasto_w["id_miasta"];
                }
                else if($opcja_miasto=='2'){
                    $nowe_id_miasto_t = pg_exec($link, "SELECT MAX(id_miasta) AS max
                                                      FROM Miasta");
                    $nowe_id_miasto_w = pg_fetch_array($nowe_id_miasto_t, 0);
                    $id_miasto = $nowe_id_miasto_w["max"] + 1;
                    pg_exec($link, "INSERT INTO Miasta VALUES ('$id_miasto', '$n_miasto')");
                    echo"Dodano miasto " . $n_miasto . " do bazy<br>";
                }
            }
            $nowe_id_wysto_t = pg_exec($link, "SELECT MAX(id_wystawy_objazdowej) AS max
                                                      FROM wystawy_objazdowe");
            $nowe_id_wysto_w = pg_fetch_array($nowe_id_wysto_t, 0);
            $id_wysto = $nowe_id_wysto_w["max"] + 1;
            if (!empty($n_wysto)) {
                $koniec = mktime(0, 0, 0, date("m",strtotime($przewidywany_koniec)), date("d",strtotime($przewidywany_koniec)), date("Y",strtotime($przewidywany_koniec)));
                $max_koniec = mktime(0, 0, 0, date("m"), date("d") + 29, date("Y"));
                if ($koniec > $max_koniec) echo "zbyt długia wystawa objazdowa";
                else {
                    $nowe_id_eks_t = pg_exec($link, "SELECT MAX(id_eksponatu) AS max
        FROM Eksponaty");
                    $nowe_id_eks_w = pg_fetch_array($nowe_id_eks_t, 0);
                    $nowe_id_eks = $nowe_id_eks_w["max"] + 1;
                    $nowe_id_hist_t = pg_exec($link, "SELECT MAX(id) AS max
        FROM Historia");
                    $nowe_id_hist_w = pg_fetch_array($nowe_id_hist_t, 0);
                    $nowe_id_hist = $nowe_id_hist_w["max"] + 1;
                    if($opcja_autor=='1') {
                        if ($autor_l != "nieznany") {
                            $autor_nazw = odzyskaj_nazwisko($autor_l);
                            $autor_pom = pg_exec($link, "SELECT id_autora
                    FROM Autorzy
                    WHERE nazwisko='$autor_nazw'");
                            $autor_id_wiersz = pg_fetch_array($autor_pom, 0);
                            $autor_id = $autor_id_wiersz["id_autora"];
                        }
                        else $autor_id=NULL;
                    }
                    else if($opcja_autor=='2'){
                        $nowe_id_autor_t=pg_exec($link, "SELECT MAX(id_autora) AS max
                                                FROM Autorzy");
                        $nowe_id_autor_w=pg_fetch_array($nowe_id_autor_t, 0);
                        $autor_id=$nowe_id_autor_w["max"]+1;
                        if(!empty($n_autor_roks)){
                            pg_exec($link, "INSERT INTO Autorzy VALUES ('$autor_id', '$n_autor_imie', '$n_autor_nazw', '$n_autor_roku', '$n_autor_roks')");
                        }
                        else pg_exec($link, "INSERT INTO Autorzy VALUES ('$autor_id', '$n_autor_imie', '$n_autor_nazw', '$n_autor_roku', NULL)");
                    }
                    if(!is_null($autor_id)) pg_exec($link, "INSERT INTO Eksponaty VALUES ('$nowe_id_eks', '$tytul', '$typ', '$wysokosc', '$szerokosc', '$waga', '$autor_id', 'O', '$cen')");
                    else  pg_exec($link, "INSERT INTO Eksponaty VALUES ('$nowe_id_eks', '$tytul', '$typ', '$wysokosc', '$szerokosc', '$waga', NULL, 'O', '$cen')");
                    pg_exec($link, "INSERT INTO wystawy_objazdowe VALUES ('$id_wysto', '$n_wysto', '$id_miasto', '$przewidywany_koniec')");
                    pg_exec($link, "INSERT INTO Historia VALUES ('$nowe_id_hist', '$nowe_id_eks', NULL, NULL,  NULL, '$id_wysto', CURRENT_DATE, NULL)");
                    $nowy_t = pg_exec($link, "SELECT Eksponaty.id_eksponatu, Eksponaty.tytul, Eksponaty.typ, Eksponaty.cenny, Eksponaty.wysokosc, Eksponaty.szerokosc, Eksponaty.waga, Autorzy.imie, Autorzy.nazwisko, wystawy_objazdowe.nazwa_wystawy_objazdowej, miasta.nazwa_miasta, wystawy_objazdowe.planowany_koniec
                                              FROM Eksponaty LEFT JOIN Autorzy
                                              ON Eksponaty.id_autora=Autorzy.id_autora
                                              LEFT JOIN historia
                                              ON eksponaty.id_eksponatu = historia.id_eksponatu
                                              LEFT JOIN wystawy_objazdowe
                                              ON historia.id_wystawy_objazdowej = wystawy_objazdowe.id_wystawy_objazdowej
                                              LEFT JOIN miasta
                                              ON wystawy_objazdowe.id_miasta = miasta.id_miasta
                                              WHERE Eksponaty.id_eksponatu='$nowe_id_eks'");
                    ?>
                    <table border="1" align=center>
                    <tr>
                        <th>ID</th>
                        <th>Tytuł</th>
                        <th>Typ</th>
                        <th>Cenny</th>
                        <th>Wysokość</th>
                        <th>Szerokość</th>
                        <th>Waga</th>
                        <th>Imię autora</th>
                        <th>Nazwisko autora</th>
                        <th>Nazwa wystawy objazdowej</th>
                        <th>Miasto</th>
                        <th>Planowany koniec</th>
                    </tr>
                    <?php
                    echo "Dodano do bazy: <tr>\n";
                    $nowy_w = pg_fetch_array($nowy_t, 0);
                    echo "<td>" . $nowy_w["id_eksponatu"] . "</td>
                    <td>" . $nowy_w["tytul"] . "</td>
                    <td>" . $nowy_w["typ"] . "</td>
                    <td>" . $nowy_w["cenny"] . "</td>
                    <td>" . $nowy_w["wysokosc"] . "</td>
                    <td>" . $nowy_w["szerokosc"] . "</td>
                    <td>" . $nowy_w["waga"] . "</td>";
                    if(!is_null($nowy_w["imie"])) echo "<td>" . $nowy_w["imie"] . "</td>";
                    else echo "<td>  Brak danych  </td>";
                    if(!is_null($nowy_w["nazwisko"])) echo "<td>" . $nowy_w["nazwisko"] . "</td>";
                    else echo "<td>  Brak danych  </td>";
                    echo "<td>" . $nowy_w["nazwa_wystawy_objazdowej"] . "</td>
                    <td>" . $nowy_w["nazwa_miasta"] . "</td>";
                    if(!is_null($nowy_w["planowany_koniec"])) echo "<td>" . $nowy_w["planowany_koniec"] . "</td>";
                    else echo "<td>  Brak danych  </td>";
                    echo "</tr>";
                    ?></table><?php
                }
            }
        }
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