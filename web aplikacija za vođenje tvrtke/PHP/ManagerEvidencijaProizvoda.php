<?php
include "connect.php";

/* DODAVANJE ULAZNOG PROIZVODA */
if(isset($_POST["dodaj_ulaz"])){
    $naziv = $_POST["naziv"];
    $cijena = $_POST["cijena"];
    $napomena = $_POST["napomena"];

    $stmt = $conn->prepare("INSERT INTO ulazni_proizvodi (naziv, cijena, napomena) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $naziv, $cijena, $napomena);
    $stmt->execute();

    header("Location: ManagerEvidencijaProizvoda.php");
    exit();
}

/* DODAVANJE IZLAZNOG PROIZVODA */
if(isset($_POST["dodaj_izlaz"])){
    $naziv = $_POST["naziv"];
    $cijena = $_POST["cijena"];
    $napomena = $_POST["napomena"];

    $stmt = $conn->prepare("INSERT INTO izlazni_proizvodi (naziv, cijena, napomena) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $naziv, $cijena, $napomena);
    $stmt->execute();

    header("Location: ManagerEvidencijaProizvoda.php");
    exit();
}

/* BRISANJE ULAZNOG PROIZVODA */
if(isset($_GET["obrisi_ulaz"])){
    $id = $_GET["obrisi_ulaz"];

    $stmt = $conn->prepare("DELETE FROM ulazni_proizvodi WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: ManagerEvidencijaProizvoda.php");
    exit();
}

/* BRISANJE IZLAZNOG PROIZVODA */
if(isset($_GET["obrisi_izlaz"])){
    $id = $_GET["obrisi_izlaz"];

    $stmt = $conn->prepare("DELETE FROM izlazni_proizvodi WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: ManagerEvidencijaProizvoda.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evidencija proizvoda</title>
    <link rel="stylesheet" href="../CSS/managerEvidencijaProizvoda.css?v=20">
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

        <h1>Evidencija proizvoda</h1>

        <div class="forme-wrapper">

            <section class="forma-section">
                <h2>Dodaj ulazni proizvod</h2>

                <form method="POST" class="proizvod-forma">
                    <input type="text" name="naziv" placeholder="Naziv proizvoda" required>
                    <input type="number" step="0.01" name="cijena" placeholder="Cijena" required>
                    <input type="text" name="napomena" placeholder="Napomena">

                    <button type="submit" name="dodaj_ulaz">Dodaj</button>
                </form>
            </section>

            <section class="forma-section">
                <h2>Dodaj izlazni proizvod</h2>

                <form method="POST" class="proizvod-forma">
                    <input type="text" name="naziv" placeholder="Naziv proizvoda ili usluge" required>
                    <input type="number" step="0.01" name="cijena" placeholder="Cijena" required>
                    <input type="text" name="napomena" placeholder="Napomena">

                    <button type="submit" name="dodaj_izlaz">Dodaj</button>
                </form>
            </section>

        </div>

        <div class="tablice-wrapper">

            <section class="tablica-section">
                <h2>Ulazni proizvodi</h2>

                <table class="proizvodi-tablica">
                    <tr>
                        <th>ID</th>
                        <th>Naziv</th>
                        <th>Cijena</th>
                        <th>Napomena</th>
                        <th>Obriši</th>
                    </tr>

                    <?php
                    $sql = "SELECT * FROM ulazni_proizvodi";
                    $result = $conn->query($sql);

                    while($row = $result->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["naziv"] . "</td>";
                        echo "<td>" . $row["cijena"] . " €</td>";
                        echo "<td>" . $row["napomena"] . "</td>";
                        echo "<td><a class='obrisi-btn' href='ManagerEvidencijaProizvoda.php?obrisi_ulaz=" . $row["id"] . "'>Obriši</a></td>";
                        echo "</tr>";
                    }
                    ?>

                </table>
            </section>

            <section class="tablica-section">
                <h2>Izlazni proizvodi / usluge</h2>

                <table class="proizvodi-tablica">
                    <tr>
                        <th>ID</th>
                        <th>Naziv</th>
                        <th>Cijena</th>
                        <th>Napomena</th>
                        <th>Obriši</th>
                    </tr>

                    <?php
                    $sql = "SELECT * FROM izlazni_proizvodi";
                    $result = $conn->query($sql);

                    while($row = $result->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["naziv"] . "</td>";
                        echo "<td>" . $row["cijena"] . " €</td>";
                        echo "<td>" . $row["napomena"] . "</td>";
                        echo "<td><a class='obrisi-btn' href='ManagerEvidencijaProizvoda.php?obrisi_izlaz=" . $row["id"] . "'>Obriši</a></td>";
                        echo "</tr>";
                    }
                    ?>

                </table>
            </section>

        </div>

    </main>

</body>
</html>