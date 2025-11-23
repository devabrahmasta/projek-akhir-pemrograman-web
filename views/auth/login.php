<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Power GYM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    <link rel="stylesheet" href="auth.css">
    <link rel="stylesheet" href="style.css"> 
</head>

<body class="bg-dark">
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['error'])) {
        $message = $_SESSION['error'];
        echo '<script>alert("' . htmlspecialchars($message) . '");</script>';
        unset($_SESSION['error']);
    }
    ?>

    <div class="container-fluid p-0">
        <div class="row g-0">

            <div class="col-lg-7 d-none d-lg-block bg-image-side">
                </div>

            <div class="col-lg-5 col-12 form-area">
                
                <a href="../main_page/index.php" class="btn-back">
                    Kembali ke Home
                </a>

                <div class="form-card">
                    <div class="mb-4">
                        <h2 class="fw-bold text-white">Login <span class="text-warning">Power GYM</span></h2>
                        <p class="text-secondary">Selamat datang kembali, silakan masuk ke akun Anda.</p>
                    </div>

                    <form action="../../controllers/auth/login.php" method="post" class="text-start">
                        <div class="mb-3">
                            <label class="form-label text-white" for="username">Username</label>
                            <input class="form-control bg-dark border-secondary" name="username" type="text" required placeholder="Masukkan username">
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-white" for="password">Password</label>
                            <input class="form-control bg-dark border-secondary" name="password" type="password" required placeholder="Masukkan password">
                        </div>

                        <button class="btn btn-warning w-100 fw-bold py-2" type="submit">Login</button>
                    </form>
                    <p class="text-white mt-4 mb-0" style="font-size: 0.9rem;">
                        Belum punya akun? <a href="register.php" class="text-warning text-decoration-none fw-bold">Daftar Sekarang</a>
                    </p>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>