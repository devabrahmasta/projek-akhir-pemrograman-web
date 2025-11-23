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

$avatar = ($user_data['gender'] == 'Perempuan') ? "https://randomuser.me/api/portraits/women/" . rand(1,90) . ".jpg":"https://randomuser.me/api/portraits/men/" . rand(1,90) . ".jpg";

$sql_membership = "SELECT m.tgl_mulai, p.durasi, p.deskripsi FROM membership m JOIN paket_member p ON m.id_paket = p.id_paket 
                    WHERE m.id_pelanggan = ? ORDER BY m.id_membership DESC LIMIT 1";

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
    
    <nav class="navbar navbar-expand-lg bg-transparent mx-5 px-5 sticky-top">
        <div class="container-fluid py-3">
            <a class="navbar-brand text-white fw-bold" href="index.php">Power GYM</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end " id="navbarNav">
                <ul class="nav nav-underline ">
                    <li class="nav-item "><a class="nav-link text-white active" aria-current="page" href="../main_page/index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Fasilitas</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="../membership/membership_list.php">Membership</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="#">Testimoni</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="../calculate_bmi/bmi.php">Cek BMI</a></li>
                    <li class="nav-item">
                        <a type="button" class="btn btn-danger" href="../../controllers/auth/logout.php">Logout</a>
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
                            
                            <a href="../../controllers/auth/logout.php" class="btn btn-custom-sidebar text-start rounded-3 py-2">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a>
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
                                    <span class="stat-label">Sisa Waktu Langganan (<?php echo htmlspecialchars($nama_paket); ?>)</span>
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

                <div class="row g-3">
                    <div class="col-12">
                        <div class="bg-card-dark p-4 d-flex align-items-center">
                            <ion-icon name="information-circle" class="text-warning me-3 fs-2"></ion-icon>
                            <div class="text-white">
                                Kamu belum memilih personal trainer. <a href="../membership/pilih_trainer.php?id_paket=1" class="text-warning fw-bold text-decoration-none">Cari Trainer Sekarang <ion-icon name="arrow-forward-outline" style="vertical-align: middle;"></ion-icon></a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="modalTestimoni" tabindex="-1" aria-labelledby="modalTestimoniLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg"> <div class="modal-content bg-dark border-warning">
                
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