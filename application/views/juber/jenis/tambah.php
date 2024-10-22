<div class="container-fluid">
    <div class="card" style="background-color: lightblue" ;>
        <div class=" card-body">
            <div class="d-flex mb-4">
                <h5 class="card-title fw-semibold">Kelola Jenis Pengaduan</h5>
                <a href="<?= base_url('jenis') ?>" class="btn btn-sm btn-warning ms-auto">Kembali</a>
            </div>
            <div class="card">
                <div class="card-body p-4">
                    <form action="<?= base_url('jenis/tambah') ?>" method="post">
                        <div class="mb-3">
                            <label class="form-label">Jenis Pengaduan</label>
                            <input type="text" class="form-control" name="jenis" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>