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
    <h1>Przenosisz eksponat do magazynu</h1>
    <h3 align="center"></h3>

    <form action="przenies_do_magazynu.php" method="post">
        <label>Tytuł:</label>
        <select name="eksponaty">
            <?php
            $eksponaty = wszystkie_eksponaty();
            foreach ($eksponaty as $id_eksponatu => $tytul):
                echo "<option value='$id_eksponatu'>" . $tytul . "</option>";
            endforeach;
            ?>
        </select>
        <input type="submit" class="btn" value="Przenieś">
    </form>
    <br>
    <a class="btn" href="magazyn.php">Powrót</a>

</div>
<?php include "footer.php"; ?>

</body>
</html>
