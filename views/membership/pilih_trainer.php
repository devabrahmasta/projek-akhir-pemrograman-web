<?php
require_once(dirname(dirname(__DIR__)) . "/config/connection.php");

session_start();


if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../auth/login.php");
    exit;
}


if (!isset($_GET['id_paket'])) {
    header("Location: ../membership/index.php");
    exit;
}

$id_paket = $_GET['id_paket'];

$sql = "SELECT * FROM trainer WHERE status = 'TIDAK DISEWA'";
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Personal Trainer - Power GYM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    <link rel="stylesheet" href="../../views/style.css">
    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body class="bg-dark">
    <?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['error'])) {
    $message = $_SESSION['error'];
    echo '<script>alert("' . htmlspecialchars($message) . '");</script>';
    unset($_SESSION['error']);
}
?>

    <nav class="navbar navbar-expand-lg bg-transparent mx-5 px-5 sticky-top">
        <div class="container-fluid py-3">
            <a class="navbar-brand text-white fw-bold" href="../main_page/index.php">
                <ion-icon name="arrow-back-outline" style="vertical-align: middle;"></ion-icon> Kembali
            </a>
        </div>
    </nav>

    <div class="container mt-4 pb-5">
        <div class="text-center mb-5">
            <h4 class="text-warning">Langkah 2 dari 3</h4>
            <h1 class="text-white fw-bold">Pilih Personal Trainer</h1>
            <p class="text-white">Pilih pelatih profesional untuk mendampingi latihan Anda.</p>
        </div>

        <div class="row justify-content-center">
            <?php 
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) { 
                    // avatar dummy
                    $avatar = ($row['gender'] == 'Perempuan') 
                        ? "https://randomuser.me/api/portraits/women/" . rand(1,90) . ".jpg"
                        : "https://randomuser.me/api/portraits/men/" . rand(1,90) . ".jpg";
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex align-items-stretch">
                    <div class="testimonial-card w-100 text-center d-flex flex-column justify-content-between p-4">
                        
                        <div class="mt-2">
                            <img src="<?php echo $avatar; ?>" 
                                 alt="Trainer" 
                                 class="rounded-circle border border-warning border-2 mb-3"
                                 style="width: 100px; height: 100px; object-fit: cover;">
                            
                            <h4 class="text-white fw-bold mb-1"><?php echo htmlspecialchars($row['nama']); ?></h4>
                            <span class="badge bg-secondary text-white mb-3"><?php echo $row['gender']; ?></span>
                            
                            <div class="text-white-50 text-start small mt-3">
                                <p class="mb-1"><ion-icon name="call-outline" class="text-warning me-2"></ion-icon><?php echo $row['no_hp']; ?></p>
                                <p class="mb-1"><ion-icon name="checkmark-done-circle-outline" class="text-warning me-2"></ion-icon>Available</p>
                            </div>
                        </div>

                        <a href="../../controllers/transaction/transaction.php?id_paket=<?php echo $id_paket; ?>&id_trainer=<?php echo $row['id_trainer']; ?>" 
                           class="btn btn-warning w-100 fw-bold mt-4 text-dark">
                           Pilih <?php echo explode(' ', trim($row['nama']))[0]; ?>
                        </a>

                    </div>
                </div>
            <?php 
                } 
            } else {
                echo "
                <div class='col-12 text-center'>
                    <div class='alert alert-warning' role='alert'>
                        <h4 class='alert-heading'>Mohon Maaf!</h4>
                        <p>Saat ini seluruh Personal Trainer kami sedang <strong>DISEWA</strong>.</p>
                        <hr>
                        <p class='mb-0'>Silakan <a href='../membership/index.php' class='alert-link'>Kembali</a> untuk membeli paket tanpa trainer, atau coba lagi nanti.</p>
                    </div>
                </div>";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>
</html>