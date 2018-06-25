<?php
session_start();
?>

<html>
<head>
<?php include "head.php" ;?>
</head>
<body>

<?php include 'navbar.php'; ?>
<div class="text-left">

    <?php
    include 'config.php';
    $login = $_POST["login"];
    $haslo = $_POST["haslo"];
    $link = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");
    $wynik = pg_exec($link, "SELECT login, password
			      FROM users
			      WHERE login = '$login' AND password ='$haslo'");
    $ile = pg_numrows($wynik);

    if ($ile == 0) {
        echo ' <br><br>
        <p align="center">
            <strong>Błąd logowania!</strong>
            <br><br><br>
            <a href="index.php" class="btn btn-default">Powrót</a>
            <br><br>
            <img src="tlo.png"/>
        </p>';

    } else {
        $_SESSION["login"] = 1;
        echo '<br><br>
    <p align="center">
        <strong>Logowanie pomyślne! Witamy! </strong>
        <br><br><br>
        <a href="menu_pracownik.php" class="btn btn-default">Przejdź do menu Pracownika</a>
        <br><br>
        <img src="open.jpg"/>';

        }
        pg_close($link);
        ?>

    <?php include "footer.php"; ?>


</body>
</html>
