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

if($_POST["dzielo_koniec"] || $_POST["powrot_do_autora"]){
    $blokuj_dzielo = true;
    $widok_autor = true;
    $blokuj_autor = false;
    $widok_lokalizacja = false;
    $blokuj_lokalizacja = true;
    $widok_lokalizacja_szczegoly = false;
} else if($_POST["autor_koniec"] || $_POST["powrot_do_lokalizacji"]) {
    $blokuj_dzielo = true;
    $widok_autor = true;
    $blokuj_autor = true;
    $widok_lokalizacja = true;
    $blokuj_lokalizacja = false;
    $widok_lokalizacja_szczegoly = false;
} else if($_POST["lokalizacja_koniec"]){
    $blokuj_dzielo = true;
    $widok_autor = true;
    $blokuj_autor = true;
    $widok_lokalizacja = true;
    $blokuj_lokalizacja = true;
    $widok_lokalizacja_szczegoly = true;
} else { //podstawowe lub powrot_do_dziela
    $blokuj_dzielo = false;
    $widok_autor = false;
    $blokuj_autor = true;
    $widok_lokalizacja = false;
    $blokuj_lokalizacja = true;
    $widok_lokalizacja_szczegoly = false;
}

$tytul = "" . $_POST["tytul"];
$typ = $_POST["typ"];
$wysokosc = "" . $_POST["wysokosc"];
$szerokosc = "" . $_POST["szerokosc"];
$waga = "" . $_POST["waga"];

$opcja_autor = $_POST["opcja_autor"];
$wybrane_id_autora = $_POST["autor_istniejacy"];
$imie = "" . $_POST["imie"];
$nazwisko = "" . $_POST["nazwisko"];
$rok_urodzenia = "" . $_POST["rok_urodzenia"];
$rok_smierci =  "" . $_POST["rok_smierci"];

$lokalizacja = $_POST["lokalizacja"];

$sala = $_POST["sala"];
$wystawa_objazdowa = $_POST["wystawa_objazdowa"];

if($_POST["koniec_nowego_dziela"]){
    stworz_dzielo($tytul, $typ, $wysokosc, $szerokosc, $waga, $opcja_autor, $wybrane_id_autora, $imie, $nazwisko,
        $rok_urodzenia, $rok_smierci, $lokalizacja, $sala, $wystawa_objazdowa);
    header('Location: eksponat.php/?tytul=' . $tytul);
}

?>

<div class="col-sm-11 text-left">
    <h1>Dodajesz nowy eksponat!</h1>
    <h3 align="center"></h3>
    <a class="btn" href="eksponaty.php">Powrót</a>

    <form action="nowy_eksponat.php" method="post">
        <fieldset <?php if ($blokuj_dzielo) echo "disabled"; ?>>
            <legend>Dzieło:</legend>
            <label>Tytuł:</label>
            <input type="text" name="tytul" class="form-group" value="<?php echo $tytul; ?>">
            <label>Typ:</label>
            <select name="typ">
                <option value="obraz" <?php if($typ == 'obraz') echo "selected";?>>obraz</option>
                <option value="rzezba" <?php if($typ == 'rzezba') echo "selected";?>>rzezba</option>
            </select><br>
            <label>Wysokość:</label><input type="text" name="wysokosc" value="<?php echo $wysokosc; ?>">
            <label>Szerokość:</label><input type="text" name="szerokosc" value="<?php echo $szerokosc; ?>">
            <label>Waga:</label><input type="text" name="waga" value="<?php echo $waga; ?>"><br>
            Pamiętaj, by liczby dziesętne oddzielać kropką, nie przecinkiem!
            <br>
            <input type="submit" name="dzielo_koniec" class="btn" value="Kolejny krok">
        </fieldset>
    </form>


    <?php if($widok_autor) { ?>
    <form method="post">
        <input type="hidden" name="tytul" value="<?php echo $tytul; ?>">
        <input type="hidden" name="typ" value="<?php echo $typ; ?>">
        <input type="hidden" name="wysokosc" value="<?php echo $wysokosc; ?>">
        <input type="hidden" name="szerokosc" value="<?php echo $szerokosc; ?>">
        <input type="hidden" name="waga" value="<?php echo $waga; ?>">

        <fieldset  <?php if ($blokuj_autor) echo "disabled"; ?>>
            <input type="submit" class="btn" name="powrot_do_dziela" value="Poprzedni krok">
            <legend>Autor:</legend>
            <input type="radio" name="opcja_autor" value="istniejacy"
                <?php if($opcja_autor == 'istniejacy') echo 'checked'; ?>> Wybierz z listy:
            <select name="autor_istniejacy">
                <option value="0" <?php if($wybrane_id_autora == 0) echo "selected"; ?> >Nieznany</option>
                <?php
                $autorzy = wszyscy_autorzy();
                foreach ($autorzy as $id_autora => $autor):
                    if($wybrane_id_autora == $id_autora) {
                        echo "<option value='$id_autora' selected>" . $autor . "</option>";
                    } else {
                        echo "<option value='$id_autora'>" . $autor . "</option>";
                    }
                endforeach;
                ?>
            </select><br>
            <input type="radio" name="opcja_autor" value="nowy"
                <?php if($opcja_autor == 'nowy') echo 'checked'; ?>> Dodaj nowego autora:<br>
            <label>Nazwisko:</label><input type="text" name="nazwisko" value="<?php echo $nazwisko; ?>">
            <label>Imię:</label><input type="text" name="imie" value="<?php echo $imie; ?>">
            <label>Rok urodzenia:</label><input type="text" name="rok_urodzenia"
                                                value="<?php echo $rok_urodzenia; ?>">
            <label>Rok śmierci:</label><input type="text" name="rok_smierci"
                                              value="<?php echo $rok_smierci; ?>"><br>
            <input type="submit" name="autor_koniec" class="btn" value="Kolejny krok">
        </fieldset>
    </form>
    <?php } ?>


    <?php if($widok_lokalizacja) { ?>
        <form method="post">
            <input type="hidden" name="tytul" value="<?php echo $tytul; ?>">
            <input type="hidden" name="typ" value="<?php echo $typ; ?>">
            <input type="hidden" name="wysokosc" value="<?php echo $wysokosc; ?>">
            <input type="hidden" name="szerokosc" value="<?php echo $szerokosc; ?>">
            <input type="hidden" name="waga" value="<?php echo $waga; ?>">

            <input type="hidden" name="opcja_autor" value="<?php echo $opcja_autor; ?>">
            <input type="hidden" name="autor_istniejacy" value="<?php echo $wybrane_id_autora; ?>">
            <input type="hidden" name="nazwisko" value="<?php echo $nazwisko; ?>">
            <input type="hidden" name="imie" value="<?php echo $imie; ?>">
            <input type="hidden" name="rok_urodzenia" value="<?php echo $rok_urodzenia; ?>">
            <input type="hidden" name="rok_smierci" value="<?php echo $rok_smierci; ?>">

            <fieldset  <?php if ($blokuj_lokalizacja) echo "disabled"; ?>>
                <input type="submit" class="btn" name="powrot_do_autora" value="Poprzedni krok">
                <legend>Lokalizacja:</legend>
                <label>Wybierz lokalizację, w której chcesz umieścić dzieło:</label>
                <select name="lokalizacja">
                    <option value="G" <?php if($lokalizacja == 'G') echo "selected";?>>Galeria</option>
                    <option value="M" <?php if($lokalizacja == 'M') echo "selected";?>>Magazyn</option>
                    <?php if($opcja_autor != 'nowy') { ?>
                    <option value="O" <?php if($lokalizacja == 'O') echo "selected";?>>Wystawa objazdowa</option>
                    <?php } ?>
                </select>
                <br>
                <?php if($opcja_autor == 'nowy') {
                    echo "Jest to pierwsze dzieło tego autora - nie możesz go umieścić na wystawie objazdowej.";
                }?>
                <br>
                <input type="submit" class="btn" name="lokalizacja_koniec" value="Kolejny krok">
            </fieldset>
        </form>
    <?php } ?>

    <?php if($widok_lokalizacja_szczegoly) { ?>
        <form method="post">
            <input type="hidden" name="tytul" value="<?php echo $tytul; ?>">
            <input type="hidden" name="typ" value="<?php echo $typ; ?>">
            <input type="hidden" name="wysokosc" value="<?php echo $wysokosc; ?>">
            <input type="hidden" name="szerokosc" value="<?php echo $szerokosc; ?>">
            <input type="hidden" name="waga" value="<?php echo $waga; ?>">

            <input type="hidden" name="opcja_autor" value="<?php echo $opcja_autor; ?>">
            <input type="hidden" name="autor_istniejacy" value="<?php echo $wybrane_id_autora; ?>">
            <input type="hidden" name="nazwisko" value="<?php echo $nazwisko; ?>">
            <input type="hidden" name="imie" value="<?php echo $imie; ?>">
            <input type="hidden" name="rok_urodzenia" value="<?php echo $rok_urodzenia; ?>">
            <input type="hidden" name="rok_smierci" value="<?php echo $rok_smierci; ?>">

            <input type="hidden" name="lokalizacja" value="<?php echo $lokalizacja; ?>">

            <fieldset>
                <input type="submit" class="btn" name="powrot_do_lokalizacji" value="Poprzedni krok">
                <legend>Lokalizacja - szczegóły:</legend>
                <?php if($lokalizacja == 'G'){ ?>
                    <label>Wybierz salę, w której umieścisz dzieło:</label>
                        <select name="sala">
                            <?php
                            $sale = wolne_sale();
                            for ($i = 0; $i < count($sale); $i++){
                                foreach($sale[$i] as $klucz => $sala):
                                    echo '<option value=' . $sala . '>' . $sala . '</option>';
                                endforeach;
                            }
                            ?>
                        </select><br>
                <?php } else if($lokalizacja == 'M'){ ?>
                    <label>Nie musisz dodawać nic więcej - zatwierdź dodanie dzieła!</label><br>
                <?php } else if($lokalizacja == 'O'){ ?>
                    <label>Wybierz wystawę objazdową, na której znajduje się dzieło:</label>
                    <select name="wystawa_objazdowa">
                        <?php
                        $wystawy_objazdowe = biezace_wystawy_objazdowe();
                        for ($i = 0; $i < count($wystawy_objazdowe); $i++){
                            foreach($wystawy_objazdowe[$i] as $klucz => $wystawa_objazdowa):
                                echo '<option value="' . $wystawa_objazdowa . '">' . $wystawa_objazdowa . '</option>';
                            endforeach;
                        }
                        ?>
                    </select><br>
                <?php } ?>
                <input type="submit" class="btn" name="koniec_nowego_dziela" value="Zatwierdź">
            </fieldset>
        </form>
    <?php } ?>
    <br>
    <br>
</div>
<?php include "footer.php"; ?>

</body>
</html>
