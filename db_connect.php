<?php
$servername = "localhost";
$username = "lazar";
$password = "password";
$dbname = "Distribucija_hrane";

// Kreiranje konekcije
$conn = new mysqli($servername, $username, $password, $dbname);

// Provera konekcije
if ($conn->connect_error) {
    die("Konekcija nije uspela: " . $conn->connect_error);
}
?>