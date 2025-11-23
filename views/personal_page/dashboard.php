<?php
require_once(__DIR__ . "/../../config/connection.php");

// Query contoh (sesuaikan jika perlu)
$sql = "SELECT * FROM pelanggan";
$stmt = $connection->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Power GYM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>

    <link rel="stylesheet" href="dashboard.css">
</head>

<body>
    <?php

    // IJIN NAMBAHIN ERROR HANDLING BG
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['error'])) {
    $message = $_SESSION['error'];
    echo '<script>alert("' . htmlspecialchars($message) . '");</script>';
    unset($_SESSION['error']);
}
?>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-transparent mx-5 px-5 sticky-top">
        <div class="container-fluid py-3">
            <a class="navbar-brand text-white fw-bold" href="index.php">Power GYM</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end " id="navbarNav">
                <ul class="nav nav-underline ">
                    <li class="nav-item ">
                        <a class="nav-link text-white active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Fasilitas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Membership</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Testimoni</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../calculate_bmi/bmi.php">Cek BMI</a>
                    </li>
                    <li class="nav-item">
                        <a type="button" class="btn btn-warning" href="../auth/login.php">Masuk</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid dashboard-container">
        <div class="row h-100">

            <div class="col-lg-3 col-md-4 sidebar-area p-0">
                <div class="d-flex flex-column h-100 p-3">

                    <div class="bg-card-dark card-outline p-4 text-center mb-3">
                        <div class="position-relative d-inline-block mb-3">
                            <img src="https://via.placeholder.com/100" class="rounded-circle border border-3 border-dark p-1" alt="Avatar" width="100" height="100">
                            <span class="position-absolute bottom-0 end-0 bg-success border border-dark rounded-circle p-2"></span>
                        </div>
                        <h4 class="fw-bold text-white mb-1">Joy Dey</h4>
                        <span class="badge bg-warning text-dark mb-4">Member Gold</span>

                        <div class="d-flex justify-content-between text-center bg-black rounded-4 p-3 bg-opacity-25">
                            <div>
                                <small class="text-secondary d-block mb-1" style="font-size: 0.7rem;">UMUR</small>
                                <span class="fw-bold text-white">24</span>
                            </div>
                            <div class="vr bg-secondary"></div>
                            <div>
                                <small class="text-secondary d-block mb-1" style="font-size: 0.7rem;">BERAT</small>
                                <span class="fw-bold text-white">50kg</span>
                            </div>
                            <div class="vr bg-secondary"></div>
                            <div>
                                <small class="text-secondary d-block mb-1" style="font-size: 0.7rem;">TINGGI</small>
                                <span class="fw-bold text-white">170cm</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-card-dark p-4 mb-3">
                        <h6 class="text-secondary text-uppercase fw-bold mb-4" style="font-size: 0.75rem; letter-spacing: 1px;">Aktivitas Hari Ini</h6>
                        
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="text-success"><ion-icon name="log-in-outline" size="large"></ion-icon></div>
                                <div>
                                    <small class="text-secondary d-block" style="font-size: 0.8rem;">Check-in</small>
                                    <span class="fw-bold text-white">08:30 AM</span>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="border-secondary opacity-25 my-3">
                        
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3">
                                <div class="text-danger"><ion-icon name="log-out-outline" size="large"></ion-icon></div>
                                <div>
                                    <small class="text-secondary d-block" style="font-size: 0.8rem;">Check-out</small>
                                    <span class="fw-bold text-white">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-card-dark p-3">
                        <div class="d-grid gap-2">
                            <button class="btn btn-warning fw-bold text-dark rounded-3 py-2">
                                <i class="bi bi-chat-quote me-2"></i> Beri Testimoni
                            </button>
                            <button class="btn btn-custom-sidebar text-start rounded-3 py-2">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-9 col-md-8 content-area p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-white fw-bold display-6">Overview</h3>
                    <small class="text-secondary">Update: Live</small>
                </div>

                <div class="row g-3 mb-5">
                    
                    <div class="col-md-4">
                        <div class="stat-card card-lime">
                            <div class="stat-card-content">
                                <div>
                                    <span class="stat-number">20</span>
                                    <span class="stat-label">Days Streak</span>
                                </div>
                                <div class="stat-icon-circle icon-theme-green">
                                    <ion-icon name="flame"></ion-icon>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-card-content">
                                <div>
                                    <span class="stat-number" style="font-size: 1.8rem;">Silver</span>
                                    <span class="stat-label">Active Plan</span>
                                </div>
                                <div class="stat-icon-circle icon-theme-yellow">
                                    <ion-icon name="card"></ion-icon>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-card-content">
                                <div>
                                    <span class="stat-number">42</span>
                                    <span class="stat-label">Total Visit</span>
                                </div>
                                <div class="stat-icon-circle icon-theme-blue">
                                    <ion-icon name="barbell"></ion-icon>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <h4 class="text-white fw-bold mb-3">Kelas Minggu Ini</h4>
                <div class="row g-3 mb-5">
                    <?php for ($i = 1; $i <= 6; $i++) { ?>
                        <div class="col-md-6">
                            <div class="bg-card-dark p-3">
                                <div class="d-flex gap-3">
                                    <img src="https://source.unsplash.com/random/100x100?gym" class="rounded-3" style="width:80px; height:80px; object-fit:cover; filter: grayscale(30%);">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h5 class="fw-bold mb-1 text-white">Yoga Class <?php echo $i; ?></h5>
                                        <p class="text-secondary small mb-2">Senin, 10:00 WIB</p>
                                        <span class="badge bg-success w-auto align-self-start">Terdaftar</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="row g-3">
                    <div class="col-12">
                        <div class="bg-card-dark p-4 d-flex align-items-center">
                            <ion-icon name="information-circle" class="text-warning me-3 fs-2"></ion-icon>
                            <div class="text-white">
                                Kamu belum memilih personal trainer. <a href="#" class="text-warning fw-bold text-decoration-none">Cari Trainer Sekarang <ion-icon name="arrow-forward-outline" style="vertical-align: middle;"></ion-icon></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html> 