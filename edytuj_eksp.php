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

    function odzyskaj_nazwisko($slowo){
        $nazwisko_i_imie=explode(",", $slowo);
        $nazwisko=$nazwisko_i_imie[0];
        return $nazwisko;
    }?>

    <form action="menu_dodawanie.php" method="post">
        <p align="right">
            <input type="submit" value="Powrót">
        </p>
    </form>
    <?php
    include 'config.php';
    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $tytul = $_POST["tytul"];
    $id = $_POST["id"];
    $id_eksponatu = $_POST["id_eksponatu"];
    $tytul_c = $_POST["tytul_c"];
    $tytul_n = $_POST["tytul_n"];
    $typ_c = $_POST["typ_c"];
    $typ_n = $_POST["typ_n"];
    $wysokosc_c = $_POST["wysokosc_c"];
    $wysokosc_n = $_POST["wysokosc_n"];
    $szerokosc_c = $_POST["szerokosc_c"];
    $szerokosc_n = $_POST["szerokosc_n"];
    $waga_c = $_POST["waga_c"];
    $waga_n = $_POST["waga_n"];
    $autor_c = $_POST["autor_c"];
    $opcja_autor = $_POST["opcja_autor"];
    $autor_l = $_POST["autor_l"];
    $n_autor_nazw= $_POST["n_autor_nazw"];
    $n_autor_imie= $_POST["n_autor_imie"];
    $n_autor_roku= $_POST["n_autor_roku"];
    $n_autor_roks= $_POST["n_autor_roks"];
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
    if(!empty($id_eksponatu)) {
        $wynik=pg_exec($link, "SELECT Eksponaty.tytul, Eksponaty.typ, eksponaty.szerokosc, eksponaty.wysokosc, eksponaty.waga, Artysci.imie, Artysci.nazwisko
				FROM eksponaty LEFT JOIN artysci
				ON artysci.id_autora=Eksponaty.id_autora
				WHERE id_eksponatu=$id_eksponatu");
        ?>
        <center>Obecne paramerty:</center>
        <table border="1" align=center>
            <tr>
                <th>Tytuł</th>
                <th>Typ</th>
                <th>Wysokość</th>
                <th>Szerokość</th>
                <th>Waga</th>
                <th>Imię autora</th>
                <th>Nazwisko autora</th>
            </tr>
            <?php
            echo "<tr>\n";
            $wiersz = pg_fetch_array($wynik, 0);
            echo "<td>" . $wiersz["tytul"] . "</td>
	    <td>" . $wiersz["typ"] . "</td>";
            echo "<td>" . $wiersz["wysokosc"] . "</td>
	    <td>" . $wiersz["szerokosc"] . "</td>
	    <td>" . $wiersz["waga"] . "</td>";
            if(!is_null($wiersz["imie"])) echo "<td>" . $wiersz["imie"] . "</td>";
            else echo "<td> Autor nieznany </td>";
            if(!is_null($wiersz["nazwisko"]))echo "<td>" . $wiersz["nazwisko"] . "</td>";
            else echo "<td> Autor nieznany </td>";
            echo "</tr>";
            ?>
        </table>
        <center>Wybierz parametry do edycji:
            <form action="edytuj_eksp.php" method="post">
                <input type="hidden" name="id_eksponatu" value="<?php echo $id_eksponatu;?>">
                <input type="checkbox" name="tytul_c" value="on"> Tytuł: <input type="text" name="tytul_n"><br>
                <input type="checkbox" name="typ_c" value="on"> Typ:  <select name="typ_n">
                    <option>obraz</option>
                    <option>rzeźba</option>
                    <option>rycina</option>
                </select><br>
                <input type="checkbox" name="wysokosc_c" value="on"> Wysokość: <input type="text" name="wysokosc_n"><br>
                <input type="checkbox" name="szerokosc_c" value="on"> Szerokość: <input type="text" name="szerokosc_n"><br>
                <input type="checkbox" name="waga_c" value="on"> Waga: <input type="text" name="waga_n"><br>
                <input type="checkbox" name="autor_c" value="on"> Autor: <input type="radio" name="opcja_autor" value="1" checked> Wybierz z listy:
                <select name="autor_l">
                    <option>nieznany</option>
                    <?php
                    $wynik = pg_exec($link, "SELECT nazwisko, imie
			      FROM artysci");
                    $ile=pg_numrows($wynik);
                    for($i = 0; $i < $ile; $i++) {
                        $wiersz = pg_fetch_array($wynik, $i);
                        echo "<option>" . $wiersz["nazwisko"] . ", " . $wiersz["imie"] . "</option>";
                    }
                    ?>
                </select><br>
                <input type="radio" name="opcja_autor" value="2"> Dodaj nowego autora:<br>
                Nazwisko: <input type="text" name="n_autor_nazw">
                Imię: <input type="text" name="n_autor_imie">
                Rok urodzenia: <input type="text" name="n_autor_roku">
                Rok śmierci: <input type="text" name="n_autor_roks"><br>
                <input type="submit" value="Zmień wbrane informacje">
            </form></center>
        <?php
    }
    if($tytul_c || $typ_c || $wysokosc_c || $szerokosc_c || $waga_c || $autor_c){
        if($autor_c=='on'){
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
            if(!is_null($autor_id)) pg_exec($link, "UPDATE Eksponaty SET id_autora='$autor_id' WHERE id_eksponatu=$id_eksponatu");
            else pg_exec($link, "UPDATE Eksponaty SET id_autora=NULL WHERE id_eksponatu=$id_eksponatu");
        }
        if($tytul_c=='on'){
            pg_exec($link, "UPDATE Eksponaty SET tytul='$tytul_n' WHERE id_eksponatu=$id_eksponatu");
        }
        if($typ_c=='on'){
            pg_exec($link, "UPDATE Eksponaty SET typ='$typ_n' WHERE id_eksponatu=$id_eksponatu");
        }
        if($wysokosc_c=='on'){
            pg_exec($link, "UPDATE Eksponaty SET wysokosc='$wysokosc_n' WHERE id_eksponatu=$id_eksponatu");
        }
        if($szerokosc_c=='on'){
            pg_exec($link, "UPDATE Eksponaty SET szerokosc='$szerokosc_n' WHERE id_eksponatu=$id_eksponatu");
        }
        if($waga_c=='on'){
            pg_exec($link, "UPDATE Eksponaty SET waga='$waga_n' WHERE id_eksponatu=$id_eksponatu");
        }
        $wynik=pg_exec($link, "SELECT Eksponaty.tytul, Eksponaty.typ, eksponaty.szerokosc, eksponaty.wysokosc, eksponaty.waga, Artysci.imie, Artysci.nazwisko
        FROM eksponaty LEFT JOIN artysci
        ON Artysci.id_autora=Eksponaty.id_autora
        WHERE id_eksponatu=$id_eksponatu");
        ?>
        <center>Parametry po zmianie:</center>
        <table border="1" align=center>
            <tr>
                <th>Tytuł</th>
                <th>Typ</th>
                <th>Wysokość</th>
                <th>Szerokość</th>
                <th>Waga</th>
                <th>Imię autora</th>
                <th>Nazwisko autora</th>
            </tr>
            <?php
            echo "<tr>\n";
            $wiersz = pg_fetch_array($wynik, 0);
            echo "<td>" . $wiersz["tytul"] . "</td>
	    <td>" . $wiersz["typ"] . "</td>";
            echo "<td>" . $wiersz["wysokosc"] . "</td>
	    <td>" . $wiersz["szerokosc"] . "</td>
	    <td>" . $wiersz["waga"] . "</td>";
            if(!is_null($wiersz["imie"])) echo "<td>" . $wiersz["imie"] . "</td>";
            else echo "<td> Autor nieznany </td>";
            if(!is_null($wiersz["nazwisko"]))echo "<td>" . $wiersz["nazwisko"] . "</td>";
            else echo "<td> Autor nieznany </td>";
            echo "</tr>";
            ?>
        </table>
        <?php
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