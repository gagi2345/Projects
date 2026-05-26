<?php
include "connect.php";

/* DODAVANJE MATERIJALA */
if(isset($_POST["dodaj"])){
    $naziv = $_POST["naziv"];
    $kategorija = $_POST["kategorija"];
    $jedinica_mjere = $_POST["jedinica_mjere"];
    $kolicina = $_POST["kolicina"];
    $minimalna_kolicina_pri_narucivanju = $_POST["minimalna_kolicina_pri_narucivanju"];
    $cijena = $_POST["cijena"];
    $dobavljac = $_POST["dobavljac"];
    $napomena = $_POST["napomena"];

    $stmt = $conn->prepare("INSERT INTO materijali 
        (naziv, kategorija, jedinica_mjere, kolicina, minimalna_kolicina_pri_narucivanju, cijena, dobavljac, napomena)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if(!$stmt){
        die("Greška u SQL upitu: " . $conn->error);
    }

    $stmt->bind_param(
        "sssiidss",
        $naziv,
        $kategorija,
        $jedinica_mjere,
        $kolicina,
        $minimalna_kolicina_pri_narucivanju,
        $cijena,
        $dobavljac,
        $napomena
    );

    $stmt->execute();

    header("Location: ManagerMaterijal.php");
    exit();
}
/* IZMJENA KOLIČINE MATERIJALA */
if(isset($_POST["spremi_kolicinu"])){
    $id = $_POST["id"];
    $kolicina = $_POST["kolicina"];

    $stmt = $conn->prepare("UPDATE materijali SET kolicina = ? WHERE id = ?");
    $stmt->bind_param("ii", $kolicina, $id);
    $stmt->execute();

    header("Location: ManagerMaterijal.php");
    exit();
}

/* BRISANJE MATERIJALA */
if(isset($_GET["obrisi"])){
    $id = $_GET["obrisi"];

    $stmt = $conn->prepare("DELETE FROM materijali WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: ManagerMaterijal.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dostupni Materijali</title>
    <link rel="stylesheet" href="../CSS/managerMaterijal.css?v=20">
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

        <h1>Dostupni materijali</h1>

        <section class="forma-section">
            <h2>Dodaj novi materijal</h2>

            <form method="POST" class="materijal-forma">
                <input type="text" name="naziv" placeholder="Naziv materijala" required>
                <input type="text" name="kategorija" placeholder="Kategorija">
                <input type="text" name="jedinica_mjere" placeholder="Jedinica mjere">
                <input type="number" name="kolicina" placeholder="Količina" required>
                <input type="number" name="minimalna_kolicina_pri_narucivanju" placeholder="Minimalna narudžba">
                <input type="number" step="0.01" name="cijena" placeholder="Cijena po jedinici">
                <input type="text" name="dobavljac" placeholder="Dobavljač">
                <input type="text" name="napomena" placeholder="Napomena">

                <button type="submit" name="dodaj">Dodaj </button>
            </form>
        </section>

        <section class="tablica-section">
            <h2>Popis materijala</h2>

            <table class="materijali-tablica">
                <tr>
                    <th>ID</th>
                    <th>Naziv</th>
                    <th>Kategorija</th>
                    <th>Jedinica</th>
                    <th>Količina</th>
                    <th>Minimalno pri naručivanju</th>
                    <th>Cijena</th>
                    <th>Dobavljač</th>
                    <th>Napomena</th>
                    <th>Obriši</th>
                </tr>

                <?php
                $sql = "SELECT * FROM materijali";
                $result = $conn->query($sql);

                $redniBroj = 1;

                while($row = $result->fetch_assoc()) {

                    $klasa = "";

                    if($row["kolicina"] <= $row["minimalna_kolicina_pri_narucivanju"]){
                        $klasa = "malo-stanje";
                    }

                    echo "<tr class='" . $klasa . "'>";

                    echo "<td>" . $redniBroj . "</td>";
                    echo "<td>" . $row["naziv"] . "</td>";
                    echo "<td>" . $row["kategorija"] . "</td>";
                    echo "<td>" . $row["jedinica_mjere"] . "</td>";
                    echo
                        "<td>
                            <form method='POST' class='kolicina-forma'>
                                <input type='hidden' name='id' value='" . $row["id"] . "'>
                                <input 
                                    type='number' 
                                    name='kolicina' 
                                    min='0' 
                                    value='" . $row["kolicina"] . "' 
                                    onchange='this.form.submit()'
                                >
                                <input type='hidden' name='spremi_kolicinu' value='1'>
                            </form>
                        </td>";
                    echo "<td>" . $row["minimalna_kolicina_pri_narucivanju"] . "</td>";
                    echo "<td>" . $row["cijena"] . " €</td>";
                    echo "<td>" . $row["dobavljac"] . "</td>";
                    echo "<td>" . $row["napomena"] . "</td>";

                   

                    echo "<td>
                            <a class='obrisi-btn' href='ManagerMaterijal.php?obrisi=" . $row["id"] . "'>Obriši</a>
                        </td>";

                    echo "</tr>";

                    $redniBroj++;
                }
                ?>

            </table>
        </section>

    </main>



</body>
</html>