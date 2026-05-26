<?php
include "connect.php";

/* DODAVANJE PRIHODA IZ IZLAZNOG PROIZVODA */
if(isset($_POST["dodaj_izlazni_prihod"])){
    $izlazni_proizvod_id = $_POST["izlazni_proizvod_id"];
    $tvrtka = $_POST["tvrtka"];
    $kolicina = (int)$_POST["kolicina"];
    $datum_isplate = $_POST["datum_isplate"];

    $stmt = $conn->prepare("SELECT naziv, cijena, napomena FROM izlazni_proizvodi WHERE id = ?");
    $stmt->bind_param("i", $izlazni_proizvod_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $proizvod = $result->fetch_assoc();

    if($proizvod){
        $vrsta = "Izlazni proizvod / usluga";
        $ukupna_cijena = $proizvod["cijena"] * $kolicina;

        $napomena = $proizvod["napomena"] . 
                    " | Količina: " . $kolicina . 
                    " | Cijena po jedinici: " . $proizvod["cijena"] . " €";

        $stmt = $conn->prepare("INSERT INTO prihodi
            (naziv_prihoda, tvrtka, vrsta_prihoda, cijena, kolicina, datum_isplate, napomena, izlazni_proizvod_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "sssdissi",
            $proizvod["naziv"],
            $tvrtka,
            $vrsta,
            $ukupna_cijena,
            $kolicina,
            $datum_isplate,
            $napomena,
            $izlazni_proizvod_id
        );

        $stmt->execute();
    }

    header("Location: ManagerPrihodi.php");
    exit();
}
/* BRISANJE PRIHODA */
if(isset($_GET["obrisi"])){
    $id = $_GET["obrisi"];

    $stmt = $conn->prepare("DELETE FROM prihodi WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: ManagerPrihodi.php");
    exit();
}
/* UKUPNI PRIHODI */
$sqlPrihodi = "SELECT COALESCE(SUM(cijena), 0) AS ukupni_prihodi FROM prihodi";
$resultPrihodi = $conn->query($sqlPrihodi);
$ukupniPrihodi = $resultPrihodi->fetch_assoc()["ukupni_prihodi"] ?? 0;

/* UKUPNI TROŠAK POTROŠENIH MATERIJALA NA PROJEKTIMA */
$sqlTrosakProjekti = "
    SELECT COALESCE(SUM(pm.potrosena_kolicina * m.cijena), 0) AS trosak_projekti
    FROM projekt_materijali pm
    JOIN materijali m ON pm.materijal_id = m.id
";

$resultTrosakProjekti = $conn->query($sqlTrosakProjekti);
$trosakProjekti = $resultTrosakProjekti->fetch_assoc()["trosak_projekti"] ?? 0;


/* UKUPNI TROŠAK POTROŠENIH MATERIJALA NA IZLAZNIM PROIZVODIMA */
$sqlTrosakIzlazni = "
    SELECT COALESCE(SUM(ipm.potrosena_kolicina * m.cijena), 0) AS trosak_izlazni
    FROM izlazni_proizvod_materijali ipm
    JOIN materijali m ON ipm.materijal_id = m.id
";

$resultTrosakIzlazni = $conn->query($sqlTrosakIzlazni);
$trosakIzlazni = $resultTrosakIzlazni->fetch_assoc()["trosak_izlazni"] ?? 0;


/* UKUPNI TROŠAK MATERIJALA */
$ukupniTrosakMaterijala = $trosakProjekti + $trosakIzlazni;


/* UKUPNA PLAĆA ZAPOSLENIKA */
$sqlPlace = "
    SELECT COALESCE(SUM(placa * odradeni_sati), 0) AS ukupne_place
    FROM zaposlenici
";

$resultPlace = $conn->query($sqlPlace);
$ukupnePlace = $resultPlace->fetch_assoc()["ukupne_place"] ?? 0;


/* UKUPNA ZARADA */
$ukupnaZarada = $ukupniPrihodi - $ukupniTrosakMaterijala - $ukupnePlace;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prihodi</title>
    <link rel="stylesheet" href="../CSS/managerPrihodi.css?v=20">
</head>
<body>
    <nav>
        <div class="nav-links">
            <a href="managerPocetna.php">Početna</a>
            <a href="ManagerZaposlenici.php">Zaposlenici</a>
            <a href="ManagerProjekti.php">Projekti</a>
            <a href="ManagerMaterijal.php">Dostupni materijali</a>
            <a href="ManagerEvidencijaProizvoda.php">Evidencija proizvoda</a>
            <a href="ManagerPrihodi.php">Prihodi</a>
        </div>

        <button onclick="logout()">Odjava</button>
    </nav>
    <script>
        // ZAŠTITA STRANICE
        if(localStorage.getItem("ulogiran") !== "true"){
            window.location.href = "../HTML/login.html";
        }
  

       

        function logout(){
            localStorage.removeItem("ulogiran");
            window.location.href = "../HTML/login.html";
    }
    </script>

    <main>

        <h1>Prihodi tvrtke</h1>

        <section class="forma-section">
            <h2>Dodaj novi prihod</h2>

            <form method="POST" class="prihodi-forma">
                <input type="text" name="naziv_prihoda" placeholder="Naziv prihoda / projekta" required>
                <input type="text" name="tvrtka" placeholder="Tvrtka / klijent">
                <input type="text" name="vrsta_prihoda" placeholder="Vrsta prihoda">
                <input type="number" step="0.01" name="cijena" placeholder="Iznos prihoda" required>
                <input type="date" name="datum_isplate">
                <input type="text" name="napomena" placeholder="Napomena">

                <button type="submit" name="dodaj">Dodaj</button>
            </form>
        </section>

        <section class="forma-section">
            <h2>Dodaj prihod iz izlaznog proizvoda</h2>

            <form method="POST" class="prihodi-forma">

                <select name="izlazni_proizvod_id" required>
                    <option value="">Odaberi izlazni proizvod / uslugu</option>

                    <?php
                    $izlazni = $conn->query("SELECT id, naziv, cijena FROM izlazni_proizvodi");

                    while($row = $izlazni->fetch_assoc()){
                        echo "<option value='" . $row["id"] . "'>" .
                                $row["naziv"] . " - " . $row["cijena"] . " € po jedinici" .
                            "</option>";
                    }
                    ?>
                </select>

                <input type="number" name="kolicina" min="1" placeholder="Količina" required>

                <input type="text" name="tvrtka" placeholder="Tvrtka / klijent">

                <input type="date" name="datum_isplate" required>

                <button type="submit" name="dodaj_izlazni_prihod">Dodaj</button>
            </form>
        </section>

        <section class="tablica-section">
            <h2>Popis prihoda</h2>

            <table class="prihodi-tablica">
                <tr>
                    <th>ID</th>
                    <th>Naziv prihoda</th>
                    <th>Tvrtka</th>
                    <th>Vrsta prihoda</th>
                    <th>Iznos</th>
                    <th>Datum isplate</th>
                    <th>Napomena</th>
                    <th>Obriši</th>
                </tr>

                <?php
                $sql = "SELECT * FROM prihodi";
                $result = $conn->query($sql);

                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["naziv_prihoda"] . "</td>";
                    echo "<td>" . $row["tvrtka"] . "</td>";
                    echo "<td>" . $row["vrsta_prihoda"] . "</td>";
                    echo "<td>" . $row["cijena"] . " €</td>";

                    if(!empty($row["datum_isplate"])){
                        echo "<td>" . date("d.m.Y.", strtotime($row["datum_isplate"])) . "</td>";
                    } else {
                        echo "<td>-</td>";
                    }

                    echo "<td>" . $row["napomena"] . "</td>";
                    echo "<td><a class='obrisi-btn' href='ManagerPrihodi.php?obrisi=" . $row["id"] . "'>Obriši</a></td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </section>

        <section class="zarada-section">
            <h2>Financijski pregled</h2>

            <div class="zarada-kartice">
                <div class="zarada-kartica">
                    <h3>Ukupni prihodi</h3>
                    <p><?php echo number_format($ukupniPrihodi, 2, ',', '.'); ?> €</p>
                </div>

                <div class="zarada-kartica">
                    <h3>Trošak materijala</h3>
                    <p><?php echo number_format($ukupniTrosakMaterijala, 2, ',', '.'); ?> €</p>
                </div>

                <div class="zarada-kartica">
                    <h3>Ukupna plaća zaposlenika</h3>
                    <p><?php echo number_format($ukupnePlace, 2, ',', '.'); ?> €</p>
                </div>

                <div class="zarada-kartica ukupno">
                    <h3>Ukupna zarada</h3>
                    <p><?php echo number_format($ukupnaZarada, 2, ',', '.'); ?> €</p>
                </div>
            </div>
        </section>

    </main>



</body>
</html>