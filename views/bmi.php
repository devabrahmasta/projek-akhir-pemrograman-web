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
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-dark">
    <nav class="navbar navbar-expand-lg bg-transparent mx-5 px-5 sticky-top mb-5">
        <div class="container-fluid py-3">
            <img style="width: 60px; height: 60px; object-fit: cover;"
                src="data:image/jpeg;base64,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"
                alt="anjer">
            <a class="navbar-brand text-white fw-bold" href="index.php">Power GYM</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end " id="navbarNav">
                <ul class="nav nav-underline ">
                    <li class="nav-item ">
                        <a class="nav-link text-white" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Fasilitas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Membership</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Testimoni</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white active" href="bmi.php">Cek BMI</a>
                    </li>
                    <li class="nav-item">
                        <a type="button" class="btn btn-warning" href="#">Hubungi Kami</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<div class="d-flex justify-content-center vh-80">
        <div class="row w-75" style="height: auto;"> 

            <div class="col-6 d-flex">

                <div class="testimonial-card text-center">
                            <h5 class="text-light">Hitung BMI</h5>
                            <form action="bmi.php" method="post">
                                <div class="row text-start p-3">
                                    <label class="form-label text-white" for="tinggi">Tinggi Badan (cm)</label>
                                    <input class="form-control" name="tinggi" type="number" step="0.1" required
                                        value="<?php echo htmlspecialchars($tinggi_val); ?>">

                                    <label class="form-label mt-2 text-white" for="berat">Berat Badan (kg)</label>
                                    <input class="form-control" name="berat" type="number" step="0.1" required
                                        value="<?php echo htmlspecialchars($berat_val); ?>">

                                    <button class="btn btn-success mt-4" type="submit">Hitung</button>
                                </div>
                            </form>

                            <?php if ($hasil !== null): ?>
                                <div class="alert <?php echo ($hasil == 'Error') ? 'alert-danger' : 'alert-success'; ?> mt-3">
                                    <h5 class="alert-heading">Hasil BMI Anda: <br>
                                        <?php echo "<h3 class='$hasil_text_class'>$hasil</h6>"; ?></h5>
                                    <p class="mb-0"><?php echo $bmi_category; ?></p>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                
                <div class="col-6 d-flex">
                    <div class="testimonial-card">
                        <div class="card-body text-center">
                            <table class="table table-dark table-striped table-bordered border-light my-4 rounded-4">
                                <thead class="table table-secondary">
                                    <tr>
                                        <th>Kategori BMI</th>
                                        <th>Rentang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Kekurangan Berat Badan</td>
                                        <td>Dibawah 18.5</td>
                                    </tr>
                                    <tr>
                                        <td>Ideal</td>
                                        <td>18.5 - 24.9</td>
                                    </tr>
                                    <tr>
                                        <td>Kelebihan Berat Badan</td>
                                        <td>25.0 - 29.9</td>
                                    </tr>
                                    <tr>
                                        <td>Obesitas</td>
                                        <td>Diatas 30.0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>