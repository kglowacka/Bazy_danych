<?php
session_start();
if($_SESSION["login"]!=1)
{
    header('Location: /~kg359266/bd/aplikacja.php');}
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
    <h1>Archiwum wydarzeń muzealnych</h1>
    <p align=\"justify\"></p>

    <div class="text-center">
        <div class="btn-group">
            <a class="btn btn-lg" href="menu_pracownik.php">Powrót do menu</a>
        </div>
        <br><br>

        <?php
        include "database_search_function.php";
        ?>

        <form class="example" method="get" style="margin:auto;max-width:600px">
            <center>
                <input type="text" name="zapytanie" class="form-control"
                       placeholder="Wyszukiwanie w bazie muzeum: wpisz tytuł">
                <br>
                <div class="form-row">
                    <div class="col-md-5">
                        <input type="date" name="poczatek" class="form-control date"
                               placeholder="Początek przeszukiwanego okresu">
                    </div>
                    <div class="col-md-5">
                        <input type="date" name="koniec" class="form-control date"
                            placeholder="Koniec przeszukiwanego okresu">
                    </div>
                </div>
                <button class="btn default">Szukaj</button>
            </center>
        </form>
    </div>
    <br>

    <?php
    $zapytanie = "" . $_GET["zapytanie"];

    $poczatek = $_GET["poczatek"];
    if(!$poczatek) $poczatek = strtotime("January 01 2010");
    else $poczatek = strtotime($poczatek);

    $koniec = $_GET["koniec"];
    if(!$koniec) $koniec = strtotime("Now");
    else $koniec = strtotime($koniec);

    wyswietl_historie($zapytanie, $poczatek, $koniec);
    ?>
    <br><br>
</div>

<?php include "footer.php"; ?>

</body>
</html>