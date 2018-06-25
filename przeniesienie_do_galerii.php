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

<?php
include "database_search_function.php";

?>

<div class="col-sm-11 text-left">
    <h1>Przenosisz eksponat do galerii</h1>
    <h3 align="center"></h3>

    <form action="przenies_do_galerii.php" method="post">
        <label>Tytuł:</label>
        <select name="eksponaty">
            <?php
            $eksponaty = wszystkie_eksponaty();
            foreach ($eksponaty as $id_eksponatu => $tytul):
                echo "<option value='$id_eksponatu'>" . $tytul . "</option>";
            endforeach;
            ?>
        </select>

        <label>Sala docelowa:</label>
        <select name="sale">
            <?php
            $sale = wolne_sale();
            for ($i = 0; $i < count($sale); $i++){
                foreach($sale[$i] as $klucz => $sala):
                    echo '<option value=' . $sala . '>' . $sala . '</option>';
                endforeach;
            }
            ?>
        </select>
        <br>
        Sale, które są w pełni zapełnione nie zostaną wyświetlone!
        <br>
        <input type="submit" class="btn btn-success" value="Przenieś">
    </form>
    <br>
    <a class="btn btn-danger" href="galerie.php">Powrót</a>

</div>
<?php include "footer.php"; ?>

</body>
</html>
