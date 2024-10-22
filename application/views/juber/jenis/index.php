<div class="container-fluid">
    <div class="card" style="background-color: lightblue;">
        <div class="card-body">
            <div class="d-flex mb-4">
                <h5 class="card-title fw-semibold">Kelola Jenis Pengaduan</h5>
                <a href="<?= base_url('jenis/tambah') ?>" class="btn btn-sm btn-success ms-auto">Tambah</a>
            </div>
            <div class="card">
                <div class="card-body p-4">
                    <table class="table table-striped" id="dataTables">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($jenis as $row) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row->jenis ?></td>
                                    <td>
                                        <a href="<?= base_url('jenis/ubah/' . $row->id_jenis) ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="<?= base_url('jenis/hapus/' . $row->id_jenis) ?>" class="btn btn-danger btn-sm">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>