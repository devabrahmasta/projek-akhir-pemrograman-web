<?php

use LDAP\Result;

require_once(__DIR__ . "/../../config/connection.php");

$sql = "SELECT * FROM  pelanggan";
$stmt = $connection->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power GYM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=arrow_forward_ios" />
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <link rel="stylesheet" href="dashboard.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-transparent mx-5 px-5 sticky-top">
        <div class="container-fluid py-3">
            <a class="navbar-brand text-white fw-bold" href="index.php">Power GYM</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end " id="navbarNav">
                <ul class="nav nav-underline ">
                    <li class="nav-item ">
                        <a class="nav-link text-white active" aria-current="page" href="index.php">Home</a>
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
                        <a class="nav-link text-white" href="../calculate_bmi/bmi.php">Cek BMI</a>
                    </li>
                    <li class="nav-item">
                        <a type="button" class="btn btn-warning" href="../auth/login.php">Masuk</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div>
        
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>


    <script src="index.js"></script>
</body>

</html>