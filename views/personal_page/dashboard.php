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

$sql_membership = "SELECT m.tgl_mulai, m.id_trainer, m.id_paket, p.durasi, p.deskripsi, 
                          t.nama AS nama_trainer, t.gender AS gender_trainer, t.no_hp AS no_hp_trainer
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

if ($member_data) {
    $tgl_mulai = new DateTime($member_data['tgl_mulai']);
    $tgl_mulai->setTime(0, 0, 0);

    $durasi = (int)$member_data['durasi'];

    $tgl_akhir = clone $tgl_mulai;
    $tgl_akhir->modify("+$durasi days");

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
    if (isset($_SESSION['error'])) {
        $message = $_SESSION['error'];
        echo '<script>alert("' . htmlspecialchars($message) . '");</script>';
        unset($_SESSION['error']);
    }
    ?>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top px-5 py-3">
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

    <div class="container-fluid dashboard-container">
        <div class="row h-100">

            <div class="col-lg-3 col-md-4 sidebar-area p-0">
                <div class="d-flex flex-column h-100 p-3">

                    <div class="bg-card-dark card-outline p-4 text-center mb-3">
                        <div class="position-relative d-inline-block mb-3">
                            <img src="<?php echo $avatar; ?>" class="rounded-circle border border-3 border-dark p-1" alt="Avatar" width="100" height="100">
                            <span class="position-absolute bottom-0 end-0 bg-success border border-dark rounded-circle p-2"></span>
                        </div>
                        <h4 class="fw-bold text-white mb-1"><?php echo htmlspecialchars($user_data['nama']); ?></h4>
                        <span class="badge bg-warning text-dark mb-4">Member <?php echo ($status_member == 'Active') ? 'Gold' : 'Basic'; ?></span>

                        <div class="d-flex justify-content-between text-center bg-black rounded-4 p-3 bg-opacity-25">
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

                    <div class="bg-card-dark p-3">
                        <div class="d-grid gap-2">
                            <?php if (!empty($user_data['testimoni'])): ?>
                                <div class="text-white text-center p-2">
                                    <small class="text-warning d-block mb-1"><i class="bi bi-quote"></i> Kata Anda:</small>
                                    <p class="fst-italic mb-0">"<?php echo htmlspecialchars($user_data['testimoni']); ?>"</p>
                                </div>
                            <?php else: ?>
                                <button type="button" class="btn btn-warning fw-bold text-dark rounded-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTestimoni">
                                    <i class="bi bi-chat-quote me-2"></i> Beri Testimoni
                                </button>
                            <?php endif; ?>
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
                                    <span class="stat-number" style="font-size: 1.8rem;"><?php echo $sisa_hari; ?> Hari</span>
                                    <span class="stat-label">(<?php echo htmlspecialchars($nama_paket); ?>)</span>
                                    <span class="stat-label">Berakhir tgl(<?php echo htmlspecialchars($nama_paket); ?>)</span>
                                </div>
                                <div class="stat-icon-circle icon-theme-yellow">
                                    <ion-icon name="time"></ion-icon>
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

                <?php
                if ($member_data) {
                    // 1. KONDISI: Membership Habis
                    if ($sisa_hari <= 0) {
                ?>
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <div class="alert alert-dark-warning d-flex align-items-center" role="alert">
                                    <ion-icon name="alert-circle-outline" class="text-warning me-3 fs-2"></ion-icon>
                                    <div>
                                        Masa aktif Membership Anda telah habis!
                                        <a href="../membership/membership_list.php" class="text-warning fw-bold text-decoration-none ms-2">
                                            Perpanjang Sekarang <ion-icon name="arrow-forward-outline" style="vertical-align: middle;"></ion-icon>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php
                        // 2. KONDISI: Member Aktif TAPI Belum Punya Trainer
                    } elseif ($sisa_hari > 0 && empty($member_data['id_trainer'])) {
                    ?>
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <div class="bg-card-dark p-4 d-flex align-items-center border border-info" style="border-radius: 12px;">
                                    <ion-icon name="people-circle-outline" class="text-info me-3 fs-1"></ion-icon>
                                    <div class="text-white">
                                        Membership Anda aktif, tapi belum punya Personal Trainer.
                                        <a href="../membership/pilih_trainer.php?id_paket=<?php echo $member_data['id_paket'] ?? ''; ?>" class="text-info fw-bold text-decoration-none ms-2">
                                            Cari Trainer Sekarang <ion-icon name="arrow-forward-outline" style="vertical-align: middle;"></ion-icon>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        // 3. KONDISI: Member Aktif & SUDAH PUNYA Trainer (Tampilkan Profil Trainer)
                    } else {
                        // Generate Avatar Trainer Dummy
                        $avatar_trainer = ($member_data['gender_trainer'] == 'Perempuan')
                            ? "https://randomuser.me/api/portraits/women/" . rand(1, 99) . ".jpg"
                            : "https://randomuser.me/api/portraits/men/" . rand(1, 99) . ".jpg";
                    ?>
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <div class="bg-card-dark p-4" style="border-left: 5px solid #28a745;">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">

                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo $avatar_trainer; ?>" alt="Trainer"
                                                class="rounded-circle border border-2 border-success"
                                                style="width: 60px; height: 60px; object-fit: cover;">

                                            <div class="ms-3">
                                                <small class="text-success fw-bold text-uppercase ls-1" style="letter-spacing: 1px;">Personal Trainer Anda</small>
                                                <h4 class="text-white fw-bold mb-0"><?php echo htmlspecialchars($member_data['nama_trainer']); ?></h4>
                                            </div>
                                        </div>

                                        <div>
                                            <a href="https://wa.me/<?php echo $member_data['no_hp_trainer']; ?>" target="_blank" class="btn btn-success fw-bold d-flex align-items-center gap-2">
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
                }
                ?>

                <h4 class="text-white fw-bold mb-3">Kelas Minggu Ini</h4>
                <div class="row g-3 mb-5">
                    <?php for ($i = 1; $i <= 6; $i++) { ?>
                        <div class="col-md-6">
                            <div class="bg-card-dark p-3">
                                <div class="d-flex gap-3">
                                    <img src="https://source.unsplash.com/random/100x100?gym&sig=<?php echo $i; ?>" class="rounded-3" style="width:80px; height:80px; object-fit:cover; filter: grayscale(30%);">
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

                <form action="../../controllers/personal/submit_testimoni.php" method="POST">
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