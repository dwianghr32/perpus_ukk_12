<div class="page-header mb-4">
    <h2><i class="bi bi-clock-history me-2"></i>Riwayat Peminjaman</h2>
    <p class="text-muted mb-0">Daftar buku yang pernah dipinjam</p>
</div>

<!-- Filter and Print Section -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="search" class="form-label">Cari Buku</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Judul, pengarang, kode" value="<?= isset($filters['search']) ? htmlspecialchars($filters['search']) : '' ?>">
            </div>
            <div class="col-md-2">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Semua Status</option>
                    <option value="dipinjam" <?= (isset($filters['status']) && $filters['status'] == 'dipinjam') ? 'selected' : '' ?>>Dipinjam</option>
                    <option value="dikembalikan" <?= (isset($filters['status']) && $filters['status'] == 'dikembalikan') ? 'selected' : '' ?>>Dikembalikan</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?= isset($filters['tanggal_mulai']) ? htmlspecialchars($filters['tanggal_mulai']) : '' ?>">
            </div>
            <div class="col-md-2">
                <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?= isset($filters['tanggal_akhir']) ? htmlspecialchars($filters['tanggal_akhir']) : '' ?>">
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-primary me-2" onclick="applyFilters()">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($riwayat)): ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox" style="font-size: 48px; color: #ccc;"></i>
                <p class="text-muted mt-3">Belum ada riwayat peminjaman</p>
                <a href="<?= base_url('peminjaman') ?>" class="btn btn-primary">Pinjam Buku Sekarang</a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Batas Kembali</th>
                            <th>Status</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($riwayat as $r): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong><?= htmlspecialchars($r['judul']) ?></strong><br>
                                <small class="text-muted"><?= htmlspecialchars($r['kode_buku']) ?> - <?= htmlspecialchars($r['pengarang']) ?></small>
                            </td>
                            <td><?= date('d/m/Y', strtotime($r['tanggal_pinjam'])) ?></td>
                            <td><?= date('d/m/Y', strtotime($r['tanggal_kembali'])) ?></td>
                            <td>
                                <?php if ($r['status'] == 'dipinjam'): ?>
                                    <?php if (strtotime($r['tanggal_kembali']) < strtotime(date('Y-m-d'))): ?>
                                        <span class="badge bg-danger">Terlambat</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Dipinjam</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="badge bg-success">Dikembalikan</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($r['denda'] > 0): ?>
                                    <span class="text-danger">Rp <?= number_format($r['denda'], 0, ',', '.') ?></span>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function applyFilters() {
    const search = document.getElementById('search').value;
    const status = document.getElementById('status').value;
    const tanggal_mulai = document.getElementById('tanggal_mulai').value;
    const tanggal_akhir = document.getElementById('tanggal_akhir').value;
    
    let url = '<?= base_url('peminjaman/riwayat') ?>?';
    const params = [];
    
    if (search) params.push('search=' + encodeURIComponent(search));
    if (status) params.push('status=' + encodeURIComponent(status));
    if (tanggal_mulai) params.push('tanggal_mulai=' + encodeURIComponent(tanggal_mulai));
    if (tanggal_akhir) params.push('tanggal_akhir=' + encodeURIComponent(tanggal_akhir));
    
    if (params.length > 0) {
        url += params.join('&');
    }
    
    window.location.href = url;
}

function printToPDF() {
    window.print();
}
</script>

<style>
@media print {
    .card.mb-4, .page-header {
        display: none !important;
    }
    .card {
        border: 1px solid #000 !important;
        box-shadow: none !important;
    }
    .card-body {
        padding: 10px !important;
    }
    .table {
        font-size: 12px;
    }
    @page {
        margin: 1cm;
    }
}
</style>
