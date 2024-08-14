<?php
session_start();
include 'db_connect.php';

// Provera da li je admin prijavljen
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$error = '';
$success = '';

// Definisanje kategorija
$kategorije = ["Voće", "Povrće", "Meso", "Mlečni proizvodi", "Pekarski proizvodi"];

// Brisanje proizvoda
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM proizvodi WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $success = "Proizvod je uspesno obrisan.";
    } else {
        $error = "Doslo je do greske prilikom brisanja proizvoda.";
    }
    $stmt->close();
}

// Dodavanje novog proizvoda
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ime = $_POST['ime'];
    $opis = $_POST['opis'];
    $cena = $_POST['cena'];
    $kategorija = $_POST['kategorija'];
    $slika = '';

    // Provera i upload slike
    if (isset($_FILES['slika']) && $_FILES['slika']['error'] == 0) {
        $target_dir = "slike/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }
        $target_file = $target_dir . basename($_FILES["slika"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Provera da li je fajl slika
        $check = getimagesize($_FILES["slika"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["slika"]["tmp_name"], $target_file)) {
                $slika = $target_file;
            } else {
                $error = "Doslo je do greske prilikom upload-a slike.";
            }
        } else {
            $error = "Fajl nije slika.";
        }
    }

    if (empty($error)) {
        // Unos novog proizvoda u bazu
        $sql = "INSERT INTO proizvodi (ime, opis, cena, kategorija, slika) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdss", $ime, $opis, $cena, $kategorija, $slika);

        if ($stmt->execute()) {
            $success = "Proizvod je uspesno dodat.";
        } else {
            $error = "Doslo je do greske prilikom dodavanja proizvoda.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
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
                <a class="nav-link" href="orders.php">Pregled Porudžbina</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Odjavi se</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <h2 class="my-4">Dodaj Novi Proizvod</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    <form method="post" action="admin.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="ime">Ime Proizvoda</label>
            <input type="text" class="form-control" id="ime" name="ime" required>
        </div>
        <div class="form-group">
            <label for="opis">Opis</label>
            <textarea class="form-control" id="opis" name="opis" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="cena">Cena</label>
            <input type="number" step="0.01" class="form-control" id="cena" name="cena" required>
        </div>
        <div class="form-group">
            <label for="kategorija">Kategorija</label>
            <select class="form-control" id="kategorija" name="kategorija" required>
                <?php foreach ($kategorije as $kat): ?>
                    <option value="<?php echo $kat; ?>"><?php echo $kat; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="slika">Slika</label>
            <input type="file" class="form-control-file" id="slika" name="slika" required>
        </div>
        <button type="submit" class="btn btn-primary">Dodaj Proizvod</button>
    </form>

    <h2 class="my-4">Lista Proizvoda</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ime</th>
                <th>Opis</th>
                <th>Cena</th>
                <th>Kategorija</th>
                <th>Slika</th>
                <th>Akcije</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Dohvatanje proizvoda
            $sql = "SELECT * FROM proizvodi";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row["id"] . '</td>';
                    echo '<td>' . $row["ime"] . '</td>';
                    echo '<td>' . $row["opis"] . '</td>';
                    echo '<td>' . $row["cena"] . '</td>';
                    echo '<td>' . $row["kategorija"] . '</td>';
                    echo '<td><img src="' . $row["slika"] . '" alt="' . $row["ime"] . '" style="width: 100px; height: auto;"></td>';
                    echo '<td><a href="admin.php?delete_id=' . $row["id"] . '" class="btn btn-danger btn-sm">Obrisi</a></td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="7" class="text-center">Nema pronađenih proizvoda.</td></tr>';
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>