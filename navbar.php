<?php
$pages = array();
    $pages["index.php"] = "Zadanie";
    $pages["diagram.php"] = "Diagram ERD";
    $pages["skrypt.php"] = "Skrypt generujący";
    $pages["aplikacja.php"] = "Aplikacja";
    if($_SESSION["login"] == 1){
        $pages["menu_pracownik.php"] = "Menu pracowników";
    }
?>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <?php foreach ($pages as $url => $title): ?>
                    <li <?php if (strcmp($url, $activePage) === 0): ?>class="active"<?php endif; ?>>
                        <a href="<?php echo "/~kg359266/bd/" . $url; ?>">
                            <?php echo $title; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php
            if ($_SESSION["login"] != 1){ ?>
            <form action="logresult.php" method="post" id="signin" class="navbar-form navbar-right" role="form">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input type="text" name="login" class="form-control" value="" placeholder="Login">
                </div>

                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input id="password" type="password" class="form-control" name="haslo" value=""
                           placeholder="Hasło">
                </div>

                <button type="submit" class="btn btn-default">Loguj</button>
            </form>
                <?php } else { ?>
                    <form action="wyloguj.php" method="post" class="navbar-form navbar-right" role="form">
                        <input type="submit" class="btn btn-default" value="Wyloguj">
                    </form>
                <?php } ?>
        </div>
    </div>
</nav>