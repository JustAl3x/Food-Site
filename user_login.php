<?php
session_start();
include 'db_connect.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Priprema i izvršavanje SQL upita
    $sql = "SELECT * FROM korisnici WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Provera šifre
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['ime'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Pogrešna šifra.";
        }
    } else {
        $error = "Nema naloga sa ovim emailom.";
    }

    $stmt->close();
    $conn->close();
}
?>