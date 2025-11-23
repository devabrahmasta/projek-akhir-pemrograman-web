<?php 
session_start();

function redirect($path, $errorMessage = null) {
    if ($errorMessage) {
        $_SESSION['error'] = $errorMessage;
    }
    header("Location: " . $path);
    exit;
}

require_once(__DIR__ . "../../config/connection.php"); 

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    redirect("../../views/auth/login.php", "Anda harus login untuk melanjutkan pembelian.");
}

if ($_SERVER['REQUEST_METHOD'] !== "GET" || !isset($_GET['id_paket'])) {
    redirect("../../views/membership/membership_list.php", "Permintaan tidak valid.");
}

$id_paket = (int)$_GET['id_paket'];
$id_trainer = isset($_GET['id_trainer']) ? (int)$_GET['id_trainer'] : 0;
$user_id = $_SESSION['user_id'] ?? null; 

$trainer_perhari = 20000;
$trainer_total = 0;
$final_price = 0;
$data_paket = null;
$data_trainer_nama = "-";

try {
    $stmt = $connection->prepare("SELECT deskripsi, harga, durasi FROM paket_member WHERE id_paket = ?");
    $stmt->bind_param('i', $id_paket);
    
    if ($stmt->execute()) {
        $paket = $stmt->get_result();
        $data_paket = $paket->fetch_object();
        $stmt->close();
    } else {
        throw new Exception("Gagal mengambil data paket.");
    }

    if (!$data_paket) {
        redirect("../../views/membership/membership_list.php", "Paket tidak ditemukan.");
    }

    if ($id_trainer > 0) {
        $stmt = $connection->prepare("SELECT nama, status FROM trainer WHERE id_trainer = ? AND status = 'TIDAK DISEWA'");
        $stmt->bind_param('i', $id_trainer);
        
        if ($stmt->execute()) {
            $trainer = $stmt->get_result();
            $data_trainer_obj = $trainer->fetch_object();
            $stmt->close();
            
            if ($data_trainer_obj) {
                $data_trainer_nama = $data_trainer_obj->nama;
                // Hitung biaya trainer
                $trainer_total = $trainer_perhari * $data_paket->durasi;
            } else {
                redirect("../../views/membership/pilih_trainer.php?id_paket={$id_paket}", "Trainer tidak tersedia.");
            }
        } else {
            throw new Exception("Gagal mengambil data trainer.");
        }
    } 

    // 3. Hitung Total Harga
    $base_price = (float)$data_paket->harga;
    $final_price = $base_price + $trainer_total;
     
    // 4. Simpan ke Session
    $_SESSION['transaction_data'] = [
        'id_pelanggan' => $user_id,
        'id_paket' => $id_paket,
        'id_trainer' => $id_trainer,
        'nama_paket' => $data_paket->deskripsi,
        'durasi_paket' => $data_paket->durasi,
        'nama_trainer' => $data_trainer_nama,
        'base_price' => $base_price,
        'trainer_fee' => $trainer_total,
        'total_price' => $final_price,
        'status' => 'PENDING',
        'transaksi_type' => ($id_trainer > 0) ? 'WITH_TRAINER' : 'PACKAGE_ONLY'
    ];

    redirect("../../views/transaction/checkout.php"); 

} catch (Exception $e) {
    error_log("Transaction Error: " . $e->getMessage());
    redirect("../../views/membership/membership_list.php", "Terjadi kesalahan saat memproses transaksi. Coba lagi.");
} finally {
    if (isset($stmt) && $stmt instanceof mysqli_stmt) {
         $stmt->close();
    }
}
?>