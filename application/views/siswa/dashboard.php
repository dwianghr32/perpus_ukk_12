<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #0d6efd;
            --primary-dark: #0b5ed7;
        }

        body {
            background: #f8fafc;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

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

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-card .icon {
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 24px;
            color: white;
        }

        .stat-card .value {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
        }

        .stat-card .label {
            font-size: 14px;
            color: #7f8c8d;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #eef2f6;
            font-weight: 600;
            padding: 16px 20px;
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

        /* Modal Styles */
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
    </style>
</head>
<body>
    <div class="container py-4">
        <!-- Page Header -->
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="bi bi-speedometer2 me-2"></i>Dashboard Siswa</h2>
                <p class="text-muted mb-0">Selamat datang, <?= htmlspecialchars($anggota['nama']) ?></p>
            </div>
            <div>
                <span class="badge bg-success p-2"><i class="bi bi-calendar me-1"></i><?= date('d F Y') ?></span>
            </div>
        </div>

        <!-- Student Info Card -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card" style="background: linear-gradient(135deg, #0d6efd, #0b5ed7); color: white; height: 100%; border: none; border-radius: 12px;">
                    <div class="card-body text-center py-4">
                        <i class="bi bi-person-circle" style="font-size: 64px;"></i>
                        <h4 class="mt-3 mb-1"><?= htmlspecialchars($anggota['nama']) ?></h4>
                        <p class="mb-0"><i class="bi bi-upc-scan me-1"></i>NIS: <?= htmlspecialchars($anggota['nis']) ?></p>
                        <p class="mb-0"><i class="bi bi-building me-1"></i>Kelas: <?= htmlspecialchars($anggota['kelas']) ?></p>

                        <div class="mt-3">
                           
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card h-100">
                    <div class="d-flex align-items-center h-100">
                        <div class="icon me-3" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                            <i class="bi bi-book"></i>
                        </div>
                        <div>
                            <div class="value"><?= $total_pinjaman ?></div>
                            <div class="label">Total Peminjaman</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card h-100">
                    <div class="d-flex align-items-center h-100">
                        <div class="icon me-3" style="background: linear-gradient(135deg, #fdcb6e, #e17055);">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div>
                            <div class="value"><?= $pinjaman_aktif ?></div>
                            <div class="label">Sedang Dipinjam</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-lightning-charge me-2"></i>Aksi Cepat
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <a href="<?= base_url('peminjaman') ?>" class="btn btn-primary w-100 py-3">
                                    <i class="bi bi-book me-2"></i>Pinjam Buku Baru
                                </a>
                            </div>
                            <div class="col-md-6 mb-2">
                                <a href="<?= base_url('peminjaman/riwayat') ?>" class="btn btn-success w-100 py-3">
                                    <i class="bi bi-clock-history me-2"></i>Lihat Riwayat Peminjaman
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Borrowings -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2"></i>Peminjaman Terbaru</span>
                <a href="<?= base_url('peminjaman/riwayat') ?>" class="btn btn-sm btn-light">Lihat Semua</a>
            </div>
            <div class="card-body">
                <?php if (empty($riwayat_terbaru)): ?>
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
                                    <th>Tanggal Pinjam</th>
                                    <th>Batas Kembali</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($riwayat_terbaru as $r): ?>
                                <tr>
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
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ID Card Modal (Hanya Preview & Cetak) -->
    <div class="modal fade" id="idCardModal" tabindex="-1" aria-labelledby="idCardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="idCardModalLabel">
                        <i class="bi bi-person-badge me-2"></i>ID Card Anggota Perpustakaan
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
                                    <div class="id-card-name" id="cardNama"><?= htmlspecialchars($anggota['nama']) ?></div>
                                    <div class="id-card-detail">
                                        <div class="id-card-detail-item">
                                            <label>NIS</label>
                                            <span id="cardNis"><?= htmlspecialchars($anggota['nis']) ?></span>
                                        </div>
                                        <div class="id-card-detail-item">
                                            <label>Kelas</label>
                                            <span id="cardKelas"><?= htmlspecialchars($anggota['kelas']) ?></span>
                                        </div>
                                    </div>
                                    <div class="id-card-detail">
                                        <div class="id-card-detail-item">
                                            <label>Telepon</label>
                                            <span id="cardTelepon"><?= htmlspecialchars($anggota['telepon'] ?? '-') ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="id-card-footer">
                                <div class="id-number" id="cardId">ID: LIB-<?= htmlspecialchars($anggota['nis']) ?></div>
                                <div class="year">Tahun Ajaran 2025/2026</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="printCardBtn">
                        <i class="bi bi-printer me-1"></i>Cetak ID Card
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Print Area -->
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
                    <div class="id-card-name" id="printNama"><?= htmlspecialchars($anggota['nama']) ?></div>
                    <div class="id-card-detail">
                        <div class="id-card-detail-item">
                            <label>NIS</label>
                            <span id="printNis"><?= htmlspecialchars($anggota['nis']) ?></span>
                        </div>
                        <div class="id-card-detail-item">
                            <label>Kelas</label>
                            <span id="printKelas"><?= htmlspecialchars($anggota['kelas']) ?></span>
                        </div>
                    </div>
                    <div class="id-card-detail">
                        <div class="id-card-detail-item">
                            <label>Telepon</label>
                            <span id="printTelepon"><?= htmlspecialchars($anggota['telepon'] ?? '-') ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="id-card-footer">
                <div class="id-number" id="printId">ID: LIB-<?= htmlspecialchars($anggota['nis']) ?></div>
                <div class="year">Tahun Ajaran 2025/2026</div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fungsi untuk cetak ID Card
        function printCard() {
            var printArea = document.getElementById('printArea');
            printArea.style.display = 'flex';
            
            setTimeout(function() {
                window.print();
                setTimeout(function() {
                    printArea.style.display = 'none';
                }, 500);
            }, 100);
        }

        // Event listener untuk tombol cetak
        document.getElementById('printCardBtn')?.addEventListener('click', printCard);
    </script>
</body>
</html>