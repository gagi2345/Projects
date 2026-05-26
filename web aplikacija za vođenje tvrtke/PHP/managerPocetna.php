<?php
include "../PHP/connect.php";
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Početna stranica</title>
    <link rel="stylesheet" href="../CSS/managerPocetnaStyle.css">
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
        
     <h1>Dobrodošli, Gabrijel!</h1>

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


</body>
</html>