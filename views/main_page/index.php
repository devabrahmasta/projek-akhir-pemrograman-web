<?php

use LDAP\Result;

require_once(__DIR__ . "/../../config/connection.php");

$sql = "SELECT * FROM  pelanggan";
$stmt = $connection->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power GYM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=arrow_forward_ios" />
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="index.css">

</head>

<body class="bg-dark">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent fixed-top px-5 py-3">
        <div class="container-fluid">
            <img style="width: 50px; height: 50px; object-fit: cover;"
                src="data:image/jpeg;base64,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"
                alt="Logo">
            <a class="navbar-brand text-warning fw-bold ms-2" href="index.php">Power GYM</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="nav nav-underline ">
                    <li class="nav-item"><a class="nav-link text-white" href="#fasilitas">Fasilitas</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#kelas">Kelas</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#trainer">Personal Trainer</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#testimonial">Testimoni</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#contact">Hubungi Kami</a></li>
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

    <!-- HERO HOME -->
    <header class="hero-section">
        <div class="container hero-content">
            <div class="row">
                <div class="col-lg-8 px-3">
                    <h6 class="text-warning fw-bold mb-3 ls-2">POWER GYM</h6>

                    <h1 class="hero-title mb-4 fw-bold">
                        Latihan Eksklusif,<br>
                        Harga Ekonomis
                    </h1>

                    <p class="lead text-white-50 mb-5" style="max-width: 600px;">
                        Temukan ketenangan dan energi baru di Mega Gym 24 jam pertama di Jogja dengan fasilitas standar internasional.
                    </p>

                    <a href="../auth/login.php" class="btn btn-warning hero-btn text-dark">
                        Get Membership <ion-icon name="arrow-forward-outline" style="vertical-align: middle; margin-left: 5px;"></ion-icon>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- FASILITAS -->
    <section class="py-5" style="background-color: #0f0f0f;" id="fasilitas">
        <div class="container py-5">

            <div class="row mb-5">
                <div class="col-lg-6">
                    <h6 class="text-warning fw-bold ls-2 text-uppercase">Fasilitas Unggulan</h6>
                    <h2 class="title text-white display-5 fw-bold">Mengapa Harus Power GYM?</h2>
                </div>
                <div class="col-lg-6 d-flex align-items-end justify-content-lg-end mt-3 mt-lg-0">
                    <p class="text-white-50 mb-0 text-lg-end">
                        Kami menyediakan fasilitas terbaik untuk menunjang <br> performa latihan Anda menjadi lebih maksimal.
                    </p>
                </div>
            </div>

            <div class="row g-4">

                <div class="col-md-6 col-lg-3">
                    <div class="feature-card p-4 h-100">
                        <div class="icon-box mb-4">
                            <ion-icon name="time-outline"></ion-icon>
                        </div>
                        <h4 class="text-white fw-bold mb-2">Akses 24 Jam</h4>
                        <p class="text-secondary small mb-0">Latihan kapan saja tanpa batasan waktu. Gym kami tidak pernah tidur.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="feature-card p-4 h-100">
                        <div class="icon-box mb-4">
                            <ion-icon name="map-outline"></ion-icon>
                        </div>
                        <h4 class="text-white fw-bold mb-2">Lokasi Strategis</h4>
                        <p class="text-secondary small mb-0">Terletak di pusat kota, mudah dijangkau dari mana saja.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="feature-card p-4 h-100">
                        <div class="icon-box mb-4">
                            <ion-icon name="barbell-outline"></ion-icon>
                        </div>
                        <h4 class="text-white fw-bold mb-2">Alat Premium</h4>
                        <p class="text-secondary small mb-0">100+ Alat fitness standar internasional untuk semua jenis latihan.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="feature-card p-4 h-100">
                        <div class="icon-box mb-4">
                            <ion-icon name="water-outline"></ion-icon>
                        </div>
                        <h4 class="text-white fw-bold mb-2">Free Refill</h4>
                        <p class="text-secondary small mb-0">Isi ulang air minum sepuasnya. Hindari dehidrasi saat latihan.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="feature-card p-4 h-100">
                        <div class="icon-box mb-4">
                            <ion-icon name="file-tray-stacked-outline"></ion-icon>
                        </div>
                        <h4 class="text-white fw-bold mb-2">Loker & Handuk</h4>
                        <p class="text-secondary small mb-0">Penyimpanan aman dan amenities lengkap, tak perlu bawa dari rumah.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="feature-card p-4 h-100">
                        <div class="icon-box mb-4">
                            <ion-icon name="car-sport-outline"></ion-icon>
                        </div>
                        <h4 class="text-white fw-bold mb-2">Parkir Luas</h4>
                        <p class="text-secondary small mb-0">Area parkir luas dan aman untuk kendaraan roda dua maupun empat.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="feature-card p-4 h-100">
                        <div class="icon-box mb-4">
                            <ion-icon name="wifi-outline"></ion-icon>
                        </div>
                        <h4 class="text-white fw-bold mb-2">Free WiFi</h4>
                        <p class="text-secondary small mb-0">Koneksi internet super cepat untuk menemani streaming musik Anda.</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="feature-card p-4 h-100">
                        <div class="icon-box mb-4">
                            <ion-icon name="snow-outline"></ion-icon>
                        </div>
                        <h4 class="text-white fw-bold mb-2">Full AC</h4>
                        <p class="text-secondary small mb-0">Ruangan dingin dan nyaman dengan sirkulasi udara yang baik.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- KELAS -->
    <section class="py-5" style="background-color: #1a1a1a;" id="kelas">
        <div class="container py-5">

            <div class="text-center mb-5">
                <h6 class="text-warning fw-bold ls-2 text-uppercase">Pilihan Kelas</h6>
                <h2 class="title text-white display-5 fw-bold font-oswald">TEMUKAN RITMEMU</h2>
            </div>

            <div class="class-menu-wrapper mb-4">
                <ul class="nav nav-pills justify-content-center flex-nowrap class-nav" id="pills-tab" role="tablist">

                    <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill px-4 fw-bold" id="pills-zumba-tab" data-bs-toggle="pill" data-bs-target="#pills-zumba" type="button" role="tab">ZUMBA</button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill px-4 fw-bold" id="pills-yoga-tab" data-bs-toggle="pill" data-bs-target="#pills-yoga" type="button" role="tab">YOGA</button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill px-4 fw-bold" id="pills-combat-tab" data-bs-toggle="pill" data-bs-target="#pills-combat" type="button" role="tab">BODY COMBAT</button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill px-4 fw-bold" id="pills-pilates-tab" data-bs-toggle="pill" data-bs-target="#pills-pilates" type="button" role="tab">PILATES</button>
                    </li>

                </ul>
            </div>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-zumba" role="tabpanel">
                    <div class="class-card">
                        <img src="https://images.unsplash.com/photo-1518611012118-696072aa579a?q=80&w=1470&auto=format&fit=crop" alt="Zumba" class="class-bg">
                        <div class="class-overlay">
                            <h2 class="text-white fw-bold font-oswald display-4">ZUMBA</h2>
                            <p class="text-white-50 lead">Gabungan tarian latin dan aerobik yang menyenangkan. Bakar kalori sambil berpesta!</p>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-yoga" role="tabpanel">
                    <div class="class-card">
                        <img src="https://images.unsplash.com/photo-1683056255281-e52a141924f0?q=80&w=1738&auto=format&fit=crop" alt="Yoga" class="class-bg">
                        <div class="class-overlay">
                            <h2 class="text-white fw-bold font-oswald display-4">YOGA</h2>
                            <p class="text-white-50 lead">Tingkatkan fleksibilitas, keseimbangan, dan ketenangan pikiran dengan teknik pernapasan.</p>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-combat" role="tabpanel">
                    <div class="class-card">
                        <img src="https://images.unsplash.com/photo-1620123646588-b9117246a9d0?q=80&w=1740&auto=format&fit=crop" alt="Body Combat" class="class-bg">
                        <div class="class-overlay">
                            <h2 class="text-white fw-bold font-oswald display-4">BODY COMBAT</h2>
                            <p class="text-white-50 lead">Latihan kardio bertenaga tinggi yang terinspirasi dari seni bela diri.</p>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pills-pilates" role="tabpanel">
                    <div class="class-card">
                        <img src="https://images.unsplash.com/photo-1747240549807-fc3962949818?q=80&w=1642&auto=format&fit=crop" alt="Pilates" class="class-bg">
                        <div class="class-overlay">
                            <h2 class="text-white fw-bold font-oswald display-4">PILATES</h2>
                            <p class="text-white-50 lead">Latihan angkat beban seluruh tubuh untuk membentuk otot yang ramping dan kuat.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- PERSONAL TRAINER -->
    <section class="py-5" style="background-color: #1a1a1a;" id="trainer">
        <div class="container py-5">

            <div class="row mb-5 align-items-center">
                <div class="col-lg-7">
                    <h6 class="text-warning fw-bold ls-2 text-uppercase">Personal Trainer</h6>
                    <h2 class="title text-white display-5 fw-bold font-oswald text-uppercase">
                        Latih Potensi Terbaikmu <br> Bersama Ahlinya
                    </h2>
                </div>
                <div class="col-lg-5">
                    <p class="text-white-50 mb-0 mt-3 mt-lg-0">
                        Tim Personal Trainer kami bersertifikat internasional dan siap membantu Anda mencapai target kebugaran dengan program yang dipersonalisasi.
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <?php
                $sql_trainer = "SELECT * FROM trainer LIMIT 4";
                $result_trainer = $connection->query($sql_trainer);

                // Data Dummy 
                $specialties = [
                    ['skills' => ['Muscle Hypertrophy', 'Strength Training', 'Diet Plan']],
                    ['skills' => ['HIIT Cardio', 'Calorie Deficit', 'Endurance']],
                    ['skills' => ['Flexibility', 'Mindfulness', 'Pilates']],
                    ['skills' => ['Crossfit', 'Agility', 'Injury Rehab']]
                ];

                $counter = 0;

                if ($result_trainer->num_rows > 0) {
                    while ($pt = $result_trainer->fetch_assoc()) {
                        $spec = $specialties[$counter % count($specialties)];
                ?>
                        <div class="col-md-6 col-lg-3">
                            <div class="trainer-card">
                                <div class="trainer-img-box">
                                    <img src="<?= $pt['image']; ?>" alt="<?= $pt['nama']; ?>" class="trainer-img">
                                    <div class="trainer-overlay">
                                        <span class="badge bg-warning text-dark mb-2"><?= $pt['spesialisasi']; ?></span>
                                        <h4 class="text-white font-oswald mb-0 text-uppercase">COACH <?= explode(' ', trim($pt['nama']))[0]; ?></h4>
                                    </div>
                                </div>
                                <div class="trainer-info p-4">
                                    <h6 class="text-warning fw-bold mb-2">PERSONAL SKILL</h6>
                                    <ul class="list-unstyled text-white-50 small mb-0">
                                        <?php foreach ($spec['skills'] as $skill): ?>
                                            <li>• <?= $skill; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                <?php
                        $counter++;
                    }
                }
                ?>
            </div>
        </div>
    </section>

    <section class="py-5" style="background-color: #0f0f0f;" id="testimonial">
        <div class="container py-5">

            <div class="mb-5">
                <h6 class="text-warning fw-bold ls-2 text-uppercase">Testimoni</h6>
                <h2 class="title text-white display-5 fw-bold font-oswald">APA KATA MEREKA?</h2>
            </div>

            <div class="testimonial-wrapper">
                <div class="testimonial-track pt-5">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <div class="testimonial-card">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" class="testimonial-photo">
                            <h5 class="testimonial-name text-center"><?= $row['nama'] ?></h5>
                            <p class="testimonial-date text-center">18 September 2024</p>
                            <p class="testimonial-text text-center"><?= $row['testimoni'] ?></p>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </section>



    <!-- Footer -->
    <div class="container-fluid px-4 px-md-5" style="background-color: #1a1a1a;">
        <footer class="py-5" id="contact">
            <div class="row justify-content-center text-white">

                <div class="col-12 col-md-5 col-lg-4 mb-5 mb-md-0">
                    <h3 class="title fw-bold text-uppercase lh-1 mb-3" style="font-size: clamp(2rem, 5vw, 3rem);">
                        Level Up Your Life.
                    </h3>
                    <p class="text-secondary">Akses fasilitas gym premium tanpa batas.</p>
                    <a href="../auth/login.php" class="btn btn-warning hero-btn text-dark fw-bold px-4">
                        Join Membership
                        <ion-icon name="arrow-forward-outline" style="vertical-align: middle; margin-left: 5px;"></ion-icon>
                    </a>
                </div>

                <div class="col-12 col-md-3 col-lg-2 mb-4 mb-md-0">
                    <h6 class="fw-bold text-uppercase mb-3 text-warning">Jelajahi</h6>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a class="nav-link p-0 text-secondary" href="#fasilitas">Fasilitas</a></li>
                        <li class="nav-item mb-2"><a class="nav-link p-0 text-secondary" href="#kelas">Kelas</a></li>
                        <li class="nav-item mb-2"><a class="nav-link p-0 text-secondary" href="#trainer">Personal Trainer</a></li>
                        <li class="nav-item mb-2"><a class="nav-link p-0 text-secondary" href="#testimonial">Testimoni</a></li>
                        <li class="nav-item mb-2"><a class="nav-link p-0 text-secondary" href="#contact">Hubungi Kami</a></li>
                        <li class="nav-item mb-2"><a class="nav-link p-0 text-secondary" href="../calculate_bmi/bmi.php">Cek BMI</a></li>
                    </ul>
                </div>

                <div class="col-12 col-md-4 col-lg-3">
                    <h6 class="fw-bold text-uppercase mb-3 text-warning">Hubungi Kami</h6>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a href="https://wa.me/+6281112833123" class="nav-link p-0 text-secondary d-flex align-items-center">
                                <i class="bi bi-telephone-fill me-2"></i> +62 811-1283-3123
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="https://www.instagram.com/power_gym/" class="nav-link p-0 text-secondary d-flex align-items-center">
                                <i class="bi bi-instagram me-2"></i> power_gym
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="#" class="nav-link p-0 text-secondary d-flex align-items-start">
                                <i class="bi bi-geo-alt-fill me-2 mt-1"></i> Jalan Babarsari Nomor 2, Yogyakarta.
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="#" class="nav-link p-0 text-secondary d-flex align-items-center">
                                <i class="bi bi-clock-fill me-2"></i> 24 Jam, 7 Hari Seminggu
                            </a>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="d-flex justify-content-center py-4 my-4 border-top border-secondary text-secondary">
                <p class="m-0">©2025 <b>Power GYM</b>. All rights reserved.</p>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>


    <script src="index.js"></script>
</body>

</html>