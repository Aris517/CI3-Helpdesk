<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>cetak<?= date('Y-m-d H:i:s') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container-fluid p-5 mx-auto">
        <div class="text-center">
            <div class="row">
                <div class="col-2">
                    <img src="<?= base_url('assets/img/logo juber.png') ?>" alt="" style="width: 130%;">
                </div>
                <div class="col-10">
                    <div class="text-center">
                        <h5 style="margin-bottom: 0px;">PT. MAJU BERKAH ADIKARYA</h5>
                        <P> JL AR Hakim Gg 22 No. 4 Randugunting Tegal Selatan, Kota tegal</P>
                    </div>
                </div>
            </div>
            <hr>
            <h4>Laporan dari <?= $dari ?> - <?= $sampai ?></h4>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis</th>
                <th>Pengadu</th>
                <th>Perespon</th>
                <th>Status</th>
                <th>Tgl Masuk</th>
                <th>Tgl Proses</th>
                <th>Tgl Selesai</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($pengaduan as $row) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row->jenis->jenis ?></td>
                    <td><?= $row->pengadu->username ?></td>
                    <td><?= $row->status == 'menunggu' ? '-' : $row->perespon->username ?></td>
                    <td><?= $row->status ?></td>
                    <td><?= $row->tgl_masuk ?></td>
                    <td><?= $row->status == 'menunggu' ? '-' : $row->tgl_direspon ?></td>
                    <td><?= $row->status == 'menunggu' ? '-' : $row->tgl_selesai ?></td>
                    <td><?= $row->tgl_selesai ?></td>
                </tr>
                <tr>
                    <td>Isi</td>
                    <td colspan="7"><?= $row->isi ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <div class="row justify-content-end">
        <div class="col-5">
            <div class="text-center">
                <p class="text-start mb-0">Mengetahui,</p>
                <p class="text-start mb-5 mt-0">Pimpinan PT. MAJU BERKAH ADIKARYA</p>
                <p class="text-start mb-4 mt-0"><b><u>Mohamaad </b></u></p>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        window.print()
        window.onafterprint = function() {
            window.close();
        };
    </script>
</body>

</html>