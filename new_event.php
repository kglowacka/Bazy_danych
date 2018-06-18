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

    ?>
    <form action="menu_dodawanie.php" method="post">
        <p align="right">
            <input type="submit" value="Powrót">
        </p>
    </form>
    <?php
    include 'config.php';
    $id = $_POST["id"];
    $id_eksponatu = $_POST["id_eksponatu"];
    $tytul = $_POST["tytul"];
    $lokalizacja = $_POST["lokalizacja"];
    $galeria = $_POST["galeria"];
    $sala = $_POST["sala"];
    $n_miasto = $_POST["n_miasto"];
    $przewidywany_koniec = $_POST["przewidywany_koniec"];
    $opcja_wysto = $_POST["opcja_wysto"];
    $n_wysto_l = $_POST["n_wysto_l"];
    $n_wysto_n = $_POST["n_wysto_n"];
    $miasto = $_POST["miasto"];
    $lok=lokalizacja($lokalizacja);
    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_exec($link, "SELECT id_eksponatu
				FROM Eksponaty
				WHERE LOWER(tytul) LIKE LOWER('%$tytul%') AND (id_eksponatu=$id OR $id=0)");
    $ile=pg_numrows($wynik);
    if($ile==0 && empty($id_eksponatu)){
        echo "<center><strong>Brak!</strong></center>";
    }
    else if($ile>1 && empty($id_eksponatu)){
        echo "<center><strong>Za dużo eksponatów!</strong></center>";
    }
    else if($ile==1 && empty($id_eksponatu)){
        $wiersz = pg_fetch_array($wynik, 0);
        $id_eksponatu = $wiersz["id_eksponatu"];
    }
    if(!empty($id_eksponatu)){
        ?>
        <form action="new_event.php" method="post">
            <input type="hidden" name="id_eksponatu" value="<?php echo $id_eksponatu; ?>">
            <input type="hidden" name="lokalizacja" value="<?php echo $lokalizacja; ?>">
            Przewidywany koniec: <input type="date" name="przewidywany_koniec"><br>
            <input type="submit" value="Wybierz datę">
        </form>
        <?php
        if ($lok == 'G') {
            ?>
            <h2 align="center">Wskaż dokładną lokalizację dzieła</h2>
            <form action="new_event.php" method="post">
                <input type="hidden" name="id_eksponatu" value="<?php echo $id_eksponatu; ?>">
                <input type="hidden" name="lokalizacja" value="<?php echo $lokalizacja; ?>">
                <input type="hidden" name="przewidywany_koniec" value="<?php echo $przewidywany_koniec; ?>">
                Galeria: <select name="galeria">
                    <?php
                    $wynik = pg_exec($link, "SELECT nr_galerii
        FROM Galerie");
                    $ile = pg_numrows($wynik);
                    for ($i = 0; $i < $ile; $i++) {
                        $wiersz = pg_fetch_array($wynik, $i);
                        echo "<option>" . $wiersz["nr_galerii"] . "</option>";
                    }
                    ?>
                </select>
                <input type="submit" value="Wybierz galerię">
            </form>
            <form action="new_event.php" method="post">
                <input type="hidden" name="id_eksponatu" value="<?php echo $id_eksponatu; ?>">
                <input type="hidden" name="lokalizacja" value="<?php echo $lokalizacja; ?>">
                <input type="hidden" name="przewidywany_koniec" value="<?php echo $przewidywany_koniec; ?>">
                Sala: <select name="sala">
                    <?php
                    $wynik = pg_exec($link, "SELECT nr_sali
        FROM Sale
        WHERE nr_galerii='$galeria'");
                    $ile = pg_numrows($wynik);
                    for ($i = 0; $i < $ile; $i++) {
                        $wiersz = pg_fetch_array($wynik, $i);
                        echo "<option>" . $wiersz["nr_sali"] . "</option>";
                    }
                    ?>
                </select>
                <input type="submit" value="Wybierz salę">
            </form>
            <?php
            if (!empty($sala)) {
                $nowe_id_hist_t = pg_exec($link, "SELECT MAX(id) AS max
            FROM Historia_ekspozycji");
                $nowe_id_hist_w = pg_fetch_array($nowe_id_hist_t, 0);
                $nowe_id_hist = $nowe_id_hist_w["max"] + 1;
                $nowe_id_wyst_t = pg_exec($link, "SELECT MAX(id_wystawy) AS max
            FROM Prezentowane_eksponaty");
                $nowe_id_wyst_w = pg_fetch_array($nowe_id_wyst_t, 0);
                $nowe_id_wyst = $nowe_id_wyst_w["max"] + 1;
                $czy_konczyc = pg_exec($link, "SELECT id
            FROM historia_ekspozycji
            WHERE id_eksponatu=$id_eksponatu AND koniec IS NULL ");
                $czy_konczyc_i=pg_num_rows($czy_konczyc);
                pg_exec($link, "UPDATE Eksponaty SET obecna_lokalizacja='W' WHERE id_eksponatu=$id_eksponatu");
                if($czy_konczyc_i==1)pg_exec($link, "UPDATE historia_ekspozycji SET koniec=CURRENT_DATE -1 WHERE id_eksponatu=$id_eksponatu AND koniec IS NULL");
                pg_exec($link, "INSERT INTO Prezentowane_eksponaty VALUES ('$nowe_id_wyst', '$sala', '$przewidywany_koniec')");
                pg_exec($link, "INSERT INTO historia_ekspozycji VALUES ('$nowe_id_hist', '$id_eksponatu', '$nowe_id_wyst', NULL, NULL, NULL, CURRENT_DATE, NULL)");
                echo "Zmeniono lokalizację na wystawę w sali " . $sala . " dla eksponatu o id " . $id_eksponatu;
            }
        } else if ($lok == 'M') {
            if (!empty($przewidywany_koniec)) {
                $nowe_id_hist_t = pg_exec($link, "SELECT MAX(id_wydarzenia) AS max
            FROM Historia_ekspozycji");
                $nowe_id_hist_w = pg_fetch_array($nowe_id_hist_t, 0);
                $nowe_id_hist = $nowe_id_hist_w["max"] + 1;
                $nowe_id_mag_t = pg_exec($link, "SELECT MAX(id_magazynowania) AS max
                                              FROM Magazyn");
                $nowe_id_mag_w = pg_fetch_array($nowe_id_mag_t, 0);
                $nowe_id_mag = $nowe_id_mag_w["max"] + 1;
                $czy_konczyc = pg_exec($link, "SELECT id_wydarzenia
            FROM historia_ekspozycji
            WHERE id_eksponatu=$id_eksponatu AND koniec IS NULL ");
                $czy_konczyc_i=pg_num_rows($czy_konczyc);
                pg_exec($link, "UPDATE Eksponaty SET obecna_lokalizacja='M' WHERE id_eksponatu=$id_eksponatu");
                if($czy_konczyc_i==1) pg_exec($link, "UPDATE historia_ekspozycji SET koniec=CURRENT_DATE -1 WHERE id_eksponatu=$id_eksponatu AND koniec IS NULL");
                pg_exec($link, "INSERT INTO magazyn VALUES ('$nowe_id_mag', '$przewidywany_koniec')");
                pg_exec($link, "INSERT INTO historia_ekspozycji VALUES ('$nowe_id_hist', '$id_eksponatu', NULL, '$nowe_id_mag', NULL, NULL, CURRENT_DATE, NULL)");
                echo "Zmieniono lokalizację na magazyn dla eksponatu o id " . $id_eksponatu;
            }
        }
        else if ($lok == 'O') {
            ?>
                <h2 align="center">Podaj wystawę objazdową, na którą chcesz wysłać dzieło</h2>
                <form action="new_event.php" method="post">
                    <input type="hidden" name="id_eksponatu" value="<?php echo $id_eksponatu; ?>">
                    <input type="hidden" name="lokalizacja" value="<?php echo $lokalizacja; ?>">
                    <input type="hidden" name="przewidywany_koniec" value="<?php echo $przewidywany_koniec; ?>">
                    Wystawa objazdowa:<br>
                    <input type="radio" name="opcja_wysto" value="1" checked> Wybierz z listy:
                    <select name="n_wysto_l">
                        <?php
                        $wynik = pg_exec($link, "SELECT id_wystawy
                                              FROM wystawy_objazdowe
                                              GROUP BY id_wystawy");
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
                if ($opcja_wysto == '1') {
                    $n_wysto = $n_wysto_l;
                    $id_miasto_t = pg_exec($link, "SELECT nazwa_miasta
                                              FROM wystawy_objazdowe
                                              WHERE id_wystawy='$n_wysto'");
                    $id_miasto_w = pg_fetch_array($id_miasto_t, 0);
                    $id_miasto = $id_miasto_w["id_miasta"];
                } else if ($opcja_wysto == '2') {
                    $n_wysto = $n_wysto_n;
                    if ($opcja_miasto == '1') {
                        $id_miasto_t = pg_exec($link, "SELECT nazwa
                                              FROM Miasta
                                              WHERE nazwa='$miasto_l'");
                        $id_miasto_w = pg_fetch_array($id_miasto_t, 0);
                        $id_miasto = $id_miasto_w["id_miasta"];
                    } else if ($opcja_miasto == '2') {
                        $nowe_id_miasto_t = pg_exec($link, "SELECT MAX(id_miasta) AS max
                                                      FROM Miasta");
                        $nowe_id_miasto_w = pg_fetch_array($nowe_id_miasto_t, 0);
                        $id_miasto = $nowe_id_miasto_w["max"] + 1;
                        pg_exec($link, "INSERT INTO Miasta VALUES ('$id_miasto', '$n_miasto')");
                        echo "Dodano miasto " . $n_miasto . " do bazy<br>";
                    }
                }
                $nowe_id_wysto_t = pg_exec($link, "SELECT MAX(id_wystawy_objazdowej) AS max
                                                      FROM wystawy_objazdowe");
                $nowe_id_wysto_w = pg_fetch_array($nowe_id_wysto_t, 0);
                $id_wysto = $nowe_id_wysto_w["max"] + 1;
                if (!empty($n_wysto)) {
                    $dni_poza_muzeum_t=pg_exec($link, "SELECT dni_poza_muzeum_w_tym_roku('$id_eksponatu', CAST(DATE_PART('year', CURRENT_DATE) AS INT )) AS dni");
                    $dni_poza_muzeum_w=pg_fetch_array($dni_poza_muzeum_t, 0);
                    $dni_poza_muzeum=$dni_poza_muzeum_w["dni"];
                    $koniec = mktime(0, 0, 0, date("m", strtotime($przewidywany_koniec)), date("d", strtotime($przewidywany_koniec)), date("Y", strtotime($przewidywany_koniec)));
                    $max_koniec = mktime(0, 0, 0, date("m"), date("d") + 29 - $dni_poza_muzeum, date("Y"));
                    if ($koniec > $max_koniec) echo "zbyt długia wystawa objazdowa";
                    else {
                        $nowe_id_hist_t = pg_exec($link, "SELECT MAX(id_wydarzenia) AS max
        FROM Historia_ekspozycji");
                        $nowe_id_hist_w = pg_fetch_array($nowe_id_hist_t, 0);
                        $nowe_id_hist = $nowe_id_hist_w["max"] + 1;
                        $czy_konczyc = pg_exec($link, "SELECT id_wydarzenia
                                                    FROM historia_ekspozycji
                                                    WHERE id_eksponatu=$id_eksponatu AND koniec IS NULL ");
                        $czy_konczyc_i=pg_num_rows($czy_konczyc);
                        pg_exec($link, "UPDATE Eksponaty SET obecna_lokalizacja='O' WHERE id_eksponatu=$id_eksponatu");
                        if($czy_konczyc_i==1) pg_exec($link, "UPDATE historia_ekspozycji SET koniec=CURRENT_DATE -1 WHERE id_eksponatu=$id_eksponatu AND koniec IS NULL");
                        pg_exec($link, "INSERT INTO wystawy_objazdowe VALUES ('$id_wysto', '$n_wysto', '$id_miasto', '$przewidywany_koniec')");
                        pg_exec($link, "INSERT INTO historia_ekspozycji VALUES ('$nowe_id_hist', '$id_eksponatu', NULL, NULL,  NULL, '$id_wysto', CURRENT_DATE, NULL)");
                        echo "Zmeniono lokalizację na wystawa objazdowa dla eksponatu o id " . $id_eksponatu;
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
