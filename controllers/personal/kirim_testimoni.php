<?php
session_start();
require_once(__DIR__ . '/../../config/connection.php');

function redirect($path, $msg) {
    $_SESSION['error'] = $msg;
    header("Location: " . $path);
    exit;
}

$dashboard_path = "../../views/personal_page/dashboard.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect($dashboard_path, "Akses tidak valid.");
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    redirect("../../views/auth/login.php", "Silakan login kembali.");
}

$user_id = $_SESSION['user_id'];
$testimoni = trim($_POST['testimoni']);
$tgl_sekarang = date('Y-m-d');

if (empty($testimoni)) {
    redirect($dashboard_path, "Testimoni tidak boleh kosong.");
}

if (strlen($testimoni) < 10) {
    redirect($dashboard_path, "Testimoni terlalu pendek (min. 10 karakter).");
}

try {
    $sql = "UPDATE pelanggan SET testimoni = ?, tanggal_testimoni = ? WHERE id_pelanggan = ?";
    
    $stmt = $connection->prepare($sql);
    if (!$stmt) throw new Exception("Prepare failed: " . $connection->error);

    $stmt->bind_param('ssi', $testimoni, $tgl_sekarang, $user_id);
    
    if ($stmt->execute()) {
        redirect($dashboard_path, "Testimoni berhasil dikirim.");
    } else {
        throw new Exception("Gagal menyimpan testimoni.");
    }

} catch (Exception $e) {
    error_log("Testimoni Error: " . $e->getMessage());
    redirect($dashboard_path, "Terjadi kesalahan: " . $e->getMessage());
}
?>