<style>
    .filter-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    }

    .filter-card .card-body {
        padding: 24px;
    }

    /* Tombol Cetak Laporan - Ungu Gradient seperti gambar */
    .btn-cetak-laporan {
        background: linear-gradient(90deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        transition: all 0.3s ease;
    }

    .btn-cetak-laporan:hover {
        background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
    }

    .dropdown-item {
        padding: 10px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .dropdown-item:hover {
        background-color: #f3f4f6;
    }
</style>

<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="bi bi-file-earmark-text me-2"></i>Kelola Laporan</h2>
        <p class="text-muted mb-0">Laporan transaksi perpustakaan dengan filter dan ringkasan yang jelas.</p>
    </div>
    
    <!-- Tombol Cetak Laporan dengan Dropdown (Sesuai Gambar) -->
    <div class="dropdown">
        <button class="btn btn-cetak-laporan dropdown-toggle" type="button" id="dropdownCetak" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-printer me-2"></i>Cetak Laporan
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownCetak">
            <li>
                <a class="dropdown-item" href="<?= base_url('Laporan/cetak?periode=hari') ?>" target="_blank">
                    <i class="bi bi-calendar-day"></i> Hari Ini
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="<?= base_url('Laporan/cetak?periode=minggu') ?>" target="_blank">
                    <i class="bi bi-calendar-week"></i> Minggu Ini
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="<?= base_url('Laporan/cetak?periode=bulan') ?>" target="_blank">
                    <i class="bi bi-calendar-month"></i> Bulan Ini
                </a>
            </li>
            <li>
                <a class="dropdown-item" href="<?= base_url('Laporan/cetak?periode=tahun') ?>" target="_blank">
                    <i class="bi bi-calendar3"></i> Tahun Ini
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item" href="<?= base_url('Laporan/cetak?periode=semua') ?>" target="_blank">
                    <i class="bi bi-file-earmark-text"></i> Semua Data
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Filter Card tetap sama seperti sebelumnya -->
<div class="card mb-4 filter-card">
    <div class="card-body">
        <form method="GET" action="<?= base_url('laporan') ?>" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="search" class="form-label">Cari Buku</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Judul, pengarang, kode" value="<?= isset($filters['search']) ? htmlspecialchars($filters['search']) : '' ?>">
            </div>
            <div class="col-md-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select class="form-select" id="kategori" name="kategori">
                    <option value="">Semua Kategori</option>
                    <?php if (!empty($kategori_list)): ?>
                        <?php foreach ($kategori_list as $k): ?>
                            <option value="<?= htmlspecialchars($k['kategori']) ?>" 
                                    <?= (isset($filters['kategori']) && $filters['kategori'] == $k['kategori']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($k['kategori']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="tahun" class="form-label">Tahun</label>
                <select class="form-select" id="tahun" name="tahun">
                    <option value="">Semua Tahun</option>
                    <?php if (!empty($tahun_list)): ?>
                        <?php foreach ($tahun_list as $t): ?>
                            <option value="<?= $t['tahun'] ?>" 
                                    <?= (isset($filters['tahun']) && $filters['tahun'] == $t['tahun']) ? 'selected' : '' ?>>
                                <?= $t['tahun'] ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-md-5 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1" style="background: linear-gradient(90deg, #6366f1, #8b5cf6); border: none;">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
                <a href="<?= base_url('laporan') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Tabel Detail Laporan Buku (tetap sama) -->
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="mb-0">Detail Laporan Buku</h5>
                <small class="text-muted">Menampilkan daftar buku dan status stok untuk laporan.</small>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Buku</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Kategori</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($buku)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data untuk ditampilkan.</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($buku as $item): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($item['kode_buku'] ?? '-') ?></span></td>
                                <td><?= htmlspecialchars($item['judul'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($item['pengarang'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($item['kategori'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($item['tahun_terbit'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($item['stok'] ?? 0) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>