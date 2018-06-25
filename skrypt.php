<?php
session_start();
?>

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

    <pre>-- drop

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
    nazwa_wystawy varchar(80)  NULL,
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
    nazwa_wystawy varchar(80)  NOT NULL,
    nazwa_miasta varchar(40)  NOT NULL,
    data_rozpoczenia timestamp  NOT NULL,
    data_zakonczenia timestamp  NOT NULL,
    CONSTRAINT Wystawy_objazdowe_pk PRIMARY KEY (nazwa_wystawy)
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
    FOREIGN KEY (nazwa_wystawy)
    REFERENCES Wystawy_objazdowe (nazwa_wystawy)
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

-- Wstępnedane w bazie

INSERT INTO Artysci VALUES(1, 'Jan', 'Matejko', 1838, 1893);
INSERT INTO Artysci VALUES(2, 'Vincent', 'van Gogh', 1853, 1890);
INSERT INTO Artysci VALUES(3, 'Salvador', 'Dali', 1904, 1989);
INSERT INTO Artysci VALUES(4, 'Rafael', 'Santi', 1483, 1520);
INSERT INTO Artysci VALUES(5, 'Michał', 'Anioł', 1475, 1564);

INSERT INTO Eksponaty VALUES(1, 'Bitwa pod Grunwaldem', 'obraz', 426.6, 987, 290, 1, 'G');
INSERT INTO Eksponaty VALUES(2, 'Kazanie Skargi', 'obraz', 224, 397, 43.5, 1, 'G');
INSERT INTO Eksponaty VALUES(3, 'Stanczyk', 'obraz', 88, 120, 4.8, 1, 'M');
INSERT INTO Eksponaty VALUES(4, 'Sloneczniki', 'obraz', 91, 72.2, 3.5, 2, 'O');
INSERT INTO Eksponaty VALUES(5, 'Jedzacy kartofle I', 'obraz', 72.15, 93, 3, 2, 'M');
INSERT INTO Eksponaty VALUES(6, 'Taras kawiarni w nocy', 'obraz', 81, 65.5, 2, 2, 'M');
INSERT INTO Eksponaty VALUES(7, 'Trwalosc pamieci', 'obraz', 24.5, 33, 1, 3, 'M');
INSERT INTO Eksponaty VALUES(8, 'Plonaca zyrafa', 'obraz', 35.3, 27, 1, 3, 'M');
INSERT INTO Eksponaty VALUES(9, 'Corpus Hypercubus', 'obraz', 195, 124.5, 36, 3, 'M');
INSERT INTO Eksponaty VALUES(10, 'Zmartwychwstanie Chrystusa', 'obraz', 52, 44.5, 6, 4, 'M');
INSERT INTO Eksponaty VALUES(11, 'Ukrzyzowanie', 'obraz', 283.5, 167.5, 52, 4, 'G');
INSERT INTO Eksponaty VALUES(12, 'Autoportret', 'obraz', 47, 33.5, 4, 4, 'G');
INSERT INTO Eksponaty VALUES(13, 'Dawid', 'rzezba', 47.5, 33, 4, 5, 'G');

INSERT INTO Galerie VALUES(1);
INSERT INTO Galerie VALUES(2);
INSERT INTO Galerie VALUES(3);
INSERT INTO Galerie VALUES(4);

INSERT INTO Sale VALUES(1, 1, 5);
INSERT INTO Sale VALUES(2, 1, 10);
INSERT INTO Sale VALUES(3, 1, 5);
INSERT INTO Sale VALUES(4, 2, 10);
INSERT INTO Sale VALUES(5, 3, 5);
INSERT INTO Sale VALUES(6, 3, 5);
INSERT INTO Sale VALUES(7, 4, 6);
INSERT INTO Sale VALUES(8, 4, 3);
INSERT INTO Sale VALUES(9, 4, 5);

INSERT INTO Miasta VALUES('Warszawa');
INSERT INTO Miasta VALUES('Krakow');
INSERT INTO Miasta VALUES('Torun');
INSERT INTO Miasta VALUES('Katowice');
INSERT INTO Miasta VALUES('Kijow');
INSERT INTO Miasta VALUES('Inowroclaw');
INSERT INTO Miasta VALUES('Gdansk');
INSERT INTO Miasta VALUES('Berlin');

INSERT INTO Wystawy_objazdowe VALUES('Impresjonizm 2008', 'Warszawa', '2015-01-01 17:00:01', '2015-01-05 17:00:01');
INSERT INTO Wystawy_objazdowe VALUES('Renesans', 'Inowroclaw', '2017-06-10 12:00:01', '2017-07-01 12:00:01');
INSERT INTO Wystawy_objazdowe VALUES('Wielkie Bitwy', 'Krakow', '2010-03-01 12:00:01', '2010-03-05 12:00:01');
INSERT INTO Wystawy_objazdowe VALUES('Sztuka XX wieku', 'Gdansk', '2017-01-28 12:00:01', '2017-02-06 12:00:01');
INSERT INTO Wystawy_objazdowe VALUES('Wielcy mistrzowie', 'Torun', '2012-12-12 12:00:01', '2012-12-24 12:00:01');
INSERT INTO Wystawy_objazdowe VALUES('Wielcy', 'Katowice', '2018-06-10 12:00:01', '2018-07-01 12:00:01');

INSERT INTO Magazyn VALUES(1);
INSERT INTO Magazyn VALUES(2);
INSERT INTO Magazyn VALUES(3);
INSERT INTO Magazyn VALUES(4);
INSERT INTO Magazyn VALUES(5);
INSERT INTO Magazyn VALUES(6);
INSERT INTO Magazyn VALUES(7);
INSERT INTO Magazyn VALUES(8);
INSERT INTO Magazyn VALUES(9);
INSERT INTO Magazyn VALUES(10);
INSERT INTO Magazyn VALUES(11);

INSERT INTO Historia_ekspozycji VALUES(1, 1, '2010-03-01', '2010-03-05', 'Wielkie Bitwy', NULL, NULL);
INSERT INTO Historia_ekspozycji VALUES(2, 1, '2010-03-06', '2010-05-06', NULL, NULL, 1);
INSERT INTO Historia_ekspozycji VALUES(3, 1, '2010-05-06', NULL, NULL, 5, NULL);
INSERT INTO Historia_ekspozycji VALUES(4, 2, '2008-01-01', '2009-12-31', NULL, 1, NULL);
INSERT INTO Historia_ekspozycji VALUES(5, 2, '2010-01-01', '2010-02-28', NULL, NULL, 2);
INSERT INTO Historia_ekspozycji VALUES(6, 2, '2010-03-01', '2010-03-05', 'Wielkie Bitwy', NULL, NULL);
INSERT INTO Historia_ekspozycji VALUES(7, 2, '2010-03-06', NULL, NULL, 1, NULL);
INSERT INTO Historia_ekspozycji VALUES(8, 3, '2017-06-10', '2017-07-01', 'Renesans', NULL, NULL);
INSERT INTO Historia_ekspozycji VALUES(9, 3, '2017-07-02', NULL, NULL, NULL, 3);
INSERT INTO Historia_ekspozycji VALUES(10, 4, '2017-06-10', '2017-07-01', 'Renesans', NULL, NULL);
INSERT INTO Historia_ekspozycji VALUES(11, 4, '2015-01-06', '2017-06-09', NULL, NULL, 4);
INSERT INTO Historia_ekspozycji VALUES(12, 4, '2015-01-01', '2015-01-05', 'Impresjonizm 2008', NULL, NULL);
INSERT INTO Historia_ekspozycji VALUES(13, 5, '2015-01-01', '2015-01-05', 'Impresjonizm 2008', NULL, NULL);
INSERT INTO Historia_ekspozycji VALUES(14, 5, '2015-01-06', NULL, NULL, NULL, 5);
INSERT INTO Historia_ekspozycji VALUES(15, 6, '2012-12-12', '2012-12-24', 'Wielcy mistrzowie', NULL, NULL);
INSERT INTO Historia_ekspozycji VALUES(16, 6, '2012-12-25', NULL, NULL, NULL, 6);
INSERT INTO Historia_ekspozycji VALUES(17, 7, '2008-04-20', NULL, NULL, NULL, 7);
INSERT INTO Historia_ekspozycji VALUES(18, 8, '2012-12-12', '2012-12-24', 'Wielcy mistrzowie', NULL, NULL);
INSERT INTO Historia_ekspozycji VALUES(19, 8, '2017-01-28', '2017-02-06', 'Sztuka XX wieku', NULL, NULL);
INSERT INTO Historia_ekspozycji VALUES(20, 8, '2017-02-07', NULL, NULL, NULL, 8);
INSERT INTO Historia_ekspozycji VALUES(21, 9, '2009-01-13', NULL, NULL, NULL, 9);
INSERT INTO Historia_ekspozycji VALUES(22, 10, '2012-12-12', '2012-12-24', 'Wielcy mistrzowie', NULL, NULL);
INSERT INTO Historia_ekspozycji VALUES(23, 10, '2012-12-25', NULL, NULL, NULL, 10);
INSERT INTO Historia_ekspozycji VALUES(24, 11, '2008-01-01', '2017-01-27', NULL, 3, NULL);
INSERT INTO Historia_ekspozycji VALUES(25, 11, '2017-01-28', '2017-02-06', 'Sztuka XX wieku', NULL, NULL);
INSERT INTO Historia_ekspozycji VALUES(26, 11, '2017-02-07', NULL, NULL, 4, NULL);
INSERT INTO Historia_ekspozycji VALUES(27, 12, '2010-03-01', '2010-03-05', 'Wielkie Bitwy', NULL, NULL);
INSERT INTO Historia_ekspozycji VALUES(28, 12, '2010-03-06', NULL, NULL, 5, NULL);
INSERT INTO Historia_ekspozycji VALUES(29, 13, '2010-03-01', '2010-03-05', 'Wielkie Bitwy', NULL, NULL);
INSERT INTO Historia_ekspozycji VALUES(30, 13, '2010-03-06', '2012-12-11', NULL, 6, NULL);
INSERT INTO Historia_ekspozycji VALUES(31, 13, '2012-12-12', '2012-12-24', 'Wielcy mistrzowie', NULL, NULL);
INSERT INTO Historia_ekspozycji VALUES(32, 13, '2012-12-25', '2017-01-27', NULL, 7, NULL);
INSERT INTO Historia_ekspozycji VALUES(33, 13, '2017-01-28', '2017-02-06', 'Sztuka XX wieku', NULL, NULL);
INSERT INTO Historia_ekspozycji VALUES(34, 13, '2017-02-06', '2017-03-15', NULL, 2, NULL);
INSERT INTO Historia_ekspozycji VALUES(35, 13, '2017-03-16', '2018-03-15', NULL, 9, NULL);
INSERT INTO Historia_ekspozycji VALUES(36, 13, '2018-03-16', NULL, NULL, 8, NULL);
INSERT INTO Historia_ekspozycji VALUES(37, 4, '2017-06-09', '2018-06-09', NULL, NULL, 11);
INSERT INTO Historia_ekspozycji VALUES(38, 4, '2018-06-10', NULL, 'Wielcy', NULL, NULL);


--funkcje: dwie pomocnicze i jedna glowna, ktora liczy, ile dni w danym roku eksponat byl poza muzeum
CREATE OR REPLACE FUNCTION poczatek_w_roku (poczatek DATE, rok INT) RETURNS DATE AS $$
DECLARE
    nowy_poczatek DATE;
BEGIN
    nowy_poczatek=to_date('01-01-' || to_char(rok, '9999'), 'dd-mm-yyyy');
    IF (nowy_poczatek>poczatek) THEN RETURN nowy_poczatek;
    ELSE RETURN poczatek;
    END IF ;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION koniec_w_roku (koniec DATE, rok INT) RETURNS DATE AS $$
DECLARE
    nowy_koniec DATE;
    koniec_pom DATE;
BEGIN
    IF(koniec IS NULL) THEN koniec_pom=CURRENT_DATE-1;
    ELSE koniec_pom=koniec;
    END IF;
    nowy_koniec=to_date('31-12-' || to_char(rok, '9999'), 'dd-mm-yyyy');
    IF (nowy_koniec< koniec_pom) THEN RETURN nowy_koniec;
    ELSE RETURN koniec_pom;
    END IF;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION dni_poza_muzeum_w_tym_roku (id_var INT, rok INT) RETURNS INT AS $$
DECLARE
  dni_poza INT;
  koniec_roku DATE;
  poczatek_roku DATE;
BEGIN
  koniec_roku=to_date('31-12-' || to_char(rok, '9999'), 'dd-mm-yyyy');
  poczatek_roku=to_date('01-01-' || to_char(rok, '9999'), 'dd-mm-yyyy');
  SELECT COALESCE(SUM(koniec_w_roku(koniec, rok)-poczatek_w_roku(poczatek, rok)), 0) INTO dni_poza
  FROM historia_ekspozycji
  WHERE id_eksponatu=id_var AND nazwa_wystawy IS NOT NULL AND
        poczatek <= koniec_roku AND (koniec >=poczatek_roku OR koniec IS NULL);
  RETURN dni_poza+1;
END;
$$ LANGUAGE plpgsql;

--wyzwalacz wraz ze swoja procedura, sprawdza czy po zmianie danych eksponatow kazdy autor ma choc jeden eksponat
--jesli nie ten autor jest usuwany z bazy
CREATE OR REPLACE FUNCTION kasowanie_zlych_autorow() RETURNS TRIGGER AS $$
DECLARE
  ile_dziel INT;
  id_aut INT;
BEGIN
  id_aut= old.id_autora;
  SELECT COUNT(*) INTO ile_dziel
  FROM eksponaty
  WHERE id_autora=id_aut;
  IF(ile_dziel=0) THEN DELETE FROM Artysci
  WHERE id_autora=id_aut;
  END IF;
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER sprawdz_autorow
AFTER UPDATE OR DELETE
  ON Eksponaty FOR EACH ROW
EXECUTE PROCEDURE kasowanie_zlych_autorow();

    </pre>
</div>

<?php include "footer.php";?>

</body>
</html>
