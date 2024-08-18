<?php
session_start();
include 'db_connect.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Priprema i izvršavanje SQL upita
$sql = "SELECT * FROM korisnici WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['ime'];
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Neispravna šifra.";
    }
} else {
    $_SESSION['error'] = "Neispravan email.";
}

header("Location: index.php");
exit();
?>