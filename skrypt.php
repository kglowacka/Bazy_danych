<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "head.php"?>
</head>
<body>
<?php
    $activePage = "skrypt.php";
    include "navbar.php";
?>

<div class="col-sm-10 text-left">
    <h1>Skrypt</h1>

    <a href="Muzeum.sql">Wersja do pobrania</a>
    <br><br><br>

    <pre>-- -- foreign keys
-- ALTER TABLE Eksponaty
--     DROP CONSTRAINT Eksponaty_Artysci;
--
-- ALTER TABLE Historia_ekspozycji
--     DROP CONSTRAINT Historia_Eksponaty;
--
-- ALTER TABLE Historia_ekspozycji
--     DROP CONSTRAINT Historia_Magazyn;
--
-- ALTER TABLE Historia_ekspozycji
--     DROP CONSTRAINT Historia_Sale;
--
-- ALTER TABLE Historia_ekspozycji
--     DROP CONSTRAINT Historia_Wystawy_objazdowe;
--
-- ALTER TABLE Sale
--     DROP CONSTRAINT Sale_Galerie;
--
-- ALTER TABLE Wystawy_objazdowe
--     DROP CONSTRAINT Wystawy_objazdowe_Miasta;
--
-- -- drop

DROP TABLE IF EXISTS Artysci CASCADE;

DROP TABLE IF EXISTS Eksponaty CASCADE;

DROP TABLE IF EXISTS Galerie CASCADE;

DROP TABLE IF EXISTS Historia_ekspozycji CASCADE;

DROP TABLE IF EXISTS Magazyn CASCADE;

DROP TABLE IF EXISTS Miasta CASCADE;

DROP TABLE IF EXISTS Sale CASCADE;

DROP TABLE IF EXISTS Wystawy_objazdowe CASCADE;

-- tables

-- Table: Artysci

CREATE TABLE Artysci (
id_autora int  NOT NULL,
imie varchar(40)  NOT NULL,
nazwisko varchar(50)  NOT NULL,
rok_urodzenia int  NOT NULL,
rok_smierci int  NULL,  --byl check
CONSTRAINT Artysci_pk PRIMARY KEY (id_autora)
);

-- Table: Eksponaty

CREATE TABLE Eksponaty (
id_eksponatu int  NOT NULL,
tytul varchar(50)  NOT NULL,
typ varchar(20)  NOT NULL,
wysokosc real  NOT NULL,
szerokosc real  NOT NULL,
waga real  NOT NULL,
id_autora int  NULL,
obecna_lokalizacja varchar(1) NOT NULL,
CONSTRAINT sprawdzanie_typu CHECK (typ IN ('obraz', 'rzezba', 'rycina')) NOT DEFERRABLE INITIALLY IMMEDIATE,
CONSTRAINT Eksponaty_pk PRIMARY KEY (id_eksponatu)
);

-- Table: Galerie

CREATE TABLE Galerie (
nr_galerii int  NOT NULL,
CONSTRAINT Galerie_pk PRIMARY KEY (nr_galerii)
);

-- Table: Historia_ekspozycji
CREATE TABLE Historia_ekspozycji (
    id_wydarzenia int  NOT NULL,
    id_eksponatu int  NOT NULL,
    poczatek date  NOT NULL,
    koniec date  NULL,
    id_wystawy varchar(80)  NULL,
    nr_sali int  NULL,
    id_magazynowania int  NULL,
    CONSTRAINT Historia_ekspozycji_pk PRIMARY KEY (id_wydarzenia)
);

-- Table: Magazyn
CREATE TABLE Magazyn (
    id_magazynowania int  NOT NULL,
    CONSTRAINT Magazyn_pk PRIMARY KEY (id_magazynowania)
);

-- Table: Miasta
CREATE TABLE Miasta (
    nazwa varchar(40)  NOT NULL,
    CONSTRAINT Miasta_pk PRIMARY KEY (nazwa)
);

-- Table: Sale
CREATE TABLE Sale (
    nr_sali int  NOT NULL,
    nr_galerii int  NOT NULL,
    pojemnosc int  NOT NULL,
    CONSTRAINT Sale_pk PRIMARY KEY (nr_sali)
);

-- Table: Wystawy_objazdowe
CREATE TABLE Wystawy_objazdowe (
    id_wystawy varchar(80)  NOT NULL,
    nazwa_miasta varchar(40)  NOT NULL,
    data_rozpoczenia timestamp  NOT NULL,
    data_zakonczenia timestamp  NOT NULL,
    CONSTRAINT Wystawy_objazdowe_pk PRIMARY KEY (id_wystawy)
);

-- foreign keys
-- Reference: Eksponaty_Artysci (table: Eksponaty)
ALTER TABLE Eksponaty ADD CONSTRAINT Eksponaty_Artysci
    FOREIGN KEY (id_autora)
    REFERENCES Artysci (id_autora)
    NOT DEFERRABLE
    INITIALLY IMMEDIATE
;

-- Reference: Historia_Eksponaty (table: Historia_ekspozycji)
ALTER TABLE Historia_ekspozycji ADD CONSTRAINT Historia_Eksponaty
    FOREIGN KEY (id_eksponatu)
    REFERENCES Eksponaty (id_eksponatu)
    NOT DEFERRABLE
    INITIALLY IMMEDIATE
;

-- Reference: Historia_Magazyn (table: Historia_ekspozycji)
ALTER TABLE Historia_ekspozycji ADD CONSTRAINT Historia_Magazyn
    FOREIGN KEY (id_magazynowania)
    REFERENCES Magazyn (id_magazynowania)
    NOT DEFERRABLE
    INITIALLY IMMEDIATE
;

-- Reference: Historia_Sale (table: Historia_ekspozycji)
ALTER TABLE Historia_ekspozycji ADD CONSTRAINT Historia_Sale
    FOREIGN KEY (nr_sali)
    REFERENCES Sale (nr_sali)
    NOT DEFERRABLE
    INITIALLY IMMEDIATE
;

-- Reference: Historia_Wystawy_objazdowe (table: Historia_ekspozycji)
ALTER TABLE Historia_ekspozycji ADD CONSTRAINT Historia_Wystawy_objazdowe
    FOREIGN KEY (id_wystawy)
    REFERENCES Wystawy_objazdowe (id_wystawy)
    NOT DEFERRABLE
    INITIALLY IMMEDIATE
;

-- Reference: Sale_Galerie (table: Sale)
ALTER TABLE Sale ADD CONSTRAINT Sale_Galerie
    FOREIGN KEY (nr_galerii)
    REFERENCES Galerie (nr_galerii)
    NOT DEFERRABLE
    INITIALLY IMMEDIATE
;

-- Reference: Wystawy_objazdowe_Miasta (table: Wystawy_objazdowe)
ALTER TABLE Wystawy_objazdowe ADD CONSTRAINT Wystawy_objazdowe_Miasta
    FOREIGN KEY (nazwa_miasta)
    REFERENCES Miasta (nazwa)
    NOT DEFERRABLE
    INITIALLY IMMEDIATE
;

-- End of file.
    </pre>
</div>


<div class="container-fluid text-center">
    <div class="row content">
        <p><br><br><br><br><br><br><br><br></p>
    </div>
</div>

<footer class="container-fluid text-center">
    <p>Katarzyna Głowacka - Bazy Danych 2018</p>
</footer>

</body>
</html>
