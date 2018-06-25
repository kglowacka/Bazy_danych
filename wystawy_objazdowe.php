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
    <h1>Eksponaty na wystawach objazdowych</h1>
    <p align=\"justify\"></p>

    <div class="text-center">
        <div class="btn-group">
            <a class="btn btn-lg" href="przeniesienie_na_wystawe_objazdowa.php">
                Wyślij eksponat na wystawę objazdową
            </a>
            <a class="btn btn-lg" href="nowa_wystawa_objazdowa.php">
                Stwórz nową wystawę objazdową
            </a>
            <a class="btn btn-lg" href="historia_wystawy_objazdowe.php">
                Archiwalne wystawy objazdowe
            </a>
            <a class="btn btn-lg" href="menu_pracownik.php">Powrót do menu</a>
        </div>
        <br><br>

        <?php
        include "database_search_function.php";
        $wystawy_objazdowe = wszystkie_wystawy_objazdowe();
        ?>

        <form class="example" method="get" style="margin:auto;max-width:600px">
            <center>
                <input type="text" name="zapytanie" class="form-control"
                       placeholder="Wyszukiwanie w bazie muzeum: wpisz tytuł">
                <br>
                <label>Wystawa objazdowa</label>
                <select name="wystawa_objazdowa">
                    <option value="NULL">--</option>
                    <?php
                    for ($i = 0; $i < count($wystawy_objazdowe); $i++){
                        foreach($wystawy_objazdowe[$i] as $klucz => $wystawa_objazdowa):
                            echo '<option value="' . $wystawa_objazdowa . '">' . $wystawa_objazdowa . '</option>';
                        endforeach;
                    }
                    ?>
                </select>
                <button class="btn default">Szukaj</button>
            </center>
        </form>
    </div>
    <br>

    <?php
    $zapytanie = "" . $_GET["zapytanie"];
    $wystawa_objazdowa = $_GET["wystawa_objazdowa"];
    if (!$wystawa_objazdowa) $wystawa_objazdowa = "NULL";
    wyswietl_wystawy_objazdowe($zapytanie, $wystawa_objazdowa);
    ?>
    <br><br>
</div>

<?php include "footer.php"; ?>

</body>
</html>
