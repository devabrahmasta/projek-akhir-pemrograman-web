<?php 
session_start();

if (!isset($_SESSION['transaction_data'])) {
    header("Location: ../membership/membership_list.php");
    exit;
}

$transaction = $_SESSION['transaction_data'];

$nama_paket = $transaction['nama_paket'];
$nama_trainer = $transaction['nama_trainer'];
$base_price = $transaction['base_price'];
$trainer_total = $transaction['trainer_fee']; 
$total_price = $transaction['total_price'];
$has_trainer = ($transaction['nama_trainer'] !== "-" && !empty($transaction['nama_trainer']));
$nama_trainer_display = $has_trainer ? $transaction['nama_trainer'] : "Tanpa Personal Trainer";
$trainer_class = $has_trainer ? "fw-bold text-white" : "text-muted fst-italic";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Konfirmasi Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    <link rel="stylesheet" href="../style.css">
    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</head>

<body class="bg-dark">
    <nav class="navbar navbar-expand-lg bg-transparent mx-5 px-5 sticky-top">
        <div class="container-fluid py-3">
            <a class="navbar-brand text-white fw-bold" href="../main_page/index.php">
                <ion-icon name="arrow-back-outline" style="vertical-align: middle;"></ion-icon> Kembali Ke Beranda
            </a>
        </div>
    </nav>

    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; padding: 20px;">
        
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="testimonial-card p-5 card-full-width" style="width: 100% !important;margin: 0 !important;padding: 2rem;">
                
                <h2 class="text-warning fw-bold mb-3 text-center">Konfirmasi Pembelian</h2>
                <p class="text-white-50 text-center mb-4">Pastikan semua detail di bawah ini sudah benar sebelum melanjutkan ke pembayaran.</p>

                <div class="card bg-dark shadow-sm border-warning-subtle mb-4">
                    <div class="card-body">
                        <h5 class="text-white fw-bold border-bottom border-warning pb-2">Detail Paket</h5>
                        <ul class="list-unstyled text-white mt-3">
                            <li class="d-flex justify-content-between mb-2">
                                <span>Paket Dipilih:</span>
                                <span class="fw-bold text-warning"><?php echo htmlspecialchars($nama_paket); ?></span>
                            </li>
                            <li class="d-flex justify-content-between mb-2">
                                <span>Personal Trainer:</span>
                                <span class="<?php echo $trainer_class; ?>"><?php echo htmlspecialchars($nama_trainer_display); ?></span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card bg-dark shadow-sm border-warning-subtle mb-4">
                    <div class="card-body">
                        <h5 class="text-white fw-bold border-bottom border-warning pb-2">Rincian Biaya</h5>
                        <ul class="list-unstyled text-white mt-3">
                            <li class="d-flex justify-content-between mb-2">
                                <span>Harga Paket:</span>
                                <span>Rp <?php echo number_format($base_price, 0, ',', '.'); ?></span>
                            </li>
                            
                            <li class="d-flex justify-content-between mb-2">
                                <span>Biaya Trainer Total:</span>
                                <span class="<?php echo $trainer_total > 0 ? '' : 'text-muted'; ?>">
                                    <?php echo ($trainer_total > 0) ? "Rp " . number_format($trainer_total, 0, ',', '.') : "-"; ?>
                                </span>
                            </li>

                            <li class="d-flex justify-content-between pt-3 border-top border-white-50">
                                <span class="fw-bold fs-5">TOTAL AKHIR:</span>
                                <span class="fw-bold fs-5 text-warning">Rp <?php echo number_format($total_price, 0, ',', '.'); ?></span>
                            </li>
                        </ul>
                    </div>
                </div>

                <form action="../../controllers/transaction/checkout_process.php" method="POST">
                    
                    <input type="hidden" name="confirm_checkout" value="1">
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning fw-bold py-3 text-dark">
                            Lanjutkan ke Pembayaran <ion-icon name="arrow-forward-circle" style="vertical-align: middle; margin-left: 5px;"></ion-icon>
                        </button>
                        
                        <a href="../membership/pilih_trainer.php?id_paket=<?php echo $transaction['id_paket']; ?>" 
                           class="btn btn-outline-light text-white">
                           <ion-icon name="people-outline" style="vertical-align: middle; margin-right: 5px;"></ion-icon> 
                           <?php echo $has_trainer ? "Ganti Personal Trainer" : "Tambah Personal Trainer"; ?>
                        </a>
                    </div>
                </form>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>