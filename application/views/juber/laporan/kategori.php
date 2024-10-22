<div class="container-fluid">
    <div class="card" style="background-color: lightblue;">
        <div class="card-body">
            <div class="d-flex mb-4">
                <h5 class="card-title fw-semibold">Laporan Kategori</h5>
            </div>
            <div class="card">
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <label class="form-label fs-6">Filter Data</label>
                        <div class="form-text">Sesuaikan pilih jenis untuk dicetak</div>
                    </div>
                    <form target="_blank" method="post">
                        <div class="row mb-3">
                            <label class="form-label">Jenis</label>
                            <div class="col">
                                <select name="jenis" class="form-select" required>
                                    <option value="">Pilih Jenis</option>
                                    <?php foreach ($jenis as $row) : ?>
                                        <option value="<?= $row->id_jenis ?>"><?= $row->jenis ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary form-control">Cetak</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>