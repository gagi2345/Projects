<?php
include "connect.php";

/* BRISANJE POTROŠENOG MATERIJALA S PROJEKTA */
if(isset($_GET["obrisi_materijal_projekt"])){
    $id = $_GET["obrisi_materijal_projekt"];

    // prvo dohvatimo materijal i potrošenu količinu
    $stmt = $conn->prepare("SELECT materijal_id, potrosena_kolicina FROM projekt_materijali WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $redak = $result->fetch_assoc();

    if($redak){
        $materijal_id = $redak["materijal_id"];
        $potrosena_kolicina = $redak["potrosena_kolicina"];

        // vrati količinu nazad u materijale
        $stmt = $conn->prepare("UPDATE materijali SET kolicina = kolicina + ? WHERE id = ?");
        $stmt->bind_param("ii", $potrosena_kolicina, $materijal_id);
        $stmt->execute();

        // obriši redak iz projekt_materijali
        $stmt = $conn->prepare("DELETE FROM projekt_materijali WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    header("Location: ManagerProjekti.php");
    exit();
}

/* BRISANJE POTROŠENOG MATERIJALA S IZLAZNOG PROIZVODA */
if(isset($_GET["obrisi_materijal_izlazni"])){
    $id = $_GET["obrisi_materijal_izlazni"];

    // prvo dohvatimo materijal i potrošenu količinu
    $stmt = $conn->prepare("SELECT materijal_id, potrosena_kolicina FROM izlazni_proizvod_materijali WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $redak = $result->fetch_assoc();

    if($redak){
        $materijal_id = $redak["materijal_id"];
        $potrosena_kolicina = $redak["potrosena_kolicina"];

        // vrati količinu nazad u materijale
        $stmt = $conn->prepare("UPDATE materijali SET kolicina = kolicina + ? WHERE id = ?");
        $stmt->bind_param("ii", $potrosena_kolicina, $materijal_id);
        $stmt->execute();

        // obriši redak iz izlazni_proizvod_materijali
        $stmt = $conn->prepare("DELETE FROM izlazni_proizvod_materijali WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    header("Location: ManagerProjekti.php");
    exit();
}

/* DODAVANJE POTROŠENOG MATERIJALA NA IZLAZNI PROIZVOD */
if(isset($_POST["dodaj_materijal_izlaznom_proizvodu"])){
    $izlazni_proizvod_id = $_POST["izlazni_proizvod_id"];
    $materijal_id = $_POST["materijal_id"];
    $potrosena_kolicina = $_POST["potrosena_kolicina"];

    // provjeri stanje materijala
    $stmt = $conn->prepare("SELECT kolicina FROM materijali WHERE id = ?");
    $stmt->bind_param("i", $materijal_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $materijal = $result->fetch_assoc();

    if($materijal && $materijal["kolicina"] >= $potrosena_kolicina){

        // spremi potrošeni materijal za izlazni proizvod
        $stmt = $conn->prepare("INSERT INTO izlazni_proizvod_materijali 
            (izlazni_proizvod_id, materijal_id, potrosena_kolicina)
            VALUES (?, ?, ?)");

        $stmt->bind_param("iii", $izlazni_proizvod_id, $materijal_id, $potrosena_kolicina);
        $stmt->execute();

        // smanji količinu materijala na stanju
        $stmt = $conn->prepare("UPDATE materijali 
            SET kolicina = kolicina - ?
            WHERE id = ?");

        $stmt->bind_param("ii", $potrosena_kolicina, $materijal_id);
        $stmt->execute();

        header("Location: ManagerProjekti.php");
        exit();

    } else {
        $greskaIzlazniMaterijal = "Nema dovoljno materijala na stanju.";
    }
}

/* DODAVANJE POTROŠENOG MATERIJALA NA PROJEKT */
if(isset($_POST["dodaj_materijal_projektu"])){
    $projekt_id = $_POST["projekt_id"];
    $materijal_id = $_POST["materijal_id"];
    $potrosena_kolicina = $_POST["potrosena_kolicina"];

    // provjeri koliko materijala ima na stanju
    $stmt = $conn->prepare("SELECT kolicina FROM materijali WHERE id = ?");
    $stmt->bind_param("i", $materijal_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $materijal = $result->fetch_assoc();

    if($materijal && $materijal["kolicina"] >= $potrosena_kolicina){

        // spremi materijal koji je potrošen na projektu
        $stmt = $conn->prepare("INSERT INTO projekt_materijali 
            (projekt_id, materijal_id, potrosena_kolicina) 
            VALUES (?, ?, ?)");

        $stmt->bind_param("iii", $projekt_id, $materijal_id, $potrosena_kolicina);
        $stmt->execute();

        // smanji količinu materijala na stanju
        $stmt = $conn->prepare("UPDATE materijali 
            SET kolicina = kolicina - ? 
            WHERE id = ?");

        $stmt->bind_param("ii", $potrosena_kolicina, $materijal_id);
        $stmt->execute();

        header("Location: ManagerProjekti.php");
        exit();

    } else {
        $greskaMaterijal = "Nema dovoljno materijala na stanju.";
    }
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

/* DODAVANJE PROJEKTA */
if(isset($_POST["dodaj"])){
    $naziv = $_POST["naziv_projekta"];
    $tvrtka = $_POST["tvrtka"];
    $grad = $_POST["grad"];
    $cijena = $_POST["cijena"];
    $rok_zavrsetka = $_POST["rok_zavrsetka"];

    $stmt = $conn->prepare("INSERT INTO projekti (naziv_projekta, tvrtka, grad, cijena, rok_zavrsetka, status) VALUES (?, ?, ?, ?, ?, 'Aktivan')");
    $stmt->bind_param("sssds", $naziv, $tvrtka, $grad, $cijena, $rok_zavrsetka);
    $stmt->execute();

    header("Location: ManagerProjekti.php");
    exit();
}

/* BRISANJE PROJEKTA */
if(isset($_GET["obrisi"])){
    $id = $_GET["obrisi"];

    $stmt = $conn->prepare("DELETE FROM projekti WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: ManagerProjekti.php");
    exit();
}

/* OZNAČI KAO ZAVRŠEN */
if(isset($_GET["zavrsi"])){
    $id = $_GET["zavrsi"];

    $stmt = $conn->prepare("UPDATE projekti SET status = 'Završen' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // provjeri postoji li već prihod za taj projekt
    $stmt = $conn->prepare("SELECT id FROM prihodi WHERE projekt_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $provjera = $stmt->get_result();

    if($provjera->num_rows == 0){

        // dohvati podatke projekta
        $stmt = $conn->prepare("SELECT naziv_projekta, tvrtka, cijena FROM projekti WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $projekt = $result->fetch_assoc();

        if($projekt){
            $vrsta = "Završeni projekt";
            $datum = date("Y-m-d");
            $napomena = "Automatski dodano nakon označavanja projekta kao završenog.";

            $stmt = $conn->prepare("INSERT INTO prihodi 
                (naziv_prihoda, tvrtka, vrsta_prihoda, cijena, datum_isplate, napomena, projekt_id)
                VALUES (?, ?, ?, ?, ?, ?, ?)");

            $stmt->bind_param(
                "sssdssi",
                $projekt["naziv_projekta"],
                $projekt["tvrtka"],
                $vrsta,
                $projekt["cijena"],
                $datum,
                $napomena,
                $id
            );

            $stmt->execute();
        }
    }

    header("Location: ManagerProjekti.php");
    exit();
}

/* VRATI PROJEKT U AKTIVAN */
if(isset($_GET["aktiviraj"])){
    $id = $_GET["aktiviraj"];

    $stmt = $conn->prepare("UPDATE projekti SET status = 'Aktivan' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // ukloni automatski prihod tog projekta
    $stmt = $conn->prepare("DELETE FROM prihodi WHERE projekt_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: ManagerProjekti.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projekti</title>
    <link rel="stylesheet" href="../CSS/managerProjekti.css?v=20">
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

        <h1>Projekti</h1>

        <section class="forma-section">
            <h2>Dodaj novi projekt</h2>

            <form method="POST" class="projekt-forma">
                <input type="text" name="naziv_projekta" placeholder="Ime projekta" required>
                <input type="text" name="tvrtka" placeholder="Tvrtka za koju se radi" required>
                <input type="number" step="0.01" name="cijena" placeholder="Cijena projekta" required>
                <input type="text" name="grad" placeholder="Grad projekta" required>
                <input type="date" name="rok_zavrsetka" placeholder="Rok završetka" required>

                <button type="submit" name="dodaj">Dodaj</button>
            </form>
        </section>

        <section class="forma-section">
            <h2>Dodaj potrošeni materijal na projekt</h2>

            <?php
            if(isset($greskaMaterijal)){
                echo "<p class='greska'>" . $greskaMaterijal . "</p>";
            }
            ?>

            <form method="POST" class="projekt-forma">

                <select name="projekt_id" required>
                    <option value="">Odaberi projekt</option>

                    <?php
                    $projekti = $conn->query("SELECT id, naziv_projekta, tvrtka FROM projekti");

                    while($projekt = $projekti->fetch_assoc()){
                        echo "<option value='" . $projekt["id"] . "'>" .
                                $projekt["naziv_projekta"] . " - " . $projekt["tvrtka"] .
                            "</option>";
                    }
                    ?>
                </select>

                <select name="materijal_id" required>
                    <option value="">Odaberi materijal</option>

                    <?php
                    $materijali = $conn->query("SELECT id, naziv, kolicina, cijena FROM materijali");

                    while($materijal = $materijali->fetch_assoc()){
                        echo "<option value='" . $materijal["id"] . "'>" .
                                $materijal["naziv"] .
                                " | stanje: " . $materijal["kolicina"] .
                                " | cijena: " . $materijal["cijena"] . " €" .
                            "</option>";
                    }
                    ?>
                </select>

                <input type="number" name="potrosena_kolicina" min="1" placeholder="Potrošena količina" required>

                <button type="submit" name="dodaj_materijal_projektu">Dodaj</button>
            </form>
        </section>

        <section class="forma-section">
            <h2>Dodaj potrošeni materijal na izlazni proizvod</h2>

            <?php
            if(isset($greskaIzlazniMaterijal)){
                echo "<p class='greska'>" . $greskaIzlazniMaterijal . "</p>";
            }
            ?>

            <form method="POST" class="projekt-forma">

                <select name="izlazni_proizvod_id" required>
                    <option value="">Odaberi izlazni proizvod / uslugu</option>

                    <?php
                    $izlazniProizvodi = $conn->query("SELECT id, naziv, cijena FROM izlazni_proizvodi");

                    while($proizvod = $izlazniProizvodi->fetch_assoc()){
                        echo "<option value='" . $proizvod["id"] . "'>" .
                                $proizvod["naziv"] . " - " . $proizvod["cijena"] . " €" .
                            "</option>";
                    }
                    ?>
                </select>

                <select name="materijal_id" required>
                    <option value="">Odaberi materijal</option>

                    <?php
                    $materijali = $conn->query("SELECT id, naziv, kolicina, cijena FROM materijali");

                    while($materijal = $materijali->fetch_assoc()){
                        echo "<option value='" . $materijal["id"] . "'>" .
                                $materijal["naziv"] .
                                " | stanje: " . $materijal["kolicina"] .
                                " | cijena: " . $materijal["cijena"] . " €" .
                            "</option>";
                    }
                    ?>
                </select>

                <input type="number" name="potrosena_kolicina" min="1" placeholder="Potrošena količina" required>

                <button type="submit" name="dodaj_materijal_izlaznom_proizvodu">
                    Dodaj
                </button>
            </form>
        </section>

        <section class="tablica-section">
            <h2>Popis projekata</h2>

            <table class="projekti-tablica">
                <tr>
                    <th>ID</th>
                    <th>Ime projekta</th>
                    <th>Tvrtka</th>
                    <th>Grad</th>
                    <th>Cijena</th>
                    <th>Rok završetka</th>
                    <th>Status</th>
                    <th>Označi završeno</th>
                    <th>Obriši</th>
                </tr>

                <?php
                $sql = "SELECT * FROM projekti";
                $result = $conn->query($sql);

                while($row = $result->fetch_assoc()) {
                    echo "<tr>";

                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["naziv_projekta"] . "</td>";
                    echo "<td>" . $row["tvrtka"] . "</td>";
                    echo "<td>" . $row["grad"] . "</td>";
                    echo "<td>" . $row["cijena"] . " €</td>";
                    echo "<td>" . $row["rok_zavrsetka"] . "</td>";
                    echo "<td>" . $row["status"] . "</td>";

                    if($row["status"] == "Aktivan"){
                        echo "<td><a class='zavrsi-btn' href='ManagerProjekti.php?zavrsi=" . $row["id"] . "'>Završi</a></td>";
                    } else {
                        echo "<td><a class='aktiviraj-btn' href='ManagerProjekti.php?aktiviraj=" . $row["id"] . "'>Vrati u aktivno</a></td>";
                    }

                    echo "<td><a class='obrisi-btn' href='ManagerProjekti.php?obrisi=" . $row["id"] . "'>Obriši</a></td>";

                    echo "</tr>";
                }
                ?>

            </table>
        </section>

        <section class="tablica-section">
            <h2>Potrošeni materijali po projektima</h2>

            <table class="projekti-tablica">
                <tr>
                    <th>ID</th>
                    <th>Projekt</th>
                    <th>Tvrtka</th>
                    <th>Materijal</th>
                    <th>Potrošena količina</th>
                    <th>Cijena materijala</th>
                    <th>Ukupan trošak</th>
                    <th>Obriši</th>
                </tr>

                <?php
                $sql = "
                    SELECT 
                        pm.id,
                        p.naziv_projekta,
                        p.tvrtka,
                        m.naziv AS naziv_materijala,
                        pm.potrosena_kolicina,
                        m.cijena,
                        pm.potrosena_kolicina * m.cijena AS ukupni_trosak
                    FROM projekt_materijali pm
                    JOIN projekti p ON pm.projekt_id = p.id
                    JOIN materijali m ON pm.materijal_id = m.id
                    ORDER BY pm.id DESC
                ";

                $result = $conn->query($sql);

                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["naziv_projekta"] . "</td>";
                    echo "<td>" . $row["tvrtka"] . "</td>";
                    echo "<td>" . $row["naziv_materijala"] . "</td>";
                    echo "<td>" . $row["potrosena_kolicina"] . "</td>";
                    echo "<td>" . number_format($row["cijena"], 2, ',', '.') . " €</td>";
                    echo "<td>" . number_format($row["ukupni_trosak"], 2, ',', '.') . " €</td>";
                    echo "<td>
                            <a class='obrisi-btn' href='ManagerProjekti.php?obrisi_materijal_projekt=" . $row["id"] . "'>Obriši</a>
                        </td>";
                    echo "</tr>";
                }
                ?>

            </table>
        </section>

        <section class="tablica-section">
            <h2>Potrošeni materijali po izlaznim proizvodima</h2>

            <table class="projekti-tablica">
                <tr>
                    <th>ID</th>
                    <th>Izlazni proizvod / usluga</th>
                    <th>Materijal</th>
                    <th>Potrošena količina</th>
                    <th>Cijena materijala</th>
                    <th>Ukupan trošak</th>
                    <th>Obriši</th>
                </tr>

                <?php
                $sql = "
                    SELECT 
                        ipm.id,
                        ip.naziv AS naziv_izlaznog_proizvoda,
                        m.naziv AS naziv_materijala,
                        ipm.potrosena_kolicina,
                        m.cijena,
                        ipm.potrosena_kolicina * m.cijena AS ukupni_trosak
                    FROM izlazni_proizvod_materijali ipm
                    JOIN izlazni_proizvodi ip ON ipm.izlazni_proizvod_id = ip.id
                    JOIN materijali m ON ipm.materijal_id = m.id
                    ORDER BY ipm.id DESC
                ";

                $result = $conn->query($sql);

                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["naziv_izlaznog_proizvoda"] . "</td>";
                    echo "<td>" . $row["naziv_materijala"] . "</td>";
                    echo "<td>" . $row["potrosena_kolicina"] . "</td>";
                    echo "<td>" . number_format($row["cijena"], 2, ',', '.') . " €</td>";
                    echo "<td>" . number_format($row["ukupni_trosak"], 2, ',', '.') . " €</td>";
                    echo "<td>
                            <a class='obrisi-btn' href='ManagerProjekti.php?obrisi_materijal_izlazni=" . $row["id"] . "'>Obriši</a>
                        </td>";
                    echo "</tr>";
                }
                ?>

            </table>
        </section>

    </main>


</body>
</html>