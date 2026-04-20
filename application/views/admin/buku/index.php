<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="bi bi-book me-2"></i>Kelola Data Buku</h2>
        <p class="text-muted mb-0">Manajemen data buku perpustakaan</p>
    </div>
    <a href="<?= base_url('buku/tambah') ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Tambah Buku
    </a>
</div>

<!-- Filter Section -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="search" class="form-label">Cari Buku</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Judul, pengarang, kode" value="<?= isset($filters['search']) ? htmlspecialchars($filters['search']) : '' ?>">
            </div>
            <div class="col-md-2">
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
            <div class="col-md-2">
                <label for="stok" class="form-label">Status Stok</label>
                <select class="form-select" id="stok" name="stok">
                    <option value="">Semua Stok</option>
                    <option value="available" <?= (isset($filters['stok']) && $filters['stok'] == 'available') ? 'selected' : '' ?>>Tersedia</option>
                    <option value="empty" <?= (isset($filters['stok']) && $filters['stok'] == 'empty') ? 'selected' : '' ?>>Habis</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-primary me-2" onclick="applyFilters()">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
                <button type="button" class="btn btn-secondary" onclick="clearFilters()">
                    <i class="bi bi-x-circle me-1"></i>Reset
                </button>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($buku)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data buku</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($buku as $b): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><span class="badge bg-primary"><?= htmlspecialchars($b['kode_buku']) ?></span></td>
                            <td><?= htmlspecialchars($b['judul']) ?></td>
                            <td><?= htmlspecialchars($b['pengarang']) ?></td>
                            <td><?= htmlspecialchars($b['kategori'] ?: '-') ?></td>
                            <td>
                                <?php if ($b['stok'] > 0): ?>
                                    <span class="badge bg-success"><?= $b['stok'] ?></span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Habis</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('buku/edit/' . $b['id']) ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= base_url('buku/hapus/' . $b['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function applyFilters() {
    const search = document.getElementById('search').value;
    const kategori = document.getElementById('kategori').value;
    const tahun = document.getElementById('tahun').value;
    const stok = document.getElementById('stok').value;
    
    let url = '<?= base_url('buku') ?>?';
    const params = [];
    
    if (search) params.push('search=' + encodeURIComponent(search));
    if (kategori) params.push('kategori=' + encodeURIComponent(kategori));
    if (tahun) params.push('tahun=' + encodeURIComponent(tahun));
    if (stok) params.push('stok=' + encodeURIComponent(stok));
    
    if (params.length > 0) {
        url += params.join('&');
    }
    
    window.location.href = url;
}

function clearFilters() {
    window.location.href = '<?= base_url('buku') ?>';
}
</script>
