<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi</title>
    <link rel="shortcut icon" type="image/png" href="<?= base_url('') ?>/assets/admin/src/assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="<?= base_url('') ?>/assets/admin/src/assets/css/styles.min.css" />
    <link rel="stylesheet" href="<?= base_url('') ?>assets/css/style.css">
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="<?= base_url('') ?>" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <h1>HELPDESK</h1>
                                </a>
                                <h3 class="text-center mb-3">Konfirmasi</h3>
                                <p class="text-center">Silahkan cek email <?= $akun->email ?> dan lakukan verifikasi</p>
                                <div id="cek" class="loader"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('') ?>/assets/admin/src/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url('') ?>/assets/admin/src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            function checkStatus() {
                $.ajax({
                    url: "<?= base_url('auth/cekStatus/' . $akun->id_akun) ?>",
                    method: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data.verify == 1 && data.status == 'aktif') {
                            $('#cek').removeClass('loader').addClass('checked').html('&#10003;');
                            setTimeout(function() {
                                window.location.href = "<?= base_url('auth') ?>";
                            }, 2000);
                        } else {
                            setTimeout(checkStatus, 1000);
                        }
                    }
                });
            }
            checkStatus();
        });
    </script>
</body>

</html>