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
    <h1>Archiwum wystaw objazdowych</h1>
    <p align=\"justify\"></p>

    <div class="text-center">
        <div class="btn-group">
            <a class="btn btn-lg" href="wystawy_objazdowe.php">Powrót</a>
        </div>
        <br><br>

        <?php
        include "database_search_function.php";
        ?>

    </div>
    <br>

    <?php
    pokaz_wszystkie_wystawy_objazdowe();
    ?>
    <br><br>
</div>

<?php include "footer.php"; ?>

</body>
</html>