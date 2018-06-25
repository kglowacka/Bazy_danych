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
$activePage = "menu_pracownik.php";
include "navbar.php";
?>

<?php
$obszary_muzeum = array();
$obszary_muzeum["eksponaty.php"] = "Zarządzaj eksponatami";
$obszary_muzeum["galerie.php"] = "Eksponaty w galeriach";
$obszary_muzeum["magazyn.php"] = "Eksponaty w magazynie";
$obszary_muzeum["wystawy_objazdowe.php"] = "Eksponaty na wystawach objazdowych";
$obszary_muzeum["historia.php"] = "Historia";
?>
<div class="container">
    <div class="row justify-content-md-center">
        <br><br><br>
        <div class="col col-centered col-6">
            <?php foreach ($obszary_muzeum as $url => $nazwa): ?>
                <a href="<?php echo $url; ?>" type="button"
                   class="btn btn-lg btn-block"><?php echo $nazwa; ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>

</body>
</html>