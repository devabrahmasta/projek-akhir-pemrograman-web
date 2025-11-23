<?php
require_once(dirname(dirname(__DIR__)) . "/config/connection.php");
session_start();

if (!isset($_GET['id']) || !isset($_SESSION['logged_in'])) {
    header("Location: ../../views/main_page/index.php");
    exit;
}

$id_transaksi = $_GET['id'];

// transaksi -> membership -> paket & trainer & pelanggan
$query = "SELECT t.id_transaksi, t.tanggal_transaksi, t.nominal, p.deskripsi AS nama_paket, p.durasi, tr.nama AS nama_trainer, pl.nama AS nama_pelanggan
        FROM transaksi t JOIN membership m ON t.id_membership = m.id_membership JOIN paket_member p ON m.id_paket = p.id_paket
        JOIN pelanggan pl ON m.id_pelanggan = pl.id_pelanggan LEFT JOIN trainer tr ON m.id_trainer = tr.id_trainer WHERE t.id_transaksi = ?";

$stmt = $connection->prepare($query);
$stmt->bind_param('i', $id_transaksi);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "Data transaksi tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran - Power GYM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</head>

<body class="bg-dark">

    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; padding: 20px;">
        <div class="col-lg-5 col-md-7 col-sm-10">
            
            <div class="testimonial-card card-full-width p-0 overflow-hidden" style="background-color: #fff; color: #333;">
                
                <div class="bg-warning p-4 text-center">
                    <div class="rounded-circle bg-white d-inline-flex p-3 mb-3 shadow-sm">
                        <ion-icon name="checkmark-done-outline" class="text-success" style="font-size: 40px;"></ion-icon>
                    </div>
                    <h3 class="fw-bold text-dark m-0">Pembayaran Berhasil!</h3>
                    <p class="text-dark small m-0">Terima kasih telah bergabung dengan Power GYM</p>
                </div>

                <div class="p-4">
                    <div class="text-center mb-4 border-bottom pb-3">
                        <p class="text-muted small mb-1">TOTAL DIBAYAR</p>
                        <h1 class="fw-bold text-dark">Rp <?php echo number_format($data['nominal'], 0, ',', '.'); ?></h1>
                    </div>

                    <div class="row mb-2">
                        <div class="col-5 text-muted small">ID Transaksi</div>
                        <div class="col-7 text-end fw-bold small text-uppercase">#<?php echo $data['id_transaksi']; ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted small">Tanggal</div>
                        <div class="col-7 text-end fw-bold small"><?php echo date('d F Y', strtotime($data['tanggal_transaksi'])); ?></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 text-muted small">Pelanggan</div>
                        <div class="col-7 text-end fw-bold small"><?php echo htmlspecialchars($data['nama_pelanggan']); ?></div>
                    </div>

                    <hr class="my-3" style="border-top: 2px dashed #ccc;">

                    <div class="row mb-2">
                        <div class="col-5 text-muted small">Paket</div>
                        <div class="col-7 text-end fw-bold small text-uppercase"><?php echo htmlspecialchars($data['nama_paket']); ?> (<?php echo $data['durasi']; ?> Hari)</div>
                    </div>
                    
                    <?php if ($data['nama_trainer']): ?>
                    <div class="row mb-2">
                        <div class="col-5 text-muted small">Personal Trainer</div>
                        <div class="col-7 text-end fw-bold small text-uppercase"><?php echo htmlspecialchars($data['nama_trainer']); ?></div>
                    </div>
                    <?php else: ?>
                    <div class="row mb-2">
                        <div class="col-5 text-muted small">Personal Trainer</div>
                        <div class="col-7 text-end text-muted small">-</div>
                    </div>
                    <?php endif; ?>

                </div>

                <div class="p-4 bg-light border-top text-center">
                    <p class="small text-muted mb-3">Bukti pembayaran ini sah dan dapat disimpan.</p>
                    
                    <div class="d-grid gap-2">
                        <a href="../main_page/index.php" class="btn btn-dark fw-bold">
                            <ion-icon name="home-outline" style="vertical-align: middle; margin-right: 5px;"></ion-icon> Kembali ke Home
                        </a>
                        <a href="../personal_page/dashboard.php" class="btn btn-outline-dark fw-bold">
                            Lihat Dashboard Saya
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>