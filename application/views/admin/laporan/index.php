<style>
    .filter-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
    }

    .filter-card .card-body {
        padding: 24px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 22px;
        margin-bottom: 20px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        border-left: 5px solid #0d6efd;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-card.blue { border-left-color: #0d6efd; }
    .stat-card.green { border-left-color: #10b981; }
    .stat-card.orange { border-left-color: #f59e0b; }
    .stat-card.red { border-left-color: #dc3545; }
    .stat-card.purple { border-left-color: #6f42c1; }

    .stat-card-icon {
        font-size: 24px;
        margin-right: 14px;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }

    .stat-card.blue .stat-card-icon { background: rgba(13, 110, 253, 0.1); color: #0d6efd; }
    .stat-card.green .stat-card-icon { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .stat-card.orange .stat-card-icon { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .stat-card.red .stat-card-icon { background: rgba(220, 53, 69, 0.1); color: #dc3545; }
    .stat-card.purple .stat-card-icon { background: rgba(111, 66, 193, 0.1); color: #6f42c1; }

    .stat-card-title {
        font-weight: 600;
        font-size: 14px;
        color: #343a40;
    }

    .stat-card-value {
        font-size: 28px;
        font-weight: 700;
        margin-top: 10px;
        color: #0d6efd;
    }

    .stat-card.green .stat-card-value { color: #10b981; }
    .stat-card.orange .stat-card-value { color: #f59e0b; }
    .stat-card.red .stat-card-value { color: #dc3545; }
    .stat-card.purple .stat-card-value { color: #6f42c1; }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #343a40;
        margin: 28px 0 18px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title-icon {
        font-size: 24px;
    }

    /* Header laporan untuk print */
    .report-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #333;
    }

    .report-header h3 {
        margin-bottom: 10px;
        font-weight: bold;
    }

    .report-header .periode {
        font-size: 14px;
        color: #666;
        margin-top: 5px;
    }

    @media print {
        .page-header, .filter-card, .btn, .sidebar, .navbar, .no-print {
            display: none !important;
        }
        .stat-card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
        .report-header {
            display: block !important;
        }
    }
</style>

<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="bi bi-file-earmark-text me-2"></i>Kelola Laporan</h2>
        <p class="text-muted mb-0">Laporan transaksi perpustakaan dengan filter dan ringkasan yang jelas.</p>
    </div>
    <button onclick="cetakLaporan()" class="btn btn-primary">
        <i class="bi bi-printer me-2"></i>Cetak Laporan
    </button>
</div>

<div class="card mb-4 filter-card">
    <div class="card-body">
        <form method="GET" action="<?= base_url('laporan') ?>" class="row g-3 align-items-end">
            <div class="col-md-3">
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
            <div class="col-md-2">
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
            <div class="col-md-2">
                <label for="bulan" class="form-label">Bulan</label>
                <select class="form-select" id="bulan" name="bulan">
                    <option value="">Semua Bulan</option>
                    <option value="01" <?= (isset($filters['bulan']) && $filters['bulan'] == '01') ? 'selected' : '' ?>>Januari</option>
                    <option value="02" <?= (isset($filters['bulan']) && $filters['bulan'] == '02') ? 'selected' : '' ?>>Februari</option>
                    <option value="03" <?= (isset($filters['bulan']) && $filters['bulan'] == '03') ? 'selected' : '' ?>>Maret</option>
                    <option value="04" <?= (isset($filters['bulan']) && $filters['bulan'] == '04') ? 'selected' : '' ?>>April</option>
                    <option value="05" <?= (isset($filters['bulan']) && $filters['bulan'] == '05') ? 'selected' : '' ?>>Mei</option>
                    <option value="06" <?= (isset($filters['bulan']) && $filters['bulan'] == '06') ? 'selected' : '' ?>>Juni</option>
                    <option value="07" <?= (isset($filters['bulan']) && $filters['bulan'] == '07') ? 'selected' : '' ?>>Juli</option>
                    <option value="08" <?= (isset($filters['bulan']) && $filters['bulan'] == '08') ? 'selected' : '' ?>>Agustus</option>
                    <option value="09" <?= (isset($filters['bulan']) && $filters['bulan'] == '09') ? 'selected' : '' ?>>September</option>
                    <option value="10" <?= (isset($filters['bulan']) && $filters['bulan'] == '10') ? 'selected' : '' ?>>Oktober</option>
                    <option value="11" <?= (isset($filters['bulan']) && $filters['bulan'] == '11') ? 'selected' : '' ?>>November</option>
                    <option value="12" <?= (isset($filters['bulan']) && $filters['bulan'] == '12') ? 'selected' : '' ?>>Desember</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="tanggal" class="form-label">Tanggal (Opsional)</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= isset($filters['tanggal']) ? htmlspecialchars($filters['tanggal']) : '' ?>">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
                <a href="<?= base_url('laporan') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Header Laporan untuk Cetak (akan muncul saat print) -->
<div class="report-header" id="reportHeader" style="display: none;">
    <h3>LAPORAN DATA BUKU</h3>
    <div class="periode" id="periodeText"></div>
    <div class="periode">Tanggal Cetak: <?= date('d-m-Y H:i:s') ?></div>
</div>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="mb-0">Detail Laporan Buku</h5>
                <small class="text-muted">Menampilkan daftar buku dan status stok untuk laporan.</small>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="laporanTable">
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

<script>
function cetakLaporan() {
    // Ambil nilai filter yang dipilih
    let tanggal = document.getElementById('tanggal') ? document.getElementById('tanggal').value : '';
    let bulan = document.getElementById('bulan') ? document.getElementById('bulan').options[document.getElementById('bulan').selectedIndex]?.text : '';
    let tahun = document.getElementById('tahun') ? document.getElementById('tahun').options[document.getElementById('tahun').selectedIndex]?.text : '';
    
    // Buat teks periode
    let periodeText = '';
    if (tanggal) {
        let tanggalFormatted = new Date(tanggal).toLocaleDateString('id-ID');
        periodeText = `Periode: ${tanggalFormatted}`;
    } else if (bulan && bulan !== 'Semua Bulan' && tahun && tahun !== 'Semua Tahun') {
        periodeText = `Periode: Bulan ${bulan} ${tahun}`;
    } else if (bulan && bulan !== 'Semua Bulan') {
        periodeText = `Periode: Bulan ${bulan}`;
    } else if (tahun && tahun !== 'Semua Tahun') {
        periodeText = `Periode: Tahun ${tahun}`;
    } else {
        periodeText = `Periode: Semua Data`;
    }
    
    // Set teks periode ke header
    let periodeElement = document.getElementById('periodeText');
    if (periodeElement) {
        periodeElement.innerHTML = periodeText;
    }
    
    // Tampilkan header untuk print
    let header = document.getElementById('reportHeader');
    if (header) {
        header.style.display = 'block';
    }
    
    // Print
    window.print();
    
    // Sembunyikan lagi setelah print
    setTimeout(function() {
        if (header) {
            header.style.display = 'none';
        }
    }, 100);
}

// Jika ada filter yang dipilih dari URL, tampilkan header saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    let urlParams = new URLSearchParams(window.location.search);
    let tanggal = urlParams.get('tanggal');
    let bulan = urlParams.get('bulan');
    let tahun = urlParams.get('tahun');
    
    if (tanggal || bulan || tahun) {
        let periodeText = '';
        if (tanggal) {
            let tanggalFormatted = new Date(tanggal).toLocaleDateString('id-ID');
            periodeText = `Periode: ${tanggalFormatted}`;
        } else if (bulan && tahun) {
            let namaBulan = '';
            let bulanSelect = document.getElementById('bulan');
            if (bulanSelect) {
                for(let i = 0; i < bulanSelect.options.length; i++) {
                    if(bulanSelect.options[i].value === bulan) {
                        namaBulan = bulanSelect.options[i].text;
                        break;
                    }
                }
            }
            periodeText = `Periode: Bulan ${namaBulan} ${tahun}`;
        } else if (bulan) {
            let namaBulan = '';
            let bulanSelect = document.getElementById('bulan');
            if (bulanSelect) {
                for(let i = 0; i < bulanSelect.options.length; i++) {
                    if(bulanSelect.options[i].value === bulan) {
                        namaBulan = bulanSelect.options[i].text;
                        break;
                    }
                }
            }
            periodeText = `Periode: Bulan ${namaBulan}`;
        } else if (tahun) {
            periodeText = `Periode: Tahun ${tahun}`;
        }
        
        let periodeElement = document.getElementById('periodeText');
        if (periodeElement && periodeText) {
            periodeElement.innerHTML = periodeText;
        }
    }
});
</script>