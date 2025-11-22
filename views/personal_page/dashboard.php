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
    <!-- <nav class="navbar navbar-expand-lg bg-transparent mx-5 px-5 sticky-top">
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
    </nav> -->


    <div class="containter-fluid m-3">
        <div class="row">
            <div class="col-sm-3 ">
                <!-- Profiling -->
                <div class="card bg-dark shadow-sm border-0 rounded-4 p-3 mb-3 mx-auto text-white" style="width: auto;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold m-0">Profile</h5>
                        <button class="btn btn-light btn-sm rounded-3">
                            <i class="bi bi-pencil-square"></i> </button>
                    </div>

                    <div class="d-flex flex-column align-items-center mb-4">
                        <div class="position-relative mb-2">
                            <img src="https://via.placeholder.com/100" class="rounded-circle border border-3 border-warning p-1" alt="Avatar" width="100" height="100">
                        </div>
                        <h5 class="fw-bold mb-0">Joy Dey</h5>
                    </div>

                    <div class="d-flex justify-content-between text-center px-2">
                        <div>
                            <small class="text-white-50 d-block">Age</small>
                            <span class="fw-bold">24</span>
                        </div>
                        <div>
                            <small class="text-white-50 d-block">Berat Badan</small>
                            <span class="fw-bold">50 kg</span>
                        </div>
                        <div>
                            <small class="text-white-50 d-block">Tinggi Badan</small>
                            <span class="fw-bold">170 cm</span>
                        </div>
                    </div>
                </div>
                <!-- Checkin -->
                <div class="card bg-dark text-white shadow rounded-4 p-3 mb-3 mx-auto" style="width: auto;">

                    <div class="d-flex align-items-center text-center">
                        <div class="flex-fill border-end border-white-50 pe-3">
                            <small class="text-white-50">Check-in</small>
                            <h6 class="fw-bold m-0 mt-1">-</h6>
                        </div>

                        <div class="flex-fill ps-3">
                            <small class="text-white-50">Check-out</small>
                            <h6 class="fw-bold m-0 mt-1">-</h6>
                        </div>

                    </div>

                </div>

                <div class="card bg-dark text-white shadow rounded-4 p-3 mx-auto">
                    <div class="d-flex flex-column align-items-left">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold m-0">Berikan Testimonimu</h5>
                            <!-- <button class="btn btn-light btn-sm rounded-3">
                                <i class="bi bi-pencil-square"></i> </button> -->
                        </div>
                        <small class="text-white-50 mb-4">Bantu kami agar menjadi lebih baik</small>
                        <a href="" class="btn btn-primary">Testimoni Sekarang</a>
                    </div>
                </div>
                <!-- Streak -->

            </div>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card bg-dark text-white shadow rounded-4 p-3 mx-auto">
                            <div class="d-flex flex-column align-items-center mb-4">
                                <h5 class="text-white">GymTier Anda</h5>
                                <div class="position-relative mb-2">
                                    <img src="https://via.placeholder.com/50" class="rounded-circle border border-3 border-warning p-1" alt="Avatar" width="100" height="100">
                                </div>
                                <h5 class="fw-bold mb-0">20 Streak</h5>
                                <small class="text-white-50">40 Kunjungan Gym. Tahan Ritme!</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card bg-dark text-white shadow rounded-4 p-3 mx-auto">
                            <div class="d-flex flex-column align-items-center mb-4">
                                <h5 class="text-white">Paket Gym Aktif</h5>
                                <div class="position-relative mb-2">
                                    <img src="https://via.placeholder.com/50" class="rounded-circle border border-3 border-warning p-1" alt="Avatar" width="100" height="100">
                                </div>
                                <h5 class="fw-bold mb-0">Single- Silver</h5>
                                <small class="text-white-50">Kadaluarsa tanggal 08 Agt 25</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card bg-dark text-white shadow rounded-4 p-3 mx-auto">
                            <div class="d-flex flex-column align-items-center mb-4">
                                <h5 class="text-white">Paket Gym Aktif</h5>
                                <div class="position-relative mb-2">
                                    <img src="https://via.placeholder.com/50" class="rounded-circle border border-3 border-warning p-1" alt="Avatar" width="100" height="100">
                                </div>
                                <h5 class="fw-bold mb-0">Single- Silver</h5>
                                <small class="text-white-50">40 Kunjungan Gym. Tahan Ritme!</small>
                            </div>
                        </div>
                    </div>
                    <!-- Category-->
                    <div class="col-sm-9">
                        <h3>Kelas</h3>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="card bg-dark text-white shadow rounded-4 p-3 mx-auto">
                                    <div class="d-flex flex-column align-items-center mb-4">
                                        <h5 class="text-white">Paket Gym Aktif</h5>
                                        <div class="position-relative mb-2">
                                            <img src="https://via.placeholder.com/50" class="rounded-circle border border-3 border-warning p-1" alt="Avatar" width="100" height="100">
                                        </div>
                                        <h5 class="fw-bold mb-0">Single- Silver</h5>
                                        <small class="text-white-50">40 Kunjungan Gym. Tahan Ritme!</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <h3>Rekomendasi Trainer Untukmu</h3>
                        <div class="row">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="card bg-dark text-white shadow rounded-4 p-3 mx-auto">
                                        <div class="d-flex flex-column align-items-center mb-4">
                                            <h5 class="text-white">Paket Gym Aktif</h5>
                                            <div class="position-relative mb-2">
                                                <img src="https://via.placeholder.com/50" class="rounded-circle border border-3 border-warning p-1" alt="Avatar" width="100" height="100">
                                            </div>
                                            <h5 class="fw-bold mb-0">Single- Silver</h5>
                                            <small class="text-white-50">40 Kunjungan Gym. Tahan Ritme!</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>


    <script src="index.js"></script>
</body>

</html>