<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "head.php"; ?>
</head>
<body>

<?php
$activePage = "aplikacja.php";
include 'navbar.php';
?>

<div class="col-sm-11 text-left">
    <h1>Witamy w katalogu muzeum!</h1>
    <p align=\"justify\"></p>
    Zapraszamy do zapoznania się z listą aktualnie prezentowanych eksponatów i ich rozmieszczeniem oraz przeszukiwania
    całego zbioru.

    <p><br></p>
    <?php
    session_start();
    ?>

    <h3 align="center"></h3>
    <form class="example" method="get" style="margin:auto;max-width:600px">
        <center>
            <input type="text" name="zapytanie" class="form-control"
                   placeholder="Wyszukiwanie w bazie muzeum: wpisz tytuł lub autora">
            <br>
            <input type="checkbox" name="cala_baza" value="on"> Szukaj wyłącznie wśród eksponatów dostępnych w naszych
            galeriach <br>
            <br>
            <button class="btn default">Szukaj</button>


        </center>
    </form>

    <?php
        $zapytanie = "" . $_GET["zapytanie"];
        $cala_baza = $_GET["cala_baza"];

    include "database_search_function.php";
    echo "<h2 align=center>Zobacz w naszych galeriach:</h2>";
    pokaz_dziela_w_galeriach($zapytanie);

    if(!$cala_baza) {
        echo "<h2 align=center>Te eksponaty są w magazynie - czekaj, aż wrócą do galerii:</h2>";
        pokaz_dziela_w_magazynie($zapytanie);
        echo "<h2 align=center>Tych eksponatów szukaj na bieżących wystawach objazdowych:</h2>";
        pokaz_dziela_na_wystawach_objazdowych($zapytanie);
    }
    ?>
    <br><br>
</div>
<?php include "footer.php"; ?>

</body>
</html>
