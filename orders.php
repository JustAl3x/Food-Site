<?php
session_start();
include 'db_connect.php';

// Provera da li je admin prijavljen
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pregled Porudzbina</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">Distribucija Hrane</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="admin.php">Admin Panel</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="orders.php">Pregled Porudzbina</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Odjavi se</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <h2 class="my-4">Sve Porudzbine</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Porudzbine</th>
                <th>Korisnik</th>
                <th>Datum</th>
                <th>Stavke</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Dohvatanje porudzbina
            $sql = "SELECT p.id, p.datum, k.ime, k.prezime FROM porudzbine p JOIN korisnici k ON p.user_id = k.id ORDER BY p.datum DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row["id"] . '</td>';
                    echo '<td>' . $row["ime"] . ' ' . $row["prezime"] . '</td>';
                    echo '<td>' . $row["datum"] . '</td>';
                    echo '<td>';
                    // Dohvatanje stavki porudzbine
                    $order_id = $row["id"];
                    $sql_items = "SELECT ps.kolicina, ps.cena, pr.ime FROM porudzbine_stavke ps JOIN proizvodi pr ON ps.proizvod_id = pr.id WHERE ps.porudzbina_id = ?";
                    $stmt = $conn->prepare($sql_items);
                    $stmt->bind_param("i", $order_id);
                    $stmt->execute();
                    $result_items = $stmt->get_result();

                    if ($result_items->num_rows > 0) {
                        while($item = $result_items->fetch_assoc()) {
                            echo $item["ime"] . ' x ' . $item["kolicina"] . ' - ' . $item["cena"] . ' din<br>';
                        }
                    } else {
                        echo 'Nema stavki.';
                    }

                    $stmt->close();
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="4" class="text-center">Nema pronadjenih porudzbina.</td></tr>';
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>

</body>
</html>