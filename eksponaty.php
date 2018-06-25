<?php
session_start();
if($_SESSION["login"]!=1)
{
    header('Location: /~kg359266/bd/aplikacja.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "head.php"; ?>
</head>
<body>

<?php
include 'navbar.php';
?>

<div class="col-sm-11 text-left">
    <h1>Eksponaty</h1>
    <p align=\"justify\"></p>

    <div class="text-center">
        <div class="btn-group">
            <a class="btn btn-lg" href="nowy_eksponat.php">Dodaj nowy eksponat</a>
            <a class="btn btn-lg" href="menu_pracownik.php">Powrót do menu</a>
        </div>
        <br><br>

        <form class="example" method="get" style="margin:auto;max-width:600px">
            <center>
                <input type="text" name="zapytanie" class="form-control"
                       placeholder="Wyszukiwanie w bazie muzeum: wpisz tytuł">
                <br>
                <button class="btn default">Szukaj</button>
            </center>
        </form>
    </div>
    <br>

    <?php
    $zapytanie = "" . $_GET["zapytanie"];
    include "database_search_function.php";
    wypisz_wszystkie_eksponaty($zapytanie);
    ?>
    <br><br>
</div>

<?php include "footer.php"; ?>

</body>
</html>
