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
include 'navbar.php';
?>

<div class="col-sm-11 text-left">
    <?php
        $tytul_eks = $_GET["tytul"];
        include "database_search_function.php";
    ?>
    <h1><?php echo $tytul_eks ?></h1>
    <p align=\"justify\"></p>

    <div class="text-center">
        <div class="btn-group">
            <a class="btn btn-danger btn-lg" href="/~kg359266/bd/menu_pracownik.php">Powrót do menu</a>
        </div>
        <h3>Informacje:</h3>
        <?php
            $informacje = dane_o_eksponacie($tytul_eks);
            foreach ($informacje as $nazwa => $wartosc):
                echo konwertuj($nazwa) . ": " . $wartosc . "<br>";
            endforeach;
        ?>
        <?php if($_SESSION["login"] == 1) {
            echo "<h3>Historia:</h3>";
            historia_dziela($tytul_eks);
        }
        ?>
</div>

<?php include "footer.php"; ?>

</body>
</html>
