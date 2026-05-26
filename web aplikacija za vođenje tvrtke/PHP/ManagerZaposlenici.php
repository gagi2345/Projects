<?php
include "connect.php";

/* DODAVANJE ZAPOSLENIKA */
if(isset($_POST["dodaj"])){
    $ime = $_POST["ime"];
    $prezime = $_POST["prezime"];
    $pozicija = $_POST["pozicija"];
    $placa = $_POST["placa"]; // plaća po satu
    $odradeni_sati = $_POST["odradeni_sati"];

    $stmt = $conn->prepare("INSERT INTO zaposlenici (ime, prezime, pozicija, placa, odradeni_sati) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdd", $ime, $prezime, $pozicija, $placa, $odradeni_sati);
    $stmt->execute();

    header("Location: ManagerZaposlenici.php");
    exit();
}

/* BRISANJE ZAPOSLENIKA */
if(isset($_GET["obrisi"])){
    $id = $_GET["obrisi"];

    $stmt = $conn->prepare("DELETE FROM zaposlenici WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: ManagerZaposlenici.php");
    exit();
}

/* IZMJENA POZICIJE, PLAĆE PO SATU I ODRAĐENIH SATI */
if(isset($_POST["spremi_izmjene"])){
    $id = $_POST["id"];
    $pozicija = $_POST["pozicija"];
    $placa = $_POST["placa"];
    $odradeni_sati = $_POST["odradeni_sati"];

    $stmt = $conn->prepare("UPDATE zaposlenici SET pozicija = ?, placa = ?, odradeni_sati = ? WHERE id = ?");
    $stmt->bind_param("sddi", $pozicija, $placa, $odradeni_sati, $id);
    $stmt->execute();

    header("Location: ManagerZaposlenici.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Zaposlenici</title>
    <link rel="stylesheet" href="../CSS/managerZaposlenici.css">
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

<main>

    <h1>Zaposlenici</h1>

    <section class="forma-section">
        <h2>Dodaj zaposlenika</h2>

        <form method="POST" class="zaposlenik-forma">
            <input type="text" name="ime" placeholder="Ime" required>
            <input type="text" name="prezime" placeholder="Prezime" required>
            <input type="text" name="pozicija" placeholder="Pozicija" required>
            <input type="number" step="0.01" name="placa" placeholder="Plaća po satu" required>
            <input type="number" step="0.01" name="odradeni_sati" placeholder="Odrađeni sati" required>


            <button type="submit" name="dodaj">Dodaj</button>
        </form>
    </section>


    <section class="tablica-section">
        <h2>Popis zaposlenika</h2>

        <table class="zaposlenici-tablica">
            <tr>
                <th>ID</th>
                <th>Ime</th>
                <th>Prezime</th>
                <th>Pozicija</th>
                <th>Plaća po satu</th>
                <th>Odrađeni sati</th>
                <th>Ukupna zarada</th>
                <th>Spremi izmjene</th>
                <th>Obriši</th>
            </tr>

            <?php
            $sql = "SELECT * FROM zaposlenici";
            $result = $conn->query($sql);

            while($row = $result->fetch_assoc()) {
                $ukupna_zarada = $row["placa"] * $row["odradeni_sati"];

                echo "<tr>";

                echo "<form method='POST'>";

                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["ime"] . "</td>";
                echo "<td>" . $row["prezime"] . "</td>";

                echo "<td>
                        <input type='text' name='pozicija' value='" . $row["pozicija"] . "' required>
                      </td>";

                echo "<td>
                        <input type='number' step='0.01' name='placa' value='" . $row["placa"] . "' required> €
                      </td>";

                echo "<td>
                        <input type='number' step='0.01' name='odradeni_sati' value='" . $row["odradeni_sati"] . "' required> h
                      </td>";

                echo "<td>" . number_format($ukupna_zarada, 2, ',', '.') . " €</td>";

                echo "<td>
                        <input type='hidden' name='id' value='" . $row["id"] . "'>
                        <button class='spremi-btn' type='submit' name='spremi_izmjene'>Spremi</button>
                      </td>";

                echo "<td>
                        <a class='obrisi-btn' href='ManagerZaposlenici.php?obrisi=" . $row["id"] . "'>Obriši</a>
                      </td>";

                echo "</form>";

                echo "</tr>";
            }
            ?>

        </table>
    </section>


</main>

<script>
function logout(){
    localStorage.removeItem("ulogiran");
    window.location.href = "../HTML/login.html";
}
</script>

</body>
</html>