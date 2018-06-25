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
    <h1>Eksponaty w galeriach</h1>
    <p align=\"justify\"></p>

    <div class="text-center">
        <div class="btn-group">
            <a class="btn btn-lg" href="przeniesienie_do_galerii.php">Przenieś eksponat do galerii</a>
            <a class="btn btn-lg" href="menu_pracownik.php">Powrót do menu</a>
        </div>
        <br><br>

        <?php
        include "database_search_function.php";
        $sale = wszystkie_sale();
        ?>

        <form class="example" method="get" style="margin:auto;max-width:600px">
            <center>
                <input type="text" name="zapytanie" class="form-control"
                       placeholder="Wyszukiwanie w bazie muzeum: wpisz tytuł">
                <br>
                <label>Sala</label>
                <select name="sala">
                    <option value="NULL">--</option>
                    <?php
                    for ($i = 0; $i < count($sale); $i++){
                        foreach($sale[$i] as $klucz => $sala):
                            echo '<option value=' . $sala . '>' . $sala . '</option>';
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
    $sala = $_GET["sala"];
    if (!$sala) $sala = "NULL";
    wyswietl_galerie($zapytanie, $sala);
    ?>
    <br><br>
</div>

<?php include "footer.php"; ?>

</body>
</html>
