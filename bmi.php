<?php

$hasil = null;
$bmi_category = "";
$tinggi_val = "";
$berat_val = ""; 
$hasil_text_class = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    $tinggi = $_POST['tinggi'];
    $berat = $_POST['berat'];

    
    $tinggi_val = $tinggi;
    $berat_val = $berat;

    if (is_numeric($tinggi) && is_numeric($berat) && $tinggi > 0 && $berat > 0) {
        
        
        $tinggiMeter = $tinggi / 100;
        $bmi = $berat / ($tinggiMeter * $tinggiMeter);
        
        $hasil = number_format($bmi, 2);

        if ($bmi < 18.5) {
            $bmi_category = "Kategori: Kekurangan berat badan";
            $hasil_text_class = "text-warning";
        } elseif ($bmi < 25) {
            $bmi_category = "Kategori: Normal (ideal)";
            $hasil_text_class = "text-success";
        } elseif ($bmi < 30) {
            $bmi_category = "Kategori: Kelebihan berat badan";
            $hasil_text_class = "text-danger";
        } else {
            $bmi_category = "Kategori: Obesitas";
        }
    } else {

        $hasil = "Error";
        $bmi_category = "Pastikan tinggi dan berat badan diisi dengan angka yang valid.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator BMI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="bg-dark">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid p-3">
            <img style="width: 60px; height: 60px; object-fit: cover;"
                src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQ..." 
                alt="Logo">
            <a class="navbar-brand" href="index.php">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="nav nav-underline">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Fasilitas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Membership</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Testimoni</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="bmi.php">Cek BMI</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Hubungi Kami</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow" style="width: 24rem;">
            <div class="card-body text-center">
                <h5 class="card-title">Hitung BMI</h5>

                <form action="bmi.php" method="post">
                    <div class="row text-start p-3">
                        <label class="form-label" for="tinggi">Tinggi Badan (cm)</label>
                        <input class="form-control" name="tinggi" type="number" step="0.1" required 
                               value="<?php echo htmlspecialchars($tinggi_val); ?>">
                        
                        <label class="form-label mt-2" for="berat">Berat Badan (kg)</label>
                        <input class="form-control" name="berat" type="number" step="0.1" required 
                               value="<?php echo htmlspecialchars($berat_val); ?>">
                        
                        <button class="btn btn-success mt-4" type="submit">Hitung</button>
                    </div>
                </form>

                <?php if ($hasil !== null): ?>
                    <div class="alert <?php echo ($hasil == 'Error') ? 'alert-danger' : 'alert-success'; ?> mt-3">
                        <h5 class="alert-heading">Hasil BMI Anda: <br> <?php echo "<h3 class='$hasil_text_class'>$hasil</h6>"; ?></h5>
                        <p><?php echo $bmi_category; ?></p>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>