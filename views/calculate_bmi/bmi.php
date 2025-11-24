<?php

session_start();
$hasil = null;
$bmi_category = "Belum Dihitung";
$bmi_number = "00.00";
$tinggi_val = "";
$berat_val = "";
$hasil_text_class = "";
$berat_normal = "";
$ponderal = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tinggi = $_POST['tinggi'];
    $berat = $_POST['berat'];
    $tinggi_val = $tinggi;
    $berat_val = $berat;

    if (is_numeric($tinggi) && is_numeric($berat) && $tinggi > 0 && $berat > 0) {
        $tinggiMeter = $tinggi / 100;
        $bmi = $berat / ($tinggiMeter * $tinggiMeter);
        $bmi_number = number_format($bmi, 2);
        $min_weight = 18.5 * ($tinggiMeter * $tinggiMeter);
        $max_weight = 24.9 * ($tinggiMeter * $tinggiMeter);
        $berat_normal = number_format($min_weight, 1) . " - " . number_format($max_weight, 1) . " kg";

        $ponderal_itung = $berat / ($tinggiMeter * $tinggiMeter * $tinggiMeter);
        $ponderal = number_format($ponderal_itung, 2) . " kg/m³";

        if ($bmi < 18.5) {
            $bmi_category = "Kekurangan Berat Badan";
        } elseif ($bmi < 25) {
            $bmi_category = "Normal (Ideal)";
        } elseif ($bmi < 30) {
            $bmi_category = "Kelebihan Berat Badan";
        } else {
            $bmi_category = "Obesitas";
        }
    } else {
        $bmi_number = "Error";
        $bmi_category = "Input Tidak Valid";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator BMI - Power GYM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="bmi.css">
    <link rel="stylesheet" href="../style.css">
    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</head>

<body class="bg-dark">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top px-5 py-3">
        <div class="container-fluid">
            <img style="max-height: 120px; object-fit: cover;"
                src="../../images/logo.png" alt="Logo">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="nav nav-underline ">
                    <li class="nav-item"><a class="nav-link text-warning active" href="../personal_page/dashboard.php">Profil Saya</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="../main_page/index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="../membership/membership_list.php">Membership</a></li>
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

    <section class="bmi-section">
        <div class="bmi-modern-card">
            
            <div class="bmi-left-panel">
                <h3 class="bmi-title">Hitung BMI <br> (Body Mass Index)</h3>
                
                <form action="bmi.php" method="post">
                    

                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex align-items-center mb-2">
                                <span class="me-4 text-muted small fw-bold" style="width: 50px;">UMUR</span>
                                <div class="input-skew-wrapper flex-grow-1">
                                    <input type="number" placeholder="25" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-12">
                            <div class="d-flex align-items-center">
                                <span class="me-4 text-muted small fw-bold" style="width: 50px;">GENDER</span>
                                <div class="gender-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="male" checked>
                                        <label class="form-check-label" for="male">Laki-laki</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="female">
                                        <label class="form-check-label" for="female">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex align-items-center mb-2">
                                <span class="me-4 text-muted small fw-bold" style="width: 50px;">TINGGI</span>
                                <div class="input-skew-wrapper flex-grow-1">
                                    <input type="number" name="tinggi" step="0.1" placeholder="cm" required 
                                           value="<?php echo htmlspecialchars($tinggi_val); ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex align-items-center mb-2">
                                <span class="me-4 text-muted small fw-bold" style="width: 50px;">BERAT</span>
                                <div class="input-skew-wrapper flex-grow-1">
                                    <input type="number" name="berat" step="0.1" placeholder="kg" required
                                           value="<?php echo htmlspecialchars($berat_val); ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-calculate">
                        <span>CALCULATE NOW</span>
                    </button>

                </form>
            </div>

            <div class="bmi-right-panel">
                <h4 class="text-uppercase fw-bold mb-3" style="letter-spacing: 2px;">Result</h4>
                
                <h1 class="result-big"><?php echo $bmi_number; ?></h1>
                <span class="result-unit">kg/m2</span>
                
                <div class="result-category">
                    <?php echo $bmi_category; ?>
                </div>

                <div class="result-note">
                    <strong>Catatan:</strong>
                    <ul class="mt-2">
                        <li>Rentang BMI Normal: 18.5 - 25 kg/m2</li>
                        <li>Rentang Berat Badan untuk Tinggi Badan: <?php echo $berat_normal ?></li>
                        <li>Index Ponderal: <?php echo $ponderal ?></li>
                    </ul>
                </div>
            </div>

        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>