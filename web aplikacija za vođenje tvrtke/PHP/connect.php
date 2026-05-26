<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tvrtka_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Greška pri spajanju: " . $conn->connect_error);
}
?>