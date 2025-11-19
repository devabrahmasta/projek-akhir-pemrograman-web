<?php
require_once(dirname(dirname(__DIR__)) . "/config/connection.php");

session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        if (empty($username) || empty($password)) {
    
            $_SESSION['error'] = "Harap isi kolom username dan password";
            header("Location: ../../views/auth/login.php");
            exit;
        } else {
            $query = "SELECT username, password FROM pelanggan WHERE username = ?";
            $statement = $connection->prepare($query);
            $statement->bind_param('s', $username);
            
            if ($statement->execute()) {
                
                $hasil = $statement->get_result();
                if ($hasil->num_rows<1) {
                    $_SESSION['error'] = "username tidak ditemukan";
                    header("Location: ../../views/auth/login.php");
                    exit;
                } else {
                    $row = $hasil->fetch_object();
    
                    if (password_verify($password,$row->password)) {
                        $_SESSION['username'] = $username;
                        header("Location: ../../views/main_page/index.php");
                        exit;
                    } else {
                        $_SESSION['error'] = "Password salah";
                        header("Location: ../../views/auth/login.php");
                        exit;
                    }
                }
            }
        }
    } catch (mysqli_sql_exception $e) {
        echo "Gagal login: $e";
    } finally {
        if (isset($stmt) && $stmt instanceof mysqli_stmt) {
             $stmt->close();
        }
    }
}