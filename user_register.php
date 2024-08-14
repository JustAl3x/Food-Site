<?php
include 'db_connect.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Provera da li email već postoji
    $sql = "SELECT * FROM korisnici WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Email adresa je već registrovana.";
    } else {
        // Unos novog korisnika u bazu
        $sql = "INSERT INTO korisnici (ime, prezime, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $ime, $prezime, $email, $hashed_password);

        if ($stmt->execute()) {
            $success = "Uspešno ste se registrovali. Možete se prijaviti.";
            header("Location: index.php");
            exit();
        } else {
            $error = "Došlo je do greške prilikom registracije.";
        }
    }

    $stmt->close();
    $conn->close();
}
?>