<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo 'Morate biti prijavljeni da biste zavrsili porudžbinu.';
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $cart = $_POST['cart'];

    // Kreiranje porudžbine
    $sql = "INSERT INTO porudzbine (user_id, datum) VALUES (?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // Dodavanje stavki porudžbine
    foreach ($cart as $item) {
        $sql = "INSERT INTO porudzbine_stavke (porudzbina_id, proizvod_id, kolicina, cena) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
        $stmt->execute();
        $stmt->close();
    }

    echo 'Porudžbina je uspesno zavrsena.';
    $conn->close();
}
?>