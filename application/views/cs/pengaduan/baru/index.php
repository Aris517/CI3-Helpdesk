<div class="container-fluid">
    <div class="card" style="background-color: lightblue;">
        <div class="card-body">
            <div class="d-flex mb-4">
                <h5 class="card-title fw-semibold">Pengaduan Baru</h5>
                <a href="<?= base_url('pengaduan/tambah') ?>" class="btn btn-sm btn-success ms-auto" style="background-color: blue;">Tambah</a>
            </div>
            <div class="card">
                <div class="card-body p-4">
                    <table class="table table-striped" id="dataTables">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis</th>
                                <th>Isi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($pengaduan as $row) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row->jenis->jenis ?></td>
                                    <td><?= $row->isi ?></td>
                                    <td>
                                        <a href="<?= base_url('pengaduan/ubah/' . $row->id_pengaduan) ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="<?= base_url('pengaduan/hapus/' . $row->id_pengaduan) ?>" class="btn btn-danger btn-sm">Hapus</a>
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