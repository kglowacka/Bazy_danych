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
    <h1>Przenosisz eksponat na wystawę objazdową</h1>
    <h3 align="center"></h3>
    <h4>Wysyłając dzieło na wystawę objazdową pamiętaj, że może ono przebywać jedynie 30 dni rocznie poza muzeum.</h4>

    <form action="przenies_na_wystawe_objazdowa.php" method="post">
        <label>Tytuł:</label>
        <select name="eksponaty">
            <?php
            $eksponaty = dostepne_eksponaty();
            foreach ($eksponaty as $id_eksponatu => $tytul):
                echo "<option value='$id_eksponatu'>" . $tytul . "</option>";
            endforeach;
            ?>
        </select>

        <label>Docelowa wystawa objazdowa:</label>
        <select name="wystawy_objazdowe">
            <?php
            $wystawy_objazdowe = biezace_wystawy_objazdowe();
            for ($i = 0; $i < count($wystawy_objazdowe); $i++){
                foreach($wystawy_objazdowe[$i] as $klucz => $wystawa_objazdowa):
                    echo '<option value="' . $wystawa_objazdowa . '">' . $wystawa_objazdowa . '</option>';
                endforeach;
            }
            ?>
        </select>
        <br>
        Powyżej nie są wyświetlane eksponaty, które są ostatnim dziełem danego artysty na terenie muzeum, oraz takie,
        które przebywały ponad 30 dni w tym roku poza muzeum.
        <br>
        <input type="submit" class="btn btn-success" value="Przenieś">
    </form>
    <br>
    <a class="btn btn-danger" href="wystawy_objazdowe.php">Powrót</a>

</div>
<?php include "footer.php"; ?>

</body>
</html>
