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

<?php
include "database_search_function.php";
?>

<div class="col-sm-11 text-left">
    <h1>Tworzysz nową wystawę objazdową</h1>
    <h3 align="center"></h3>

    <form action="stworz_wystawe_objazdowa.php" method="post">
        <label>Nazwa wystawy:</label>
        <input type="text" name="nazwa" class="form-group">
        <label>Miasto:</label>
        <input type="text" name="miasto" class="form-group"><br>

        <label>Początek wystawy:</label>
        <input type="date" name="poczatek" class="form-group date">

        <label>Planowany koniec wystawy:</label>
        <input type="date" name="koniec" class="form-group date"><br>
        <input type="submit" class="btn" value="Stwórz tę wystawę">
    </form>
    <br>
    <a class="btn" href="wystawy_objazdowe.php">Powrót</a>
</div>
<?php include "footer.php"; ?>

</body>
</html>
