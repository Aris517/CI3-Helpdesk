<div class="container-fluid">
    <div class="card" style="background-color: lightblue;">
        <div class="card-body">
            <div class="d-flex mb-4">
                <h5 class="card-title fw-semibold">Edit Pengaduan Baru</h5>
                <a href="<?= base_url('pengaduan/cs/baru') ?>" class="btn btn-sm btn-warning ms-auto">Kembali</a>
            </div>
            <div class="card">
                <div class="card-body p-4">
                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Jenis Pengaduan</label>
                            <select name="jenis" class="form-select" required>
                                <option value="">Pilih Jenis Pengaduan</option>
                                <?php foreach ($jenis as $row) : ?>
                                    <option value="<?= $row->id_jenis ?>" <?= $row->id_jenis == $pengaduan->id_jenis ? 'selected' : '' ?>><?= $row->jenis ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Isi</label>
                            <textarea name="isi" class="form-control" required><?= $pengaduan->isi ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>