<?php

require_once(dirname(dirname(__DIR__)) . "/config/connection.php");

session_start();

$has_active_trainer = false;

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $user_id = $_SESSION['user_id'];

    $sql_check = "SELECT m.tgl_mulai, p.durasi FROM membership m JOIN paket_member p ON m.id_paket = p.id_paket 
                  WHERE m.id_pelanggan = ? AND m.id_trainer IS NOT NULL AND m.id_trainer > 0
                  ORDER BY m.id_membership DESC LIMIT 1";

    $stmt_check = $connection->prepare($sql_check);
    $stmt_check->bind_param('i', $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $data_active = $result_check->fetch_assoc();
    $stmt_check->close();

    if ($data_active) {
        $tgl_mulai = new DateTime($data_active['tgl_mulai']);
        $tgl_mulai->setTime(0, 0, 0); 

        $durasi = (int)$data_active['durasi'];
        
        $tgl_akhir = clone $tgl_mulai;
        $tgl_akhir->modify("+$durasi days");
        
        $tgl_sekarang = new DateTime();
        $tgl_sekarang->setTime(0, 0, 0);

        if ($tgl_sekarang <= $tgl_akhir) {
            $has_active_trainer = true;
        }
    }
}

$sql = "SELECT * FROM paket_member ORDER BY harga ASC";
$result = $connection->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership - Power GYM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="membership.css">
    
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
        <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top px-5 py-3">
        <div class="container-fluid">
            <img style="max-height: 120px; object-fit: cover;"
                src="../../images/logo.png" alt="Logo">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="nav nav-underline ">
                    <li class="nav-item"><a class="nav-link text-white" href="../personal_page/dashboard.php">Profil Saya</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="../main_page/index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-warning active" href="../membership/membership_list.php">Membership</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="../calculate_bmi/bmi.php">Cek BMI</a></li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                            <a type="button" class="btn btn-danger" href="../../controllers/auth/logout.php">Logout</a>
                        <?php else: ?>
                            <a type="button" class="btn btn-warning hero-btn" href="../auth/login.php"><b>Mulai Sekarang</b></a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pb-5">
        <div class="text-center mb-5">
            <h4 class="text-warning">Pilih Paket Anda</h4>
            <h1 class="text-white fw-bold">Membership Plan</h1>
            <p class="text-white">Investasi terbaik untuk kesehatan dan tubuh impian Anda.</p>
        </div>

        <div class="row justify-content-center">
            <?php 
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) { 
            ?>
                <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
                    <div class="testimonial-card w-100 text-center d-flex flex-column justify-content-between">
                        
                        <div class="mt-3">
                            <h3 class="text-warning fw-bold text-uppercase"><?php echo htmlspecialchars($row['deskripsi']); ?></h3>
                            <h1 class="text-white fw-bold my-4">
                                Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?>
                            </h1>
                            <div class="badge bg-warning text-dark fs-6 mb-4">
                                <?php echo $row['durasi']; ?> Hari
                            </div>
                        </div>

                        <ul class="list-unstyled text-white text-start mx-auto mb-4" style="max-width: 80%;">
                            <li class="mb-2"><ion-icon name="checkmark-circle" class="text-success me-2"></ion-icon> Akses Gym Sepuasnya</li>
                            <li class="mb-2"><ion-icon name="checkmark-circle" class="text-success me-2"></ion-icon> Alat Standar Internasional</li>
                        </ul>

                        <div class="d-grid gap-2 mt-3">
                            <a href="../../controllers/transaction/transaction.php?id_paket=<?php echo $row['id_paket']; ?>&trainer=0" 
                               class="btn btn-outline-warning fw-bold">
                               Beli Paket
                            </a>
                            <?php if (!$has_active_trainer): ?>
                                <a href="pilih_trainer.php?id_paket=<?php echo $row['id_paket']; ?>" class="btn btn-warning fw-bold text-dark">
                                   Beli + Personal Trainer
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            <?php 
                } 
            } else {
                echo "<p class='text-white text-center'>Belum ada paket membership tersedia saat ini.</p>";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>