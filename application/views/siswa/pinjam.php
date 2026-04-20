<div class="page-header mb-4">
    <h2><i class="bi bi-book me-2"></i>Pinjam Buku</h2>
    <p class="text-muted mb-0">Pilih buku yang ingin dipinjam</p>
</div>

<!-- Filter and Print Section -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="search" class="form-label">Cari Buku</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Judul, pengarang, atau kode buku" value="<?= isset($filters['search']) ? htmlspecialchars($filters['search']) : '' ?>">
            </div>
            <div class="col-md-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select class="form-select" id="kategori" name="kategori">
                    <option value="">Semua Kategori</option>
                    <?php foreach ($kategori_options as $kat): ?>
                        <option value="<?= htmlspecialchars($kat['kategori']) ?>" <?= (isset($filters['kategori']) && $filters['kategori'] == $kat['kategori']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($kat['kategori']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label for="tahun" class="form-label">Tahun</label>
                <input type="number" class="form-control" id="tahun" name="tahun" placeholder="Tahun terbit" value="<?= isset($filters['tahun']) ? htmlspecialchars($filters['tahun']) : '' ?>">
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-primary me-2" onclick="applyFilters()">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <?php if (empty($buku)): ?>
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 48px; color: #ccc;"></i>
                    <p class="text-muted mt-3">Tidak ada buku yang tersedia saat ini</p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($buku as $b): ?>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3">
                        <div class="flex-shrink-0">
                            <div style="width: 60px; height: 80px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-book text-white" style="font-size: 24px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <span class="badge bg-primary mb-2"><?= htmlspecialchars($b['kode_buku']) ?></span>
                            <h5 class="mb-1"><?= htmlspecialchars($b['judul']) ?></h5>
                            <p class="text-muted mb-0 small"><?= htmlspecialchars($b['pengarang']) ?></p>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <?php if ($b['kategori']): ?>
                            <span class="badge bg-light text-dark me-1"><?= htmlspecialchars($b['kategori']) ?></span>
                        <?php endif; ?>
                        <?php if ($b['tahun_terbit']): ?>
                            <span class="badge bg-light text-dark"><?= $b['tahun_terbit'] ?></span>
                        <?php endif; ?>
                    </div>

                    <?php if ($b['deskripsi']): ?>
                        <p class="small text-muted mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            <?= htmlspecialchars($b['deskripsi']) ?>
                        </p>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
                    <span class="badge bg-success">Stok: <?= $b['stok'] ?></span>
                    <a href="<?= base_url('peminjaman/pinjam/' . $b['id']) ?>" class="btn btn-primary btn-sm" onclick="return confirm('Yakin ingin meminjam buku ini?')">
                        <i class="bi bi-cart-plus me-1"></i>Pinjam
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
function applyFilters() {
    const search = document.getElementById('search').value;
    const kategori = document.getElementById('kategori').value;
    const tahun = document.getElementById('tahun').value;
    
    let url = '<?= base_url('peminjaman') ?>?';
    const params = [];
    
    if (search) params.push('search=' + encodeURIComponent(search));
    if (kategori) params.push('kategori=' + encodeURIComponent(kategori));
    if (tahun) params.push('tahun=' + encodeURIComponent(tahun));
    
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
    .card-footer .btn, .page-header, .card.mb-4 {
        display: none !important;
    }
    .card {
        border: 1px solid #000 !important;
        box-shadow: none !important;
        page-break-inside: avoid;
    }
    .card-body {
        padding: 10px !important;
    }
    .row {
        display: flex;
        flex-wrap: wrap;
    }
    .col-md-6, .col-lg-4 {
        flex: 0 0 50%;
        max-width: 50%;
    }
    @page {
        margin: 1cm;
    }
}
</style>
