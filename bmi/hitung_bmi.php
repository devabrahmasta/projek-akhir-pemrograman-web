<?php
    $tinggi = $_POST['tinggi'];
    $tinggiMeter = $tinggi/100;
    $berat = $_POST['berat'];

    $bmi = $berat/($tinggiMeter*$tinggiMeter);
    echo "Hasil BMI: " . number_format($bmi, 2);

    if ($bmi < 18.5) {
    echo "<br>Kategori: Kekurangan berat badan";
    } elseif ($bmi < 25) {
        echo "<br>Kategori: Normal (ideal)";
    } elseif ($bmi < 30) {
        echo "<br>Kategori: Kelebihan berat badan";
    } else {
        echo "<br>Kategori: Obesitas";
    }
?>
