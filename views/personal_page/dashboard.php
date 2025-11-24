<?php
require_once(__DIR__ . "/../../config/connection.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql_user = "SELECT nama, gender, testimoni FROM pelanggan WHERE id_pelanggan = ?";
$stmt_user = $connection->prepare($sql_user);
$stmt_user->bind_param('i', $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user_data = $result_user->fetch_assoc();
$stmt_user->close();

$avatar = ($user_data['gender'] == 'Perempuan') ? "https://randomuser.me/api/portraits/women/" . rand(1, 90) . ".jpg" : "https://randomuser.me/api/portraits/men/" . rand(1, 90) . ".jpg";

// Tambahkan t.image dan t.spesialisasi di SELECT
$sql_membership = "SELECT m.tgl_mulai, m.id_trainer, m.id_paket, p.durasi, p.deskripsi, 
                          t.nama AS nama_trainer, 
                          t.gender AS gender_trainer, 
                          t.no_hp AS no_hp_trainer,
                          t.image AS foto_trainer,         
                          t.spesialisasi AS spesialisasi_trainer
                   FROM membership m 
                   JOIN paket_member p ON m.id_paket = p.id_paket 
                   LEFT JOIN trainer t ON m.id_trainer = t.id_trainer 
                   WHERE m.id_pelanggan = ? 
                   ORDER BY m.id_membership DESC LIMIT 1";

$stmt_member = $connection->prepare($sql_membership);
$stmt_member->bind_param('i', $user_id);
$stmt_member->execute();
$result_member = $stmt_member->get_result();
$member_data = $result_member->fetch_assoc();
$stmt_member->close();

$sisa_hari = 0;
$nama_paket = "Tidak Ada";
$status_member = "Inactive";
$status_badge = "Basic";
$tgl_berakhir_display = "-";

if ($member_data) {
    $tgl_mulai = new DateTime($member_data['tgl_mulai']);
    $tgl_mulai->setTime(0, 0, 0);

    $durasi = (int)$member_data['durasi'];

    $tgl_akhir = clone $tgl_mulai;
    $tgl_akhir->modify("+$durasi days");

    $tgl_berakhir_display = $tgl_akhir->format('d M Y');

    $tgl_sekarang = new DateTime();
    $tgl_sekarang->setTime(0, 0, 0);

    if ($tgl_sekarang <= $tgl_akhir) {
        $interval = $tgl_sekarang->diff($tgl_akhir);
        $sisa_hari = $interval->days;

        $nama_paket = htmlspecialchars($member_data['deskripsi']);
        $status_member = "Active";
        $status_badge = "Gold";
    } else {
        $sisa_hari = 0;
        $nama_paket = htmlspecialchars($member_data['deskripsi']) . " (Habis)";
        $status_member = "Expired";
    }
}


$sql_kelas = "SELECT *, TIMEDIFF(waktu_selesai, waktu_mulai) as durasi_jam 
            FROM kelas 
            WHERE tanggal >= CURDATE() 
            ORDER BY tanggal ASC, waktu_mulai ASC 
            LIMIT 4";

$result_kelas = $connection->query($sql_kelas);

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
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <?php
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
                    <li class="nav-item"><a class="nav-link text-warning active" href="../personal_page/dashboard.php">Profil Saya</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="../main_page/index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="../membership/membership_list.php">Membership</a></li>
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


    <div class="container-fluid dashboard-container">
        <div class="row h-100">

            <!-- PROFILE -->
            <div class="col-lg-3 col-md-4 sidebar-area p-0">
                <div class="d-flex flex-column h-100 p-3">

                    <div class="bg-card-dark p-4 text-center mb-3">
                        <div class="position-relative d-inline-block mb-3">
                            <img src="<?= $avatar; ?>" class="rounded-circle p-1" alt="Avatar" width="100" height="100">
                        </div>
                        <h4 class="fw-bold text-white mb-1"><?= htmlspecialchars($user_data['nama']); ?></h4>
                        <span class="badge bg-warning text-dark mb-4">Member <?= ($status_member == 'Active') ? 'Gold' : 'Basic'; ?></span>

                        <div class="d-flex justify-content-between text-center bg-black rounded-4 p-3 bg-opacity-   25">
                            <div>
                                <small class="text-secondary d-block mb-1" style="font-size: 0.7rem;">UMUR</small>
                                <span class="fw-bold text-white">-</span>
                            </div>
                            <div class="vr bg-secondary"></div>
                            <div>
                                <small class="text-secondary d-block mb-1" style="font-size: 0.7rem;">BERAT</small>
                                <span class="fw-bold text-white">-</span>
                            </div>
                            <div class="vr bg-secondary"></div>
                            <div>
                                <small class="text-secondary d-block mb-1" style="font-size: 0.7rem;">TINGGI</small>
                                <span class="fw-bold text-white">-</span>
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

                </div>
            </div>

            <!-- OVERVIEW -->
            <div class="col-lg-9 col-md-8 content-area p-4">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="text-white fw-bold">Overview</h3>
                    <small class="text-secondary">Update: Live</small>
                </div>
                <div class="row g-3 mb-5">
                    <!-- STREAK -->
                    <div class="col-md-4">
                        <div class="stat-card card-lime h-100">
                            <div class="stat-card-content h-100 d-flex align-items-center justify-content-between">
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

                    <!-- MEMBERSHIP -->
                    <div class="col-md-4">
                        <div class="stat-card h-100">
                            <div class="stat-card-content h-100 d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="stat-number" style="font-size: 1.8rem;"><?= $sisa_hari; ?> Hari</span>
                                    <span class="stat-label text-warning d-block mb-1"><?= htmlspecialchars($nama_paket); ?></span>
                                    <span class="stat-label text-secondary" style="font-size: 0.8rem;">
                                        <?php if ($status_member == 'Inactive'): ?>
                                            Silakan beli paket membership
                                        <?php else: ?>
                                            Berakhir: <?= $tgl_berakhir_display; ?>
                                        <?php endif; ?>
                                    </span>
                                </div>

                                <div class="stat-icon-circle icon-theme-yellow">
                                    <ion-icon name="time"></ion-icon>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TOTAL VISIT -->
                    <div class="col-md-4">
                        <div class="stat-card h-100">
                            <div class="stat-card-content h-100 d-flex align-items-center justify-content-between">
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

                <?php
                if ($member_data) {
                    // USER LAMA
                    // Membership SUDAH HABIS
                    if ($sisa_hari <= 0) {
                ?>
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <div class="alert alert-dark-warning d-flex align-items-center shadow-sm" role="alert">
                                    <ion-icon name="alert-circle-outline" class="me-3 fs-2"></ion-icon>
                                    <div>
                                        <strong>Membership Habis!</strong> Masa aktif paket Anda telah berakhir.
                                        <a href="../membership/membership_list.php" class="alert-link fw-bold ms-1">
                                            Perpanjang Sekarang <ion-icon name="arrow-forward-outline" style="vertical-align: middle;"></ion-icon>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php
                        // Membership AKTIF, tapi BELUM PILIH TRAINER
                    } elseif ($sisa_hari > 0 && empty($member_data['id_trainer'])) {
                    ?>
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <div class="alert alert-dark-info d-flex align-items-center shadow-sm" role="alert">
                                    <ion-icon name="people-circle-outline" class="me-3 fs-1"></ion-icon>
                                    <div>
                                        Membership <strong><?= htmlspecialchars($member_data['deskripsi']); ?></strong> aktif, tapi belum punya Trainer.
                                        <a href="../membership/pilih_trainer.php?id_paket=<?= $member_data['id_paket'] ?? ''; ?>" class="alert-link fw-bold ms-1">
                                            Cari Trainer Yuk <ion-icon name="arrow-forward-outline" style="vertical-align: middle;"></ion-icon>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php
                        // Membership AKTIF & SUDAH PUNYA TRAINER 
                    } else {
                        $foto_trainer = $member_data['foto_trainer'];
                        if (empty($foto_trainer)) {
                            $foto_trainer = "https://ui-avatars.com/api/?name=" . urlencode($member_data['nama_trainer']) . "&background=random";
                        }
                    ?>
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <h4 class="text-white fw-bold mb-4">Trainer Anda</h4>
                                <div class="bg-card-dark p-4" style="border-left: 5px solid #28a745;">
                                    <div class="d-flex align-dark-items-center justify-content-between flex-wrap gap-3">
                                        <div class="d-flex align-items-center">
                                            <img src="<?= $foto_trainer; ?>" alt="Trainer"
                                                class="rounded-circle border border-2 border-success"
                                                style="width: 70px; height: 70px; object-fit: cover;">
                                            <div class="ms-3">
                                                <small class="text-success fw-bold text-uppercase ls-1" style="letter-spacing: 1px;">
                                                    <?= htmlspecialchars($member_data['spesialisasi_trainer'] ?? 'Personal Trainer'); ?>
                                                </small>
                                                <h4 class="text-white fw-bold mb-0"><?= htmlspecialchars($member_data['nama_trainer']); ?></h4>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a href="https://wa.me/<?= $member_data['no_hp_trainer']; ?>" target="_blank" class="btn btn-success fw-bold d-flex align-items-center gap-2">
                                                <ion-icon name="logo-whatsapp" style="font-size: 1.2rem;"></ion-icon>
                                                Chat Trainer
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                } else {
                    // USER BARU (Belum Membership)
                    ?>
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <div class="alert alert-dark-primary d-flex align-items-center shadow" role="alert">
                                <div class="me-3 fs-1">
                                    <ion-icon name="card-outline"></ion-icon>
                                </div>
                                <div>
                                    <h5 class="alert-heading fw-bold mb-1">Selamat Datang, <?= htmlspecialchars($user_data['nama']); ?>! 👋</h5>
                                    <p class="mb-0">Kamu belum punya membership aktif. Yuk mulai transformasi tubuhmu sekarang!</p>
                                    <hr>
                                    <a href="../membership/membership_list.php" class="btn btn-primary fw-bold text-white">
                                        Pilih Paket Membership <ion-icon name="arrow-forward-outline" style="vertical-align: middle; margin-left:5px;"></ion-icon>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
                <div class="bg-card-dark p-3">
                    <div class="d-grid gap-2">
                        <?php if (!empty($user_data['testimoni'])): ?>
                            <div class="text-white text-center p-2">
                                <small class="text-warning d-block mb-1"><i class="bi bi-quote"></i> Kata Anda:</small>
                                <p class="fst-italic mb-0">"<?= htmlspecialchars($user_data['testimoni']); ?>"</p>
                            </div>
                        <?php else: ?>
                            <button type="button" class="btn btn-warning fw-bold text-dark rounded-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTestimoni">
                                <i class="bi bi-chat-quote me-2"></i> Beri Testimoni
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- KELAS -->
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <h4 class="text-white fw-bold mb-1">Kelas Mendatang</h4>
                        <p class="text-secondary small mb-0">Jadwal latihan eksklusif minggu ini</p>
                    </div>
                </div>

                <div class="row g-4 mb-5">
                    <?php
                    // Query ambil kelas yang akan datang (setelah hari ini)
                    if ($result_kelas->num_rows > 0) {
                        while ($kelas = $result_kelas->fetch_assoc()) {
                            // Format Durasi (misal 01:00:00 jadi 1 Jam)
                            $jam = (int) substr($kelas['durasi_jam'], 0, 2);
                            $menit = (int) substr($kelas['durasi_jam'], 3, 2);
                            $durasi_teks = "";
                            if ($jam > 0) $durasi_teks .= "$jam Jam ";
                            if ($menit > 0) $durasi_teks .= "$menit Mnt";

                            // Format Tanggal (26 Nov)
                            $tgl_display = date('d M', strtotime($kelas['tanggal']));
                            // Format Jam (07:00)
                            $jam_mulai = date('H:i', strtotime($kelas['waktu_mulai']));
                            $jam_berakhir = date('H:i', strtotime($kelas['waktu_selesai']));
                    ?>
                            <div class="col-md-6 col-xl-3">
                                <div class="class-card-modern">
                                    <div class="class-thumb-box">
                                        <img src="<?= $kelas['image_kelas']; ?>" alt="<?= htmlspecialchars($kelas['judul']); ?>" class="class-thumb-img">

                                        <span class="badge-duration">
                                            <ion-icon name="time-outline" style="vertical-align: middle; margin-right:3px;"></ion-icon>
                                            <?= $durasi_teks; ?>
                                        </span>
                                    </div>

                                    <div class="class-body">
                                        <h6 class="text-white fw-bold mb-1 text-truncate"><?= htmlspecialchars($kelas['judul']); ?></h6>

                                        <small class="text-secondary mb-3 d-block"><?= $tgl_display; ?> • <?= $jam_mulai; ?> - <?= $jam_berakhir; ?></small>

                                        <div class="d-flex justify-content-between align-items-center mt-auto">
                                            <div class="d-flex align-items-center">
                                                <img src="<?= $kelas['image_instruktur']; ?>" class="avatar-small me-2" alt="Instruktur">
                                                <small class="text-white-50" style="font-size: 0.75rem;"><?= explode(' ', $kelas['instruktur'])[0]; ?></small>
                                            </div>
                                        </div>

                                        <button class="btn btn-sm btn-outline-warning w-100 mt-3 rounded-pill" style="font-size: 0.8rem;">
                                            Daftar Sekarang
                                        </button>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<div class='col-12 text-center text-secondary'>Belum ada kelas yang dijadwalkan.</div>";
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="modalTestimoni" tabindex="-1" aria-labelledby="modalTestimoniLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark border-warning">

                <div class="modal-header border-secondary">
                    <h5 class="modal-title text-white fw-bold" id="modalTestimoniLabel">Bagikan Pengalamanmu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="../../controllers/personal/kirim_testimoni.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="testimoniText" class="form-label text-white-50">Apa pendapatmu tentang Power GYM?</label>
                            <textarea class="form-control bg-black text-white border-secondary" id="testimoniText" name="testimoni" rows="5" placeholder="Tulis pengalaman latihanmu di sini..." required style="resize: none;"></textarea>
                            <div class="form-text text-white-50">Minimal 10 karakter</div>
                        </div>
                    </div>

                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning fw-bold">Kirim Testimoni</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>