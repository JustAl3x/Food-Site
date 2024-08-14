<?php
include 'db_connect.php';

if (!isset($_GET['id'])) {
    echo "Proizvod nije pronadjen.";
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM proizvodi WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Proizvod nije pronadjen.";
    exit();
}

$proizvod = $result->fetch_assoc();
$stmt->close();

// Dodavanje komentara
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['komentar'])) {
    $komentar = $_POST['komentar'];
    $sql = "INSERT INTO komentari (proizvod_id, komentar) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id, $komentar);
    $stmt->execute();
    $stmt->close();
}

// Dohvatanje komentara
$sql = "SELECT * FROM komentari WHERE proizvod_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$komentari = $stmt->get_result();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($proizvod['ime']); ?> - Distribucija Hrane</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            flex: 1;
        }
        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #f8f9fa;
        }
    </style>
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
                    <a class="nav-link" href="login.php">Admin</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="my-4 text-center"><?php echo htmlspecialchars($proizvod['ime']); ?></h1>
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo htmlspecialchars($proizvod['slika']); ?>" class="img-fluid product-img" alt="<?php echo htmlspecialchars($proizvod['ime']); ?>">
            </div>
            <div class="col-md-6">
                <h3>Opis</h3>
                <p><?php echo htmlspecialchars($proizvod['opis']); ?></p>
                <h3>Cena</h3>
                <p><?php echo htmlspecialchars($proizvod['cena']); ?> din</p>
                <h3>Kategorija</h3>
                <p><?php echo htmlspecialchars($proizvod['kategorija']); ?></p>
            </div>
        </div>

        <div class="comment-box">
            <h3>Ostavite komentar</h3>
            <form method="post" action="proizvod.php?id=<?php echo $id; ?>">
                <div class="form-group">
                    <textarea class="form-control" name="komentar" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Posalji</button>
            </form>
        </div>

        <div class="comments">
            <h3>Komentari</h3>
            <?php while ($komentar = $komentari->fetch_assoc()): ?>
                <div class="comment">
                    <p><?php echo htmlspecialchars($komentar['komentar']); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2023 Distribucija Hrane. Sva prava zadrzana.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>