<?php
require_once(dirname(dirname(__DIR__)) . "/config/connection.php");

session_start();

function redirect($path, $errorMessage = null) {        // untuk mudahkan redirect
    if ($errorMessage) {
        $_SESSION['error'] = $errorMessage;
    }
    header("Location: " . $path);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $register_path = "../../views/auth/register.php";
    $login_path = "../../views/auth/login.php";

    $username = trim($_POST["username"]);
    $nama     = trim($_POST["nama"]);
    $password = $_POST["password"];
    $gender   = $_POST["gender"];
    $no_hp    = trim($_POST["no_hp"]);

    if (!isset($connection) || !$connection) {
        redirect($register_path, "Kesalahan sistem: Koneksi database tidak tersedia.");
    }

    try {
        if (empty($username) || empty($nama) || empty($password) || empty($gender) || empty($no_hp)) {
            redirect($register_path, "Semua kolom harus diisi!");
        }
        
        $check_query = "SELECT id_pelanggan FROM pelanggan WHERE username = ?";
        $check_stmt = $connection->prepare($check_query);
        $check_stmt->bind_param('s', $username);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            redirect($register_path, "Username sudah terdaftar."); 
        }
        $check_stmt->close();


        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $insert_query = "INSERT INTO pelanggan (nama, no_hp, gender, testimoni, username, password) 
                         VALUES (?, ?, ?, NULL, ?, ?)";
                         
        $stmt = $connection->prepare($insert_query);
        
        if (!$stmt) {
            throw new Exception("Gagal menyiapkan statement: " . $connection->error);
        }

        $stmt->bind_param('sssss', $nama, $no_hp, $gender, $username, $hashed_password);
        
        if ($stmt->execute()) {     // berhasil register
            redirect($login_path, "Registrasi berhasil! Silakan login.");
        } else {
            throw new Exception("Gagal mengeksekusi INSERT: " . $stmt->error);
        }
        
    } catch (Exception $e) {
        error_log("Register Error: " . $e->getMessage());
        redirect($register_path, "Terjadi kesalahan. Coba lagi.");
    } finally {
        if (isset($stmt) && $stmt instanceof mysqli_stmt) {
             $stmt->close();
        }
    }
} else {
    redirect("../../views/auth/register.php", "Akses tidak sah.");
}
?>