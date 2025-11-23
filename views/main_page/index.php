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

    <link rel="stylesheet" href="/../style.css">

</head>

<body class="bg-dark">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-transparent mx-5 px-5 sticky-top">
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
                        <a class="nav-link text-white active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Fasilitas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../membership/membership_list.php">Membership</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Testimoni</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="../calculate_bmi/bmi.php">Cek BMI</a>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                            <a type="button" class="btn btn-danger" href="../../controllers/auth/logout.php">Logout</a>
                        <?php else: ?>
                            <a type="button" class="btn btn-warning" href="../auth/login.php">Masuk</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container-fluid">
        <!-- Home -->
        <img id="gambarHome" style="object-fit: cover; "
            src="https://mir-s3-cdn-cf.behance.net/project_modules/fs/a43502139128971.622a0e70b2b1f.jpg"
            alt="tempat-gym" id="homegym">
        <div class="row p-5 mx-5">
            <div class="col-12 ">
                <p class="text-warning">Power GYM Jogja</p>
                <h1 class="text-white">Latihan Eksklusif,
                    Harga Ekonomis</h1>
                <p class="text-white">Wujudkan Target Ideal Anda Dengan Alat yang Sudah Berstandar
                    Internasional dan Dukungan Dari yang Ahli</p>
            </div>
        </div>

        <!-- Fitur -->
        <div class="row align-items-center justify-content-between px-5 mx-5 my-5">
            <div class="card border-info mb-3" style="max-width: 22rem;">
                <div class="card-header">Header</div>
                <div class="card-body">
                    <h5 class="card-title">Info card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card’s content.</p>
                    <p class="card-text"><a href="">Learn More<ion-icon name="chevron-forward-outline"></ion-icon></a></p>
                </div>
            </div>
        </div>

        <!-- Testimoni -->
        <div class="testimonialContainer mt-5 p-5">
            <div class="col-auto">
                <h4 class="text-warning">Testimoni</h4>
                <h2 class="text-white fw-bold">Apa Kata Mereka?</h2>
            </div>
            <div class="testimonial-track pt-5">
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <div class="testimonial-card">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg"
                            class="testimonial-photo">
                        <h5 class="testimonial-name text-center"><?= $row['nama'] ?></h5>
                        <p class="testimonial-date text-center">18 September 2024</p>
                        <p class="testimonial-text text-center"><?= $row['testimoni'] ?></p>
                    </div>
                <?php } ?>

                <?php mysqli_data_seek($result, 0);
                while ($row = $result->fetch_assoc()) { ?>
                    <div class="testimonial-card">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg"
                            class="testimonial-photo">
                        <h5 class="testimonial-name text-center"><?= $row['nama'] ?></h5>
                        <p class="testimonial-date text-center">18 September 2024</p>
                        <p class="testimonial-text text-center"><?= $row['testimoni'] ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>

    <div class="container-fluid px-5" style="background-color: #171717ff;">
        <footer class="py-5">
            <div class="row text-white">
                <div class="col-2 text-white">
                    <h5>Section</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">Home</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">Features</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">Pricing</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">FAQs</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">About</a></li>
                    </ul>
                </div>

                <div class="col-2 text-white">
                    <h5>Section</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">Home</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">Features</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">Pricing</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">FAQs</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">About</a></li>
                    </ul>
                </div>

                <div class="col-2">
                    <h5>Section</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">Home</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">Features</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">Pricing</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">FAQs</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-secondary">About</a></li>
                    </ul>
                </div>

                <div class="col-4 offset-1">
                    <form>
                        <h5>Subscribe to our newsletter</h5>
                        <p>Monthly digest of whats new and exciting from us.</p>
                        <div class="d-flex w-100 gap-2">
                            <label for="newsletter1" class="visually-hidden">Email address</label>
                            <input id="newsletter1" type="text" class="form-control" placeholder="Email address">
                            <button class="btn btn-primary" type="button">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="d-flex justify-content-between py-4 my-4 border-top">
                <p>© 2021 Company, Inc. All rights reserved.</p>
                <ul class="list-unstyled d-flex">
                    <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24" height="24">
                                <use xlink:href="#twitter"></use>
                            </svg></a></li>
                    <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24" height="24">
                                <use xlink:href="#instagram"></use>
                            </svg></a></li>
                    <li class="ms-3"><a class="link-dark" href="#"><svg class="bi" width="24" height="24">
                                <use xlink:href="#facebook"></use>
                            </svg></a></li>
                </ul>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>


    <script src="index.js"></script>
</body>

</html>