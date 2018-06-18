<?php
session_start();
?>

<html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title>Bazy danych - Katarzyna Głowacka</title>

<style>
    /* Remove the navbar's default margin-bottom and rounded borders */
    .navbar {
        margin-bottom: 0;
        border-radius: 0;
    }

    /* Set black background color, white text and some padding */
    footer {
        background-color: #555;
        color: white;
        padding: 15px;
    }

    }
</style>
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
        $_SESSION['login']=1;
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


</body>
</html>
