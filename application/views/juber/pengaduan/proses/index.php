<div class="container-fluid">
    <div class="card" style="background-color: lightblue;">
        <div class="card-body">
            <div class="d-flex mb-4">
                <h5 class="card-title fw-semibold">Pengaduan Proses</h5>
            </div>
            <div class="card">
                <div class="card-body p-4">
                    <table class="table table-striped" id="dataTables">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Perespon</th>
                                <th>Pengadu</th>
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
                                    <td><?= $row->perespon->username ?></td>
                                    <td><?= $row->pengadu->username ?></td>
                                    <td><?= $row->jenis->jenis ?></td>
                                    <td><?= $row->isi ?></td>
                                    <td>
                                        <a href="<?= base_url('pengaduan/chat/' . $row->id_pengaduan) ?>" class="btn btn-success btn-sm">Chat</a>
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