<div class="container-fluid">
    <div class="card" style="background-color: lightblue;">
        <div class="card-body">
            <div class="d-flex mb-4">
                <h5 class="card-title fw-semibold">Laporan Periode</h5>
            </div>
            <div class="card">
                <div class="card-body p-4">
                    <form target="_blank" method="post">
                        <div class="text-center mb-3">
                            <label class="form-label fs-6">Filter Data</label>
                            <div class="form-text">Sesuaikan tanggal awal dan akhir untuk dicetak</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Dari Tanggal</label>
                                <input type="date" class="form-control" name="dari" required>
                            </div>
                            <div class="col">
                                <label class="form-label">Sampai Tanggal</label>
                                <input type="date" class="form-control" name="sampai" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Cetak</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>