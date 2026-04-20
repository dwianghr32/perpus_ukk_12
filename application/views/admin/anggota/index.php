<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Anggota - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #0d6efd;
            --primary-dark: #0b5ed7;
            --secondary: #64748b;
            --success: #10b981;
            --danger: #dc3545;
            --warning: #f59e0b;
            --info: #0dcaf0;
        }
        
        body {
            background: #f8fafc;
            font-family: 'Segoe UI', system-ui, sans-serif;
            min-height: 100vh;
        }
        
        /* Header seperti halaman laporan */
        .page-header {
            background: white;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            border-left: 5px solid var(--primary);
        }
        
        .page-header h2 {
            margin: 0;
            font-weight: 700;
            color: #343a40;
        }
        
        .page-header h2 i {
            color: var(--primary);
        }
        
        .page-header p {
            margin: 0.5rem 0 0;
            color: #6c757d;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        }
        
        .table th {
            background: #f8f9fa;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--secondary);
            border: none;
        }
        
        .table td {
            vertical-align: middle;
            border-color: #f1f5f9;
        }
        
        .table tbody tr:hover {
            background: #f8fafc;
        }
        
        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        /* Badge NIS gaya baru */
        .badge-nis {
            background: var(--primary);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.8rem;
            display: inline-block;
        }
        
        .btn-action {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }
        
        .btn-info {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }
        
        .btn-info:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            color: white;
        }
        
        .btn-warning {
            background: #f59e0b;
            border-color: #f59e0b;
            color: white;
        }
        
        .btn-warning:hover {
            background: #d97706;
            border-color: #d97706;
            color: white;
        }
        
        .btn-danger {
            background: #dc3545;
            border-color: #dc3545;
        }

        /* Filter Button Style - seperti halaman laporan */
        .filter-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .filter-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .filter-btn i {
            margin-right: 8px;
        }
        
        .btn-secondary {
            background: #6c757d;
            border-color: #6c757d;
        }
        
        .btn-secondary:hover {
            background: #5c636a;
            border-color: #5c636a;
        }

        /* ID Card Styles */
        .id-card {
            width: 340px;
            height: 215px;
            background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
            border-radius: 16px;
            padding: 20px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }
        
        .id-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(13, 110, 253, 0.3) 0%, transparent 70%);
            border-radius: 50%;
        }
        
        .id-card::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -20%;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.2) 0%, transparent 70%);
            border-radius: 50%;
        }
        
        .id-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
            position: relative;
            z-index: 1;
        } 
        
        .id-card-logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        
        .id-card-school {
            flex: 1;
        }
        
        .id-card-school h4 {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        
        .id-card-school span {
            font-size: 10px;
            opacity: 0.7;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .id-card-body {
            display: flex;
            gap: 16px;
            position: relative;
            z-index: 1;
        }
        
        .id-card-photo {
            width: 70px;
            height: 85px;
            background: linear-gradient(135deg, #374151, #1f2937);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: #6b7280;
            border: 2px solid rgba(255,255,255,0.1);
        }
        
        .id-card-info {
            flex: 1;
        }
        
        .id-card-name {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #f8fafc;
        }
        
        .id-card-detail {
            display: flex;
            gap: 20px;
            margin-bottom: 6px;
        }
        
        .id-card-detail-item label {
            display: block;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #94a3b8;
            margin-bottom: 2px;
        }
        
        .id-card-detail-item span {
            font-size: 13px;
            font-weight: 600;
            color: #e2e8f0;
        }
        
        .id-card-footer {
            position: absolute;
            bottom: 12px;
            right: 20px;
            text-align: right;
            z-index: 1;
        }
        
        .id-card-footer .id-number {
            font-size: 10px;
            color: var(--primary);
            font-weight: 600;
            letter-spacing: 1px;
        }
        
        .id-card-footer .year {
            font-size: 9px;
            color: #64748b;
        }
        
        /* Print Styles */
        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            body * {
                visibility: hidden !important;
            }
            
            #printArea, #printArea * {
                visibility: visible !important;
            }
            
            #printArea {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                bottom: 0 !important;
                width: 100% !important;
                height: 100% !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            
            #printArea .id-card {
                margin: 0 auto !important;
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }
            
            @page {
                size: A4 portrait;
                margin: 0;
            }
        }
        
        .modal-content {
            border: none;
            border-radius: 16px;
        }
        
        .preview-container {
            display: flex;
            justify-content: center;
            padding: 20px;
            background: #f1f5f9;
            border-radius: 12px;
        }
        
        /* Filter card styling seperti laporan */
        .filter-card {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <!-- Header - gaya seperti laporan -->
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="bi bi-people me-2"></i>Kelola Data Anggota</h2>
                <p class="text-muted mb-0">Manajemen data anggota perpustakaan</p>
            </div>
            <a href="<?= base_url('anggota/tambah') ?>" class="btn btn-primary">
                <i class="bi bi-person-plus me-2"></i>Tambah Anggota
            </a>
        </div>
        
        <!-- Filter Section - gaya seperti laporan -->
        <div class="card filter-card mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Cari Anggota</label>
                        <input type="text" class="form-control" id="search" name="search" placeholder="Nama atau NIS" value="<?= isset($filters['search']) ? htmlspecialchars($filters['search']) : '' ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <select class="form-select" id="kelas" name="kelas">
                            <option value="">Semua Kelas</option>
                            <?php foreach ($kelas_options as $kelas): ?>
                                <option value="<?= htmlspecialchars($kelas['kelas']) ?>" <?= (isset($filters['kelas']) && $filters['kelas'] == $kelas['kelas']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($kelas['kelas']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-5 d-flex gap-2">
                        <button type="button" class="btn btn-primary" onclick="applyFilters()">
                            <i class="bi bi-search me-1"></i>Filter
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="clearFilters()">
                            <i class="bi bi-x-circle"></i>Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Table -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="mb-0">Daftar Anggota Perpustakaan</h5>
                        <small class="text-muted">Menampilkan semua data anggota yang terdaftar</small>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($anggota)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">Belum ada data anggota</td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($anggota as $a): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><span class="badge-nis"><?= htmlspecialchars($a['nis']) ?></span></td>
                                    <td class="fw-semibold"><?= htmlspecialchars($a['nama']) ?></td>
                                    <td><?= htmlspecialchars($a['kelas']) ?></td>
                                    <td><?= htmlspecialchars($a['telepon'] ?: '-') ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info btn-action me-1" data-bs-toggle="modal" data-bs-target="#idCardModal"
                                            data-nis="<?= htmlspecialchars($a['nis']) ?>"
                                            data-nama="<?= htmlspecialchars($a['nama']) ?>"
                                            data-kelas="<?= htmlspecialchars($a['kelas']) ?>"
                                            data-telepon="<?= htmlspecialchars($a['telepon'] ?: '-') ?>"
                                            data-alamat="<?= htmlspecialchars($a['alamat'] ?: '-') ?>"
                                            title="Cetak ID Card">
                                            <i class="bi bi-person-badge"></i>
                                        </button>
                                        <a href="<?= base_url('anggota/edit/' . $a['id']) ?>" class="btn btn-sm btn-warning btn-action me-1" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="<?= base_url('anggota/hapus/' . $a['id']) ?>" class="btn btn-sm btn-danger btn-action" onclick="return confirm('Yakin ingin menghapus anggota ini?')" title="Hapus">
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
    </div>
    
    <!-- ID Card Modal -->
    <div class="modal fade" id="idCardModal" tabindex="-1" aria-labelledby="idCardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="idCardModalLabel">
                        <i class="bi bi-person-badge me-2"></i>Preview ID Card
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="preview-container">
                        <div class="id-card" id="idCardPreview">
                            <div class="id-card-header">
                                <div class="id-card-logo">
                                    <i class="bi bi-book"></i>
                                </div>
                                <div class="id-card-school">
                                    <h4>PERPUSTAKAAN</h4>
                                    <span>Kartu Anggota</span>
                                </div>
                            </div>
                            <div class="id-card-body">
                                <div class="id-card-photo">
                                    <i class="bi bi-person"></i>
                                </div>
                                <div class="id-card-info">
                                    <div class="id-card-name" id="cardNama">Ahmad Fauzi</div>
                                    <div class="id-card-detail">
                                        <div class="id-card-detail-item">
                                            <label>NIS</label>
                                            <span id="cardNis">2024001</span>
                                        </div>
                                        <div class="id-card-detail-item">
                                            <label>Kelas</label>
                                            <span id="cardKelas">XII IPA 1</span>
                                        </div>
                                    </div>
                                    <div class="id-card-detail">
                                        <div class="id-card-detail-item">
                                            <label>Telepon</label>
                                            <span id="cardTelepon">081234567890</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="id-card-footer">
                                <div class="id-number" id="cardId">ID: LIB-2024001</div>
                                <div class="year">Tahun Ajaran 2025/2026</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="printIdCard()">
                        <i class="bi bi-printer me-1"></i>Cetak ID Card
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Print Area -->
    <div id="printArea" style="display: none;">
        <div class="id-card" id="printCard">
            <div class="id-card-header">
                <div class="id-card-logo">
                    <i class="bi bi-book"></i>
                </div>
                <div class="id-card-school">
                    <h4>PERPUSTAKAAN</h4>
                    <span>Kartu Anggota</span>
                </div>
            </div>
            <div class="id-card-body">
                <div class="id-card-photo">
                    <i class="bi bi-person"></i>
                </div>
                <div class="id-card-info">
                    <div class="id-card-name" id="printNama"></div>
                    <div class="id-card-detail">
                        <div class="id-card-detail-item">
                            <label>NIS</label>
                            <span id="printNis"></span>
                        </div>
                        <div class="id-card-detail-item">
                            <label>Kelas</label>
                            <span id="printKelas"></span>
                        </div>
                    </div>
                    <div class="id-card-detail">
                        <div class="id-card-detail-item">
                            <label>Telepon</label>
                            <span id="printTelepon"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="id-card-footer">
                <div class="id-number" id="printId"></div>
                <div class="year">Tahun Ajaran 2025/2026</div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Filter functions
        function applyFilters() {
            const search = document.getElementById('search').value;
            const kelas = document.getElementById('kelas').value;
            
            let url = '<?= base_url('anggota') ?>?';
            const params = [];
            
            if (search) params.push('search=' + encodeURIComponent(search));
            if (kelas) params.push('kelas=' + encodeURIComponent(kelas));
            
            if (params.length > 0) {
                url += params.join('&');
            }
            
            window.location.href = url;
        }

        function clearFilters() {
            window.location.href = '<?= base_url('anggota') ?>';
        }
        
        // Modal event listener
        var idCardModal = document.getElementById('idCardModal');
        if (idCardModal) {
            idCardModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var nama = button.getAttribute('data-nama');
                var nis = button.getAttribute('data-nis');
                var kelas = button.getAttribute('data-kelas');
                var telepon = button.getAttribute('data-telepon');

                document.getElementById('cardNama').textContent = nama;
                document.getElementById('cardNis').textContent = nis;
                document.getElementById('cardKelas').textContent = kelas;
                document.getElementById('cardTelepon').textContent = telepon;
                document.getElementById('cardId').textContent = 'ID: LIB-' + nis;
                
                document.getElementById('printNama').textContent = nama;
                document.getElementById('printNis').textContent = nis;
                document.getElementById('printKelas').textContent = kelas;
                document.getElementById('printTelepon').textContent = telepon;
                document.getElementById('printId').textContent = 'ID: LIB-' + nis;
            });
        }
        
        function printIdCard() {
            var printArea = document.getElementById('printArea');
            printArea.style.display = 'flex';
            
            setTimeout(function() {
                window.print();
                setTimeout(function() {
                    printArea.style.display = 'none';
                }, 500);
            }, 100);
        }
    </script>
</body>
</html>