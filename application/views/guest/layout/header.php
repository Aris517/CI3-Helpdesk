<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JUBER</title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url('') ?>/assets/admin/src/assets/images/logos/juber.png" />

    <!--vendor css ================================================== -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('') ?>assets/templates/css/vendor.css">

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <!--Bootstrap ================================================== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <!-- Style Sheet ================================================== -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('') ?>assets/templates/styles.css">

    <!-- Google Fonts ================================================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,700;1,300&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">


    <!-- script ================================================== -->
    <script src="<?= base_url('') ?>assets/templates/js/modernizr.js"></script>

</head>

<body data-bs-spy="scroll" data-bs-target="#header-nav" tabindex="0">

    <nav class="navbar navbar-expand-lg bg-white navbar-light container-fluid py-3 position-fixed ">
        <div class="container">
            <!-- <a class="navbar-brand" href="<?= base_url('') ?>"><img src="<?= base_url('') ?>assets/templates/images/main-logo.png" alt="logo"></a> -->
            <a href="<?= base_url('') ?>" class="navbar-brand"><strong>HELPDESK JUBER</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav align-items-center justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link text-uppercase <?= $aktif == 'beranda' ? "active" : "" ?> px-3" href="<?= base_url('') ?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase <?= $aktif == 'about' ? "active" : "" ?> px-3" href="<?= base_url('guest/about') ?>">Profil Perusahaan</a>
                        </li>
                        <?php if (!$this->session->userdata('online')) : ?>
                            <li class="nav-item">
                                <a class="nav-link text-uppercase text-warning px-3" href="<?= base_url('auth') ?>">Login</a>
                            </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link text-uppercase text-danger px-3" href="<?= base_url('auth/logout') ?>">Logout</a>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>