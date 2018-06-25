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
$activePage = "diagram.php";
include "navbar.php";
?>

<div>
    <h1>Diagram ERD</h1>

    <center>

        <img src="diagram.png"/>
    </center>
</div>

<?php include "footer.php" ?>

</body>
</html>
