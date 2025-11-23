<?php 

session_start();

function redirect($path, $errorMessage = null) {
    if ($errorMessage) {
        $_SESSION['error'] = $errorMessage;
    }
    header("Location: " . $path);
    exit;
}

require_once(__DIR__ . '/../../config/connection.php');

$dashboard_path = "../../views/personal_page/dashboard.php";
$membership_path = "../../views/membership/membership_list.php";

if ($_SERVER['REQUEST_METHOD'] !== "POST" || !isset($_POST['confirm_checkout'])) {
    redirect($membership_path, "Metode permintaan tidak valid.");
}

if (!isset($_SESSION['transaction_data']) || !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    redirect("../../views/auth/login.php", "Sesi transaksi tidak ditemukan atau Anda belum login.");
}

$transaction = $_SESSION['transaction_data'];
$connection->autocommit(false); 

try {
    $id_pelanggan = (int)$transaction['id_pelanggan'];
    $id_paket = (int)$transaction['id_paket'];
    $id_trainer = (int)$transaction['id_trainer']; 
    $total_price = (float)$transaction['total_price'];
    
    $base_price = (float)$transaction['base_price'];

    $tgl_mulai = date('Y-m-d');
    
    $stmt_durasi = $connection->prepare("SELECT durasi FROM paket_member WHERE id_paket = ?");
    $stmt_durasi->bind_param('i', $id_paket);
    $stmt_durasi->execute();
    $result_durasi = $stmt_durasi->get_result();
    $data_durasi = $result_durasi->fetch_object();
    $stmt_durasi->close();
    
    
    $trainer_id_for_db = ($id_trainer > 0) ? $id_trainer : null;
    
    $query_membership = "INSERT INTO membership (id_trainer, id_pelanggan, id_paket, tgl_mulai, harga) 
                         VALUES (?, ?, ?, ?, ?)";
    
    $stmt_membership = $connection->prepare($query_membership);
    
    if (!$stmt_membership) {
        throw new Exception("Prepare Statement Membership Gagal: " . $connection->error);
    }

    $stmt_membership->bind_param('iiisd', $trainer_id_for_db, $id_pelanggan, $id_paket, $tgl_mulai, $base_price);
    
    if (!$stmt_membership->execute()) {
        throw new Exception("Gagal insert membership: " . $stmt_membership->error);
    }
    
    $id_membership_baru = $connection->insert_id; 
    $stmt_membership->close();
    
    
    $query_transaksi = "INSERT INTO transaksi (id_membership, tanggal_transaksi, nominal) 
                        VALUES (?, ?, ?)";
    
    $stmt_transaksi = $connection->prepare($query_transaksi);
    
    if (!$stmt_transaksi) {
        throw new Exception("Prepare Statement Transaksi Gagal: " . $connection->error);
    }

    $stmt_transaksi->bind_param('isd', $id_membership_baru, $tgl_mulai, $total_price);
    
    if (!$stmt_transaksi->execute()) {
        throw new Exception("Gagal insert transaksi: " . $stmt_transaksi->error);
    }
    $id_transaksi_baru = $connection->insert_id;
    $stmt_transaksi->close();
    
    
    if ($id_trainer > 0) {
        $query_trainer_update = "UPDATE trainer SET status = 'DISEWA' WHERE id_trainer = ?";
        $stmt_trainer = $connection->prepare($query_trainer_update);
        $stmt_trainer->bind_param('i', $id_trainer);
        
        if (!$stmt_trainer->execute()) {
            throw new Exception("Gagal update status trainer.");
        }
        $stmt_trainer->close();
    }
    
    $connection->commit();
    unset($_SESSION['transaction_data']); 
    header("Location: ../../views/transaction/struk.php?id=" . $id_transaksi_baru);
    exit;
    
} catch (Exception $e) {
    $connection->rollback(); 
    error_log("PROCESS CHECKOUT FAILED: " . $e->getMessage());
    redirect($membership_path, "Pembayaran gagal: " . $e->getMessage());
    
} finally {
    $connection->autocommit(true);
}
?>